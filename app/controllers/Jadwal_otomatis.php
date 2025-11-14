<?php
class Jadwal_otomatis extends Controller
{
    private $db;

    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }

        if ($_SESSION['role'] == 'siswa') {
            redirect('');
        }

        $this->db = new Database();
    }

    private function getJadwalSettingAktif() {
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
    private function getWaliKelasLama() {
        $sql = "SELECT DISTINCT kelas, wali_kelas 
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
            $waliKelasMap[$row->kelas] = $row->wali_kelas;
        }

        error_log("CONTROLLER: " . count($waliKelasMap) . " wali kelas lama ditemukan.");
        return $waliKelasMap;
    }

    /**
     * Parse tahun ajaran dari format "YYYY/YYYY" atau date
     */
    private function parseTahunAjaran($dateString) {
        $year = date('Y', strtotime($dateString));
        $nextYear = $year + 1;
        return $year . '/' . $nextYear;
    }

    /**
     * Tentukan semester berdasarkan bulan
     */
    private function getSemesterFromDate($dateString) {
        $month = (int)date('m', strtotime($dateString));
        // Januari - Juni = Genap (semester 2)
        // Juli - Desember = Ganjil (semester 1)
        return ($month >= 1 && $month <= 6) ? 'Genap' : 'Ganjil';
    }

    /**
     * Tentukan blok berdasarkan bulan
     */
    private function getBlokFromDate($dateString) {
        $month = (int)date('m', strtotime($dateString));
        
        // Pembagian blok per tahun:
        // Blok I: Juli-Agustus (bulan 7-8)
        // Blok II: September-Oktober (bulan 9-10)
        // Blok III: November-Desember (bulan 11-12)
        // Blok I: Januari-Februari (bulan 1-2)
        // Blok II: Maret-April (bulan 3-4)
        // Blok III: Mei-Juni (bulan 5-6)
        
        if ($month >= 7 && $month <= 8) return 'I';
        if ($month >= 9 && $month <= 10) return 'II';
        if ($month >= 11 && $month <= 12) return 'III';
        if ($month >= 1 && $month <= 2) return 'I';
        if ($month >= 3 && $month <= 4) return 'II';
        if ($month >= 5 && $month <= 6) return 'III';
        
        return 'I'; // default
    }

    /**
     * Cari atau buat tahun ajaran
     */
    private function getOrCreateTahunAjaran($tahunAjaran) {
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

    /**
     * Cari atau buat jadwal setting
     */
    private function getOrCreateJadwalSetting($idTahunAjaran, $semester, $blok, $berlakuDari, $tanggalDirubah) {
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

            error_log("CONTROLLER: Jadwal setting diupdate (ID: {$existing->id_jadwal_setting})");
            return $existing->id_jadwal_setting;
        }

        // Non-aktifkan semua jadwal setting lain
        $this->db->query("UPDATE jadwal_setting SET status = 0");
        $this->db->execute();

        // Buat jadwal setting baru
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
            'blok_aktif' => $jadwalAktif ? $jadwalAktif->blok : ''
        ];

        require APPROOT . '/views/inc/header.php';
        $this->view('jadwal_otomatis/index', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function generateSchedule()
    {
        // Aktifkan error reporting untuk debugging (HAPUS DI PRODUKSI)
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Ambil input dari form
        $berlakuJadwalDari = $_POST['berlaku_jadwal_dari'] ?? null;
        $semester = $_POST['semester'] ?? null;
        $blok = $_POST['blok'] ?? null;
        $tahunAjaranInput = $_POST['tahun_ajaran'] ?? null;

        if (empty($berlakuJadwalDari)) {
            error_log("CONTROLLER: ERROR - Tanggal berlaku jadwal kosong.");
            flash('jadwal_message', 'Tanggal berlaku jadwal harus diisi.', 'alert-danger');
            redirect('jadwal_otomatis');
        }

        try {
            // Tentukan tahun ajaran, semester, dan blok
            $tahunAjaran = $tahunAjaranInput ?? $this->parseTahunAjaran($berlakuJadwalDari);
            $semester = $semester ?? $this->getSemesterFromDate($berlakuJadwalDari);
            $blok = $blok ?? $this->getBlokFromDate($berlakuJadwalDari);
            $tanggalDirubah = date('Y-m-d');

            error_log("CONTROLLER: Tahun Ajaran: $tahunAjaran, Semester: $semester, Blok: $blok");

            // Buat/ambil tahun ajaran
            $idTahunAjaran = $this->getOrCreateTahunAjaran($tahunAjaran);
            if (!$idTahunAjaran) {
                throw new Exception("Gagal membuat/mengambil tahun ajaran");
            }

            // Buat/update jadwal setting
            $idJadwalSetting = $this->getOrCreateJadwalSetting(
                $idTahunAjaran, 
                $semester, 
                $blok, 
                $berlakuJadwalDari, 
                $tanggalDirubah
            );

            if (!$idJadwalSetting) {
                throw new Exception("Gagal membuat/mengambil jadwal setting");
            }

            error_log("CONTROLLER: Mengambil data wali kelas lama...");
            $waliKelasLama = $this->getWaliKelasLama();

            if ($waliKelasLama) {
                error_log("CONTROLLER: Akan menggunakan " . count($waliKelasLama) . " wali kelas lama.");
            } else {
                error_log("CONTROLLER: Tidak ada wali kelas lama, akan generate baru.");
            }

            error_log("CONTROLLER: Menginisialisasi SchedulerService...");
            $scheduler = new SchedulerService($this->db);
            
            // 加载wali_kelas数据到SchedulerService
            error_log("CONTROLLER: Memanggil loadWaliKelas()...");
            $scheduler->loadWaliKelas($waliKelasLama);

            error_log("CONTROLLER: Memanggil generateSchedule() dengan wali kelas lama...");
            $schedule = $scheduler->generateSchedule();

            if (empty($schedule)) {
                error_log("CONTROLLER: ERROR - Hasil jadwal kosong dari service.");
                flash('jadwal_message', 'Gagal membuat jadwal: Hasil jadwal kosong. Periksa data guru, mata pelajaran, dan kelas.', 'alert-danger');
                redirect('jadwal_otomatis');
            }

            error_log("CONTROLLER: Memanggil saveScheduleToDatabase()...");
            $saveResult = $scheduler->saveScheduleToDatabase($schedule, $berlakuJadwalDari);

            if ($saveResult) {
                $message = 'Jadwal berhasil dibuat dengan algoritma genetika!';
                $message .= " (Tahun Ajaran: $tahunAjaran, Semester: $semester, Blok: $blok)";
                if ($waliKelasLama) {
                    $message .= ' Wali kelas lama dipertahankan.';
                }
                flash('jadwal_message', $message, 'alert-success');
            } else {
                flash('jadwal_message', 'Gagal menyimpan jadwal ke database.', 'alert-danger');
            }

        } catch (Exception $e) {
            error_log("CONTROLLER: FATAL ERROR - " . $e->getMessage());
            error_log("TRACE: " . $e->getTraceAsString());
            flash('jadwal_message', 'Terjadi kesalahan fatal: ' . $e->getMessage(), 'alert-danger');
        }

        redirect('jadwal_otomatis');
    }
}