<?php
class Absen extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
        $this->Mabsen = $this->model('Mabsen');
    }

    public function index()
    {
        $data['jadwal'] = $this->Mabsen->jadwal();
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/absen', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function isi_absen($kelas, $ruang, $jam, $tgl, $id_pelajaran, $wali_kelas)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mabsen->isi_absen($_POST, $kelas, $ruang, $jam, $tgl, $id_pelajaran, $wali_kelas)) {
            $response = array('status' => 'success', 'message' => 'Data absen berhasil disimpan');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Data absen gagal disimpan');
            echo json_encode($response);
        }
    }

    public function reset_absen($id)
    {
        if ($this->Mabsen->reset_absen($id)) {
            $response = array('status' => 'success', 'message' => 'Data berhasil di reset');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Data gagal direset');
            echo json_encode($response);
        }
    }

    public function rekap_saya()
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

        $data['rekap_absen_saya'] = $this->Mabsen->rekap_absen_saya($bulan, $tahun);
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/rekap_saya', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //-- ADMIN ----------------------------------------
    public function rekap_mengajar()
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

        $data['rekap_absen_admin'] = $this->Mabsen->rekap_mengajar_admin($bulan, $tahun);
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/rekap_mengajar', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function rekap()
    {
        $nik = $_GET['nik'];

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

        //$data['rekap_absen_saya'] = $this->Mabsen->rekap_absen_saya($bulan, $tahun);
        $data['rekap_absen_nik'] = $this->Mabsen->rekap_absen_nik($nik, $bulan, $tahun);
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/rekap', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //-- IZIN MENGAJAR 
    public function izin_mengajar()
    {
        $nik = $_SESSION['nik'];
        $data['izin'] = $this->Mabsen->izin_by_nik($nik);
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/izin_mengajar', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function tambah()
    {
        $data['pelajaran'] = $this->Mabsen->pelajaran();
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/tambah_izin_mengajar', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_izin_mengajar()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mabsen->simpan_izin_mengajar($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('absen/izin_mengajar');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('absen/izin_mengajar');
        }
    }

    public function simpan_edit_izin_mengajar()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mabsen->simpan_edit_izin_mengajar($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('absen/izin_mengajar');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('absen/izin_mengajar');
        }
    }

    public function hapus_izin_mengajar($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mabsen->hapus_izin_mengajar($id);
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

    public function hapus_transaksi_izin_mengajar($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mabsen->hapus_transaksi_izin_mengajar($id);
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

    public function edit_izin_mengajar($id)
    {
        $data['pelajaran'] = $this->Mabsen->pelajaran();
        $data['izin'] = $this->Mabsen->izin_mengajar_byid($id);
        $data['transaksi'] = $this->Mabsen->izin_transaksi_by_id($id);
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/edit_izin_mengajar', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function izin_guru()
    {
        $data['izin'] = $this->Mabsen->izin_guru();
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/izin_guru', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function acc_izin()
    {
        $id = $_GET['id'];
        $hp = $_GET['hp'];
        if ($id !== false && $id > 0) {
            $result = $this->Mabsen->acc_izin($id, $hp);
            if ($result) {
                $response = array('status' => 'success', 'message' => 'Data berhasil diacc.');
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal di acc.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'ID tidak valid.');
        }
        echo json_encode($response);
    }

    //-- IZIN MENGAJAR VERSI 2 ----- 
    public function izin()
    {
        $data['jadwal'] = $this->Mabsen->jadwal();
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/new/izin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function isi_izin($kelas, $ruang, $jam, $tgl)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mabsen->isi_absen($_POST, $kelas, $ruang, $jam, $tgl)) {
            $response = array('status' => 'success', 'message' => 'Data absen berhasil disimpan');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'message' => 'Data absen gagal disimpan');
            echo json_encode($response);
        }
    }

    public function jurnal_mengajar()
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

        $data['rekap_absen_saya'] = $this->Mabsen->rekap_absen_saya($bulan, $tahun);
        require APPROOT . '/views/inc/header.php';
        $this->view('absen/jurnal_mengajar', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_jurnal()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        if ($this->Mabsen->simpan_jurnal($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('absen/jurnal_mengajar?bulan=' . $bulan . '&tahun=' . $tahun . '&submit=');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('absen/jurnal_mengajar?bulan=' . $bulan . '&tahun=' . $tahun . '&submit=');
        }
    }

    public function cetak_jurnal_saya()
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

        $data['rekap_absen_saya'] = $this->Mabsen->rekap_absen_saya($bulan, $tahun);
        $this->view('absen/cetak_jurnal_saya', $data);
    }

    public function cetak_jurnal_admin()
    {
        $nik = $_GET['nik'];

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

        $data['rekap_absen_nik'] = $this->Mabsen->rekap_absen_nik($nik, $bulan, $tahun);
        $this->view('absen/cetak_jurnal_admin', $data);
    }
}
