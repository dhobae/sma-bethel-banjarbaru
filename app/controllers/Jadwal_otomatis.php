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
        $this->Mjadwal_otomatis = $this->model('Mjadwal_otomatis');
        $this->Mjadwal = $this->model('Mjadwal');
    }

    // PARSE tahun ajaran dari format "YYYY/YYYY" atau date
    private function parseTahunAjaran($dateString)
    {
        $year = date('Y', strtotime($dateString));
        $nextYear = $year + 1;
        return $year . '/' . $nextYear;
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

    private function validasiSemesterBlok($semester, $blok)
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

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_schedule'])) {
            $this->generateSchedule();
        }

        $jadwalAktif = $this->Mjadwal_otomatis->getJadwalSettingAktif();

        $data = [
            'jadwal_aktif' => $jadwalAktif ? $jadwalAktif->berlaku_dari : date('Y-m-d'),
            'wali_kelas_tersedia' => !empty($this->Mjadwal_otomatis->getWaliKelasLama()),
            'tahun_ajaran_aktif' => $jadwalAktif ? $jadwalAktif->tahun_ajaran : '',
            'semester_aktif' => $jadwalAktif ? $jadwalAktif->semester : '',
            'blok_aktif' => $jadwalAktif ? $jadwalAktif->blok : '',
            'mata_pelajaran' => $this->Mjadwal_otomatis->getMataPelajaran()
        ];

        require APPROOT . '/views/inc/header.php';
        $this->view('jadwal_otomatis/index', $data);
        require APPROOT . '/views/inc/footer.php';
    }


    public function generateSchedule()
    {
        header('Content-Type: application/json');

        // Aktifkan error reporting untuk debugging (HAPUS DI PRODUKSI)
        // error_reporting(E_ALL);
        // ini_set('display_errors', 0);
        // Ubah ke 0 agar error tidak merusak JSON response

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

        // Ambil input pengecualian mata pelajaran sesuai kelas
        $pengecualian = [
            'X' => [],
            'XI' => [],
            'XII' => []
        ];

        // Parse mata pelajaran khusus untuk kelas X
        if (isset($_POST['mata_pelajaran_untuk_kelas_x']) && !empty($_POST['mata_pelajaran_untuk_kelas_x'])) {
            $pengecualian['X'] = $_POST['mata_pelajaran_untuk_kelas_x'];
            // error_log("CONTROLLER: Kelas X memiliki " . count($pengecualian['X']) . " mata pelajaran khusus.");
        }

        // Parse mata pelajaran khusus untuk kelas XI
        if (isset($_POST['mata_pelajaran_untuk_kelas_xi']) && !empty($_POST['mata_pelajaran_untuk_kelas_xi'])) {
            $pengecualian['XI'] = $_POST['mata_pelajaran_untuk_kelas_xi'];
            // error_log("CONTROLLER: Kelas XI memiliki " . count($pengecualian['XI']) . " mata pelajaran khusus.");
        }

        // Parse mata pelajaran khusus untuk kelas XII
        if (isset($_POST['mata_pelajaran_untuk_kelas_xii']) && !empty($_POST['mata_pelajaran_untuk_kelas_xii'])) {
            $pengecualian['XII'] = $_POST['mata_pelajaran_untuk_kelas_xii'];
            // error_log("CONTROLLER: Kelas XII memiliki " . count($pengecualian['XII']) . " mata pelajaran khusus.");
        }

        // error_log("CONTROLLER: Pengecualian per kelas: " . json_encode($pengecualian));

        if ($this->validasiTanggal($berlakuJadwalDari)) {
            // error_log("CONTROLLER: Jadwal sudah ada pada tanggal $berlakuJadwalDari");
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

            // error_log("CONTROLLER: Tahun Ajaran: $tahunAjaran, Semester: $semester, Blok: $blok");

            $idTahunAjaran = $this->Mjadwal_otomatis->getOrCreateTahunAjaran($tahunAjaran);
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

            $idJadwalSetting = $this->Mjadwal_otomatis->getOrCreateJadwalSetting(
                $idTahunAjaran,
                $semester,
                $blok,
                $berlakuJadwalDari,
                $tanggalDirubah
            );

            // error_log('id jadwal setting: ' . print_r($berlakuJadwalDari, true));

            if (!$idJadwalSetting) {
                throw new Exception("Gagal membuat atau mengambil jadwal setting");
            }

            // error_log("CONTROLLER: Mengambil data wali kelas lama...");
            $waliKelasLama = $this->Mjadwal_otomatis->getWaliKelasLama();

            // if ($waliKelasLama) {
            //     error_log("CONTROLLER: Akan menggunakan " . count($waliKelasLama) . " wali kelas lama.");
            // } else {
            //     error_log("CONTROLLER: Tidak ada wali kelas lama, akan generate baru.");
            // }

            // error_log("CONTROLLER: Menginisialisasi SchedulerService...");
            $scheduler = new SchedulerService($this->db, $pengecualian);

            // error_log("CONTROLLER: Memanggil loadWaliKelas()...");
            $scheduler->loadWaliKelas($waliKelasLama);

            // error_log("CONTROLLER: Memanggil generateSchedule() dengan wali kelas lama...");
            $schedule = $scheduler->generateSchedule();

            if (empty($schedule)) {
                // error_log("CONTROLLER: ERROR - Hasil jadwal kosong dari service.");
                throw new Exception("Hasil jadwal kosong. Periksa data guru, mata pelajaran, dan kelas.");
            }

            // error_log("CONTROLLER: Memanggil saveScheduleToDatabase()...");
            $saveResult = $scheduler->saveScheduleToDatabase($schedule, $berlakuJadwalDari);

            if (!$saveResult) {
                throw new Exception("Gagal menyimpan jadwal ke database");
            }

            // error_log("CONTROLLER: SUCCESS - Jadwal berhasil dibuat");

            $message = 'Jadwal berhasil dibuat dengan algoritma!';
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