<?php
class Logout extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {
            return redirect('auth/login');
        }
    }

    public function index()
    {
        //$data['user'] = $this->pegawaiModel->get();
        //$this->view('dashboard/index', $data);
        require APPROOT . '/views/inc/header.php';
        $this->view('logout/logout');
        require APPROOT . '/views/inc/footer.php';
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        session_destroy();
        return redirect('auth/login');
    }
}
