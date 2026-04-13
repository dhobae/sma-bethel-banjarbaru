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
      $this->Mrapor = $this->model('Mrapor');
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

      if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') {
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
      $data = $this->Msiswa->simpan_edit($_POST, $_FILES);
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
      // intip_data($data['siswa']);

      $data['propinsi'] = $this->Msiswa->propinsi();
      $data['kabupaten'] = $this->Msiswa->kabupaten();
      $data['kecamatan'] = $this->Msiswa->kecamatan();
      $data['prodi'] = $this->Msiswa->prodi();

      // intip_data($data['siswa']);
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
      $nomor_rfid = trim($_POST['nomor_rfid']);
      $hasil = $this->Msiswa->cari_rfid($nomor_rfid);

      header('Content-Type: application/json');

      if ($hasil) {
         echo json_encode([
            'status' => 'success',
            'data' => $hasil
         ]);
      } else {
         echo json_encode([
            'status' => 'error',
            'message' => 'RFID tidak ditemukan atau belum terdaftar.'
         ]);
      }
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

     // Ambil informasi file
      $file_name = $_FILES['file_izin']['name'];
      $file_size = $_FILES['file_izin']['size'];
      $file_tmp  = $_FILES['file_izin']['tmp_name'];
      $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      // Daftar ekstensi yang diperbolehkan
      // $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
      $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];


      // Cek ekstensi file
      if (!in_array($file_ext, $allowed_ext)) {
         setFlash('Format file tidak diperbolehkan. Hanya JPG, JPEG, PNG dan PDF yang bisa diupload.', 'error');

         if ($_SESSION['role'] == 'siswa') {
            return redirect('siswa/pengajuan_izin');
         }

         exit;
      }

      // Cek ukuran file (maks 2MB)
      if ($file_size > 2000 * 1000) {
         setFlash('Ukuran file melebihi 2MB.', 'error');

         if ($_SESSION['role'] == 'siswa') {
            return redirect('siswa/pengajuan_izin');
         }

         exit;
      }

      if ($this->Msiswa->simpan_izin_siswa($_POST, $_FILES)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/pengajuan_izin');
      } else {
         setFlash('Gagal disimpan, periksa tanggal yang anda masukkan, jangan ada tanggal yang double', 'error');
         return redirect('siswa/pengajuan_izin');
      }
   }

   public function simpan_edit_izin_siswa()
   {
      if ($_POST['mulai_izin'] > $_POST['sampai_izin']) {
         setFlash('Gagal disimpan, Tanggal mulai tidak boleh melebihi tanggal sampai', 'error');
         return redirect('siswa/pengajuan_izin');
      }
      
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Cek apakah ada file yang diupload
      $upload_file = false;
      if (isset($_FILES['file_izin']) && $_FILES['file_izin']['size'] > 0) {
         $file_name = $_FILES['file_izin']['name'];
         $file_size = $_FILES['file_izin']['size'];
         $file_tmp  = $_FILES['file_izin']['tmp_name'];
         $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

         $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

         // Cek ekstensi file
         if (!in_array($file_ext, $allowed_ext)) {
            setFlash('Format file tidak diperbolehkan. Hanya JPG, JPEG, PNG dan PDF yang bisa diupload.', 'error');
            if ($_SESSION['role'] == 'siswa') {
               return redirect('siswa/pengajuan_izin');
            }
            exit;
         }

         // Cek ukuran file (maks 2MB)
         if ($file_size > 2000 * 1000) {
            setFlash('Ukuran file melebihi 2MB.', 'error');
            if ($_SESSION['role'] == 'siswa') {
               return redirect('siswa/pengajuan_izin');
            }
            exit;
         }

         $upload_file = true;
      }

      if ($this->Msiswa->simpan_edit_izin_siswa($_POST, $upload_file ? $_FILES : null)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/pengajuan_izin');
      } else {
         setFlash('Gagal disimpan, periksa tanggal yang anda masukkan, jangan ada tanggal yang double', 'error');
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
      $data['wali_kelas'] = $this->Mjadwal->wali_kelas($kelas) ?: null; 
      // intip_data($data['wali_kelas']);
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/presensi_harian', $data);
      require APPROOT . '/views/inc/footer.php';
   }




   // wali kelas
// Halaman daftar siswa untuk wali kelas (dengan filter semester)
public function rapor()
{
   if (Middleware::admin('wali_kelas')) {
      $nik_wali_kelas = $_SESSION['nik'];
      $data['siswa'] = [];
      $data['kelas'] = [];
      
      if ($nik_wali_kelas) {
         // Ambil semua jadwal setting untuk dropdown
         $data['semua_jadwal'] = $this->Mrapor->ambil_semua_jadwal_setting();
         
         // Ambil jadwal aktif sebagai default
         $data['jadwal_aktif'] = $this->Mrapor->ambil_jadwal_aktif();
         
         // Cek apakah ada parameter semester dari GET
         $id_jadwal_pilihan = isset($_GET['semester']) ? (int)$_GET['semester'] : null;
         
         // Tentukan semester yang akan digunakan
         if ($id_jadwal_pilihan) {
            // Validasi apakah jadwal setting ada
            $jadwal_dipilih = null;
            foreach ($data['semua_jadwal'] as $js) {
               if ($js->id_jadwal_setting == $id_jadwal_pilihan) {
                  $jadwal_dipilih = $js;
                  break;
               }
            }
            
            if ($jadwal_dipilih) {
               $data['semester_dipilih'] = $id_jadwal_pilihan;
               $data['jadwal_terpilih'] = $jadwal_dipilih;
            } else {
               // Jadwal tidak valid, gunakan yang aktif
               $data['semester_dipilih'] = $data['jadwal_aktif'] ? $data['jadwal_aktif']->id_jadwal_setting : null;
               $data['jadwal_terpilih'] = $data['jadwal_aktif'];
            }
         } else {
            // Gunakan jadwal aktif
            $data['semester_dipilih'] = $data['jadwal_aktif'] ? $data['jadwal_aktif']->id_jadwal_setting : null;
            $data['jadwal_terpilih'] = $data['jadwal_aktif'];
         }
         
         // Ambil data siswa dan kelas
         $data['siswa'] = $this->Mrapor->ambil_siswa_berdasarkan_wali_kelas($nik_wali_kelas);
         $data['kelas'] = $this->Mrapor->ambil_kelas_wali_kelas($nik_wali_kelas);
         
         // Tambahkan info kelengkapan rapor untuk setiap siswa berdasarkan semester terpilih
         if ($data['semester_dipilih']) {
            foreach ($data['siswa'] as &$siswa) {
               $siswa->kelengkapan = $this->Mrapor->cek_kelengkapan_rapor(
                  $data['semester_dipilih'], 
                  $siswa->id_siswa
               );
            }
         }
      }

      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/rapor', $data);
      require APPROOT . '/views/inc/footer.php';
   } else {
      return redirect('siswa');
      exit;
   }
}

// Halaman detail input rapor siswa (dengan parameter semester)
public function rapor_detail($id = null)
{
    if (!Middleware::admin('wali_kelas')) {
        setFlash('Akses ditolak! Hanya wali kelas yang bisa mengakses halaman ini.', 'error');
        return redirect('siswa/rapor');
    }

    if (!$id) {
        setFlash('ID siswa tidak valid', 'error');
        return redirect('siswa/rapor');
    }

    // Ambil data siswa
    $siswa = $this->Mrapor->ambil_siswa_by_id($id);
    
    if (!$siswa) {
        setFlash('Data siswa tidak ditemukan', 'error');
        return redirect('siswa/rapor');
    }

    // Verifikasi apakah siswa ini memang di kelas wali kelas yang login
    $siswa_wali = $this->Mrapor->ambil_siswa_berdasarkan_wali_kelas($_SESSION['nik']);
    $found = false;
    foreach ($siswa_wali as $s) {
        if ($s->id_siswa == $id) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        setFlash('Anda tidak berhak mengakses data siswa ini', 'error');
        return redirect('siswa/rapor');
    }

    // Ambil semua jadwal setting untuk dropdown
    $data['semua_jadwal'] = $this->Mrapor->ambil_semua_jadwal_setting();
    
    // Ambil jadwal aktif
    $data['jadwal_aktif'] = $this->Mrapor->ambil_jadwal_aktif();
    
    // Cek apakah ada parameter semester dari GET
    $id_jadwal_pilihan = isset($_GET['semester']) ? (int)$_GET['semester'] : null;
    
    // Tentukan semester yang akan digunakan
    if ($id_jadwal_pilihan) {
        // Validasi apakah jadwal setting ada
        $jadwal_dipilih = null;
        foreach ($data['semua_jadwal'] as $js) {
            if ($js->id_jadwal_setting == $id_jadwal_pilihan) {
                $jadwal_dipilih = $js;
                break;
            }
        }
        
        if ($jadwal_dipilih) {
            $jadwal = $jadwal_dipilih;
            $data['semester_dipilih'] = $id_jadwal_pilihan;
        } else {
            // Jadwal tidak valid, gunakan yang aktif
            $jadwal = $data['jadwal_aktif'];
            $data['semester_dipilih'] = $data['jadwal_aktif'] ? $data['jadwal_aktif']->id_jadwal_setting : null;
        }
    } else {
        // Gunakan jadwal aktif
        $jadwal = $data['jadwal_aktif'];
        $data['semester_dipilih'] = $data['jadwal_aktif'] ? $data['jadwal_aktif']->id_jadwal_setting : null;
    }

    if (!$jadwal) {
        setFlash('Terjadi kesalahan', 'error');
        return redirect('siswa/rapor');
    }

    // Ambil mata pelajaran berdasarkan kelas siswa dan periode jadwal (REVISI)
    $data['pelajaran'] = $this->Mrapor->ambil_mata_pelajaran_kelas($siswa->kelas_siswa, $jadwal->id_jadwal_setting);
    
    // Ambil data rapor yang sudah ada untuk semester terpilih
    $data['siswa'] = $siswa;
    $data['jadwal'] = $jadwal;
    $data['nilai_pelajaran'] = $this->Mrapor->ambil_nilai_pelajaran($jadwal->id_jadwal_setting, $id);
    $data['nilai_sikap'] = $this->Mrapor->ambil_nilai_sikap($jadwal->id_jadwal_setting, $id);
    $data['ekskul'] = $this->Mrapor->ambil_ekstrakurikuler($jadwal->id_jadwal_setting, $id);
    $data['prestasi'] = $this->Mrapor->ambil_prestasi($jadwal->id_jadwal_setting, $id);
    $data['catatan'] = $this->Mrapor->ambil_catatan_wali($jadwal->id_jadwal_setting, $id);

    require APPROOT . '/views/inc/header.php';
    $this->view('siswa/rapor_detail', $data);
    require APPROOT . '/views/inc/footer.php';
}
 
 // Simpan data rapor
// Simpan data rapor (tetap sama, tapi redirect ke semester yang dipilih)
public function simpan_rapor()
{
    if (!Middleware::admin('wali_kelas')) {
        setFlash('Akses ditolak!', 'error');
        return redirect('siswa/rapor');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validasi input
        if (empty($_POST['id_siswa']) || empty($_POST['id_jadwal_setting'])) {
            setFlash('Data tidak lengkap', 'error');
            return redirect('siswa/rapor');
        }

        $id_siswa = $_POST['id_siswa'];
        $id_jadwal_setting = $_POST['id_jadwal_setting'];
        
        // Simpan data
        $result = $this->Mrapor->simpan_semua_nilai($_POST);
        
        if ($result) {
            setFlash('Data rapor berhasil disimpan', 'success');
        } else {
            setFlash('Gagal menyimpan data rapor. Silakan coba lagi.', 'error');
        }
        
        // Redirect ke halaman detail dengan parameter semester
        redirect('siswa/rapor_detail/' . $id_siswa . '?semester=' . $id_jadwal_setting);
    } else {
        setFlash('Method tidak diizinkan', 'error');
        redirect('siswa/rapor');
    }
}

// Method untuk halaman cetak rapor
public function cetak_rapor_wali($id_siswa = null)
{
    if (!Middleware::admin('wali_kelas')) {
        setFlash('Akses ditolak! Hanya wali kelas yang bisa mengakses halaman ini.', 'error');
        return redirect('siswa/rapor');
    }

    if (!$id_siswa) {
        setFlash('ID siswa tidak valid', 'error');
        return redirect('siswa/rapor');
    }

    // Ambil data siswa
    $siswa = $this->Mrapor->ambil_siswa_by_id($id_siswa);
    
    if (!$siswa) {
        setFlash('Data siswa tidak ditemukan', 'error');
        return redirect('siswa/rapor');
    }

    // Verifikasi apakah siswa ini di kelas wali kelas yang login
    $siswa_wali = $this->Mrapor->ambil_siswa_berdasarkan_wali_kelas($_SESSION['nik']);
    $found = false;
    foreach ($siswa_wali as $s) {
        if ($s->id_siswa == $id_siswa) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        setFlash('Anda tidak berhak mengakses data siswa ini', 'error');
        return redirect('siswa/rapor');
    }

    // Ambil semester yang dipilih
    $id_jadwal_pilihan = isset($_GET['semester']) ? (int)$_GET['semester'] : null;
    
    // Ambil semua jadwal
    $data['semua_jadwal'] = $this->Mrapor->ambil_semua_jadwal_setting();
    $data['jadwal_aktif'] = $this->Mrapor->ambil_jadwal_aktif();
    
    // Tentukan jadwal yang digunakan
    if ($id_jadwal_pilihan) {
        $jadwal_dipilih = null;
        foreach ($data['semua_jadwal'] as $js) {
            if ($js->id_jadwal_setting == $id_jadwal_pilihan) {
                $jadwal_dipilih = $js;
                break;
            }
        }
        $jadwal = $jadwal_dipilih ?: $data['jadwal_aktif'];
    } else {
        $jadwal = $data['jadwal_aktif'];
    }

    if (!$jadwal) {
        setFlash('Jadwal tidak ditemukan', 'error');
        return redirect('siswa/rapor');
    }

    // Ambil semua data rapor
    $data['siswa'] = $siswa;
    $data['jadwal'] = $jadwal;
    $data['semester_dipilih'] = $jadwal->id_jadwal_setting;
    $data['pelajaran'] = $this->Mrapor->ambil_mata_pelajaran_kelas($siswa->kelas_siswa, $jadwal->id_jadwal_setting);
    $data['nilai_pelajaran'] = $this->Mrapor->ambil_nilai_pelajaran($jadwal->id_jadwal_setting, $id_siswa);
    $data['nilai_sikap'] = $this->Mrapor->ambil_nilai_sikap($jadwal->id_jadwal_setting, $id_siswa);
    $data['ekskul'] = $this->Mrapor->ambil_ekstrakurikuler($jadwal->id_jadwal_setting, $id_siswa);
    $data['prestasi'] = $this->Mrapor->ambil_prestasi($jadwal->id_jadwal_setting, $id_siswa);
    $data['catatan'] = $this->Mrapor->ambil_catatan_wali($jadwal->id_jadwal_setting, $id_siswa);
    $data['rata_rata'] = $this->Mrapor->hitung_rata_rata_nilai($id_siswa, $jadwal->id_jadwal_setting);
    
    $data['wali_kelas'] = $this->Mrapor->ambil_data_wali_kelas($_SESSION['nik']);
    
    $data['kepala_sekolah'] = $this->Mrapor->ambil_kepala_sekolah();

    $this->view('siswa/rapor_cetak_walikelas', $data);
}
   // wali kelas

//--ADMIN---------------------------------

   public function admin_izin_siswa() {
      if (isset($_GET['status'])) {
         $status = $_GET['status'];
      } else {
         $status = 'Menunggu ACC';
      }
      $data['izin_siswa'] = $this->Msiswa->izin_siswa($status);
      $data['semester_aktif'] = $this->Msiswa->semester_aktif();
      $data['seluruh_siswa_aktif'] = $this->Msiswa->siswa_aktif_admin();
      require APPROOT . '/views/inc/header.php';
      $this->view('siswa/admin_izin_siswa', $data);
      require APPROOT . '/views/inc/footer.php';
   }

   public function admin_simpan_izin_siswa()
   {
      if ($_POST['mulai_izin'] > $_POST['sampai_izin']) {
         setFlash('Gagal disimpan, Tanggal mulai tidak boleh melebihi tanggal sampai', 'error');
         return redirect('siswa/admin_izin_siswa');
      }
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $file_name = $_FILES['file_izin']['name'];
      $file_size = $_FILES['file_izin']['size'];
      $file_tmp  = $_FILES['file_izin']['tmp_name'];
      $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

      $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

      if (!empty($file_name) && !in_array($file_ext, $allowed_ext)) {
         setFlash('Format file tidak diperbolehkan. Hanya JPG, JPEG, PNG dan PDF yang bisa diupload.', 'error');
         if ($_SESSION['role'] == 'admin') {
            return redirect('siswa/admin_izin_siswa');
         }
         exit;
      }

      if ($file_size > 2000 * 1000) {
         setFlash('Ukuran file melebihi 2MB.', 'error');
         if ($_SESSION['role'] == 'admin') {
            return redirect('siswa/admin_izin_siswa');
         }
         exit;
      }

      if ($this->Msiswa->simpan_izin_siswa_admin($_POST, $_FILES)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/admin_izin_siswa?status=Disetujui');
      } else {
         setFlash('Gagal disimpan, periksa tanggal yang anda masukkan, jangan ada tanggal yang double', 'error');
         return redirect('siswa/admin_izin_siswa');
      }
   }

   public function admin_hapus_izin_siswa($id) {
      if ($id !== false && $id > 0) {
         $result = $this->Msiswa->hapus_pengajuan_izin($id);
         if ($result) {
            setFlash('Data berhasil dihapus.', 'success');
         } else {
            setFlash('Gagal menghapus data.', 'error');
         }
      } else {
         setFlash('ID tidak valid.', 'error');
      }
      return redirect('siswa/admin_izin_siswa');
   }

   public function admin_simpan_edit_izin_siswa()
   {
      if ($_POST['mulai_izin'] > $_POST['sampai_izin']) {
         setFlash('Gagal disimpan, Tanggal mulai tidak boleh melebihi tanggal sampai', 'error');
         return redirect('siswa/admin_izin_siswa');
      }
      
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $upload_file = false;
      if (isset($_FILES['file_izin']) && $_FILES['file_izin']['size'] > 0) {
         $file_name = $_FILES['file_izin']['name'];
         $file_size = $_FILES['file_izin']['size'];
         $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

         $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

         if (!in_array($file_ext, $allowed_ext)) {
            setFlash('Format file tidak diperbolehkan. Hanya JPG, JPEG, PNG dan PDF yang bisa diupload.', 'error');
            return redirect('siswa/admin_izin_siswa');
         }

         if ($file_size > 2000 * 1000) {
            setFlash('Ukuran file melebihi 2MB.', 'error');
            return redirect('siswa/admin_izin_siswa');
         }

         $upload_file = true;
      }

      if ($this->Msiswa->simpan_edit_izin_siswa_admin($_POST, $upload_file ? $_FILES : null)) {
         setFlash('Berhasil diupdate.', 'success');
         return redirect('siswa/admin_izin_siswa?status=' . $_POST['status_kembali']);
      } else {
         setFlash('Gagal disimpan', 'error');
         return redirect('siswa/admin_izin_siswa');
      }
   }

   public function admin_respon_izin()
   {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($this->Msiswa->respon_izin_admin($_POST)) {
         setFlash('Berhasil disimpan.', 'success');
         return redirect('siswa/admin_izin_siswa');
      } else {
         setFlash('Gagal disimpan', 'error');
         return redirect('siswa/admin_izin_siswa');
      }
   }


//--ADMIN---------------------------------


   // siswa
   // Method untuk siswa melihat rapor mereka sendiri
   public function rapor_saya()
   {
       // Cek apakah yang login adalah siswa
       if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
           setFlash('Akses ditolak! Halaman ini hanya untuk siswa.', 'error');
           return redirect('auth/login');
       }
   
       $nis = $_SESSION['nik']; // NIS siswa ada di session nik
   
       // Cek apakah siswa terdaftar
       $cek_siswa = $this->Mrapor->cek_id_saya($nis);
       
       if (!$cek_siswa) {
           setFlash('Data siswa tidak ditemukan atau status tidak aktif.','error');
           require APPROOT . '/views/inc/header.php';
           $this->view('siswa/rapor_tidak_ditemukan');
           require APPROOT . '/views/inc/footer.php';
           return;
       }
   
       $id_siswa = $cek_siswa->id_siswa;
      
       // Ambil data siswa lengkap
       $data['siswa'] = $this->Mrapor->ambil_data_saya_by_id($id_siswa);
       
       // Ambil semua jadwal setting untuk dropdown
       $data['semua_jadwal'] = $this->Mrapor->ambil_semua_jadwal_setting();
       
       // Ambil jadwal aktif
       $data['jadwal_aktif'] = $this->Mrapor->ambil_jadwal_aktif();
   
       // Cek apakah ada parameter semester dari GET
       $id_jadwal_pilihan = isset($_GET['semester']) ? (int)$_GET['semester'] : null;
       
       // Jika ada pilihan semester, gunakan itu. Jika tidak, gunakan yang aktif
       if ($id_jadwal_pilihan) {
           // Validasi apakah jadwal setting ada
           $jadwal_dipilih = null;
           foreach ($data['semua_jadwal'] as $js) {
               if ($js->id_jadwal_setting == $id_jadwal_pilihan) {
                   $jadwal_dipilih = $js;
                   break;
               }
           }
           
           if ($jadwal_dipilih) {
               $data['rapor'] = $this->Mrapor->ambil_rapor_lengkap_siswa($id_siswa, $id_jadwal_pilihan);
               $data['semester_dipilih'] = $id_jadwal_pilihan;
           } else {
               // Jadwal tidak valid, gunakan yang aktif
               $data['rapor'] = $this->Mrapor->ambil_rapor_lengkap_siswa($id_siswa);
               $data['semester_dipilih'] = $data['jadwal_aktif'] ? $data['jadwal_aktif']->id_jadwal_setting : null;
           }
       } else {
           // Gunakan jadwal aktif
           $data['rapor'] = $this->Mrapor->ambil_rapor_lengkap_siswa($id_siswa);
           $data['semester_dipilih'] = $data['jadwal_aktif'] ? $data['jadwal_aktif']->id_jadwal_setting : null;
       }
   
       // Hitung rata-rata nilai
       if ($data['rapor']['ada_data']) {
           $data['rata_rata'] = $this->Mrapor->hitung_rata_rata_nilai(
               $id_siswa, 
               $data['semester_dipilih']
           );
       } else {
           $data['rata_rata'] = 0;
       }

       require APPROOT . '/views/inc/header.php';
       $this->view('siswa/rapor_saya', $data);
       require APPROOT . '/views/inc/footer.php';
   }
   
   // Method untuk print/export rapor (opsional)
   public function cetak_rapor()
   {
       if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
           setFlash('Akses ditolak!', 'error');
           return redirect('auth/login');
       }
   
       $nis = $_SESSION['nik'];
       $cek_siswa = $this->Mrapor->cek_id_saya($nis);
       
       if (!$cek_siswa) {
           setFlash('Data siswa tidak ditemukan', 'error');
           return redirect('siswa/rapor_saya');
       }
   
       $id_siswa = $cek_siswa->id_siswa;
       $id_jadwal = isset($_GET['semester']) ? (int)$_GET['semester'] : null;
   
       $data['siswa'] = $this->Mrapor->ambil_data_saya_by_id($id_siswa);
       $data['rapor'] = $this->Mrapor->ambil_rapor_lengkap_siswa($id_siswa, $id_jadwal);
       
       if (!$data['rapor']['ada_data']) {
           setFlash('Rapor belum tersedia untuk periode ini', 'error');
           return redirect('siswa/rapor_saya');
       }
   
       $data['rata_rata'] = $this->Mrapor->hitung_rata_rata_nilai($id_siswa, $id_jadwal);
   
       // Load view cetak (tanpa header/footer)
       $this->view('siswa/rapor_cetak', $data);
   }
 // siswa




}