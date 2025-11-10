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

    public function index()
    {
        // Cek apakah ada request untuk generate jadwal
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generate_schedule'])) {
            $this->generateSchedule();
        }

        $data = [
            'title' => 'Jadwal Otomatis',
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

        $this->db->query("SELECT berlaku_dari FROM `jadwal_setting` WHERE status = 1");
        $jadwalBerlaku = $this->db->single();
        $berlakuJadwalDari = $jadwalBerlaku->berlaku_dari;

        // exit();

        // error_log("CONTROLLER: Proses generate jadwal dimulai.");

        // $berlakuJadwalDari = $_POST['berlaku_jadwal_dari'] ?? date('Y-m-d');

        if (empty($berlakuJadwalDari)) {
            error_log("CONTROLLER: ERROR - Tanggal berlaku jadwal kosong.");
            flash('jadwal_message', 'Tanggal berlaku jadwal harus diisi', 'alert-danger');
            redirect('jadwal_otomatis');
        }

        try {
            // 🧹 HAPUS isi tabel jadwal_lengkap sebelum generate baru
            error_log("CONTROLLER: Menghapus isi tabel jadwal_lengkap...");
            $this->db->query("TRUNCATE TABLE jadwal_lengkap");
            $this->db->execute();

            error_log("CONTROLLER: Tabel jadwal_lengkap berhasil dikosongkan");

            // die(); //  Stop semua eksekusi di sini
            error_log("CONTROLLER: Menginisialisasi SchedulerService...");
            $scheduler = new SchedulerService($this->db);

            error_log("CONTROLLER: Memanggil generateSchedule()...");
            $schedule = $scheduler->generateSchedule();

            if (empty($schedule)) {
                error_log("CONTROLLER: ERROR - Hasil jadwal kosong dari service.");
                flash('jadwal_message', 'Gagal membuat jadwal: Hasil jadwal kosong. Periksa data guru, mata pelajaran, dan kelas.', 'alert-danger');
                redirect('jadwal_otomatis');
            }

            error_log("CONTROLLER: Memanggil saveScheduleToDatabase()...");
            $saveResult = $scheduler->saveScheduleToDatabase($schedule, $berlakuJadwalDari);

            if ($saveResult) {
                flash('jadwal_message', 'Jadwal berhasil dibuat dengan algoritma genetika!', 'alert-success');
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