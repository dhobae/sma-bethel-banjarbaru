<?php
class Absen_pegawai extends Controller
{

    // KHUSUS RFID PEGAWAI
    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }

        $allowed_roles = ['rfid', 'admin'];

        if (!in_array($_SESSION['role'], $allowed_roles)) {
            return redirect('');
        }

        $this->Mabsen_pegawai = $this->model('Mabsen_pegawai');
        $this->Mdashboard     = $this->model('Mdashboard');
        $this->Mpresensi      = $this->model('Mpresensi');
    }

    private function getStatus()
    {
        $jamKerja  = $this->Mabsen_pegawai->ambil_jam_kerja();
        $jam_masuk = $jamKerja->masuk;   // 07:30:00
        $jam_pulang = $jamKerja->pulang;  // 16:00:00
        $hasil     = validasi_waktu_rfid($jam_masuk, $jam_pulang);
        return $hasil['status'];
    }

    public function index()
    {
        $this->view('khusus/absen_rfid_pegawai');
    }

    public function isi_absen_by_rfid()
    {
        header('Content-Type: application/json');

        if (date('D') == 'Sat' || date('D') == 'Sun') {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Hari Libur Tidak Dapat Melakukan Absensi',
            ]);
            return;
        }

        if ($this->getStatus() == 'ditutup') {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Perangkat RFID Ditutup',
            ]);
            return;
        }

        $_POST          = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $rfid           = $_POST['isi'];
        $id_pengunjung  = $_POST['id_pengunjung'];
        $lokasi_koordinat = $_POST['lokasi_koordinat'];

        // Cek apakah kartu RFID terdaftar
        $pegawai = $this->Mabsen_pegawai->ambil_pegawai_by_rfid($rfid);

        if (!$pegawai) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Kartu RFID tidak terdaftar dalam sistem',
            ]);
            return;
        }

        $data['cek_absen'] = $this->Mabsen_pegawai->cek_absen($pegawai->nik);
        $status_masuk      = null;

        if (!empty($data['cek_absen']) && isset($data['cek_absen'][0])) {
            $status_masuk = $data['cek_absen'][0]->status_masuk;
        }

        if ($status_masuk == 'Cuti1' || $status_masuk == 'Cuti2') {
            echo json_encode([
                'status'  => 'info',
                'message' => 'Anda Sedang Izin Cuti',
            ]);
            return;
        } else if ($status_masuk == 'Sakit') {
            echo json_encode([
                'status'  => 'info',
                'message' => 'Anda Sedang Izin Sakit',
            ]);
            return;
        } else if ($status_masuk == 'TL') {
            echo json_encode([
                'status'  => 'info',
                'message' => 'Anda Sedang Izin Tugas Luar',
            ]);
            return;
        }

        $nik     = $pegawai->nik;
        $nama    = $pegawai->nama    ?? 'Pegawai';
        $jabatan = $pegawai->jabatan ?? '-';

        // Cek status absen hari ini
        $cek_absen = $this->Mabsen_pegawai->cek_absen_hari_ini($nik);

        if (!$cek_absen) {
            // BELUM ABSEN MASUK - Lakukan absen masuk
            $keterangan  = 'Absen masuk via RFID' . ($this->getStatus() == 'terlambat' ? ' (Terlambat)' : '');
            $data_absen  = [
                'nik'        => $nik,
                'rfid'       => $rfid,
                'from_masuk' => 'WFO',
                'loc_masuk'  => $lokasi_koordinat,
                'keterangan' => $keterangan,
                'visitid'    => $id_pengunjung,
            ];

            if ($this->Mabsen_pegawai->absen_masuk($data_absen)) {
                echo json_encode([
                    'status'  => 'success',
                    'type'    => 'masuk',
                    'message' => 'Selamat datang! Presensi MASUK berhasil dicatat. ' . $this->getStatus(),
                    'nama'    => $nama,
                    'nik'     => $nik,
                    'jabatan' => $jabatan,
                    'waktu'   => date('H:i:s'),
                    'lokasi'  => 'WFO',
                    'koordinat' => $lokasi_koordinat,
                ]);
            } else {
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Gagal mencatat presensi masuk. Silakan coba lagi.',
                ]);
            }
        } else {
            $jam_pulang_db = $cek_absen->jam_pulang ?? null;
            $belum_pulang  = empty($jam_pulang_db)
                || $jam_pulang_db == null
                || $jam_pulang_db == '00:00:00'
                || $jam_pulang_db == '-';

            if ($belum_pulang) {
                if ($this->getStatus() == 'pulang') {
                    $data_absen = [
                        'nik'         => $nik,
                        'rfid'        => $rfid,
                        'from_pulang' => 'WFO',
                        'loc_pulang'  => $lokasi_koordinat,
                        'keterangan'  => 'Absen pulang via RFID',
                        'visitid'     => $id_pengunjung,
                    ];

                    if ($this->Mabsen_pegawai->absen_pulang($data_absen)) {
                        $waktu_pulang = date('H:i:s');
                        $jam_masuk_ts = strtotime($cek_absen->jam_masuk);
                        $jam_pulang_ts = strtotime($waktu_pulang);
                        $durasi = $jam_pulang_ts - $jam_masuk_ts;

                        // Kurangi 1 jam (3600 detik) istirahat
                        $durasi = max(0, $durasi - 3600);

                        $jam   = floor($durasi / 3600);
                        $menit = floor(($durasi % 3600) / 60);

                        echo json_encode([
                            'status'        => 'success',
                            'type'          => 'pulang',
                            'message'       => 'Hati-hati di jalan! Presensi PULANG berhasil dicatat.',
                            'nama'          => $nama,
                            'nik'           => $nik,
                            'jabatan'       => $jabatan,
                            'jam_masuk'     => $cek_absen->jam_masuk,
                            // FIX: jam_pulang sebelumnya tidak dikirim ke response
                            'jam_pulang'    => $waktu_pulang,
                            'waktu'         => $waktu_pulang,
                            'durasi'        => "$jam jam $menit menit",
                            'lokasi_masuk'  => 'WFO',
                            'lokasi_pulang' => 'WFO',
                            'koordinat'     => $lokasi_koordinat,
                        ]);
                    } else {
                        echo json_encode([
                            'status'  => 'error',
                            'message' => 'Gagal mencatat presensi pulang. Silakan coba lagi.',
                        ]);
                    }
                } else {
                    echo json_encode([
                        'status'  => 'error',
                        'message' => 'Gagal mencatat presensi pulang. Waktu Pulang belum terbuka.',
                    ]);
                }
            } else {
                // Sanitasi jam_pulang sebelum dikirim ke client
                $jam_pulang_display = ($jam_pulang_db && $jam_pulang_db !== '00:00:00')
                    ? $jam_pulang_db
                    : '-';

                echo json_encode([
                    'status'        => 'warning',
                    'message'       => 'Anda sudah melakukan presensi MASUK dan PULANG hari ini.',
                    'nama'          => $nama,
                    'nik'           => $nik,
                    'jabatan'       => $jabatan,
                    'jam_masuk'     => $cek_absen->jam_masuk,
                    'jam_pulang'    => $jam_pulang_display,
                    'lokasi_masuk'  => 'WFO',
                    'lokasi_pulang' => 'WFO',
                ]);
            }
        }
    }
}