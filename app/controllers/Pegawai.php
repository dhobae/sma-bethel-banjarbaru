<?php
class Pegawai extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
        $this->Mpegawai = $this->model('Mpegawai');
    }

    public function index($status = null)
    {
        if ($status == '') {
            $status = 'Aktif';
        } else if ($status == 'Aktif') {
            $status = 'Aktif';
        } else {
            $status = 'Tidak';
        }

        $data['status'] = $status;
        $data['pegawai'] = $this->Mpegawai->pegawai_bystatus($status);
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/index', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function add()
    {
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/add');
        require APPROOT . '/views/inc/footer.php';
    }

    public function edit($id_pegawai)
    {
        $data['pegawai'] = $this->Mpegawai->pegawai_byid($id_pegawai);
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/edit', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function lihat($id_pegawai)
    {
        $data['pegawai'] = $this->Mpegawai->pegawai_byid($id_pegawai);
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/lihat', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan()
    {
        $nik = $_POST['nik'];
        $data['cek_nik'] =  $this->Mpegawai->cek_nik($nik);
        if ($data['cek_nik']) {
            setFlash('NIK yang anda masukkan sudah digunakan.', 'error');
            return redirect('pegawai/add');
        }

        $username = $_POST['nik'];
        $data['cek_username'] =  $this->Mpegawai->cek_username($username);
        if ($data['cek_username']) {
            setFlash('Username yang anda masukkan sudah digunakan.', 'error');
            return redirect('pegawai/add');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->simpan($_POST, $_FILES)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('pegawai');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('pegawai');
        }
    }

    public function simpan_edit()
    {
        $nik = $_POST['nik'];
        $nik_lama = $_POST['nik_lama'];
        if ($nik != $nik_lama) {
            $data['cek_nik'] =  $this->Mpegawai->cek_nik($nik);
            if ($data['cek_nik']) {
                setFlash('NIK yang anda masukkan sudah digunakan.', 'error');
                return redirect('pegawai/add');
            }
        }

        $username = $_POST['username'];
        $username_lama = $_POST['username_lama'];
        if ($username != $username_lama) {
            $data['cek_username'] =  $this->Mpegawai->cek_username($username);
            if ($data['cek_username']) {
                setFlash('Username yang anda masukkan sudah digunakan.', 'error');
                return redirect('pegawai/add');
            }
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->simpan_edit($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            if ($_SESSION['role'] == 'admin') {
                return redirect('pegawai');
            } else {
                return redirect('pegawai/saya');
            }
        } else {
            setFlash('Gagal disimpan.', 'error');
            if ($_SESSION['role'] == 'admin') {
                return redirect('pegawai');
            } else {
                return redirect('pegawai/saya');
            }
        }
    }

    public function master_jam_all()
    {
        $data['jam'] = $this->Mpegawai->master_jam_all();
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/master_jam_all', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function master_jam()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 'kosong';
        }
        $data['id'] = $id;
        $data['jam'] = $this->Mpegawai->master_jam_byid($id);
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/master_jam', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_jam()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->simpan_jam($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('pegawai/master_jam_all');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('pegawai/master_jam_all');
        }
    }

    //---------------------------------------------------------
    public function ip_address()
    {
        $data['ip'] = $this->Mpegawai->ip_address();
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/ip_address', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_ip_address()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->simpan_ip_address($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('pegawai/ip_address');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('pegawai/ip_address');
        }
    }

    public function edit_ip_address()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->edit_ip_address($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('pegawai/ip_address');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('pegawai/ip_address');
        }
    }

    public function hapus_ip_address($id)
    {
        if ($id !== false && $id > 0) {
            $result = $this->Mpegawai->hapus_ip_address($id);
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

    //-- KHUSUS ------------------------------
    public function simpan_foto()
    {
        $id_pegawai = $_POST['id_pegawai'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->Mpegawai->simpan_foto($_POST, $_FILES)) {
                setFlash('Berhasil memperbarui foto profile', 'success');
                if ($_SESSION['role'] == 'admin') {
                    return redirect('pegawai/edit/' . $id_pegawai);
                } else {
                    return redirect('pegawai/saya');
                }
            } else {
                setFlash('Gagal memperbarui foto profile', 'danger');
                if ($_SESSION['role'] == 'admin') {
                    return redirect('pegawai/edit/' . $id_pegawai);
                } else {
                    return redirect('pegawai/saya');
                }
            }
        } else {
            if ($_SESSION['role'] == 'admin') {
                return redirect('pegawai/edit/' . $id_pegawai);
            } else {
                return redirect('pegawai/saya');
            }
        }
    }

    //--- SAYA ----------------------------------
    public function saya()
    {
        $data['pegawai'] = $this->Mpegawai->saya();
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/edit', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_nomor_hp()
    {
        $proses = $_POST['proses'];

        if ($proses == "simpan") {
            echo "simpan";
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if ($this->Mpegawai->simpan_nomor_hp($_POST)) {
                setFlash('Berhasil disimpan.', 'success');
                return redirect('dashboard');
            } else {
                setFlash('Gagal disimpan.', 'error');
                return redirect('dashboard');
            }
        } else {
            $data['no_telp'] = $_POST['nomor_hp'];
            $data['isi_pesan'] = 'Nomor WhatsApp anda sudah terkoneksi dengan sistem Notfifikasi Presensi SMK Telkom Banjarbaru';
            notifWA($data);
            setFlash('WA terkirim.', 'success');
            return redirect('dashboard');
        }
    }

    //--------------------
    public function hapus()
    {
        $id = $_GET['id'];
        $result = $this->Mpegawai->hapus($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
        }
        echo json_encode($response);
    }

    //-SEND WA----------------------
    public function send_wa()
    {
        $nik = $_SESSION['nik'];
        if ($_SESSION['role'] == 'admin') {
            $data['send'] = $this->Mpegawai->send_wa();
        } else {
            $data['send'] = $this->Mpegawai->send_wa_bynik($nik);
        }
        require APPROOT . '/views/inc/header.php';
        if ($_SESSION['role'] == 'admin') {
            $this->view('pegawai/send_wa_admin', $data);
        } else {
            $this->view('pegawai/send_wa', $data);
        }
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_send_wa()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->simpan_send_wa($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('pegawai/send_wa');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('pegawai/send_wa');
        }
    }

    public function edit_send_wa($id)
    {
        $data['send'] = $this->Mpegawai->edit_send_wa($id);
        require APPROOT . '/views/inc/header.php';
        $this->view('pegawai/send_wa_edit', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    public function simpan_edit_send_wa()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if ($this->Mpegawai->simpan_edit_send_wa($_POST)) {
            setFlash('Berhasil disimpan.', 'success');
            return redirect('pegawai/send_wa');
        } else {
            setFlash('Gagal disimpan.', 'error');
            return redirect('pegawai/send_wa');
        }
    }

    public function kunci()
    {
        $id = $_GET['nik'];
        $result = $this->Mpegawai->kunci($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Data berhasil dikunci.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal dikunci.');
        }
        echo json_encode($response);
    }

    public function bukakunci()
    {
        $id = $_GET['nik'];
        $result = $this->Mpegawai->bukakunci($id);
        if ($result) {
            $response = array('status' => 'success', 'message' => 'Kunci berhasil dibuka.');
        } else {
            $response = array('status' => 'error', 'message' => 'Gagal dibuka.');
        }
        echo json_encode($response);
    }
}
