<?php
class Jadwal_otomatis extends Controller
{
    private $db;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        // harus kurikulum/admin
        if (!Middleware::admin('kurikulum') && $_SESSION['role'] != 'admin') {
            redirect('');
        }

        $this->db = new Database();
        $this->Mjadwal = $this->model('Mjadwal');
    }

    private function getJadwalSettingAktif()
    {
        $sql = "SELECT 
            js.*,
            ta.tahun_ajaran
        FROM jadwal_setting js
        JOIN m_tahun_ajaran ta ON js.id_tahun_ajaran = ta.id_tahun_ajaran
        WHERE js.status = 1
        ORDER BY js.id_tahun_ajaran DESC, js.semester DESC, js.blok DESC
        LIMIT 1";

        $this->db->query($sql);
        return $this->db->single();
    }

    /**
     * Cek apakah ada wali kelas lama di jadwal_lengkap
     * Return: array dengan format ['kelas' => 'nik_guru'] atau null jika kosong
     */
    private function getWaliKelasLama()
    {
        $sql = "SELECT DISTINCT kelas, ruang, wali_kelas 
                FROM jadwal_lengkap 
                WHERE wali_kelas IS NOT NULL AND wali_kelas != ''";

        $this->db->query($sql);
        $result = $this->db->resultSet();

        if (empty($result)) {
            error_log("CONTROLLER: Tidak ada wali kelas lama ditemukan.");
            return null;
        }

        $waliKelasMap = [];
        foreach ($result as $row) {
            // Format kunci: kelas tanpa spasi (misal: XIIA, XIB)
            $kelasKey = str_replace(' ', '', $row->kelas . $row->ruang);
            $waliKelasMap[$kelasKey] = $row->wali_kelas;
        }

        error_log("CONTROLLER: " . count($waliKelasMap) . " wali kelas lama ditemukan.");
        return $waliKelasMap;
    }

    /**
     * Parse tahun ajaran dari format "YYYY/YYYY" atau date
     */
    private function parseTahunAjaran($dateString)
    {
        $year = date('Y', strtotime($dateString));
        $nextYear = $year + 1;
        return $year . '/' . $nextYear;
    }

    private function getOrCreateTahunAjaran($tahunAjaran)
    {
        // Cek apakah tahun ajaran sudah ada
        $this->db->query("SELECT * FROM m_tahun_ajaran WHERE tahun_ajaran = :tahun_ajaran");
        $this->db->bind(':tahun_ajaran', $tahunAjaran);
        $existing = $this->db->single();

        if ($existing) {
            // Jika tahun ajaran sudah ada, set statusnya menjadi aktif (1) dan nonaktifkan yang lain
            $this->db->query("UPDATE m_tahun_ajaran SET status = 0");
            $this->db->execute();

            $this->db->query("UPDATE m_tahun_ajaran SET status = 1 WHERE id_tahun_ajaran = :id_tahun_ajaran");
            $this->db->bind(':id_tahun_ajaran', $existing->id_tahun_ajaran);
            $this->db->execute();

            error_log("CONTROLLER: Tahun ajaran $tahunAjaran diaktifkan (ID: {$existing->id_tahun_ajaran})");
            return $existing->id_tahun_ajaran;
        }

        // Non-aktifkan semua tahun ajaran lain
        $this->db->query("UPDATE m_tahun_ajaran SET status = 0");
        $this->db->execute();

        // Buat tahun ajaran baru dengan status aktif (1)
        $this->db->query("INSERT INTO m_tahun_ajaran (tahun_ajaran, status) VALUES (:tahun_ajaran, 1)");
        $this->db->bind(':tahun_ajaran', $tahunAjaran);

        if ($this->db->execute()) {
            $newId = $this->db->lastInsertId();
            error_log("CONTROLLER: Tahun ajaran baru dibuat dan diaktifkan: $tahunAjaran (ID: $newId)");
            return $newId;
        }

        return null;
    }

    private function getOrCreateJadwalSetting($idTahunAjaran, $semester, $blok, $berlakuDari, $tanggalDirubah)
    {
        // Cek apakah kombinasi sudah ada
        $this->db->query("SELECT * FROM jadwal_setting 
                         WHERE id_tahun_ajaran = :id_tahun_ajaran 
                         AND semester = :semester 
                         AND blok = :blok");
        $this->db->bind(':id_tahun_ajaran', $idTahunAjaran);
        $this->db->bind(':semester', $semester);
        $this->db->bind(':blok', $blok);
        $existing = $this->db->single();

        if ($existing) {
            $this->db->query("UPDATE jadwal_setting SET status = 0");
            $this->db->execute();
            // Update yang sudah ada
            $this->db->query("UPDATE jadwal_setting 
                            SET berlaku_dari = :berlaku_dari,
                                tanggal_dirubah = :tanggal_dirubah,
                                status = 1
                            WHERE id_jadwal_setting = :id");
            $this->db->bind(':berlaku_dari', $berlakuDari);
            $this->db->bind(':tanggal_dirubah', $tanggalDirubah);
            $this->db->bind(':id', $existing->id_jadwal_setting);
            $this->db->execute();

            error_log("CONTROLLER: Jadwal setting diupdate exiting (ID: {$existing->id_jadwal_setting})");
            return $existing->id_jadwal_setting;
        }

        $this->db->query("UPDATE jadwal_setting SET status = 0");
        $this->db->execute();

        $this->db->query("INSERT INTO jadwal_setting 
                         (id_tahun_ajaran, semester, blok, berlaku_dari, tanggal_dirubah, status) 
                         VALUES 
                         (:id_tahun_ajaran, :semester, :blok, :berlaku_dari, :tanggal_dirubah, 1)");
        $this->db->bind(':id_tahun_ajaran', $idTahunAjaran);
        $this->db->bind(':semester', $semester);
        $this->db->bind(':blok', $blok);
        $this->db->bind(':berlaku_dari', $berlakuDari);
        $this->db->bind(':tanggal_dirubah', $tanggalDirubah);

        if ($this->db->execute()) {
            $newId = $this->db->lastInsertId();
            error_log("CONTROLLER: Jadwal setting baru dibuat (ID: $newId)");
            return $newId;
        }

        return null;
    }


    private function validasiTanggal($tanggal)
    {
        $sql = "SELECT COUNT(*) as total_rows 
                FROM jadwal_lengkap 
                WHERE berlaku_jadwal_dari = :tanggal";

        $this->db->query($sql);
        $this->db->bind(':tanggal', $tanggal);
        $result = $this->db->single();

        return $result->total_rows > 0;
    }

    function validasiSemesterBlok($semester, $blok)
    {
        $semester = ucfirst(strtolower(trim($semester)));
        $blok = strtoupper(trim($blok));

        if ($semester === 'Ganjil' && $blok === 'I') {
            return true;
        }

        if ($semester === 'Genap' && $blok === 'II') {
            return true;
        }

        return false;
    }


    private function getMataPelajaran()
    {
        $sql = "SELECT * from m_pelajaran order by mata_pelajaran";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function index()
    {
        // Cek apakah ada request untuk generate jadwal
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_schedule'])) {
            $this->generateSchedule();
        }

        $jadwalAktif = $this->getJadwalSettingAktif();

        $data = [
            'jadwal_aktif' => $jadwalAktif ? $jadwalAktif->berlaku_dari : date('Y-m-d'),
            'wali_kelas_tersedia' => !empty($this->getWaliKelasLama()),
            'tahun_ajaran_aktif' => $jadwalAktif ? $jadwalAktif->tahun_ajaran : '',
            'semester_aktif' => $jadwalAktif ? $jadwalAktif->semester : '',
            'blok_aktif' => $jadwalAktif ? $jadwalAktif->blok : '',
            'mata_pelajaran' => $this->getMataPelajaran()
        ];

        require APPROOT . '/views/inc/header.php';
        $this->view('jadwal_otomatis/index', $data);
        require APPROOT . '/views/inc/footer.php';
    }


    public function generateSchedule()
    {
        header('Content-Type: application/json');

        // Aktifkan error reporting untuk debugging (HAPUS DI PRODUKSI)
        error_reporting(E_ALL);
        ini_set('display_errors', 0);
        // Ubah ke 0 agar error tidak merusak JSON response

        // Ambil input dari form
        $berlakuJadwalDari = $_POST['berlaku_jadwal_dari'] ?? null;
        $semester = $_POST['semester'] ?? null;
        $blok = $_POST['blok'] ?? null;
        // $tahunAjaranInput = $_POST['tahun_ajaran'] ?? null;

        if (
            empty($_POST['berlaku_jadwal_dari']) ||
            empty($_POST['semester']) ||
            empty($_POST['blok'])
            // || empty($_POST['tahun_ajaran'])
        ) {
            echo json_encode([
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'tahun ajar,semester,blok, dan tanggal berlaku wajib diisi.'
            ]);
            exit;
        }

        $validasiSemBlok = $this->validasiSemesterBlok($semester, $blok);

        if (!$validasiSemBlok) {
            echo json_encode([
                'type' => 'error',
                'title' => 'Gagal',
                'message' => 'Semester dan Blok Tidak Sesuai'
            ]);
            exit;
        }

        // Ambil input pengecualian mata pelajaran - FORMAT BARU
        $pengecualian = [
            'X' => [],
            'XI' => [],
            'XII' => []
        ];

        // Parse mata pelajaran khusus untuk kelas X
        if (isset($_POST['mata_pelajaran_untuk_kelas_x']) && !empty($_POST['mata_pelajaran_untuk_kelas_x'])) {
            $pengecualian['X'] = $_POST['mata_pelajaran_untuk_kelas_x'];
            error_log("CONTROLLER: Kelas X memiliki " . count($pengecualian['X']) . " mata pelajaran khusus.");
        }

        // Parse mata pelajaran khusus untuk kelas XI
        if (isset($_POST['mata_pelajaran_untuk_kelas_xi']) && !empty($_POST['mata_pelajaran_untuk_kelas_xi'])) {
            $pengecualian['XI'] = $_POST['mata_pelajaran_untuk_kelas_xi'];
            error_log("CONTROLLER: Kelas XI memiliki " . count($pengecualian['XI']) . " mata pelajaran khusus.");
        }

        // Parse mata pelajaran khusus untuk kelas XII
        if (isset($_POST['mata_pelajaran_untuk_kelas_xii']) && !empty($_POST['mata_pelajaran_untuk_kelas_xii'])) {
            $pengecualian['XII'] = $_POST['mata_pelajaran_untuk_kelas_xii'];
            error_log("CONTROLLER: Kelas XII memiliki " . count($pengecualian['XII']) . " mata pelajaran khusus.");
        }

        error_log("CONTROLLER: Pengecualian per kelas: " . json_encode($pengecualian));

        if ($this->validasiTanggal($berlakuJadwalDari)) {
            error_log("CONTROLLER: Jadwal sudah ada pada tanggal $berlakuJadwalDari");
            echo json_encode([
                'type' => 'error',
                'title' => 'Gagal Generate Jadwal',
                'message' => 'Jadwal sudah ada pada tanggal ' . date('d/m/Y', strtotime($berlakuJadwalDari)) . '. Silakan pilih tanggal lain.'
            ]);
            exit;
        }

        try {
            $tahunAjaran = $this->parseTahunAjaran($berlakuJadwalDari);
            $tanggalDirubah = date('Y-m-d');

            error_log("CONTROLLER: Tahun Ajaran: $tahunAjaran, Semester: $semester, Blok: $blok");

            $idTahunAjaran = $this->getOrCreateTahunAjaran($tahunAjaran);
            if (!$idTahunAjaran) {
                throw new Exception("Gagal membuat atau mengambil data tahun ajaran");
            }

            // $berlaku = new DateTime($berlakuJadwalDari);
            // $dirubah = new DateTime($tanggalDirubah);   

            // if ($berlaku > $dirubah) {
            //     echo json_encode([
            //         'type' => 'error',
            //         'title' => 'Gagal Generate Jadwal',
            //         'message' => 'Jadwal  Berlaku '
            //     ]);
            //     exit;
            // }

            $idJadwalSetting = $this->getOrCreateJadwalSetting(
                $idTahunAjaran,
                $semester,
                $blok,
                $berlakuJadwalDari,
                $tanggalDirubah
            );

            // error_log('id jadwal setting: ' . print_r($berlakuJadwalDari, true));
            // exit;

            if (!$idJadwalSetting) {
                throw new Exception("Gagal membuat atau mengambil jadwal setting");
            }

            error_log("CONTROLLER: Mengambil data wali kelas lama...");
            $waliKelasLama = $this->getWaliKelasLama();

            if ($waliKelasLama) {
                error_log("CONTROLLER: Akan menggunakan " . count($waliKelasLama) . " wali kelas lama.");
            } else {
                error_log("CONTROLLER: Tidak ada wali kelas lama, akan generate baru.");
            }

            error_log("CONTROLLER: Menginisialisasi SchedulerService...");
            $scheduler = new SchedulerService($this->db, $pengecualian);

            // error_log("CONTROLLER: Memanggil loadWaliKelas()...");
            $scheduler->loadWaliKelas($waliKelasLama);

            // error_log("CONTROLLER: Memanggil generateSchedule() dengan wali kelas lama...");
            $schedule = $scheduler->generateSchedule();

            if (empty($schedule)) {
                error_log("CONTROLLER: ERROR - Hasil jadwal kosong dari service.");
                throw new Exception("Hasil jadwal kosong. Periksa data guru, mata pelajaran, dan kelas.");
            }

            // error_log("CONTROLLER: Memanggil saveScheduleToDatabase()...");
            $saveResult = $scheduler->saveScheduleToDatabase($schedule, $berlakuJadwalDari);

            if (!$saveResult) {
                throw new Exception("Gagal menyimpan jadwal ke database");
            }

            // error_log("CONTROLLER: SUCCESS - Jadwal berhasil dibuat");

            $message = 'Jadwal berhasil dibuat dengan algoritma genetika!';
            $message .= " (Tahun Ajaran: $tahunAjaran, Semester: $semester, Blok: $blok)";
            if ($waliKelasLama) {
                $message .= ' Wali kelas lama dipertahankan.';
            }

            echo json_encode([
                'type' => 'success',
                'title' => 'Berhasil',
                'message' => $message,
                'redirect' => URLROOT . '/jadwal'
            ]);
            exit;

        } catch (Exception $e) {
            // error_log("CONTROLLER: FATAL ERROR - " . $e->getMessage());
            // error_log("TRACE: " . $e->getTraceAsString());

            echo json_encode([
                'type' => 'error',
                'title' => 'Terjadi Kesalahan',
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
}