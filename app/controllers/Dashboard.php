<?php
class Dashboard extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
        $this->Mdashboard = $this->model('Mdashboard');
        $this->Mpegawai = $this->model('Mpegawai');
        $this->Mpresensi = $this->model('Mpresensi');
        $this->Mjadwal = $this->model('Mjadwal');
        $this->Msiswa = $this->model('Msiswa');
    }

    public function index()
    {
        if ($_SESSION['kunci'] != '1') {
            if ($_SESSION['role'] != 'rfid') {
                $data['cek_absen'] = $this->Mdashboard->cek_absen();
                $data['ip'] = $this->Mdashboard->ip();
                $data['settingan'] = $this->Mdashboard->setting();

                $data['notif'] = $this->Mdashboard->notif();

                $data['jumlahkaryawan'] = $this->Mdashboard->jumlahkaryawan();
                $data['jumlahwfo'] = $this->Mdashboard->jumlahwfo();
                $data['jumlahwfh'] = $this->Mdashboard->jumlahwfh();
                $data['jumlahizin'] = $this->Mdashboard->jumlahizin();
                $data['jumlahcuti'] = $this->Mdashboard->jumlahcuti();
                $data['jumlahbelum'] = count($data['jumlahkaryawan']) - (count($data['jumlahwfo']) + count($data['jumlahwfh']) + count($data['jumlahizin']) + count($data['jumlahcuti']));

                $data['beban_kerja'] = $this->Mdashboard->beban_kerja();
                $data['absen_kerja'] = $this->Mdashboard->absen_kerja($_SESSION['nik']);

                $data['polling'] = $this->Mdashboard->polling();

                if ($_SESSION['role'] == 'satpam') {
                    $data['ada_izin'] = $this->Mdashboard->ada_izin();
                    require APPROOT . '/views/inc/header.php';
                    $this->view('dashboard/satpam', $data);
                    require APPROOT . '/views/inc/footer.php';
                }

                if ($_SESSION['role'] == 'pegawai') {
                    $data['ada_izin'] = $this->Mdashboard->ada_izin();
                    require APPROOT . '/views/inc/header.php';
                    $this->view('dashboard/index', $data);
                    require APPROOT . '/views/inc/footer.php';
                }
                if ($_SESSION['role'] == 'admin') {
                    require APPROOT . '/views/inc/header.php';
                    $this->view('dashboard/index_admin', $data);
                    require APPROOT . '/views/inc/footer.php';
                }
                if ($_SESSION['role'] == 'siswa') {
                    require APPROOT . '/views/inc/header.php';
                    $year = date('Y');
                    $month = date('m');
                    $cek_absen_siswa = $this->Mdashboard->cek_absen_siswa();
                    $siswa = $this->Mdashboard->siswa_by_id($_SESSION['nik']);
                    $wali_kelas = $this->Mdashboard->ambil_wali_kelas();
                    $absensi = $this->Mdashboard->cek_absen_siswa_bulan($year, $month);
                    $semester_aktif = $this->Mdashboard->semester_aktif();

                    $absensi_by_date = [];
                    foreach ($absensi as $absen) {
                        $absensi_by_date[$absen->tgl_ahs] = $absen;
                    }

                    $data = [
                        'cek_absen_siswa'   => $cek_absen_siswa,
                        'siswa'             => $siswa,
                        'wali_kelas'        => $wali_kelas,
                        'absensi_by_date'   => $absensi_by_date,
                        'ip'                => $data['ip'],
                        'semester_aktif'    => $semester_aktif
                    ];

                    $this->view('dashboard/index_siswa', $data);
                    require APPROOT . '/views/inc/footer.php';
                }
                if ($_SESSION['role'] == 'piket') {
                    $data['daftar'] = $this->Mpresensi->daftar();

                    if (isset($_GET['tanggal'])) {
                        $tanggal = $_GET['tanggal'];
                    } else {
                        $tanggal = date('Y-m-d');
                    }
                    $data['tanggal'] = $tanggal;

                    $nomor_hari = date('N', strtotime($tanggal));
                    if ($nomor_hari == '1') {
                        $hari = 'Senin';
                    } else if ($nomor_hari == '2') {
                        $hari = 'Selasa';
                    } else if ($nomor_hari == '3') {
                        $hari = 'Rabu';
                    } else if ($nomor_hari == '4') {
                        $hari = 'Kamis';
                    } else if ($nomor_hari == '5') {
                        $hari = 'Jumat';
                    } else if ($nomor_hari == '6') {
                        $hari = 'Sabtu';
                    } else {
                        $hari = 'Minggu';
                    }

                    $data['absen_1'] = $this->Mdashboard->kelas_1($hari);
                    $data['absen_2'] = $this->Mdashboard->kelas_2($hari);
                    $data['absen_3'] = $this->Mdashboard->kelas_3($hari);
                    $data['ip'] = $this->Mdashboard->ip();

                    $kelas_data = array();
                    foreach ($data['absen_1'] as $d) {
                        $kelas = $d->kelas;
                        if (!isset($kelas_data[$kelas])) {
                            $kelas_data[$kelas] = array();
                        }
                        $kelas_data[$kelas][] = array(
                            'kode_kelas' => $d->kode_kelas,
                            'nama1'  => $d->nama1, 'nama2'  => $d->nama2, 'nama3'  => $d->nama3, 'nama4'  => $d->nama4, 'nama5'  => $d->nama5, 'nama6'  => $d->nama6, 'nama7'  => $d->nama7, 'nama8'  => $d->nama8, 'nama9'  => $d->nama9, 'nama10'  => $d->nama10,
                            'singkatan1' => $d->singkatan1, 'singkatan2' => $d->singkatan2, 'singkatan3' => $d->singkatan3, 'singkatan4' => $d->singkatan4, 'singkatan5' => $d->singkatan5, 'singkatan6' => $d->singkatan6, 'singkatan7' => $d->singkatan7, 'singkatan8' => $d->singkatan8, 'singkatan9' => $d->singkatan9, 'singkatan10' => $d->singkatan10,

                            'id_pelajaran1' => $d->id_pelajaran1, 'id_pelajaran2' => $d->id_pelajaran2, 'id_pelajaran3' => $d->id_pelajaran3, 'id_pelajaran4' => $d->id_pelajaran4, 'id_pelajaran5' => $d->id_pelajaran5, 'id_pelajaran6' => $d->id_pelajaran6, 'id_pelajaran7' => $d->id_pelajaran7, 'id_pelajaran8' => $d->id_pelajaran8, 'id_pelajaran9' => $d->id_pelajaran9, 'id_pelajaran10' => $d->id_pelajaran10,

                            'guru1' => $d->guru1, 'guru2' => $d->guru2, 'guru3' => $d->guru3, 'guru4' => $d->guru4, 'guru5' => $d->guru5, 'guru6' => $d->guru6, 'guru7' => $d->guru7, 'guru8' => $d->guru8, 'guru9' => $d->guru9, 'guru10' => $d->guru10,
                            'kode_pegawai1' => $d->kode_pegawai1, 'kode_pegawai2' => $d->kode_pegawai2, 'kode_pegawai3' => $d->kode_pegawai3, 'kode_pegawai4' => $d->kode_pegawai4, 'kode_pegawai5' => $d->kode_pegawai5, 'kode_pegawai6' => $d->kode_pegawai6, 'kode_pegawai7' => $d->kode_pegawai7, 'kode_pegawai8' => $d->kode_pegawai8, 'kode_pegawai9' => $d->kode_pegawai9, 'kode_pegawai10' => $d->kode_pegawai10,
                            'mata_pelajaran1' => $d->mata_pelajaran1, 'mata_pelajaran2' => $d->mata_pelajaran2, 'mata_pelajaran3' => $d->mata_pelajaran3, 'mata_pelajaran4' => $d->mata_pelajaran4, 'mata_pelajaran5' => $d->mata_pelajaran5, 'mata_pelajaran6' => $d->mata_pelajaran6, 'mata_pelajaran7' => $d->mata_pelajaran7, 'mata_pelajaran8' => $d->mata_pelajaran8, 'mata_pelajaran9' => $d->mata_pelajaran9, 'mata_pelajaran10' => $d->mata_pelajaran10,
                            'kelas' => $d->kelas,
                            'ruang' => $d->ruang,
                            'hari' => $d->hari,
                            'validasi' => $d->validasi,
                            'wali_kelas' => $d->wali_kelas,
                            'tanggal_validasi' => $d->tanggal_validasi,
                            'berlaku_jadwal_dari' => $d->berlaku_jadwal_dari
                        );
                    }
                    $data['kelas_data_1'] = $kelas_data;

                    $kelas_data2 = array();
                    foreach ($data['absen_2'] as $d) {
                        $kelas = $d->kelas;
                        if (!isset($kelas_data2[$kelas])) {
                            $kelas_data2[$kelas] = array();
                        }
                        $kelas_data2[$kelas][] = array(
                            'kode_kelas' => $d->kode_kelas,
                            'nama1'  => $d->nama1, 'nama2'  => $d->nama2, 'nama3'  => $d->nama3, 'nama4'  => $d->nama4, 'nama5'  => $d->nama5, 'nama6'  => $d->nama6, 'nama7'  => $d->nama7, 'nama8'  => $d->nama8, 'nama9'  => $d->nama9, 'nama10'  => $d->nama10,
                            'singkatan1' => $d->singkatan1, 'singkatan2' => $d->singkatan2, 'singkatan3' => $d->singkatan3, 'singkatan4' => $d->singkatan4, 'singkatan5' => $d->singkatan5, 'singkatan6' => $d->singkatan6, 'singkatan7' => $d->singkatan7, 'singkatan8' => $d->singkatan8, 'singkatan9' => $d->singkatan9, 'singkatan10' => $d->singkatan10,

                            'id_pelajaran1' => $d->id_pelajaran1, 'id_pelajaran2' => $d->id_pelajaran2, 'id_pelajaran3' => $d->id_pelajaran3, 'id_pelajaran4' => $d->id_pelajaran4, 'id_pelajaran5' => $d->id_pelajaran5, 'id_pelajaran6' => $d->id_pelajaran6, 'id_pelajaran7' => $d->id_pelajaran7, 'id_pelajaran8' => $d->id_pelajaran8, 'id_pelajaran9' => $d->id_pelajaran9, 'id_pelajaran10' => $d->id_pelajaran10,

                            'guru1' => $d->guru1, 'guru2' => $d->guru2, 'guru3' => $d->guru3, 'guru4' => $d->guru4, 'guru5' => $d->guru5, 'guru6' => $d->guru6, 'guru7' => $d->guru7, 'guru8' => $d->guru8, 'guru9' => $d->guru9, 'guru10' => $d->guru10,
                            'kode_pegawai1' => $d->kode_pegawai1, 'kode_pegawai2' => $d->kode_pegawai2, 'kode_pegawai3' => $d->kode_pegawai3, 'kode_pegawai4' => $d->kode_pegawai4, 'kode_pegawai5' => $d->kode_pegawai5, 'kode_pegawai6' => $d->kode_pegawai6, 'kode_pegawai7' => $d->kode_pegawai7, 'kode_pegawai8' => $d->kode_pegawai8, 'kode_pegawai9' => $d->kode_pegawai9, 'kode_pegawai10' => $d->kode_pegawai10,
                            'mata_pelajaran1' => $d->mata_pelajaran1, 'mata_pelajaran2' => $d->mata_pelajaran2, 'mata_pelajaran3' => $d->mata_pelajaran3, 'mata_pelajaran4' => $d->mata_pelajaran4, 'mata_pelajaran5' => $d->mata_pelajaran5, 'mata_pelajaran6' => $d->mata_pelajaran6, 'mata_pelajaran7' => $d->mata_pelajaran7, 'mata_pelajaran8' => $d->mata_pelajaran8, 'mata_pelajaran9' => $d->mata_pelajaran9, 'mata_pelajaran10' => $d->mata_pelajaran10,
                            'kelas' => $d->kelas,
                            'ruang' => $d->ruang,
                            'hari' => $d->hari,
                            'validasi' => $d->validasi,
                            'wali_kelas' => $d->wali_kelas,
                            'tanggal_validasi' => $d->tanggal_validasi,
                            'berlaku_jadwal_dari' => $d->berlaku_jadwal_dari
                        );
                    }
                    $data['kelas_data_2'] = $kelas_data2;

                    $kelas_data3 = array();
                    foreach ($data['absen_3'] as $d) {
                        $kelas = $d->kelas;
                        if (!isset($kelas_data3[$kelas])) {
                            $kelas_data3[$kelas] = array();
                        }
                        $kelas_data3[$kelas][] = array(
                            'kode_kelas' => $d->kode_kelas,
                            'nama1'  => $d->nama1, 'nama2'  => $d->nama2, 'nama3'  => $d->nama3, 'nama4'  => $d->nama4, 'nama5'  => $d->nama5, 'nama6'  => $d->nama6, 'nama7'  => $d->nama7, 'nama8'  => $d->nama8, 'nama9'  => $d->nama9, 'nama10'  => $d->nama10,
                            'singkatan1' => $d->singkatan1, 'singkatan2' => $d->singkatan2, 'singkatan3' => $d->singkatan3, 'singkatan4' => $d->singkatan4, 'singkatan5' => $d->singkatan5, 'singkatan6' => $d->singkatan6, 'singkatan7' => $d->singkatan7, 'singkatan8' => $d->singkatan8, 'singkatan9' => $d->singkatan9, 'singkatan10' => $d->singkatan10,

                            'id_pelajaran1' => $d->id_pelajaran1, 'id_pelajaran2' => $d->id_pelajaran2, 'id_pelajaran3' => $d->id_pelajaran3, 'id_pelajaran4' => $d->id_pelajaran4, 'id_pelajaran5' => $d->id_pelajaran5, 'id_pelajaran6' => $d->id_pelajaran6, 'id_pelajaran7' => $d->id_pelajaran7, 'id_pelajaran8' => $d->id_pelajaran8, 'id_pelajaran9' => $d->id_pelajaran9, 'id_pelajaran10' => $d->id_pelajaran10,

                            'guru1' => $d->guru1, 'guru2' => $d->guru2, 'guru3' => $d->guru3, 'guru4' => $d->guru4, 'guru5' => $d->guru5, 'guru6' => $d->guru6, 'guru7' => $d->guru7, 'guru8' => $d->guru8, 'guru9' => $d->guru9, 'guru10' => $d->guru10,
                            'kode_pegawai1' => $d->kode_pegawai1, 'kode_pegawai2' => $d->kode_pegawai2, 'kode_pegawai3' => $d->kode_pegawai3, 'kode_pegawai4' => $d->kode_pegawai4, 'kode_pegawai5' => $d->kode_pegawai5, 'kode_pegawai6' => $d->kode_pegawai6, 'kode_pegawai7' => $d->kode_pegawai7, 'kode_pegawai8' => $d->kode_pegawai8, 'kode_pegawai9' => $d->kode_pegawai9, 'kode_pegawai10' => $d->kode_pegawai10,
                            'mata_pelajaran1' => $d->mata_pelajaran1, 'mata_pelajaran2' => $d->mata_pelajaran2, 'mata_pelajaran3' => $d->mata_pelajaran3, 'mata_pelajaran4' => $d->mata_pelajaran4, 'mata_pelajaran5' => $d->mata_pelajaran5, 'mata_pelajaran6' => $d->mata_pelajaran6, 'mata_pelajaran7' => $d->mata_pelajaran7, 'mata_pelajaran8' => $d->mata_pelajaran8, 'mata_pelajaran9' => $d->mata_pelajaran9, 'mata_pelajaran10' => $d->mata_pelajaran10,
                            'kelas' => $d->kelas,
                            'ruang' => $d->ruang,
                            'hari' => $d->hari,
                            'validasi' => $d->validasi,
                            'wali_kelas' => $d->wali_kelas,
                            'tanggal_validasi' => $d->tanggal_validasi,
                            'berlaku_jadwal_dari' => $d->berlaku_jadwal_dari
                        );
                    }
                    $data['kelas_data_3'] = $kelas_data3;


                    $this->view('dashboard/index_piket', $data);
                }
            } else {
                // $data['pegawai_all'] = $this->Mdashboard->pegawai_all();
                $this->view('khusus/index'); 
            }
        } else {
            
        }
    }

    public function hadir()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mdashboard->hadir($_POST)) {
            setFlash('Presensi Hadir berhasil.', 'success');
            return redirect('dashboard');
        } else {
            setFlash('Gagal melakukan presensi.', 'danger');
            return redirect('dashboard');
        }
    }

    public function pulang()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mdashboard->pulang($_POST)) {
            setFlash('Presensi pulang berhasil.', 'success');
            return redirect('dashboard');
        } else {
            setFlash('Gagal melakukan presensi.', 'danger');
            return redirect('dashboard');
        }
    }

    public function setting()
    {
        $data['setting'] = $this->Mdashboard->setting();
        require APPROOT . '/views/inc/header.php';
        $this->view('dashboard/setting', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_setting()
    {
        //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mdashboard->simpan_setting($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('dashboard/setting');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('dashboard/setting');
        }
    }

    //---HADIR SISWA -----------------------------
    public function hadir_siswa()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mdashboard->hadir_siswa($_POST)) {
            setFlash('Presensi Hadir berhasil.', 'success');
            return redirect('dashboard');
        } else {
            setFlash('Gagal melakukan presensi.', 'danger');
            return redirect('dashboard');
        }
    }

    public function ganti_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password_baru = $_POST['password_baru'] ?? '';
            $konfirmasi = $_POST['konfirmasi_password'] ?? '';

            if (empty($password_baru) || empty($konfirmasi)) {
                echo json_encode(['success' => false, 'message' => 'Semua field harus diisi']);
                return;
            }

            if (strlen($password_baru) < 6) {
                echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter']);
                return;
            }

            if ($password_baru !== $konfirmasi) {
                echo json_encode(['success' => false, 'message' => 'Konfirmasi password tidak cocok']);
                return;
            }

            $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
            $nik = $_SESSION['nik'];

            if ($this->Mdashboard->update_password($nik, $hashed_password)) {
                unset($_SESSION['password_change_required']);
                echo json_encode(['success' => true, 'message' => 'Password berhasil diubah']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengubah password']);
            }
        }
    }

    public function dismiss_password_popup()
    {
        unset($_SESSION['password_change_required']);
        echo json_encode(['success' => true]);
    }

    // --- KONTROL RFID (ADMIN) ---
    public function rfid_control()
    {
        if ($_SESSION['role'] != 'admin') {
            return redirect('');
        }
        $data['rfid_status'] = $this->Mdashboard->get_rfid_status();
        require APPROOT . '/views/inc/header.php';
        $this->view('dashboard/rfid_control', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_rfid_jadwal()
    {
        if ($_SESSION['role'] != 'admin') {
            setFlash('Tidak memiliki akses', 'error');
            return redirect('');
        }

        $data = [
            'rfid_masuk_buka'   => $_POST['rfid_masuk_buka'],
            'rfid_masuk_tutup'  => $_POST['rfid_masuk_tutup'],
            'rfid_pulang_buka'  => $_POST['rfid_pulang_buka'],
            'rfid_pulang_tutup' => $_POST['rfid_pulang_tutup'],
        ];

        if ($this->Mdashboard->update_rfid_jadwal($data)) {
            setFlash('Jadwal RFID berhasil disimpan.', 'success');
        } else {
            setFlash('Gagal menyimpan jadwal RFID.', 'error');
        }
        return redirect('dashboard/rfid_control');
    }

    // admin bisa mengubah password akun rfid & piket
    public function ubah_akun_rfid() {
        if ($_SESSION['role'] != 'admin') {
            return redirect('');
        }

        $akun_rfid = $this->Mdashboard->get_akun_rfid();
        $data['akun_rfid'] = $akun_rfid;

        require APPROOT . '/views/inc/header.php';
        $this->view('dashboard/ubah_akun_rfid', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_akun_rfid() {
        if ($_SESSION['role'] != 'admin') {
            return redirect('');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return redirect('dashboard/ubah_akun_rfid');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password_baru = trim($_POST['password_baru'] ?? '');
        $konfirmasi_password = trim($_POST['konfirmasi_password'] ?? '');

        if (empty($password_baru) || empty($konfirmasi_password)) {
            setFlash('Semua field harus diisi.', 'danger');
            return redirect('dashboard/ubah_akun_rfid');
        }

        if (strlen($password_baru) < 6) {
            setFlash('Password minimal 6 karakter.', 'danger');
            return redirect('dashboard/ubah_akun_rfid');
        }

        if ($password_baru !== $konfirmasi_password) {
            setFlash('Konfirmasi password tidak cocok.', 'danger');
            return redirect('dashboard/ubah_akun_rfid');
        }

        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
        if ($this->Mdashboard->update_akun_rfid($hashed_password)) {
            setFlash('Password akun RFID berhasil diubah.', 'success');
        } else {
            setFlash('Gagal mengubah password akun RFID.', 'danger');
        }

        return redirect('dashboard/ubah_akun_rfid');
    }

    public function ubah_akun_piket() {
        if ($_SESSION['role'] != 'admin') {
            return redirect('');
        }

        $akun_piket = $this->Mdashboard->get_akun_piket();
        $data['akun_piket'] = $akun_piket;

        require APPROOT . '/views/inc/header.php';
        $this->view('dashboard/ubah_akun_piket', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_akun_piket() {
        if ($_SESSION['role'] != 'admin') {
            return redirect('');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return redirect('dashboard/ubah_akun_piket');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $password_baru = trim($_POST['password_baru'] ?? '');
        $konfirmasi_password = trim($_POST['konfirmasi_password'] ?? '');

        if (empty($password_baru) || empty($konfirmasi_password)) {
            setFlash('Semua field harus diisi.', 'danger');
            return redirect('dashboard/ubah_akun_piket');
        }

        if (strlen($password_baru) < 6) {
            setFlash('Password minimal 6 karakter.', 'danger');
            return redirect('dashboard/ubah_akun_piket');
        }

        if ($password_baru !== $konfirmasi_password) {
            setFlash('Konfirmasi password tidak cocok.', 'danger');
            return redirect('dashboard/ubah_akun_piket');
        }

        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
        if ($this->Mdashboard->update_akun_piket($hashed_password)) {
            setFlash('Password akun Piket berhasil diubah.', 'success');
        } else {
            setFlash('Gagal mengubah password akun Piket.', 'danger');
        }

        return redirect('dashboard/ubah_akun_piket');
    }
}
