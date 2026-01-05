<?php
class Absen_siswa extends Controller
{
    // KHUSUS RFID SISWA
    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }

        $allowed_roles = ['rfid', 'admin'];

        if (!in_array($_SESSION['role'], $allowed_roles)) {
            return redirect('');
        }
   
        $this->Mabsen_siswa = $this->model('Mabsen_siswa');
        $this->Mdashboard = $this->model('Mdashboard');
    }

    public function index()
    {
        $this->view('khusus/absen_rfid_siswa');
    }

    private function getStatus() {
        $jamKerja = $this->Mabsen_siswa->ambil_jam_sekolah();
        $jam_masuk  = $jamKerja->masuk;   
        $jam_pulang = $jamKerja->pulang;  
        $hasil = validasi_waktu_rfid($jam_masuk, $jam_pulang);
        return $hasil['status'];
    }

    public function isi_absen_by_rfid()
    {
        header('Content-Type: application/json');

        if(date('D') == 'Sat' || date('D') == 'Sun') {
            echo json_encode([
                    'status' => 'error',
                    'message' => 'Hari Libur Tidak Dapat Melakukan Absensi',
            ]);
            return;
        }

        if($this->getStatus() == 'ditutup') {
            echo json_encode([
                'status' => 'error',
                'message' => 'Perangkat RFID Ditutup',
            ]);
            return;
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $rfid = $_POST['isi'];

        $siswa = $this->Mabsen_siswa->ambil_siswa_by_rfid($rfid);

        if (!$siswa) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Kartu tidak terdaftar dalam sistem',
            ]);
            return;
        }

        $data['cek_absen'] = $this->Mabsen_siswa->cek_absen_siswa($siswa->nis);
        $status_masuk = null;

        if (!empty($data['cek_absen']) && isset($data['cek_absen'][0])) {
            $status_masuk = $data['cek_absen'][0]->status_ahs;
        }

        if ($status_masuk == 'Izin' || $status_masuk == 'Sakit') {
            echo json_encode([
                'status' => 'info',
                'message' => 'Anda Sedang Izin',
            ]);
            return;
        } else if ($status_masuk == 'Alpa') {
            echo json_encode([
                'status' => 'info',
                'message' => 'Anda Sudah di Alpa, Tidak bisa melakukan presensi',
            ]);
            return; 
        }

        $nis = $siswa->nis;
        $nama = $siswa->nama_siswa ?? 'Siswa';
        $kelas = $siswa->kelas_siswa ?? '-';

        $cek_absen = $this->Mabsen_siswa->cek_absen_hari_ini($nis);

        if (!$cek_absen) {
            $keterangan = $this->getStatus() == 'terlambat' ? ' (Terlambat)' : '';
            if ($this->Mabsen_siswa->hadir_rfid_siswa($_POST)) {
                echo json_encode([
                    'status' => 'success',
                    'type' => 'masuk',
                    'message' => 'Selamat datang! Presensi MASUK berhasil dicatat' . $keterangan . '.',
                    'nama' => $nama,
                    'nis' => $nis,
                    'kelas' => $kelas,
                    'waktu' => date('H:i:s'),
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal mencatat presensi masuk. Silakan coba lagi.',
                ]);
            }
        } else {
            if (empty($cek_absen->jam_pulang_ahs) || $cek_absen->jam_pulang_ahs == null) {
                if($this->getStatus() == 'pulang') {

                if ($this->Mabsen_siswa->pulang_rfid_siswa($_POST)) {
                    $jam_masuk = strtotime($cek_absen->jam_masuk_ahs);
                    $jam_pulang = strtotime(date('H:i:s'));
                    $durasi = $jam_pulang - $jam_masuk;
                    $jam = floor($durasi / 3600);
                    $menit = floor(($durasi % 3600) / 60);

                    echo json_encode([
                        'status' => 'success',
                        'type' => 'pulang',
                        'message' => 'Hati-hati di jalan! Presensi PULANG berhasil dicatat.',
                        'nama' => $nama,
                        'nis' => $nis,
                        'kelas' => $kelas,
                        'waktu' => date('H:i:s'),
                        'jam_masuk' => $cek_absen->jam_masuk_ahs,
                        'durasi' => "$jam jam $menit menit",
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Gagal mencatat presensi pulang. Silakan coba lagi.',
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal mencatat presensi pulang. Waktu Pulang belum terbuka.',
                ]);
            }

            } else {
                echo json_encode([
                    'status' => 'warning',
                    'message' => 'Anda sudah melakukan presensi MASUK dan PULANG hari ini.',
                    'nama' => $nama,
                    'nis' => $nis,
                    'kelas' => $kelas,
                    'jam_masuk' => $cek_absen->jam_masuk_ahs,
                    'jam_pulang' => $cek_absen->jam_pulang_ahs,
                ]);
            }
        }
    }
}
