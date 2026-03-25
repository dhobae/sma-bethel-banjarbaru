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

    // kelas, wali kelas, jadwal setting
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

    // public function isi_absen_by_rfid()
    // {
    //     header('Content-Type: application/json');

    //     if(date('D') == 'Sat' || date('D') == 'Sun') {
    //         echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'Hari Libur Tidak Dapat Melakukan Absensi',
    //         ]);
    //         return;
    //     }

    //     if($this->getStatus() == 'ditutup') {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Perangkat RFID Ditutup',
    //         ]);
    //         return;
    //     }

    //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //     $rfid = $_POST['isi'];

    //     $siswa = $this->Mabsen_siswa->ambil_siswa_by_rfid($rfid);

    //     // fix kolom kelas_ahs,wali_kelas_ahs,id_jadwal_setting_ahs null
    //     $siswa = $this->Mabsen_siswa->ambil_siswa_by_rfid($rfid);
    //     $kode_kelas = $siswa->kelas_siswa;
    //     $wali_kelas = $this->Mabsen_siswa->ambil_wali_kelas_nik($kode_kelas);
    //     $semester_aktif = $this->Mdashboard->semester_aktif()->id_jadwal_setting; // hasilnya id seperti 1

    //     $data = [
    //         'kode_kelas'        => $kode_kelas,
    //         'wali_kelas'        => $wali_kelas,
    //         'semester_aktif'    => $semester_aktif
    //     ];
    //     // fix kolom kelas_ahs,wali_kelas_ahs,id_jadwal_setting_ahs null

    //     if (!$siswa) {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Kartu tidak terdaftar dalam sistem',
    //         ]);
    //         return;
    //     }

    //     $data['cek_absen'] = $this->Mabsen_siswa->cek_absen_siswa($siswa->nis);
    //     $status_masuk = null;

    //     if (!empty($data['cek_absen']) && isset($data['cek_absen'][0])) {
    //         $status_masuk = $data['cek_absen'][0]->status_ahs;
    //     }

    //     if ($status_masuk == 'Izin' || $status_masuk == 'Sakit') {
    //         echo json_encode([
    //             'status' => 'info',
    //             'message' => 'Anda Sedang Izin',
    //         ]);
    //         return;
    //     } else if ($status_masuk == 'Alpa') {
    //         echo json_encode([
    //             'status' => 'info',
    //             'message' => 'Anda Sudah di Alpa, Tidak bisa melakukan presensi',
    //         ]);
    //         return; 
    //     }

    //     $nis = $siswa->nis;
    //     $nama = $siswa->nama_siswa ?? 'Siswa';
    //     $kelas = $siswa->kelas_siswa ?? '-';

    //     $cek_absen = $this->Mabsen_siswa->cek_absen_hari_ini($nis);

    //     if (!$cek_absen) {
    //         $keterangan = $this->getStatus() == 'terlambat' ? ' (Terlambat)' : '';
    //         if ($this->Mabsen_siswa->hadir_rfid_siswa($_POST)) {
    //             echo json_encode([
    //                 'status' => 'success',
    //                 'type' => 'masuk',
    //                 'message' => 'Selamat datang! Presensi MASUK berhasil dicatat' . $keterangan . '.',
    //                 'nama' => $nama,
    //                 'nis' => $nis,
    //                 'kelas' => $kelas,
    //                 'waktu' => date('H:i:s'),
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'Gagal mencatat presensi masuk. Silakan coba lagi.',
    //             ]);
    //         }
    //     } else {
    //         if (empty($cek_absen->jam_pulang_ahs) || $cek_absen->jam_pulang_ahs == null) {
    //             if($this->getStatus() == 'pulang') {

    //             if ($this->Mabsen_siswa->pulang_rfid_siswa($_POST)) {
    //                 $jam_masuk = strtotime($cek_absen->jam_masuk_ahs);
    //                 $jam_pulang = strtotime(date('H:i:s'));
    //                 $durasi = $jam_pulang - $jam_masuk;
    //                 $jam = floor($durasi / 3600);
    //                 $menit = floor(($durasi % 3600) / 60);

    //                 echo json_encode([
    //                     'status' => 'success',
    //                     'type' => 'pulang',
    //                     'message' => 'Hati-hati di jalan! Presensi PULANG berhasil dicatat.',
    //                     'nama' => $nama,
    //                     'nis' => $nis,
    //                     'kelas' => $kelas,
    //                     'waktu' => date('H:i:s'),
    //                     'jam_masuk' => $cek_absen->jam_masuk_ahs,
    //                     'durasi' => "$jam jam $menit menit",
    //                 ]);
    //             } else {
    //                 echo json_encode([
    //                     'status' => 'error',
    //                     'message' => 'Gagal mencatat presensi pulang. Silakan coba lagi.',
    //                 ]);
    //             }
    //         } else {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'Gagal mencatat presensi pulang. Waktu Pulang belum terbuka.',
    //             ]);
    //         }

    //         } else {
    //             echo json_encode([
    //                 'status' => 'warning',
    //                 'message' => 'Anda sudah melakukan presensi MASUK dan PULANG hari ini.',
    //                 'nama' => $nama,
    //                 'nis' => $nis,
    //                 'kelas' => $kelas,
    //                 'jam_masuk' => $cek_absen->jam_masuk_ahs,
    //                 'jam_pulang' => $cek_absen->jam_pulang_ahs,
    //             ]);
    //         }
    //     }
    // }

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

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $rfid  = $_POST['isi'];

        // FIX: Hanya panggil 1x, cek null dulu sebelum akses properti
        $siswa = $this->Mabsen_siswa->ambil_siswa_by_rfid($rfid);

        if (!$siswa) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Kartu tidak terdaftar dalam sistem',
            ]);
            return;
        }

        $nis   = $siswa->nis;
        $nama  = $siswa->nama_siswa  ?? 'Siswa';
        $kelas = $siswa->kelas_siswa ?? '-';
        $wali_kelas = $this->Mabsen_siswa->ambil_wali_kelas_nik($kelas)->wali_kelas;
        $semester_aktif = $this->Mdashboard->semester_aktif()->id_jadwal_setting;

        $data =  [
            'kelas' => $kelas,
            'wali_kelas' => $wali_kelas,
            'id_jadwal_setting' => $semester_aktif,
            'nis' => $nis
        ];      

        // for debug only
        // echo json_encode([
        //         'status'  => 'info',
        //         'message' => json_encode($data['nis']),
        //     ]);
        // return;
          
        // Cek status izin/alpa hari ini
        $cek_status   = $this->Mabsen_siswa->cek_absen_siswa($nis);
        $status_masuk = null;

        if (!empty($cek_status) && isset($cek_status[0])) {
            $status_masuk = $cek_status[0]->status_ahs;
        }

        if ($status_masuk == 'Izin' || $status_masuk == 'Sakit') {
            echo json_encode([
                'status'  => 'info',
                'message' => 'Anda Sedang Izin',
            ]);
            return;
        }

        if ($status_masuk == 'Alpa') {
            echo json_encode([
                'status'  => 'info',
                'message' => 'Anda Sudah di Alpa, Tidak bisa melakukan presensi',
            ]);
            return;
        }

        // Cek rekap absen hari ini
        $cek_absen = $this->Mabsen_siswa->cek_absen_hari_ini($nis);

        if (!$cek_absen) {
            // BELUM ABSEN MASUK
            $keterangan = $this->getStatus() == 'terlambat' ? ' (Terlambat)' : '';

            // FIX: Kirim $nis langsung, bukan raw $_POST
            if ($this->Mabsen_siswa->hadir_rfid_siswa($data)) {
                echo json_encode([
                    'status'  => 'success',
                    'type'    => 'masuk',
                    'message' => 'Selamat datang! Presensi MASUK berhasil dicatat' . $keterangan . '.',
                    'nama'    => $nama,
                    'nis'     => $nis,
                    'kelas'   => $kelas,
                    'waktu'   => date('H:i:s'),
                ]);
            } else {
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Gagal mencatat presensi masuk. Silakan coba lagi.',
                ]);
            }
        } else {
             echo json_encode([
                    'status'    => 'warning',
                    'message'   => 'Anda sudah melakukan presensi hari ini.',
                    'nama'      => $nama,
                    'nis'       => $nis,
                    'kelas'     => $kelas,
                    'jam_masuk' => $cek_absen->jam_masuk_ahs,
                    // 'jam_pulang' => $jam_pulang_db,
                ]);
        }
        
        // else {
        //     $jam_pulang_db = $cek_absen->jam_pulang_ahs ?? null;
        //     $belum_pulang  = empty($jam_pulang_db) || $jam_pulang_db == null;

        //     if ($belum_pulang) {
        //         if ($this->getStatus() == 'pulang') {
        //             // FIX: Kirim $nis langsung, bukan raw $_POST
        //             if ($this->Mabsen_siswa->pulang_rfid_siswa($nis)) {
        //                 $waktu_pulang  = date('H:i:s');
        //                 $jam_masuk_ts  = strtotime($cek_absen->jam_masuk_ahs);
        //                 $jam_pulang_ts = strtotime($waktu_pulang);
        //                 $durasi        = max(0, $jam_pulang_ts - $jam_masuk_ts);
        //                 $jam           = floor($durasi / 3600);
        //                 $menit         = floor(($durasi % 3600) / 60);

        //                 echo json_encode([
        //                     'status'    => 'success',
        //                     'type'      => 'pulang',
        //                     'message'   => 'Hati-hati di jalan! Presensi PULANG berhasil dicatat.',
        //                     'nama'      => $nama,
        //                     'nis'       => $nis,
        //                     'kelas'     => $kelas,
        //                     'jam_masuk' => $cek_absen->jam_masuk_ahs,
        //                     // FIX: jam_pulang sebelumnya tidak dikirim ke response
        //                     'jam_pulang' => $waktu_pulang,
        //                     'waktu'     => $waktu_pulang,
        //                     'durasi'    => "$jam jam $menit menit",
        //                 ]);
        //             } else {
        //                 echo json_encode([
        //                     'status'  => 'error',
        //                     'message' => 'Gagal mencatat presensi pulang. Silakan coba lagi.',
        //                 ]);
        //             }
        //         } else {
        //             echo json_encode([
        //                 'status'  => 'error',
        //                 'message' => 'Gagal mencatat presensi pulang. Waktu Pulang belum terbuka.',
        //             ]);
        //         }
        //     } 
            
        //     else {
        //         echo json_encode([
        //             'status'    => 'warning',
        //             'message'   => 'Anda sudah melakukan presensi MASUK dan PULANG hari ini.',
        //             'nama'      => $nama,
        //             'nis'       => $nis,
        //             'kelas'     => $kelas,
        //             'jam_masuk' => $cek_absen->jam_masuk_ahs,
        //             'jam_pulang' => $jam_pulang_db,
        //         ]);
        //     }
        // }
    }
}
