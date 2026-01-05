<?php
class Presensi extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
        $this->Mpresensi = $this->model('Mpresensi');
        $this->Mrekap = $this->model('Mrekap');
    }

    public function index()
    {
        $data['daftar'] = $this->Mpresensi->daftar();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/daftar_hadir', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function daftar_hadir_wfo()
    {
        $data['daftar'] = $this->Mpresensi->daftar_wfo();

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/daftar_hadir', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function daftar_hadir_wfh()
    {
        $data['daftar'] = $this->Mpresensi->daftar_wfh();

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/daftar_hadir', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function belum_absen()
    {
        $data['daftar'] = $this->Mpresensi->belum_absen();

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/daftar_hadir', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function hari_libur()
    {
        $data['libur'] = $this->Mpresensi->libur();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/hari_libur', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function tambah_libur()
    {
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/tambah_libur');
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_libur()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_libur($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/hari_libur');
        } else {
            setFlash('Gagal disimpan.', 'danger');
            return redirect('presensi/hari_libur');
        }
    }

    public function hapus_libur($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mpresensi->hapus_libur($id);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'ID tidak valid.');
        }
        echo json_encode($response);
    }

    public function ajukan_izin()
    {
        $username = $_SESSION['username'];
        $data['libur'] = $this->Mpresensi->libur();
        $data['ajukan_izin'] = $this->Mpresensi->ajukan_izin($username);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/ajukan_izin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function ajukan()
    {
        $username = $_SESSION['username'];
        $data['libur'] = $this->Mpresensi->libur();
        $data['ajukan_izin'] = $this->Mpresensi->ajukan_izin($username);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/ajukan', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_pengajuan_izin()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_pengajuan_izin($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/ajukan_izin');
        } else {
            setFlash('Terdapat tanggal yang sama pada tanggal yang anda masukkan.', 'error');
            return redirect('presensi/ajukan_izin');
        }
    }

    public function edit_pengajuan_izin($id)
    {
        $data['ajukan_izin_byid'] = $this->Mpresensi->ajukan_izin_byid($id);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/ajukan_edit', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_edit_pengajuan_izin()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_edit_pengajuan_izin($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/ajukan_izin');
        } else {
            setFlash('Gagal disimpan.', 'danger');
            return redirect('presensi/ajukan_izin');
        }
    }

    public function hapus_pengajuan_izin($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mpresensi->hapus_pengajuan_izin($id);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'ID tidak valid.');
        }
        echo json_encode($response);
    }

    public function karyawan()
    {
        $data['karyawan'] = $this->Mpresensi->karyawan();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/karyawan', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function karyawan_add()
    {
        $data['jabatan'] = $this->Mpresensi->jabatan();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/karyawan_add', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function karyawan_simpan()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->karyawan_simpan($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/karyawan');
        } else {
            setFlash('Gagal disimpan.', 'danger');
            return redirect('presensi/karyawan');
        }
    }

    public function karyawan_edit()
    {
        $npk = $_GET['id'];
        $data['jabatan'] = $this->Mpresensi->jabatan();
        $data['karyawan'] = $this->Mpresensi->karyawan_byid($npk);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/karyawan_edit', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function karyawan_edit_simpan()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->karyawan_edit_simpan($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/karyawan');
        } else {
            setFlash('Gagal disimpan.', 'danger');
            return redirect('presensi/karyawan');
        }
    }

    public function karyawan_hapus()
    {
        $id = $_GET['id'];
        $result = $this->Mpresensi->karyawan_hapus($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
        }
        echo json_encode($response);
    }

    public function wfh()
    {
        $data['karyawan_wfh'] = $this->Mpresensi->karyawan_wfh();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/wfh', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function today()
    {
        if (isset($_GET['tanggal'])) {
            $tanggal = $_GET['tanggal'];
        } else {
            $tanggal = date('Y-m-d');
        }
        $data['tanggal'] = $tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        $data['jam_kerja'] = $this->Mpresensi->jam_kerja_bydate($bulan, $tahun);
        $data['today'] = $this->Mpresensi->today();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/today_baru', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function rekap_jam_kerja()
    {
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }

        if (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        //$data['jam_kerja'] = $this->Mpresensi->jam_kerja();
        $data['jam_kerja'] = $this->Mpresensi->jam_kerja_bydate($bulan, $tahun);
        $data['rekap_jam_kerja'] = $this->Mpresensi->rekap_jam_kerja($bulan, $tahun);
        $data['rekap_jam_kerja_nik'] = $this->Mpresensi->rekap_jam_kerja_nik($bulan, $tahun);
        $data['jumlah_libur'] = $this->Mpresensi->jumlah_libur($bulan, $tahun);

        // intip_data($data);

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/rekap_jam_kerja_baru', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function rekap_wfo_wfh()
    {
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }

        if (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $data['jam_kerja'] = $this->Mpresensi->jam_kerja();
        $data['rekap_wfo_wfh'] = $this->Mpresensi->rekap_wfo_wfh($bulan, $tahun);
        $data['query_libur'] = $this->Mpresensi->query_libur($bulan, $tahun);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/rekap_wfo_wfh', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //---------------------
    public function daftar_izin()
    {
        $data['daftar_izin'] = $this->Mpresensi->daftar_izin();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/daftar_izin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function tambah_izin()
    {
        $data['daftar'] = $this->Mpresensi->daftar3();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/tambah_izin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function edit_izin($id)
    {
        $data['edit'] = $this->Mpresensi->daftar_izin_byid($id);
        $data['daftar'] = $this->Mpresensi->daftar2();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/edit_izin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_tambah_izin()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_tambah_izin($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/daftar_izin');
        } else {
            setFlash('Terdapat tanggal yang sama dari tanggal yang anda masukkan.', 'error');
            return redirect('presensi/daftar_izin');
        }
    }

    public function simpan_edit_tambah_izin()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_edit_tambah_izin($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/daftar_izin');
        } else {
            setFlash('Gagal disimpan.', 'danger');
            return redirect('presensi/daftar_izin');
        }
    }

    public function hapus_izin($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mpresensi->hapus_izin($id);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'ID tidak valid.');
        }
        echo json_encode($response);
    }

    public function permohonan_izin()
    {
        $data['tmp_izin'] = $this->Mpresensi->tmp_izin();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/permohonan_izin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function hapus_permohonan_izin()
    {
        $id = $_GET['id'];
        $result = $this->Mpresensi->hapus_permohonan_izin($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
        }
        echo json_encode($response);
    }

    public function acc_permohonan($id)
    {
        $data['tmp_izin'] = $this->Mpresensi->tmp_izin_byid($id);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/permohonan_izin_acc', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_acc_permohonan()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_acc_permohonan($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/permohonan_izin');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('presensi/permohonan_izin');
        }
    }

    public function showloc()
    {
        $this->view('presensi/show_loc');
    }

    //-- RESET ABSEN -----------------------------------
    public function reset_absen()
    {
        $id = $_GET['id'];
        $result = $this->Mpresensi->reset_absen($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Presensi datang anda berhasil direset.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal direset.');
        }
        echo json_encode($response);
    }

    public function reset_absen_pulang()
    {
        $id = $_GET['id'];
        $result = $this->Mpresensi->reset_absen_pulang($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Presensi pulang anda berhasil direset.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal direset.');
        }
        echo json_encode($response);
    }

    public function reset($id)
    {
        $data['reset'] = $this->Mpresensi->ambil_reset($id);
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/reset', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_absen_admin()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_absen_admin($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/today');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('presensi/today');
        }
    }

    public function setting_urutan()
    {
        $data['pegawai'] = $this->Mpresensi->setting_urutan();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/setting_urutan', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function reset_urutan()
    {
        $result = $this->Mpresensi->reset_urutan();
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Urutan berhasil direset.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal direset.');
        }
        echo json_encode($response);
    }

    public function simpan_urutan()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = array();
        foreach ($_POST['nik'] as $key => $nik) {
            $data[$nik] = $_POST['urutan'][$key];
        }

        if ($this->Mpresensi->simpan_urutan($data)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/setting_urutan');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('presensi/setting_urutan');
        }
    }

    //-- ISIKAN PRESENSI ------------------------
    public function isikan_presensi()
    {
        $data['pegawai'] = $this->Mpresensi->daftar3();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/isikan_presensi', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_isikan_absen()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_isikan_absen($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('presensi/today');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('presensi/today');
        }
    }

    //--- IZIN PADA JAM KERJA -----------------------------------
    public function izin_jam_kerja()
    {
        $data['pegawai'] = $this->Mpresensi->daftar3();
        $data['izin_jam_kerja'] = $this->Mpresensi->izin_jam_kerja();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/izin_jam_kerja', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_izin_jam_kerja()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->simpan_izin_jam_kerja($_POST)) {
            setFlash('Data Berhasil disimpan.', 'success');
            return redirect('presensi/izin_jam_kerja');
        } else {
            setFlash('Gagal disimpan, kemungkinan ada jam yang sama pada hari ini.', 'error');
            return redirect('presensi/izin_jam_kerja');
        }
    }

    public function edit_izin_jam_kerja()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->edit_izin_jam_kerja($_POST)) {
            setFlash('Data Berhasil disimpan.', 'success');
            return redirect('presensi/izin_jam_kerja');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('presensi/izin_jam_kerja');
        }
    }

    public function status_izin_jam_kerja()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpresensi->status_izin_jam_kerja($_POST)) {
            setFlash('Data Berhasil disimpan.', 'success');
            return redirect('presensi/izin_jam_kerja');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('presensi/izin_jam_kerja');
        }
    }

    public function hapus_izin_jam_kerja($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mpresensi->hapus_izin_jam_kerja($id);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'ID tidak valid.');
        }
        echo json_encode($response);
    }


    public function lihat_detail()
    {
        $nik = $_GET['id'];

        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
        } else {
            $bulan = date('m');
        }

        if (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }

        $data['rekap'] = $this->Mpresensi->rekap();
        $data['ambil_nama'] = $this->Mpresensi->ambil_nama($nik);
        $data['jam_kerja'] = $this->Mpresensi->jam_kerja_bydate($bulan, $tahun);

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/lihat_detail_baru', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //------------------------
    public function teman_hadir()
    {
        $data['daftar'] = $this->Mpresensi->teman_hadir();

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/daftar_hadir_siswa', $data);
        require APPROOT . '/views/inc/footer.php';
    }


    //-------------------------
    public function rekap_cuti()
    {
        $tahun = date('Y');
        $data['rekap_cuti'] = $this->Mpresensi->nama_rekap_cuti($tahun);

        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/rekap_cuti', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //-------------------------------
    public function device()
    {
        if (isset($_GET['tanggal'])) {
            $tanggal = $_GET['tanggal'];
        } else {
            $tanggal = date('Y-m-d');
        }
        $data['tanggal'] = $tanggal;

        $data['device'] = $this->Mpresensi->device();
        require APPROOT . '/views/inc/header.php';
        $this->view('presensi/device', $data);
        require APPROOT . '/views/inc/footer.php';
    }
}
