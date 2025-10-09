<?php
class Dar extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
        $this->Mdar = $this->model('Mdar');
    }

    public function laporan()
    {
        $nik = $_SESSION['nik'];

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

        $data['dar'] = $this->Mdar->dar_saya($nik, $bulan, $tahun);
        require APPROOT . '/views/inc/header.php';
        $this->view('dar/laporan');
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_isi()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $dataField  = $_POST['dataField'] ?? '';
            $nik        = $_POST['nik'] ?? '';
            $tanggal    = $_POST['tanggal'] ?? '';

            $cek = $this->Mdar->cek_isi($nik, $tanggal);

            if ($cek) {
                $result = $this->Mdar->update_isi($dataField, $nik, $tanggal);
            } else {
                $result = $this->Mdar->simpan_isi($dataField, $nik, $tanggal);
            }

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data.']);
            }
        }
    }

    //----- admin --------------------------------------
    public function admin()
    {
        if (isset($_GET['bulan'])) {
            $bulan = $_GET['bulan'];
            $data['bulan'] = $bulan;
        } else {
            $bulan = date('m');
            $data['bulan'] = $bulan;
        }

        if (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
            $data['tahun'] = $tahun;
        } else {
            $tahun = date('Y');
            $data['tahun'] = $tahun;
        }

        if (isset($_GET['nik'])) {
            $nik = $_GET['nik'];
            $data['nik'] = $nik;
        } else {
            $nik = $_SESSION['nik'];
            $data['nik'] = $nik;
        }

        $data['pegawai'] = $this->Mdar->pegawai();

        require APPROOT . '/views/inc/header.php';
        $this->view('dar/admin', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //--- WAJIB DAR ----------------------------------
    public function wajib()
    {
        $data['wajib'] = $this->Mdar->wajib_dar();
        $data['tidak_wajib'] = $this->Mdar->tidak_wajib_dar();
        require APPROOT . '/views/inc/header.php';
        $this->view('dar/wajib', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function hidupkan_dar()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mdar->hidupkan_dar($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('dar/wajib');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('dar/wajib');
        }
    }

    public function matikan_dar()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mdar->matikan_dar($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('dar/wajib');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('dar/wajib');
        }
    }
}
