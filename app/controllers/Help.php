<?php 
class Help extends Controller{

    public function __construct()
    {
        if(!isLoggedIn()){
            return redirect('auth/login');
        }
        //new model instance
        $this->helpModel = $this->model('HelpModel');
        $this->adminModel = $this->model('AdminModel');
        $this->pegawaiModel = $this->model('PegawaiModel');
    }

    public function index(){
        if($_SESSION['role'] == 'ADMIN'){
            $help = $this->helpModel->get();
            $data = [
                'title' => 'Daftar Help Desk',
                'menu' => 'help',
                'help' => $help
            ];
    
            $this->view('help/admin', $data);
        }else{
            $help = $this->helpModel->getByNIP();
            $data = [
                'title' => 'Daftar Help Desk',
                'menu' => 'help',
                'help' => $help
            ];
    
            $this->view('help/index', $data);
        }
    }

    public function add(){
      $data['title'] = 'Form Laporan Error';
      $data['menu'] = 'help';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          //validate error free
          if(empty($_POST['subjek']) || empty($_POST['laporan'])){
              //load view with error
              setFlash('Form input tidak boleh kosong','danger');
              $this->view('help/add', $data);
          }else{
              if($this->helpModel->add($_POST)){
                // admin kendi notif wa
                $kb = $this->adminModel->getPegawai('help_desk');
                $data['isi_pesan'] = "[BSPJI:SIP-Help Desk] Harap ditindaklanjuti";
                foreach ($kb as $k) {
                    $data['no_telp'] = $k->no_telp;
                    notifWA($data);
                }

                setFlash('Laporan Error telah dikirim kepada admin.','success');
                return redirect('help');
              }else{
                  die('something went wrong');
              }
          }
      }else{
          $this->view('help/add', $data);
      }
  }

  public function tanggapan($id = ''){
    if($_SESSION['role'] == 'ADMIN'){
      $data['title'] = 'Berikan Tanggapan Laporan';
      $data['menu'] = 'help';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      //validate error free
          if(empty($_POST['tanggapan'])){
              //load view with error
              setFlash('Form input tidak boleh kosong','danger');
              $this->view('help/tanggapan', $data);
          }else{
              if($this->helpModel->tanggapan($_POST)){
                    $ats = $this->pegawaiModel->getByNIP($_POST['user']);
                    // send notification to whatsapp atasan
                    $data['no_telp'] = $ats->no_telp;
                    $data['isi_pesan'] = "[BSPJI:SIP-Help Desk] Telah ditindaklanjuti";
                    notifWA($data);

                    setFlash('Laporan telah ditanggapi','success');
                    return redirect('help'); 
              }else{
                  die('something went wrong');
              }
          }
      }else{
          $help = $this->helpModel->getById($id);
          if($help && !$help->tanggapan){
              $data['id'] = $id;
              $data['help'] = $help;
              
              $this->view('help/tanggapan', $data);
          }else{
              return redirect('help');
          }
      }
    }else{
        return redirect('help');
    }
  }
    

}                            
                        