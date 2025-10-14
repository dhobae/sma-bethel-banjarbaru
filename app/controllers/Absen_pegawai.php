<?php
class Absen_pegawai extends Controller
{
    public function __construct()
    {
        $this->Mabsen_pegawai = $this->model('Mabsen_pegawai');
    }

    public function index()
    {
        $this->view('khusus/index2');
    }

    /**
     * Proses absen RFID pegawai dengan validasi IP Address
     */
    public function isi_absen_by_rfid()
    {
        header('Content-Type: application/json');

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $rfid = $_POST['isi'];
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Ambil koordinat dari client (jika ada)
        $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '-';
        $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '-';
        $lokasi_koordinat = null;

        if ($latitude && $longitude) {
            $lokasi_koordinat = $latitude . ',' . $longitude;
        }

        // VALIDASI: Cek IP Address harus terdaftar
        $cek_ip = $this->Mabsen_pegawai->cek_ip_address($ip_address);

        if (!$cek_ip) {
            echo json_encode([
                'status' => 'error',
                'message' => 'IP Address tidak terdaftar. Anda hanya dapat melakukan presensi dari lokasi yang terdaftar.',
                'ip_address' => $ip_address,
            ]);
            return;
        }

        // Cek apakah kartu RFID terdaftar
        $pegawai = $this->Mabsen_pegawai->ambil_pegawai_by_rfid($rfid);

        if (!$pegawai) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Kartu RFID tidak terdaftar dalam sistem',
            ]);
            return;
        }

        $nik = $pegawai->nik;
        $nama = $pegawai->nama ?? 'Pegawai';
        $jabatan = $pegawai->jabatan ?? '-';

        // Cek status absen hari ini
        $cek_absen = $this->Mabsen_pegawai->cek_absen_hari_ini($nik);

        if (!$cek_absen) {
            // BELUM ABSEN MASUK - Lakukan absen masuk
            $data_absen = [
                'nik' => $nik,
                'rfid' => $rfid,
                'from_masuk' => 'WFO',
                'loc_masuk' => $lokasi_koordinat,
                'keterangan' => 'Absen masuk via RFID',
            ];

            if ($this->Mabsen_pegawai->absen_masuk($data_absen)) {
                echo json_encode([
                    'status' => 'success',
                    'type' => 'masuk',
                    'message' => 'Selamat datang! Presensi MASUK berhasil dicatat.',
                    'nama' => $nama,
                    'nik' => $nik,
                    'jabatan' => $jabatan,
                    'waktu' => date('H:i:s'),
                    'lokasi' => 'WFO',
                    'koordinat' => $lokasi_koordinat,
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal mencatat presensi masuk. Silakan coba lagi.',
                ]);
            }
        } else {
            // SUDAH ABSEN MASUK - Cek apakah sudah absen pulang
            if (empty($cek_absen->jam_pulang) || $cek_absen->jam_pulang == null) {
                // BELUM ABSEN PULANG - Lakukan absen pulang
                $data_absen = [
                    'nik' => $nik,
                    'rfid' => $rfid,
                    'from_pulang' => 'WFO',
                    'loc_pulang' => $lokasi_koordinat,
                    'keterangan' => 'Absen pulang via RFID',
                ];

                if ($this->Mabsen_pegawai->absen_pulang($data_absen)) {
                    // Hitung durasi kehadiran
                    $jam_masuk = strtotime($cek_absen->jam_masuk);
                    $jam_pulang = strtotime(date('H:i:s'));
                    $durasi = $jam_pulang - $jam_masuk;
                    $jam = floor($durasi / 3600);
                    $menit = floor(($durasi % 3600) / 60);

                    echo json_encode([
                        'status' => 'success',
                        'type' => 'pulang',
                        'message' => 'Hati-hati di jalan! Presensi PULANG berhasil dicatat.',
                        'nama' => $nama,
                        'nik' => $nik,
                        'jabatan' => $jabatan,
                        'waktu' => date('H:i:s'),
                        'jam_masuk' => $cek_absen->jam_masuk,
                        'durasi' => "$jam jam $menit menit",
                        'lokasi_masuk' => 'WFO',
                        'lokasi_pulang' => 'WFO',
                        'koordinat' => $lokasi_koordinat,
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
                    'nik' => $nik,
                    'jabatan' => $jabatan,
                    'jam_masuk' => $cek_absen->jam_masuk,
                    'jam_pulang' => $cek_absen->jam_pulang,
                    'lokasi_masuk' => 'WFO',
                    'lokasi_pulang' => 'WFO',
                ]);
            }
        }
    }
}
