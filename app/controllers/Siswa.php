<?php
class Siswa extends Controller
{

   public function __construct()
   {
      if (!isLoggedIn()) {
         return redirect('auth/login');
      }
      $this->Msiswa = $this->model('Msiswa');
      $this->Mjadwal = $this->model('Mjadwal');
   }

   public function index()
   {
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'all';
      }

      $data['jumlah_siswa'] = count($this->Msiswa->siswa_aktif('all'));
      $data['rekap'] = $this->Msiswa->rekap_perkelas();
      $data['perkelas'] = $this->Msiswa->perkelas();
      $data['m_prodi'] = $this->Msiswa->m_prodi();

      $data['siswa_aktif'] = $this->Msiswa->siswa_aktif_kelas($kelas);
      $data['wali_kelas'] = $this->Mjadwal->wali_kelas($kelas);
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/index', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function tambah()
   {
      $data['propinsi'] = $this->Msiswa->propinsi();
      $data['kabupaten'] = $this->Msiswa->kabupaten();
      $data['prodi'] = $this->Msiswa->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/tambah', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function edit($id_siswa)
   {
      $data['siswa'] = $this->Msiswa->siswa_by_id($id_siswa);
      $data['propinsi'] = $this->Msiswa->propinsi();
      $data['kabupaten'] = $this->Msiswa->kabupaten();
      $data['kecamatan'] = $this->Msiswa->kecamatan();
      $data['prodi'] = $this->Msiswa->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/edit', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function lihat($id_siswa)
   {
      //$filter = $_GET['data'];
      //$data['filter'] = $filter;
      $data['siswa'] = $this->Msiswa->siswa_by_id($id_siswa);
      $data['propinsi'] = $this->Msiswa->propinsi();
      $data['kabupaten'] = $this->Msiswa->kabupaten();
      $data['kecamatan'] = $this->Msiswa->kecamatan();
      $data['prodi'] = $this->Msiswa->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/lihat', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function simpan()
   {
      $nis = $_POST['nis'];
      $data['cek_nis'] =  $this->Msiswa->cek_nis($nis);
      if ($data['cek_nis']) {
         setFlash('NIS yang anda masukkan sudah digunakan.', 'error');
         return redirect('siswa/tambah');
      }

      $username = $_POST['nis'];
      $data['cek_username'] =  $this->Msiswa->cek_username($username);
      if ($data['cek_username']) {
         setFlash('Username yang anda masukkan sudah digunakan.', 'error');
         return redirect('siswa/tambah');
      }

      if ($_FILES['avatar']['size'] > 2000 * 1000) {
         setFlash('Ukuran file gambar melebihi 2MB.', 'error');
         return redirect('siswa/tambah');
      }

      $nomor_rfid = $_POST['nomor_rfid'];
      $data['cek_rfid'] =  $this->Msiswa->cek_rfid($nomor_rfid);
      if ($data['cek_rfid']) {
         setFlash('Kartu RFID yang anda masukkan sudah digunakan.', 'error');
         return redirect('siswa/tambah');
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Msiswa->simpan($_POST, $_FILES)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa');
      } else {
         setFlash('Gagal disimpan.', 'error');
         return redirect('siswa');
      }
   }

   public function simpan_edit()
   {
      $nis = $_POST['nis'];
      $nomor_rfid = $_POST['nomor_rfid'];

      if (Middleware::admin('kurikulum')) {
         if ($_POST['rfid']) {
            $data['cek_rfid'] =  $this->Msiswa->cek_rfid($nomor_rfid);
            if ($data['cek_rfid']) {
               $nis_lama = $data['cek_rfid']->nis;
               if ($nis_lama != $nis) {
                  setFlash('Kartu RFID yang anda masukkan sudah digunakan.', 'error');
                  return redirect('siswa/edit/' . $_POST['id_siswa']);
               }
            }
         }
      }

      if ($_FILES['avatar']['size'] > 2000 * 1000) {
         setFlash('Ukuran file gambar melebihi 2MB.', 'error');
         if ($_SESSION['role'] == 'siswa') {
            return redirect('siswa/saya');
         } else {
            return redirect('siswa/edit/' . $_POST['id_siswa']);
         }
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Msiswa->simpan_edit($_POST, $_FILES)) {
         setFlash('Berhasil disimpan.', 'success');
         if ($_SESSION['role'] == 'siswa') {
            return redirect('siswa/saya');
         } else {
            return redirect('siswa');
         }
      } else {
         setFlash('Gagal disimpan.', 'error');
         if ($_SESSION['role'] == 'siswa') {
            return redirect('siswa/saya');
         } else {
            return redirect('siswa');
         }
      }
   }

   public function hapus_siswa()
   {
      $id = $_GET['id'];
      $result = $this->Msiswa->hapus_siswa($id);
      if ($result) {
         $response = array('status' => 'success', 'message' => 'Data berhasil dihapus.');
      } else {
         $response = array('status' => 'error', 'message' => 'Gagal menghapus data.');
      }
      echo json_encode($response);
   }

   //---------------------------------------

   public function status()
   {
      if (isset($_GET['status'])) {
         $status = $_GET['status'];
      } else {
         $status = 'aktif';
      }
      $data['siswa_aktif'] = $this->Msiswa->status_siswa($status);
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/status', $data);
      require APPROOT . '/views/inc/footer.php';
   }



   //--- SAYA ----------------------------------
   public function saya()
   {
      $data['siswa'] = $this->Msiswa->saya();
      $data['propinsi'] = $this->Msiswa->propinsi();
      $data['kabupaten'] = $this->Msiswa->kabupaten();
      $data['kecamatan'] = $this->Msiswa->kecamatan();
      $data['prodi'] = $this->Msiswa->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/saya', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function edit_saya()
   {
      $data['siswa'] = $this->Msiswa->saya();
      $data['propinsi'] = $this->Msiswa->propinsi();
      $data['kabupaten'] = $this->Msiswa->kabupaten();
      $data['kecamatan'] = $this->Msiswa->kecamatan();
      $data['prodi'] = $this->Msiswa->prodi();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/edit', $data);
      require APPROOT . '/views/inc/footer.php';
   }



   public function kabupaten()
   {
      $propinsiId = $_GET['propinsiId'];
      $kabupaten = $this->Msiswa->kabupatenByPropinsi($propinsiId);
      $options = "<option value=''>Pilih Kabupaten</option>";
      foreach ($kabupaten as $k) {
         $options .= "<option value='$k->id_kabupaten'>$k->nama_kabupaten</option>";
      }
      echo $options;
   }

   public function kecamatan()
   {
      $kabupatenId = $_GET['kabupatenId'];
      $kecamatan = $this->Msiswa->kecamatanByKabupaten($kabupatenId);
      $options = "<option value=''>Pilih Kecamatan</option>";
      foreach ($kecamatan as $k) {
         $options .= "<option value='$k->id_kecamatan'>$k->nama_kecamatan</option>";
      }
      echo $options;
   }

   public function pilih_kelas()
   {
      $id_siswa = $_POST['id_siswa'];
      $pilih_kelas = $_POST['pilih_kelas'];
      $nama_field = $_POST['nama_field'];
      $result = $this->Msiswa->pilih_kelas($id_siswa, $pilih_kelas, $nama_field);
      if ($result) {
         $response = array('status' => 'success', 'message' => 'Data berhasil diproses.');
      } else {
         $response = array('status' => 'error', 'message' => 'Gagal memproses data.');
      }
      echo json_encode($response);
   }

   public function pilih_prodi()
   {
      $id_siswa = $_POST['id_siswa'];
      $pilih_prodi = $_POST['pilih_prodi'];
      $nama_field = $_POST['nama_field'];
      $result = $this->Msiswa->pilih_prodi($id_siswa, $pilih_prodi, $nama_field);
      if ($result) {
         $response = array('status' => 'success', 'message' => 'Data berhasil diproses.');
      } else {
         $response = array('status' => 'error', 'message' => 'Gagal memproses data.');
      }
      echo json_encode($response);
   }

   public function pilih_status()
   {
      $id_siswa = $_POST['id_siswa'];
      $pilih_status = $_POST['pilih_status'];
      $result = $this->Msiswa->pilih_status($id_siswa, $pilih_status);
      if ($result) {
         $response = array('status' => 'success', 'message' => 'Data berhasil diproses.');
      } else {
         $response = array('status' => 'error', 'message' => 'Gagal memproses data.');
      }
      echo json_encode($response);
   }

   public function cek_rfid()
   {
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/cek_rfid');
      require APPROOT . '/views/inc/footer.php';
   }

   public function cari_rfid()
   {
      $nomor_rfid = $_POST['nomor_rfid'];
      $hasil = $this->Msiswa->cari_rfid($nomor_rfid);
      header('Content-Type: application/json');
      $response = [];
      if ($hasil) {
         $response['nama_siswa'] = $hasil->nama_siswa;
      } else {
         $response['nama_siswa'] = 'RFID tidak ditemukan atau belum terdaftar.';
      }
      echo json_encode($response['nama_siswa']);
   }

   //------------------------------------------
   public function kelas_saya()
   {
      if (isset($_GET['tanggal'])) {
         $data['tanggal'] = $_GET['tanggal'];
      } else {
         $data['tanggal'] = date('Y-m-d');
      }
      $tanggal = $data['tanggal'];

      $data['ambil_kelas'] = $this->Msiswa->ambil_kelas($_SESSION['nik']);
      $kelas = $data['ambil_kelas']->kode_kelas;

      $data['kelas_saya'] = $this->Msiswa->kelas_saya($tanggal);

      $data['cek_izin'] = $this->Mjadwal->cek_izin($tanggal, $kelas);

      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/siswa_saya', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function izin_siswa()
   {
      if (isset($_GET['status'])) {
         $status = $_GET['status'];
      } else {
         $status = 'Menunggu ACC';
      }
      $data['izin_siswa'] = $this->Msiswa->izin_siswa($status);
      $data['semester_aktif'] = $this->Msiswa->semester_aktif();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/izin_siswa', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function respon_izin()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Msiswa->respon_izin($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/izin_siswa');
      } else {
         setFlash('Gagal disimpan', 'error');
         return redirect('siswa/izin_siswa');
      }
   }

   //--SISWA---------------------------------
   public function absen_kelas()
   {
      if (isset($_GET['tanggal'])) {
         $data['tanggal'] = $_GET['tanggal'];
      } else {
         $data['tanggal'] = date('Y-m-d');
      }

      $kls = $this->Mjadwal->kelas_saya_siswa();
      $kelas = $kls->kelas_siswa;

      $tanggal = $data['tanggal'];
      $data['kelas_saya'] = $this->Msiswa->absen_kelas($tanggal, $kelas);
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/kelas_saya', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function pengajuan_izin()
   {
      $data['guru'] = $this->Msiswa->wali_kelas();
      $data['izin'] = $this->Msiswa->pengajuan_izin();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/pengajuan_izin', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function simpan_izin_siswa()
   {
      if ($_POST['mulai_izin'] > $_POST['sampai_izin']) {
         setFlash('Gagal disimpan, Tanggal mulai tidak boleh melebihi tanggal sampai', 'error');
         return redirect('siswa/pengajuan_izin');
      }
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Msiswa->simpan_izin_siswa($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/pengajuan_izin');
      } else {
         setFlash('Gagal disimpan, periksa tanggal yang anda masukkan, jangan ada tanggal yang double', 'error');
         return redirect('siswa/pengajuan_izin');
      }
   }

   public function simpan_edit_izin_siswa()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Msiswa->simpan_edit_izin_siswa($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/pengajuan_izin');
      } else {
         setFlash('Berhasil disimpan.', 'danger');
         return redirect('siswa/pengajuan_izin');
      }
   }

   public function hapus_pengajuan_izin($id)
   {
      if ($id !== false && $id > 0) {
         $result = $this->Msiswa->hapus_pengajuan_izin($id);
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

   //--REKAP PRESENSI ------------------------ 
   public function rekap_presensi()
   {
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'all';
      }

      if (isset($_GET['mulai'])) {
         $mulai = $_GET['mulai'];
      } else {
         $mulai = '2024-07-01';
      }

      if (isset($_GET['sampai'])) {
         $sampai = $_GET['sampai'];
      } else {
         $sampai = date('Y-m-d');
      }

      $data['mulai'] = $mulai;
      $data['sampai'] = $sampai;

      //$data['jumlah_siswa'] = count($this->Msiswa->siswa_aktif('all'));
      //$data['rekap'] = $this->Msiswa->rekap_perkelas();
      //$data['perkelas'] = $this->Msiswa->perkelas();
      $data['siswa_aktif'] = $this->Msiswa->siswa_aktif_kelas($kelas);
      $data['wali_kelas'] = $this->Mjadwal->wali_kelas($kelas);

      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/rekap_presensi', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   //--IZIN TODAY -----------------------------------
   public function izin_today()
   {
      $data['izin_today'] = $this->Msiswa->izin_today();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/izin_today', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   //---PRESENSI HARIAN SISWA -------------------------
   public function presensi_harian()
   {
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'XA';
      }
      $data['kelas'] = $kelas;

      if (isset($_GET['bulan'])) {
         $bulan = $_GET['bulan'];
      } else {
         $bulan = date('n');
      }
      $data['bulan'] = $bulan;

      if (isset($_GET['tahun'])) {
         $tahun = $_GET['tahun'];
      } else {
         $tahun = date('Y');
      }
      $data['tahun'] = $tahun;

      $data['siswa_aktif'] = $this->Msiswa->siswa_aktif_kelas($kelas);
      $data['wali_kelas'] = $this->Mjadwal->wali_kelas($kelas);
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/presensi_harian', $data);
      require APPROOT . '/views/inc/footer.php';
   }
}
