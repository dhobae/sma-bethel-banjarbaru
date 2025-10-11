<?php
class Absen_siswa extends Controller
{

    public function __construct()
    {
        //if (!isLoggedIn()) {
        //    return redirect('auth/login');
        //}
        //new model instance
        $this->Mabsen_siswa = $this->model('Mabsen_siswa');
    }

    public function index()
    {
        $this->view('khusus/index');
    }

    // KHUSUS RFID --------------------------------
    public function ambil_siswa_by_rfid()
    {
        $isi = $_POST['isi'];

        $data['ada_data'] = $this->Mabsen_siswa->ambil_siswa_by_rfid($isi);

        if (!$data['ada_data']) {
            echo "error";
            return;
        } else {
            $nis = $data['ada_data']->nis;
            $data['cek_absen'] = $this->Mabsen_siswa->cek_absen_rfid($nis);
            if (!$data['cek_absen']) {
                $data['absen_datang'] = 'belum';
            } else {
                $data['absen_datang'] = 'sudah';
            }
        }

        $this->view('dashboard/isi_form_absen', $data);
    }

    public function hadir_rfid_siswa()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($_POST['absen_datang'] == 'belum') {
            if ($this->Mabsen_siswa->hadir_rfid_siswa($_POST)) {
                setFlash('Presensi Hadir berhasil.', 'success');
                return redirect('dashboard');
            } else {
                setFlash('Gagal melakukan presensi.', 'danger');
                return redirect('dashboard');
            }
        } else {
            if ($this->Mabsen_siswa->pulang_rfid_siswa($_POST)) {
                setFlash('Presensi Pulang berhasil.', 'success');
                return redirect('dashboard');
            } else {
                setFlash('Gagal melakukan presensi.', 'danger');
                return redirect('dashboard');
            }
        }
    }

    public function isi_absen_by_rfid()
    {
        header('Content-Type: application/json');

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $isi = $_POST['isi'];

        // Cek apakah kartu terdaftar
        $siswa = $this->Mabsen_siswa->ambil_siswa_by_rfid($isi);

        if (!$siswa) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Kartu tidak terdaftar dalam sistem',
            ]);
            return;
        }

        $nis = $siswa->nis;
        $nama = $siswa->nama ?? 'Siswa';
        $kelas = $siswa->kelas ?? '-';

        // Cek status absen hari ini
        $cek_absen = $this->Mabsen_siswa->cek_absen_rfid($nis);

        if (!$cek_absen) {
            // BELUM ABSEN MASUK - Lakukan absen masuk
            if ($this->Mabsen_siswa->hadir_rfid_siswa($_POST)) {
                echo json_encode([
                    'status' => 'success',
                    'type' => 'masuk',
                    'message' => 'Selamat datang! Presensi MASUK berhasil dicatat.',
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
            // SUDAH ABSEN MASUK - Cek apakah sudah absen pulang
            if (empty($cek_absen->jam_pulang_ahs) || $cek_absen->jam_pulang_ahs == null) {
                // BELUM ABSEN PULANG - Lakukan absen pulang
                if ($this->Mabsen_siswa->pulang_rfid_siswa($_POST)) {
                    // Hitung durasi kehadiran
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
                // SUDAH ABSEN MASUK DAN PULANG
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
