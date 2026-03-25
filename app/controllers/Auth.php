<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

class Auth extends Controller
{
   public function __construct()
   {
      $this->userModel = $this->model('UserModel');
      $this->logUserModel = $this->model('LogUserModel');
      $this->Mdashboard = $this->model('Mdashboard');

      session_regenerate_id(true);
      if (!isset($_SESSION['csrf_token'])) {
         $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      }
   }

   public function index()
   {
      if (isLoggedIn()) {
         return redirect('dashboard');  
      } else {
         return redirect('auth/login');
      }
   }

   public function login()
   {
      if (isLoggedIn()) {
         redirect('dashboard');
      } else {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
               die('CSRF validation failed.');
            }

            $data = [
               'username' => trim($_POST['username']),
               'password' => trim($_POST['password']),
               'username_err' => '',
               'password_err' => ''
            ];

            if (empty($data['username'])) {
               $data['username_err'] = 'Please enter username';
            } elseif (!$this->userModel->findUserByUsernameOrNIP($data['username'])) {
               $data['username_err'] = 'User not found';
            }

            if (empty($data['password'])) {
               $data['password_err'] = 'Please enter your password';
            }

            $ip_address = $_SERVER['REMOTE_ADDR'];
            if ($this->userModel->isBruteForce($ip_address)) {
              die('Too many failed login attempts. Try again later.');
            }

            if (empty($data['username_err']) && empty($data['password_err'])) {
               $loggedInUser = $this->userModel->login($data['username'], $data['password']);

               if ($loggedInUser) {
                  $this->userModel->resetLoginAttempts($ip_address);
                  $cek_pengunjung = $this->logUserModel->pengunjung($data['username']);
                  if (!$cek_pengunjung) {
                     $this->logUserModel->simpan_pengunjung($_POST);
                  }

                  $this->createUserSession($loggedInUser);
               } else {
                  $data['password_err'] = 'Password incorrect';
                  $this->userModel->recordLoginAttempt($ip_address);
                  $data['ip'] = $this->userModel->ip();
                  $data['csrf_token'] = $_SESSION['csrf_token'];
                  $this->view('auth/login', $data);
               }
            } else {
               $data['ip'] = $this->userModel->ip();
               $data['csrf_token'] = $_SESSION['csrf_token'];
               $this->view('auth/login', $data);
            }
         } else {
            $data = [
               'username' => '',
               'password' => '',
               'username_err' => '',
               'password_err' => '',
               'csrf_token' => $_SESSION['csrf_token']
            ];

            $data['ip'] = $this->userModel->ip();
            $this->view('auth/login', $data);
         }
      }
   }

   public function createUserSession($user)
   {
      $_SESSION['id_user'] = $user->id_user;
      $_SESSION['id_pegawai'] = $user->id_pegawai;
      $_SESSION['username'] = $user->username;
      $_SESSION['nik'] = $user->nik_user;
      $_SESSION['nama'] = $user->nama_user;
      $_SESSION['role'] = $user->role;
      $_SESSION['waktu_login'] = date('Y-m-d H:i:s');
      $_SESSION['avatar'] = $user->avatar;
      $_SESSION['nomor_hp'] = $user->nomor_hp;
      $_SESSION['kunci'] = bin2hex(random_bytes(16));

      if ($_SESSION['role'] != 'admin') {
         // Cek apakah password masih default "user"
         if (password_verify('user', $user->password)) {
            $_SESSION['password_change_required'] = true;
         }
      }

      if($_SESSION['role'] == 'siswa') {
         $_SESSION['avatar'] = $user->foto_siswa;
         $_SESSION['nis'] = $user->nik_user;
      }


      return redirect('dashboard');
   }

   public function logout()
   {
      session_unset();
      session_destroy();
      setcookie(session_name(), '', time() - 3600, '/');

      return redirect('auth/login');
   }

   public function simpan_ip_address_sementara()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->userModel->simpan_ip_address_sementara($_POST)) {
         if (isLoggedIn()) {
            return redirect('dashboard');
         } else {
            return redirect('auth/login');
         }
      } else {
         if (isLoggedIn()) {
            return redirect('dashboard');
         } else {
            return redirect('auth/login');
         }
      }
   }
}
