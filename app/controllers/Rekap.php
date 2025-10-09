<?php
class Rekap extends Controller
{

   public function __construct()
   {
      if (!isLoggedIn()) {
         return redirect('auth/login');
      }
      $this->Mrekap = $this->model('Mrekap');
   }

   public function index()
   {
      //
   }

   public function rekap()
   {
      $data['rekap'] = $this->Mrekap->rekap();
      //$data['jam_kerja'] = $this->Mrekap->jam_kerja();

      $bulan = date('m');
      $tahun = date('Y');
      $data['jam_kerja'] = $this->Mrekap->jam_kerja_bydate($bulan, $tahun);

      require APPROOT . '/views/inc/header.php';
      if ($_SESSION['role'] == 'satpam') {
         $this->view('rekap/rekap_satpam', $data);
      } else {
         $this->view('rekap/rekap_baru', $data);
      }
      require APPROOT . '/views/inc/footer.php';
   }

   public function bulan()
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


      $data['rekap'] = $this->Mrekap->rekap();
      //$data['jam_kerja'] = $this->Mrekap->jam_kerja();
      $data['jam_kerja'] = $this->Mrekap->jam_kerja_bydate($bulan, $tahun);

      require APPROOT . '/views/inc/header.php';
      if ($_SESSION['role'] == 'satpam') {
         $this->view('rekap/bulan_baru_satpam', $data);
      } else {
         $this->view('rekap/bulan_baru', $data);
      }
      require APPROOT . '/views/inc/footer.php';
   }

   public function rekap_admin()
   {
      $data['nm'] = $this->Mrekap->ambil_nama();
      $data['role'] = $this->Mrekap->ambil_role();

      $data['jam_kerja'] = $this->Mrekap->jam_kerja();
      require APPROOT . '/views/inc/header.php';
      if ($data['role']->role == 'satpam') {
         $this->view('rekap/rekap_admin_satpam', $data);
      } else {
         $this->view('rekap/rekap_admin', $data);
      }
      require APPROOT . '/views/inc/footer.php';
   }

   public function reset($id, $tanggal)
   {
      $data['id'] = $id;
      $data['tanggal'] = $tanggal;
      require APPROOT . '/views/inc/header.php';
      $this->view('rekap/reset', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function reset_jam()
   {
      $id = $_GET['id'];
      if ($this->Mrekap->reset_jam()) {
         setFlash('Berhasil direset.', 'success');
         return redirect('rekap/rekap_admin?data=' . $id);
      } else {
         setFlash('Gagal di reset.', 'danger');
         return redirect('rekap/rekap_admin?data=' . $id);
      }
   }
}
