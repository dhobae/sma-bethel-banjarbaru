<?php 
class LogUser extends Controller{

    public function __construct()
    {
        if(!isLoggedIn()){
            return redirect('auth/login');
        }
        //new model instance
        $this->logUserModel = $this->model('LogUserModel');
    }

    public function index(){
        $log_user = $this->logUserModel->get();
        $data = [
            'title' => 'Log User',
            'menu' => 'Admin',
            'log_user' => $log_user
        ];

        $this->view('log_user/index', $data);
    }
}                            
                        