<?php
class Jadwal extends Controller
{

   public function __construct()
   {
      if (!isLoggedIn()) {
         return redirect('auth/login');
      }
      $this->Mjadwal = $this->model('Mjadwal');
      $this->Mdashboard = $this->model('Mdashboard');
   }

   // TAMBAHKAN METHOD BARU INI
   public function aktifkan_jadwal_setting()
   {
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           $id_jadwal_setting = $_POST['id_jadwal_setting'];
           
           // Ambil data jadwal setting yang dipilih
           $jadwal_setting = $this->Mjadwal->get_jadwal_setting_by_id($id_jadwal_setting);
           
           if ($jadwal_setting) {
               try {
                   // Matikan semua jadwal setting
                   $this->Mjadwal->nonaktifkan_semua_jadwal_setting();
                   
                   // Aktifkan jadwal setting yang dipilih
                   $this->Mjadwal->aktifkan_jadwal_setting($id_jadwal_setting);
                   
                   // TAMBAHAN: Matikan semua tahun ajaran
                   $this->Mjadwal->nonaktifkan_semua_tahun_ajaran();
                   
                   // TAMBAHAN: Aktifkan tahun ajaran yang sesuai
                   $this->Mjadwal->aktifkan_tahun_ajaran($jadwal_setting->id_tahun_ajaran);
                   
                   echo json_encode([
                       'status' => 'success',
                       'message' => 'Jadwal setting berhasil diaktifkan'
                   ]);
               } catch (Exception $e) {
                   echo json_encode([
                       'status' => 'error',
                       'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                   ]);
               }
           } else {
               echo json_encode([
                   'status' => 'error',
                   'message' => 'Jadwal setting tidak ditemukan'
               ]);
           }
       } else {
           echo json_encode([
               'status' => 'error',
               'message' => 'Method tidak valid'
           ]);
       }
   }

   public function index()
   {
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'ringkasan';
      }
      $data['jadwal'] = $this->Mjadwal->jadwal_kelas($kelas);
      $data['wali_kelas'] = $this->Mjadwal->wali_kelas($kelas);
      $data['pelajaran'] = $this->Mjadwal->pelajaran();
      $data['guru'] = $this->Mjadwal->guru();
      $data['tahun_ajaran'] = $this->Mjadwal->tahun_ajaran();
      $data['jadwal_setting'] = $this->Mjadwal->jadwal_setting();
      $data['belum_ada_guru'] = $this->Mjadwal->belum_ada_guru();
      $data['list_jadwal_setting'] = $this->Mjadwal->get_all_jadwal_setting();

      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/jadwal', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function edit_jadwal_kelas()
   {
      $id = $_GET['id'];
      $kelas = $_GET['kelas'];
      $data['jadwal'] = $this->Mjadwal->edit_jadwal_kelas($id);
      $data['pelajaran'] = $this->Mjadwal->pelajaran();
      $data['guru'] = $this->Mjadwal->guru();
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/edit_jadwal_kelas', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function simpan_edit_jadwal()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $kelas = $_POST['kelasnya'];
      if ($this->Mjadwal->simpan_edit_jadwal($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/jadwal?kelas=' . $kelas);
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/jadwal?kelas=' . $kelas);
      }
   }

   public function simpan_wali_kelas()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $kelas = $_POST['kelasnya'];
      if ($this->Mjadwal->simpan_wali_kelas($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/jadwal?kelas=' . $kelas);
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/jadwal?kelas=' . $kelas);
      }
   }

   public function validasi_jadwal()
   {
      $kode_kelas = $_GET['id'];
      $result = $this->Mjadwal->validasi_jadwal($kode_kelas);
      if ($result) {
         $response = array('status' => 'success', 'message' => 'Jadwal berhasil divalidasi.');
      } else {
         $response = array('status' => 'error', 'message' => 'Gagal divalidasi.');
      }
      echo json_encode($response);
   }

   public function kosongkan_jadwal()
   {
      $kode_kelas = $_GET['id'];
      $result = $this->Mjadwal->kosongkan_jadwal($kode_kelas);
      if ($result) {
         $response = array('status' => 'success', 'message' => 'Jadwal berhasil dikosongkan.');
      } else {
         $response = array('status' => 'error', 'message' => 'Gagal dikosongkan.');
      }
      echo json_encode($response);
   }

   //-- MASTER MATA PELAJARAN ------------------------------- 
   public function pelajaran()
   {
      $data['pelajaran'] = $this->Mjadwal->pelajaran();
      $data['prodi'] = $this->Mjadwal->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/pelajaran/pelajaran', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function simpan_pelajaran()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->simpan_pelajaran($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/pelajaran');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/pelajaran');
      }
   }

