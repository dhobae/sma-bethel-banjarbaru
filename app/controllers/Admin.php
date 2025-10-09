<?php
class Admin extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
        //new model instance
        $this->Madmin = $this->model('AdminModel');
        $this->Mpegawai = $this->model('Mpegawai');
    }

    public function index()
    {
        $admin = $this->Madmin->get();
        $no = 0;
        $data = [
            'title' => 'Daftar Admin',
            'menu' => 'Pegawai',
            'admin' => $admin
        ];
        foreach ($admin as $adm) {
            $data['pegawai'][$no] = $this->Madmin->getAllNIP($adm->nip_pegawai);
            $no++;
        }

        require APPROOT . '/views/inc/header.php';
        $this->view('admin/index', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //edit
    public function edit($id = '')
    {
        $data['title'] = 'Edit Admin';
        $data['menu'] = 'Pegawai';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //validate error free
            if (empty($_POST['pegawai'])) {
                //load view with error
                setFlash('Form input tidak boleh kosong', 'danger');
                return redirect('admin/edit/' . $_POST['id']);
            } else {
                if ($this->Madmin->update($_POST)) {
                    setFlash('Admin berhasil diperbarui.', 'success');
                    return redirect('admin/edit/' . $_POST['id']);
                } else {
                    setFlash('Gagal memperbarui Admin', 'danger');
                    return redirect('admin');
                }
            }
        } else {
            $admin = $this->Madmin->getById($id);
            if ($admin) {
                $data['id'] = $id;
                $data['admin'] = $admin;
                $data['pegawai'] = $this->Madmin->getAllNIP($data['admin']->nip_pegawai);
                $data['daftar_pegawai'] = $this->Madmin->get_pegawai();

                require APPROOT . '/views/inc/header.php';
                $this->view('admin/edit', $data);
                require APPROOT . '/views/inc/footer.php';
            } else {
                return redirect('admin');
            }
        }
    }

    public function deleteAdmin($data)
    {
        $array = explode('-', $data);
        $idAdmin = $array[0];
        $nip = $array[1];

        $admin = $this->Madmin->getById($idAdmin);
        $pegawai = explode(',', $admin->nip_pegawai);
        if (($key = array_search($nip, $pegawai)) !== false) {
            unset($pegawai[$key]);
        }
        $newdata['id'] = $idAdmin;
        $newdata['pegawai'] = $pegawai;
        if ($this->Madmin->update($newdata) > 0) {
            setFlash('Berhasil hapus admin.', 'success');
            return redirect('admin/edit/' . $idAdmin);
        }
    }

    //-- ADMIN KURIKULUM ----------------------
    public function kurikulum()
    {
        $admin = $this->Madmin->get_kurikulum();
        $no = 0;
        $data = [
            'title' => 'Daftar Admin',
            'menu' => 'Pegawai',
            'admin' => $admin
        ];
        foreach ($admin as $adm) {
            $data['pegawai'][$no] = $this->Madmin->getAllNIP($adm->nip_pegawai);
            $no++;
        }

        require APPROOT . '/views/inc/header.php';
        $this->view('admin/index', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //-- ADMIN DAR ----------------------
    public function DAR()
    {
        $admin = $this->Madmin->get_dar();
        $no = 0;
        $data = [
            'title' => 'Daftar Admin DAR',
            'menu' => 'Pegawai',
            'admin' => $admin
        ];
        foreach ($admin as $adm) {
            $data['pegawai'][$no] = $this->Madmin->getAllNIP($adm->nip_pegawai);
            $no++;
        }

        require APPROOT . '/views/inc/header.php';
        $this->view('admin/dar', $data);
        require APPROOT . '/views/inc/footer.php';
    }

    //edit
    public function DAR_edit($id = '')
    {
        $data['title'] = 'Edit Admin';
        $data['menu'] = 'Pegawai';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (empty($_POST['pegawai'])) {
                setFlash('Form input tidak boleh kosong', 'danger');
                return redirect('admin/DAR_edit/' . $_POST['id']);
            } else {
                if ($this->Madmin->update($_POST)) {
                    setFlash('Admin berhasil diperbarui.', 'success');
                    return redirect('admin/DAR_edit/' . $_POST['id']);
                } else {
                    setFlash('Gagal memperbarui Admin', 'danger');
                    return redirect('admin');
                }
            }
        } else {
            $admin = $this->Madmin->getById($id);
            if ($admin) {
                $data['id'] = $id;
                $data['admin'] = $admin;
                $data['pegawai'] = $this->Madmin->getAllNIP($data['admin']->nip_pegawai);
                $data['daftar_pegawai'] = $this->Madmin->get_pegawai();

                require APPROOT . '/views/inc/header.php';
                $this->view('admin/dar_edit', $data);
                require APPROOT . '/views/inc/footer.php';
            } else {
                return redirect('admin/DAR');
            }
        }
    }

    public function deleteAdminDAR($data)
    {
        $array = explode('-', $data);
        $idAdmin = $array[0];
        $nip = $array[1];

        $admin = $this->Madmin->getById($idAdmin);
        $pegawai = explode(',', $admin->nip_pegawai);
        if (($key = array_search($nip, $pegawai)) !== false) {
            unset($pegawai[$key]);
        }
        $newdata['id'] = $idAdmin;
        $newdata['pegawai'] = $pegawai;
        if ($this->Madmin->update($newdata) > 0) {
            setFlash('Berhasil hapus admin.', 'success');
            return redirect('admin/DAR_edit/' . $idAdmin);
        }
    }
}
