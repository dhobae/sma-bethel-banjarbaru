<?php 
class User extends Controller{

    public function __construct()
    {
        if(!isLoggedIn()){
            return redirect('auth/login');
        }
        //new model instance
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
      $user = $this->userModel->getByLogin();
      
      $data = [
          'title' => 'Pengaturan Akun',
          'user' => $user
      ];

      $this->view('user/index', $data);
    }

    public function changePassword()
    {
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (empty($_POST['password']) || empty($_POST['password_baru']) || empty($_POST['konfirmasi_password_baru'])) {
          setFlash('Form input tidak boleh kosong','danger');
          return redirect('user');
        }
        if ($_POST['password_baru'] !== $_POST['konfirmasi_password_baru']) {
          setFlash('Konfrimasi Password Baru tidak sama', 'danger');
          return redirect('user');
        }
        if ($this->userModel->changePassword($_POST)) {
          setFlash('Berhasil memperbarui password anda', 'success');
          return redirect('user');
        }else{
          setFlash('Gagal memperbarui password anda', 'danger');
          return redirect('user');
        }
      }else{
        return redirect('user');
      }
    }

    public function changeProfile()
    {
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (empty($_POST['nama']) || empty($_POST['no_telp']) || empty($_POST['email']) || empty($_POST['username'])) {
          setFlash('Form input tidak boleh kosong', 'danger');
          return redirect('user');
        }
        if ($this->userModel->changeProfile($_POST,$_FILES)) {
          setFlash('Berhasil memperbarui profile anda', 'success');
          return redirect('user');
        }else{
          setFlash('Gagal memperbarui profile anda', 'danger');
          return redirect('user');
        }
      }else{
        return redirect('user');
      }
    }

}