   public function edit_pelajaran()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->edit_pelajaran($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/pelajaran');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/pelajaran');
      }
   }

   public function hapus_pelajaran($id)
   {
      if ($id !== false && $id > 0) {
         $result = $this->Mjadwal->hapus_pelajaran($id);
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

   //-- ABSEN -------------------------------
   public function absen()
   {
      if (isset($_GET['tanggal'])) {
         $tanggal = $_GET['tanggal'];
      } else {
         $tanggal = date('Y-m-d');
      }
      $data['tanggal'] = $tanggal;

      $nomor_hari = date('N', strtotime($tanggal));
      if ($nomor_hari == '1') {
         $hari = 'Senin';
      } else if ($nomor_hari == '2') {
         $hari = 'Selasa';
      } else if ($nomor_hari == '3') {
         $hari = 'Rabu';
      } else if ($nomor_hari == '4') {
         $hari = 'Kamis';
      } else if ($nomor_hari == '5') {
         $hari = 'Jumat';
      } else if ($nomor_hari == '6') {
         $hari = 'Sabtu';
      } else {
         $hari = 'Minggu';
      }


      $data['absen'] = $this->Mjadwal->absen($hari);
      $data['ip'] = $this->Mdashboard->ip();

      $kelas_data = array();
      // foreach ($data['absen'] as $d) {
      //    $kelas = $d->kelas;
      //    if (!isset($kelas_data[$kelas])) {
      //       $kelas_data[$kelas] = array();
      //    }
      //    $kelas_data[$kelas][] = array(
      //       'kode_kelas' => $d->kode_kelas,
      //       'nama1'  => $d->nama1, 'nama2'  => $d->nama2, 'nama3'  => $d->nama3, 'nama4'  => $d->nama4, 'nama5'  => $d->nama5, 'nama6'  => $d->nama6, 'nama7'  => $d->nama7, 'nama8'  => $d->nama8, 'nama9'  => $d->nama9, 'nama10'  => $d->nama10, 'nama11'  => $d->nama11,

      //       'singkatan1' => $d->singkatan1, 'singkatan2' => $d->singkatan2, 'singkatan3' => $d->singkatan3, 'singkatan4' => $d->singkatan4, 'singkatan5' => $d->singkatan5, 'singkatan6' => $d->singkatan6, 'singkatan7' => $d->singkatan7, 'singkatan8' => $d->singkatan8, 'singkatan9' => $d->singkatan9, 'singkatan10' => $d->singkatan10, 'singkatan11' => $d->singkatan11,

      //       'id_pelajaran1' => $d->id_pelajaran1, 'id_pelajaran2' => $d->id_pelajaran2, 'id_pelajaran3' => $d->id_pelajaran3, 'id_pelajaran4' => $d->id_pelajaran4, 'id_pelajaran5' => $d->id_pelajaran5, 'id_pelajaran6' => $d->id_pelajaran6, 'id_pelajaran7' => $d->id_pelajaran7, 'id_pelajaran8' => $d->id_pelajaran8, 'id_pelajaran9' => $d->id_pelajaran9, 'id_pelajaran10' => $d->id_pelajaran10, 'id_pelajaran11' => $d->id_pelajaran11,

      //       'guru1' => $d->guru1, 'guru2' => $d->guru2, 'guru3' => $d->guru3, 'guru4' => $d->guru4, 'guru5' => $d->guru5, 'guru6' => $d->guru6, 'guru7' => $d->guru7, 'guru8' => $d->guru8, 'guru9' => $d->guru9, 'guru10' => $d->guru10, 'guru11' => $d->guru11,

      //       'kode_pegawai1' => $d->kode_pegawai1, 'kode_pegawai2' => $d->kode_pegawai2, 'kode_pegawai3' => $d->kode_pegawai3, 'kode_pegawai4' => $d->kode_pegawai4, 'kode_pegawai5' => $d->kode_pegawai5, 'kode_pegawai6' => $d->kode_pegawai6, 'kode_pegawai7' => $d->kode_pegawai7, 'kode_pegawai8' => $d->kode_pegawai8, 'kode_pegawai9' => $d->kode_pegawai9, 'kode_pegawai10' => $d->kode_pegawai10, 'kode_pegawai11' => $d->kode_pegawai11,

      //       'mata_pelajaran1' => $d->mata_pelajaran1, 'mata_pelajaran2' => $d->mata_pelajaran2, 'mata_pelajaran3' => $d->mata_pelajaran3, 'mata_pelajaran4' => $d->mata_pelajaran4, 'mata_pelajaran5' => $d->mata_pelajaran5, 'mata_pelajaran6' => $d->mata_pelajaran6, 'mata_pelajaran7' => $d->mata_pelajaran7, 'mata_pelajaran8' => $d->mata_pelajaran8, 'mata_pelajaran9' => $d->mata_pelajaran9, 'mata_pelajaran10' => $d->mata_pelajaran10, 'mata_pelajaran11' => $d->mata_pelajaran11,

      //       'kelas' => $d->kelas,
      //       'ruang' => $d->ruang,
      //       'hari' => $d->hari,
      //       'validasi' => $d->validasi,
      //       'wali_kelas' => $d->wali_kelas,
      //       'tanggal_validasi' => $d->tanggal_validasi,
      //       'berlaku_jadwal_dari' => $d->berlaku_jadwal_dari
      //    );
      // }

      foreach ($data['absen'] as $d) {
         $kelas = $d->kelas;
         if (!isset($kelas_data[$kelas])) {
             $kelas_data[$kelas] = array();
         }
         $kelas_data[$kelas][] = array(
             'kode_kelas' => $d->kode_kelas,
             'nama1'  => $d->nama1, 'nama2'  => $d->nama2, 'nama3'  => $d->nama3, 'nama4'  => $d->nama4,
             'nama5'  => $d->nama5, 'nama6'  => $d->nama6, 'nama7'  => $d->nama7, 'nama8'  => $d->nama8,
             'nama9'  => $d->nama9, 'nama10' => $d->nama10,
     
             'singkatan1' => $d->singkatan1, 'singkatan2' => $d->singkatan2, 'singkatan3' => $d->singkatan3,
             'singkatan4' => $d->singkatan4, 'singkatan5' => $d->singkatan5, 'singkatan6' => $d->singkatan6,
             'singkatan7' => $d->singkatan7, 'singkatan8' => $d->singkatan8, 'singkatan9' => $d->singkatan9,
             'singkatan10' => $d->singkatan10,
     
             'id_pelajaran1' => $d->id_pelajaran1, 'id_pelajaran2' => $d->id_pelajaran2, 'id_pelajaran3' => $d->id_pelajaran3,
             'id_pelajaran4' => $d->id_pelajaran4, 'id_pelajaran5' => $d->id_pelajaran5, 'id_pelajaran6' => $d->id_pelajaran6,
             'id_pelajaran7' => $d->id_pelajaran7, 'id_pelajaran8' => $d->id_pelajaran8, 'id_pelajaran9' => $d->id_pelajaran9,
             'id_pelajaran10' => $d->id_pelajaran10,
     
             'guru1' => $d->guru1, 'guru2' => $d->guru2, 'guru3' => $d->guru3, 'guru4' => $d->guru4,
             'guru5' => $d->guru5, 'guru6' => $d->guru6, 'guru7' => $d->guru7, 'guru8' => $d->guru8,
             'guru9' => $d->guru9, 'guru10' => $d->guru10,
     
             'kode_pegawai1' => $d->kode_pegawai1, 'kode_pegawai2' => $d->kode_pegawai2, 'kode_pegawai3' => $d->kode_pegawai3,
             'kode_pegawai4' => $d->kode_pegawai4, 'kode_pegawai5' => $d->kode_pegawai5, 'kode_pegawai6' => $d->kode_pegawai6,
             'kode_pegawai7' => $d->kode_pegawai7, 'kode_pegawai8' => $d->kode_pegawai8, 'kode_pegawai9' => $d->kode_pegawai9,
             'kode_pegawai10' => $d->kode_pegawai10,
     
             'mata_pelajaran1' => $d->mata_pelajaran1, 'mata_pelajaran2' => $d->mata_pelajaran2, 'mata_pelajaran3' => $d->mata_pelajaran3,
             'mata_pelajaran4' => $d->mata_pelajaran4, 'mata_pelajaran5' => $d->mata_pelajaran5, 'mata_pelajaran6' => $d->mata_pelajaran6,
             'mata_pelajaran7' => $d->mata_pelajaran7, 'mata_pelajaran8' => $d->mata_pelajaran8, 'mata_pelajaran9' => $d->mata_pelajaran9,
             'mata_pelajaran10' => $d->mata_pelajaran10,
     
             'kelas' => $d->kelas,
             'ruang' => $d->ruang,
             'hari' => $d->hari,
             'validasi' => $d->validasi,
             'wali_kelas' => $d->wali_kelas,
             'tanggal_validasi' => $d->tanggal_validasi,
             'berlaku_jadwal_dari' => $d->berlaku_jadwal_dari
         );
     }
     
      $data['kelas_data'] = $kelas_data;
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/absen/absen', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   //-- WALI KELAS --------------------------- 
   public function wali_kelas()
   {
      $data['wali_kelas'] = $this->Mjadwal->wakel();
      $data['nama_guru'] = $this->Mjadwal->nama_guru();
      $data['prodi'] = $this->Mjadwal->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/wali_kelas/wali_kelas', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function edit_wali_kelas()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->edit_wali_kelas($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/wali_kelas');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/wali_kelas');
      }
   }

   public function hapus_semua_wali_kelas()
   {
      if ($this->Mjadwal->hapus_semua_wali_kelas()) {
         $response = array('status' => 'success', 'message' => 'Data berhasil dihapus');
         echo json_encode($response);
      } else {
         $response = array('status' => 'error', 'message' => 'Data gagal dihapus');
         echo json_encode($response);
      }
   }

   //-- GURU AKTIF ---------------------------- 
   public function guru_aktif($status = NULL)
   {
      if ($status == '') {
         $status = 'Ya';
      } else if ($status == 'Ya') {
         $status = 'Ya';
      } else {
         $status = 'Tidak';
      }
      $data['status'] = $status;

      $data['guru_aktif'] = $this->Mjadwal->guru_aktif($status);
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/guru_aktif', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function status_mengajar_non()
   {
      $id = $_GET['id'];
      if ($this->Mjadwal->status_mengajar_non($id)) {
         $response = array('status' => 'success', 'message' => 'Data berhasil disimpan');
         echo json_encode($response);
      } else {
         $response = array('status' => 'error', 'message' => 'Data gagal disimpan');
         echo json_encode($response);
      }
   }

   public function status_mengajar_aktif()
   {
      $id = $_GET['id'];
      if ($this->Mjadwal->status_mengajar_aktif($id)) {
         $response = array('status' => 'success', 'message' => 'Data berhasil disimpan');
         echo json_encode($response);
      } else {
         $response = array('status' => 'error', 'message' => 'Data gagal disimpan');
         echo json_encode($response);
      }
   }

   //-- KELAS SAYA ------------------------
   public function kelas_saya()
   {
      if (isset($_GET['tanggal'])) {
         $tanggal = $_GET['tanggal'];
      } else {
         $tanggal = date('Y-m-d');
      }
      $data['tanggal'] = $tanggal;

      $nomor_hari = date('N', strtotime($tanggal));
      if ($nomor_hari == '1') {
         $hari = 'Senin';
      } else if ($nomor_hari == '2') {
         $hari = 'Selasa';
      } else if ($nomor_hari == '3') {
         $hari = 'Rabu';
      } else if ($nomor_hari == '4') {
         $hari = 'Kamis';
      } else if ($nomor_hari == '5') {
         $hari = 'Jumat';
      } else if ($nomor_hari == '6') {
         $hari = 'Sabtu';
      } else {
         $hari = 'Minggu';
      }

      $data['absen'] = $this->Mjadwal->absen_saya($hari);

      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/kelas_saya', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   // -- PROGRAM STUDI ----------------------------- 
   public function prodi()
   {
      $data['prodi'] = $this->Mjadwal->prodi_all();
      $data['pegawai'] = $this->Mjadwal->pegawai();
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/prodi', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function simpan_prodi()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->simpan_prodi($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/prodi');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/prodi');
      }
   }

   public function edit_prodi()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->edit_prodi($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/prodi');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/prodi');
      }
   }

   //--JADWAL SETTING ----------------------------
   public function simpan_jadwal_setting()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // var_dump($_POST);
      // exit;

      if ($this->Mjadwal->simpan_jadwal_setting($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/jadwal');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/jadwal');
      }
   }

   public function isi_absen()
   {
      $data['kelas'] = $_GET['kelas'];
      $data['ruang'] = $_GET['ruang'];
      $data['jam'] = $_GET['jam'];
      $data['tgl'] = $_GET['tgl'];
      $data['hari'] = $_GET['hari'];
      $data['id_pelajaran'] = $_GET['id_pelajaran'];
      $data['wali_kelas'] = $_GET['wali_kelas'];
      $kelas_ruang = $data['kelas'] . $data['ruang'];

      $data['cek_izin'] = $this->Mjadwal->cek_izin($data['tgl'], $data['kelas'] . $data['ruang']);

      $data['isi_kelas'] = $this->Mjadwal->ambil_isi_kelas($kelas_ruang);
      $data['jumlah_siswa'] = count($data['isi_kelas']);

      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/absen/isi_absen', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function isi_absen_kurikulum()
   {
      $data['kelas'] = $_GET['kelas'];
      $data['ruang'] = $_GET['ruang'];
      $data['jam'] = $_GET['jam'];
      $data['tgl'] = $_GET['tgl'];
      $data['hari'] = $_GET['hari'];
      $data['id_pelajaran'] = $_GET['id_pelajaran'];
      $data['wali_kelas'] = $_GET['wali_kelas'];
      $kelas_ruang = $data['kelas'] . $data['ruang'];

      $data['cek_izin'] = $this->Mjadwal->cek_izin($data['tgl'], $data['kelas'] . $data['ruang']);

      $data['isi_kelas'] = $this->Mjadwal->ambil_isi_kelas($kelas_ruang);
      $data['jumlah_siswa'] = count($data['isi_kelas']);

      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/absen/isi_absen_kurikulum', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function simpan_isi_absen()
   {
      $tgl = $_POST['tgl'];
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->simpan_isi_absen($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/absen?tanggal=' . $tgl);
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/absen?tanggal=' . $tgl);
      }
   }

   public function simpan_edit_isi_absen()
   {
      $tgl = $_POST['tgl'];
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Mjadwal->simpan_edit_isi_absen($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('jadwal/absen?tanggal=' . $tgl);
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('jadwal/absen?tanggal=' . $tgl);
      }
   }

   public function reset_absen()
   {
      $id_absen = $_GET['id_absen'];
      $tgl = $_GET['tgl'];

      $data['absen'] = $this->Mjadwal->absen_byid($id_absen);
      $kelas_ruang = $data['absen']->kelas_absen_kelas . $data['absen']->ruang_absen_kelas;
      $jam = $data['absen']->jam_absen_kelas;

      $data['cek_izin'] = $this->Mjadwal->cek_izin($tgl, $kelas_ruang);

      $data['absen_kelas'] = $this->Mjadwal->absen_kelas_byid($id_absen, $jam);
      $data['jumlah_siswa'] = count($data['absen_kelas']);

      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/absen/reset_absen', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   //------ SISWA ------------------------------
   public function jadwal_pelajaran()
   {
      $kls = $this->Mjadwal->kelas_saya_siswa();
      $kelas = $kls->kelas_siswa;
      $data['kelas'] = $kelas;

      $data['jadwal'] = $this->Mjadwal->jadwal_kelas($kelas);
      $data['wali_kelas'] = $this->Mjadwal->wali_kelas($kelas);
      require APPROOT . '/views/inc/header.php';
      $this->view('jadwal/jadwal_siswa', $data);
      require APPROOT . '/views/inc/footer.php';
   }
}
