<?php
class Msiswa
{
   public function __construct()
   {
      $this->db = new Database;
   }

   public function siswa_aktif($filter)
   {
      if ($filter == 'all') {
         $sql = "SELECT siswa.*, m_prodi.*, siswa.kelas_siswa from siswa 
         LEFT JOIN m_prodi on siswa.prodi = m_prodi.id_prodi where status_siswa=:status";
         $this->db->query($sql);
         $this->db->bind('status', 'Aktif');
      } else {
         $sql = "SELECT * from siswa where status_siswa=:status and prodi=:prodi";
         $this->db->query($sql);
         $this->db->bind('status', 'Aktif');
         $this->db->bind('prodi', $filter);
      }
      return $this->db->resultset();
   }

   public function perkelas()
   {
      $sql = "SELECT kelas_siswa, prodi, COUNT(*) as jumlah FROM siswa WHERE status_siswa = 'Aktif' GROUP BY kelas_siswa";
      $this->db->query($sql);
      return $this->db->resultset();
   }

   public function ambil_prodi($id)
   {
      $sql = "SELECT siswa.prodi, m_prodi.kode_prodi from siswa left join m_prodi on siswa.prodi=m_prodi.id_prodi where siswa.kelas_siswa=:id group by siswa.prodi";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   // public function rekap_perkelas()
   // {
   //    $sql_drop_temp = "DROP TEMPORARY TABLE IF EXISTS temp_rekap;";
   //    $this->db->query($sql_drop_temp);
   //    $this->db->execute();

   //    $sql_temp = "CREATE TEMPORARY TABLE temp_rekap AS SELECT 
   //          CASE
   //             WHEN kelas_siswa LIKE 'X%' AND kelas_siswa NOT LIKE 'XI%' AND kelas_siswa NOT LIKE 'XII%' THEN 'X'
   //             WHEN kelas_siswa LIKE 'XI%' AND kelas_siswa NOT LIKE 'XII%' THEN 'XI'
   //             WHEN kelas_siswa LIKE 'XII%' THEN 'XII'
   //          END as kelas,
   //          prodi as prodi,
   //          jenis_kelamin as jk,
   //          COUNT(*) as jumlah_siswa
   //       FROM siswa
   //       WHERE status_siswa = :status
   //       GROUP BY kelas, prodi, jk;";

   //    $this->db->query($sql_temp);
   //    $this->db->bind('status', 'Aktif');
   //    $this->db->execute();

   //    $sql = "SELECT 
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '1' THEN jumlah_siswa ELSE 0 END) as TJKT_X,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '6' THEN jumlah_siswa ELSE 0 END) as TJAT_X,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '7' THEN jumlah_siswa ELSE 0 END) as TKJ_X,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '2' THEN jumlah_siswa ELSE 0 END) as RPL_X,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '3' THEN jumlah_siswa ELSE 0 END) as DKV_X,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '4' THEN jumlah_siswa ELSE 0 END) as ANI_X,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '1' THEN jumlah_siswa ELSE 0 END) as TJKT_XI,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '6' THEN jumlah_siswa ELSE 0 END) as TJAT_XI,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '7' THEN jumlah_siswa ELSE 0 END) as TKJ_XI,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '2' THEN jumlah_siswa ELSE 0 END) as RPL_XI,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '3' THEN jumlah_siswa ELSE 0 END) as DKV_XI,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '4' THEN jumlah_siswa ELSE 0 END) as ANI_XI,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '1' THEN jumlah_siswa ELSE 0 END) as TJKT_XII,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '6' THEN jumlah_siswa ELSE 0 END) as TJAT_XII,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '7' THEN jumlah_siswa ELSE 0 END) as TKJ_XII,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '2' THEN jumlah_siswa ELSE 0 END) as RPL_XII,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '3' THEN jumlah_siswa ELSE 0 END) as DKV_XII,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '4' THEN jumlah_siswa ELSE 0 END) as ANI_XII,

   //          SUM(CASE WHEN kelas = 'X' AND prodi = '6' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as TJAT_X_L,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '6' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as TJAT_X_P,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '6' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as TJAT_XI_L,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '6' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as TJAT_XI_P,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '6' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as TJAT_XII_L,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '6' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as TJAT_XII_P,

   //          SUM(CASE WHEN kelas = 'X' AND prodi = '7' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as TKJ_X_L,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '7' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as TKJ_X_P,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '7' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as TKJ_XI_L,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '7' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as TKJ_XI_P,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '7' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as TKJ_XII_L,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '7' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as TKJ_XII_P,

   //          SUM(CASE WHEN kelas = 'X' AND prodi = '2' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as RPL_X_L,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '2' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as RPL_X_P,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '2' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as RPL_XI_L,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '2' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as RPL_XI_P,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '2' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as RPL_XII_L,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '2' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as RPL_XII_P,

   //          SUM(CASE WHEN kelas = 'X' AND prodi = '3' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as DKV_X_L,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '3' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as DKV_X_P,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '3' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as DKV_XI_L,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '3' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as DKV_XI_P,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '3' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as DKV_XII_L,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '3' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as DKV_XII_P,

   //          SUM(CASE WHEN kelas = 'X' AND prodi = '4' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as ANI_X_L,
   //          SUM(CASE WHEN kelas = 'X' AND prodi = '4' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as ANI_X_P,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '4' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as ANI_XI_L,
   //          SUM(CASE WHEN kelas = 'XI' AND prodi = '4' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as ANI_XI_P,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '4' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as ANI_XII_L,
   //          SUM(CASE WHEN kelas = 'XII' AND prodi = '4' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as ANI_XII_P,


   //          SUM(jumlah_siswa) as total_jumlah_siswa

   //          FROM temp_rekap;";
   //    $this->db->query($sql);
   //    $result = $this->db->single();
   //    return $result;
   // }

   public function rekap_perkelas()
   {
      $sql_drop_temp = "DROP TEMPORARY TABLE IF EXISTS temp_rekap;";
      $this->db->query($sql_drop_temp);
      $this->db->execute();

      $sql_temp = "CREATE TEMPORARY TABLE temp_rekap AS SELECT 
            CASE
               WHEN kelas_siswa LIKE 'X%' AND kelas_siswa NOT LIKE 'XI%' AND kelas_siswa NOT LIKE 'XII%' THEN 'X'
               WHEN kelas_siswa LIKE 'XI%' AND kelas_siswa NOT LIKE 'XII%' THEN 'XI'
               WHEN kelas_siswa LIKE 'XII%' THEN 'XII'
            END as kelas,
            prodi as prodi,
            jenis_kelamin as jk,
            COUNT(*) as jumlah_siswa
         FROM siswa
         WHERE status_siswa = :status AND prodi = '1'
         GROUP BY kelas, prodi, jk;";

      $this->db->query($sql_temp);
      $this->db->bind('status', 'Aktif');
      $this->db->execute();

      $sql = "SELECT 
            SUM(CASE WHEN kelas = 'X' AND prodi = '1' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_X,
            SUM(CASE WHEN kelas = 'XI' AND prodi = '1' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_XI,
            SUM(CASE WHEN kelas = 'XII' AND prodi = '1' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_XII,

            SUM(CASE WHEN kelas = 'X' AND prodi = '1' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_X_L,
            SUM(CASE WHEN kelas = 'X' AND prodi = '1' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_X_P,
            SUM(CASE WHEN kelas = 'XI' AND prodi = '1' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_XI_L,
            SUM(CASE WHEN kelas = 'XI' AND prodi = '1' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_XI_P,
            SUM(CASE WHEN kelas = 'XII' AND prodi = '1' AND jk = 'Laki-laki' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_XII_L,
            SUM(CASE WHEN kelas = 'XII' AND prodi = '1' AND jk = 'Perempuan' THEN jumlah_siswa ELSE 0 END) as SMABETHEL_XII_P,

            SUM(jumlah_siswa) as total_jumlah_siswa

            FROM temp_rekap;";
      $this->db->query($sql);
      $result = $this->db->single();
      return $result;
   }
   

   public function siswa_aktif_kelas($kelas)
   {
      if ($kelas == 'all') {
         $sql = "SELECT siswa.*, m_prodi.* from siswa 
         LEFT JOIN m_prodi on siswa.prodi = m_prodi.id_prodi where status_siswa=:status order by kelas_siswa, prodi, nama_siswa";
         $this->db->query($sql);
         $this->db->bind('status', 'Aktif');
      } else if ($kelas == 'tanpa_kelas') {
         $sql = "SELECT siswa.*, m_prodi.* from siswa 
         LEFT JOIN m_prodi on siswa.prodi = m_prodi.id_prodi where status_siswa=:status and (kelas_siswa='-' or kelas_siswa IS NULL) order by kelas_siswa, nama_siswa";
         $this->db->query($sql);
         $this->db->bind('status', 'Aktif');
      } else {
         $sql = "SELECT siswa.*, m_prodi.* from siswa 
         LEFT JOIN m_prodi on siswa.prodi = m_prodi.id_prodi where status_siswa=:status and kelas_siswa=:kelas order by kelas_siswa, prodi, nama_siswa";
         $this->db->query($sql);
         $this->db->bind('status', 'Aktif');
         $this->db->bind('kelas', $kelas);
      }
      return $this->db->resultset();
   }

   public function m_prodi()
   {
      $sql = "SELECT * from m_prodi order by kode_prodi ";
      $this->db->query($sql);
      return $this->db->resultset();
   }

   public function status_siswa($status)
   {
      $sql = "SELECT siswa.*, m_prodi.* from siswa 
         LEFT JOIN m_prodi on siswa.prodi = m_prodi.id_prodi where status_siswa=:status order by kelas_siswa, prodi, nis, nama_siswa";
      $this->db->query($sql);
      $this->db->bind('status', $status);
      return $this->db->resultset();
   }

   public function siswa_by_id($id_siswa)
   {
      $sql = "SELECT * from siswa where id_siswa=:id_siswa";
      $this->db->query($sql);
      $this->db->bind('id_siswa', $id_siswa);
      return $this->db->single();
   }

   public function siswa_by_nis($nis)
   {
      $sql = "SELECT * from siswa where nis=:nis";
      $this->db->query($sql);
      $this->db->bind('nis', $nis);
      return $this->db->single();
   }

   public function wali_kelas_by_nik($nik)
   {
      $sql = "SELECT nama from pegawai where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function prodi_siswa_aktif()
   {
      $sql = "SELECT distinct prodi from siswa where status_siswa=:status";
      $this->db->query($sql);
      $this->db->bind('status', 'Aktif');
      return $this->db->resultset();
   }

   public function propinsi()
   {
      $sql = "SELECT * from tb_propinsi order by id_propinsi";
      $this->db->query($sql);
      return $this->db->resultset();
   }

   public function kabupaten()
   {
      $sql = "SELECT * from tb_kabupaten order by id_kabupaten";
      $this->db->query($sql);
      return $this->db->resultset();
   }

   public function kecamatan()
   {
      $sql = "SELECT * from tb_kecamatan order by id_kecamatan";
      $this->db->query($sql);
      return $this->db->resultset();
   }

   public function kabupatenByPropinsi($propinsiId)
   {
      $sql = "SELECT * FROM tb_kabupaten WHERE id_propinsi_kabupaten=:propinsiId ORDER BY id_kabupaten";
      $this->db->query($sql);
      $this->db->bind(':propinsiId', $propinsiId);
      return $this->db->resultset();
   }

   public function kecamatanByKabupaten($kabupatenId)
   {
      $sql = "SELECT * FROM tb_kecamatan WHERE id_kabupaten_kecamatan=:kabupatenId ORDER BY id_kecamatan";
      $this->db->query($sql);
      $this->db->bind(':kabupatenId', $kabupatenId);
      return $this->db->resultset();
   }

   public function cek_nis($nis)
   {
      $sql = "SELECT * from siswa where nis=:nis";
      $this->db->query($sql);
      $this->db->bind('nis', $nis);
      return $this->db->single();
   }

   public function cek_username($username)
   {
      $sql = "SELECT * from users where username=:username";
      $this->db->query($sql);
      $this->db->bind('username', $username);
      return $this->db->single();
   }

   public function cek_rfid($nomor_rfid)
   {
      $sql = "SELECT * from siswa where rfid=:rfid";
      $this->db->query($sql);
      $this->db->bind('rfid', $nomor_rfid);
      return $this->db->single();
   }

   public function prodi()
   {
      $sql = "SELECT * FROM m_prodi where status_prodi='Aktif'";
      $this->db->query($sql);
      return $this->db->resultset();
   }

   public function prodi_by_id($id)
   {
      $sql = "SELECT * FROM m_prodi where id_prodi=:kode_prodi";
      $this->db->query($sql);
      $this->db->bind('kode_prodi', $id);
      return $this->db->single();
   }

   public function simpan($data, $files)
   {
      $sql = "INSERT into siswa (id_siswa, nis, nama_siswa, tahun_masuk, prodi, kelas_siswa, ruang_siswa, jenis_kelamin, NISN, tempat_lahir, tanggal_lahir, agama, alamat, propinsi, kabupaten, kecamatan, nomor_hp, nama_wali, alamat_wali, nama_ibu, nomor_hp_wali, status_siswa, pekerjaan_wali, rfid) values (:id_siswa, :nis, :nama_siswa, :tahun_masuk, :prodi, :kelas_siswa, :ruang_siswa,  :jenis_kelamin, :NISN, :tempat_lahir, :tanggal_lahir, :agama, :alamat, :propinsi, :kabupaten, :kecamatan, :nomor_hp, :nama_wali, :alamat_wali, :nama_ibu, :nomor_hp_wali, :status_siswa, :pekerjaan_wali, :rfid)";
      $this->db->query($sql);
      $this->db->bind('id_siswa', NULL);
      $this->db->bind('nis', $data['nis']);
      $this->db->bind('nama_siswa', $data['nama']);
      $this->db->bind('tahun_masuk', $data['tahun_masuk']);
      $this->db->bind('prodi', $data['prodi']);
      $this->db->bind('kelas_siswa', $data['kelas_siswa'] . $data['ruang_siswa']);
      $this->db->bind('ruang_siswa', $data['ruang_siswa']);
      $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
      $this->db->bind('NISN', $data['nisn']);
      $this->db->bind('tempat_lahir', $data['tempat_lahir']);
      $this->db->bind('tanggal_lahir', $data['tanggal_lahir']);
      $this->db->bind('agama', $data['agama']);
      $this->db->bind('alamat', $data['alamat']);
      $this->db->bind('propinsi', $data['propinsi']);
      $this->db->bind('kabupaten', $data['kabupaten']);
      $this->db->bind('kecamatan', $data['kecamatan']);
      $this->db->bind('nomor_hp', $data['nomor_hp']);
      $this->db->bind('nama_wali', $data['nama_wali']);
      $this->db->bind('alamat_wali', $data['alamat_wali']);
      $this->db->bind('nama_ibu', $data['nama_ibu']);
      $this->db->bind('nomor_hp_wali', $data['nomor_hp_wali']);
      $this->db->bind('pekerjaan_wali', $data['pekerjaan_wali']);
      $this->db->bind('status_siswa', 'Aktif');
      $this->db->bind('rfid', $data['nomor_rfid']);
      $this->db->execute();

      $sql2 = "INSERT INTO users (id_user, nik_user, username, nama_user, password, role) values (:id_user, :nik_user, :username, :nama_user, :password, :role)";
      $this->db->query($sql2);
      $this->db->bind('id_user', NULL);
      $this->db->bind('nik_user', $data['nis']);
      $this->db->bind('username', $data['nis']);
      $this->db->bind('nama_user', $data['nama']);
      $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
      $this->db->bind('role', 'siswa');
      $this->db->execute();

      if ($files['avatar']['size'] > 0) {
         $file_extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);

         if ($_SESSION['role'] != 'siswa') {
            $newAvatarName = $data['nis'] . '.' . $file_extension;
         } else {
            $newAvatarName = $_SESSION['nis'] . '.' . $file_extension;
         }

         if ($files['avatar']['size'] < 2000 * 1000) {
            if ($_SESSION['avatar'] == NULL) {
               move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
            } else {
               move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
            }
         } else {
            return false;
         }

         $query = "UPDATE siswa SET foto_siswa=:foto_siswa WHERE nis=:nis";
         $this->db->query($query);
         if ($_SESSION['role'] != 'siswa') {
            $this->db->bind(':nis', $data['nis']);
         } else {
            $this->db->bind(':nis', $_SESSION['nis']);
         }
         $this->db->bind(':foto_siswa', $newAvatarName);
         $this->db->execute();
      }

      return true;
   }

   public function simpan_edit($data, $files)
   {
      $sql = "UPDATE siswa set nama_siswa=:nama_siswa, tahun_masuk=:tahun_masuk, prodi=:prodi, kelas_siswa=:kelas_siswa, ruang_siswa=:ruang_siswa, jenis_kelamin=:jenis_kelamin, NISN=:NISN, tempat_lahir=:tempat_lahir, tanggal_lahir=:tanggal_lahir, agama=:agama, alamat=:alamat, propinsi=:propinsi, kabupaten=:kabupaten, kecamatan=:kecamatan, nomor_hp=:nomor_hp, nama_wali=:nama_wali, alamat_wali=:alamat_wali, nama_ibu=:nama_ibu, nomor_hp_wali=:nomor_hp_wali, status_siswa=:status_siswa, pekerjaan_wali=:pekerjaan_wali, rfid=:rfid WHERE id_siswa=:id_siswa";
      $this->db->query($sql);
      $this->db->bind('id_siswa', $data['id_siswa']);
      $this->db->bind('nama_siswa', $data['nama']);
      $this->db->bind('tahun_masuk', $data['tahun_masuk']);
      $this->db->bind('prodi', $data['prodi']);
      $this->db->bind('kelas_siswa', $data['kelas_siswa'] . $data['ruang_siswa']);
      $this->db->bind('ruang_siswa', $data['ruang_siswa']);
      $this->db->bind('jenis_kelamin', $data['jenis_kelamin']);
      $this->db->bind('NISN', $data['nisn']);
      $this->db->bind('tempat_lahir', $data['tempat_lahir']);
      $this->db->bind('tanggal_lahir', $data['tanggal_lahir']);
      $this->db->bind('agama', $data['agama']);
      $this->db->bind('alamat', $data['alamat']);
      $this->db->bind('propinsi', $data['propinsi']);
      $this->db->bind('kabupaten', $data['kabupaten']);
      $this->db->bind('kecamatan', $data['kecamatan']);
      $this->db->bind('nomor_hp', $data['nomor_hp']);
      $this->db->bind('nama_wali', $data['nama_wali']);
      $this->db->bind('alamat_wali', $data['alamat_wali']);
      $this->db->bind('nama_ibu', $data['nama_ibu']);
      $this->db->bind('nomor_hp_wali', $data['nomor_hp_wali']);
      $this->db->bind('pekerjaan_wali', $data['pekerjaan_wali']);
      $this->db->bind('status_siswa', 'Aktif');
      $this->db->bind('rfid', $data['nomor_rfid']);
      $this->db->execute();

      if ($data['password']) {
         $sql2 = "UPDATE users set password=:password where nik_user=:nik_user";
         $this->db->query($sql2);
         $this->db->bind('nik_user', $data['nis']);
         $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
         $this->db->execute();
      }

      if ($files['avatar']['size'] > 0) {
         echo "tes";
         $file_extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);

         if ($_SESSION['role'] != 'siswa') {
            $newAvatarName = $data['nis'] . '.' . $file_extension;
         } else {
            $newAvatarName = $_SESSION['nis'] . '.' . $file_extension;
         }

         if ($files['avatar']['size'] < 2000 * 1000) {
            if ($_SESSION['avatar'] == NULL) {
               move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
            } else {
               if (unlink("../public/skatel/avatar/" . $_SESSION['avatar'])) {
                  move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
               } else {
                  move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
               }
            }
         } else {
            return false;
         }

         $query = "UPDATE siswa SET foto_siswa=:foto_siswa WHERE nis=:nis";
         $this->db->query($query);
         if ($_SESSION['role'] != 'siswa') {
            $this->db->bind(':nis', $data['nis']);
         } else {
            $this->db->bind(':nis', $_SESSION['nis']);
         }
         $this->db->bind(':foto_siswa', $newAvatarName);
         $this->db->execute();
      }
      return true;
   }

   public function hapus_siswa($id)
   {
      $sqlCopy = "INSERT INTO siswa_hapus SELECT * FROM siswa WHERE nis=:nis_siswa";
      $this->db->query($sqlCopy);
      $this->db->bind('nis_siswa', $id);
      $this->db->execute();

      $sql = "DELETE from siswa where nis=:nis_siswa";
      $this->db->query($sql);
      $this->db->bind('nis_siswa', $id);
      $this->db->execute();

      $sql = "DELETE from users where username=:nis_siswa";
      $this->db->query($sql);
      $this->db->bind('nis_siswa', $id);
      $this->db->execute();
      return true;
   }

   public function pilih_kelas($id_siswa, $pilih_kelas, $nama_field)
   {
      $sql = "UPDATE siswa set kelas_siswa=:kelas where id_siswa=:id";
      $this->db->query($sql);
      $this->db->bind('kelas', $pilih_kelas);
      $this->db->bind('id', $id_siswa);
      $this->db->execute();
      return true;
   }

   public function pilih_prodi($id_siswa, $pilih_prodi, $nama_field)
   {
      $sql = "UPDATE siswa set prodi=:prodi where id_siswa=:id";
      $this->db->query($sql);
      $this->db->bind('prodi', $pilih_prodi);
      $this->db->bind('id', $id_siswa);
      $this->db->execute();
      return true;
   }


   public function pilih_status($id_siswa, $pilih_status)
   {
      $sql = "UPDATE siswa set status_siswa=:status_siswa where id_siswa=:id";
      $this->db->query($sql);
      $this->db->bind('status_siswa', $pilih_status);
      $this->db->bind('id', $id_siswa);
      $this->db->execute();
      return true;
   }

   //--------------------
   public function saya()
   {
      $saya = $_SESSION['nik'];
      $sql = "SELECT siswa.*, m_prodi.* from siswa LEFT JOIN m_prodi on siswa.prodi = m_prodi.id_prodi where nis=:nis";
      $this->db->query($sql);
      $this->db->bind('nis', $saya);
      return $this->db->single();
   }

   public function cari_rfid($nomor_rfid)
   {
      $sql = "SELECT nama_siswa from siswa where rfid=:rfid";
      $this->db->query($sql);
      $this->db->bind('rfid', $nomor_rfid);
      return $this->db->single();
   }

   //-------------------------------
   public function nama_propinsi($id)
   {
      $sql = "SELECT * from tb_propinsi where id_propinsi=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function nama_kabupaten($id)
   {
      $sql = "SELECT * from tb_kabupaten where id_kabupaten=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function nama_kecamatan($id)
   {
      $sql = "SELECT * from tb_kecamatan where id_kecamatan=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   //---------------------------
   public function kelas_saya($tanggal)
   {
      $sql = "SELECT absen_kelas_siswa.*, siswa.nama_siswa from absen_kelas_siswa left join siswa on absen_kelas_siswa.nis_aks=siswa.nis where wali_kelas_aks=:wali_kelas and absen_kelas_siswa.tgl_aks=:tanggal order by nama_siswa";
      $this->db->query($sql);
      $this->db->bind('wali_kelas', $_SESSION['nik']);
      $this->db->bind('tanggal', $tanggal);
      return $this->db->resultSet();
   }

   //--SISWA-------------------------
   public function absen_kelas($tanggal, $kelas)
   {
      $sql = "SELECT absen_kelas_siswa.*, siswa.nama_siswa from absen_kelas_siswa left join siswa on absen_kelas_siswa.nis_aks=siswa.nis where kelas_aks=:kelas and absen_kelas_siswa.tgl_aks=:tanggal order by nama_siswa";
      $this->db->query($sql);
      $this->db->bind('kelas', $kelas);
      $this->db->bind('tanggal', $tanggal);
      return $this->db->resultSet();
   }

   //---WALI KELAS
   public function wali_kelas()
   {
      $sql = "SELECT jadwal_lengkap.wali_kelas, jadwal_lengkap.kode_kelas, pegawai.nama from jadwal_lengkap left join pegawai on jadwal_lengkap.wali_kelas=pegawai.nik order by pegawai.nama";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function pengajuan_izin()
   {
      $sql = "SELECT * from izin_siswa where nis_izin=:nis order by tgl_dibuat_izin DESC";
      $this->db->query($sql);
      $this->db->bind('nis', $_SESSION['nik']);
      return $this->db->resultSet();
   }

   public function cek_double_izin($nis, $mulai, $sampai)
   {
      $sql = "SELECT * FROM izin_siswa WHERE nis_izin = :nis_izin AND (
               (mulai_izin <= :start_date AND sampai_izin >= :start_date) OR
               (mulai_izin <= :end_date AND sampai_izin >= :end_date) OR
               (mulai_izin >= :start_date AND sampai_izin <= :end_date)
            )";
      $this->db->query($sql);
      $this->db->bind('nis_izin', $nis);
      $this->db->bind('start_date', $mulai);
      $this->db->bind('end_date', $sampai);
      return $this->db->resultSet();
   }

   public function simpan_izin_siswa($data, $files)
   {
      // Cek izin ganda
      $cek = $this->cek_double_izin($_SESSION['nik'], $data['mulai_izin'], $data['sampai_izin']);
      if ($cek) {
         return false;
      }

      // Ambil kelas siswa
      $ambil = "SELECT kelas_siswa FROM siswa WHERE nis = :nis";
      $this->db->query($ambil);
      $this->db->bind('nis', $_SESSION['nik']);
      $ambil1 = $this->db->single();
      $kelas = $ambil1->kelas_siswa;

      // Ambil wali kelas
      $wakel = "SELECT wali_kelas FROM jadwal_lengkap WHERE kode_kelas = :kode_kelas";
      $this->db->query($wakel);
      $this->db->bind('kode_kelas', $kelas);
      $wakel1 = $this->db->single();
      $wali_kelas = $wakel1->wali_kelas;

      // --- Proses upload file ---
      $file_izin = null;

      if ($files['file_izin']['size'] > 0) {
         $file_name = $files['file_izin']['name'];
         $file_tmp  = $files['file_izin']['tmp_name'];
         $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

         $upload_dir = "../public/smabethel/file_izin/";
         $newfile_izinName = uniqid('izin_', true) . '.' . $file_ext;

         // Jika sebelumnya ada file izin, hapus dulu
         if (!empty($_SESSION['file_izin'])) {
               $oldFile = $upload_dir . $_SESSION['file_izin'];
               if (file_exists($oldFile)) {
                  unlink($oldFile);
               }
         }

         // Pindahkan file ke folder tujuan
         if (move_uploaded_file($file_tmp, $upload_dir . $newfile_izinName)) {
               $file_izin = $newfile_izinName;
               $_SESSION['file_izin'] = $newfile_izinName;
         } else {
               setFlash('Gagal mengupload file.', 'error');
               return false;
         }
      }

      // --- Simpan data ke database ---
      $sql = "INSERT INTO izin_siswa 
            (nis_izin, kelas_izin, wali_kelas_izin, jenis_izin, mulai_izin, sampai_izin, tgl_dibuat_izin, alasan_izin, status_izin, file_izin)
            VALUES 
            (:nis_izin, :kelas_izin, :wali_kelas_izin, :jenis_izin, :mulai_izin, :sampai_izin, :tgl_dibuat_izin, :alasan_izin, :status_izin, :file_izin)";

      $this->db->query($sql);
      $this->db->bind('nis_izin', $_SESSION['nik']);
      $this->db->bind('kelas_izin', $kelas);
      $this->db->bind('wali_kelas_izin', $wali_kelas);
      $this->db->bind('jenis_izin', $data['jenis_izin']);
      $this->db->bind('mulai_izin', $data['mulai_izin']);
      $this->db->bind('sampai_izin', $data['sampai_izin']);
      $this->db->bind('tgl_dibuat_izin', date('Y-m-d'));
      $this->db->bind('alasan_izin', $data['keterangan']);
      $this->db->bind('status_izin', 'Menunggu ACC');
      $this->db->bind('file_izin', $file_izin);
      $this->db->execute();

      return true;
   }

      public function simpan_edit_izin_siswa($data, $files = null)
   {
      // Ambil data file lama terlebih dahulu
      $sql_get = "SELECT file_izin FROM izin_siswa WHERE id_izin = :id";
      $this->db->query($sql_get);
      $this->db->bind('id', $data['id_izin']);
      $old_data = $this->db->single();
      $old_file = $old_data->file_izin ?? null;

      $file_izin = $old_file; // Default tetap gunakan file lama

      // Proses upload file baru jika ada
      if ($files !== null && isset($files['file_izin']) && $files['file_izin']['size'] > 0) {
         $file_name = $files['file_izin']['name'];
         $file_tmp  = $files['file_izin']['tmp_name'];
         $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

         $upload_dir = "../public/smabethel/file_izin/";
         $new_file_name = uniqid('izin_', true) . '.' . $file_ext;

         // Hapus file lama jika ada
         if (!empty($old_file)) {
            $old_file_path = $upload_dir . $old_file;
            if (file_exists($old_file_path)) {
               unlink($old_file_path);
            }
         }

         // Upload file baru
         if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $file_izin = $new_file_name;
         } else {
            setFlash('Gagal mengupload file.', 'error');
            return false;
         }
      }

      // Update data ke database
      $sql = "UPDATE izin_siswa 
            SET jenis_izin = :jenis_izin, 
                  mulai_izin = :mulai_izin, 
                  sampai_izin = :sampai_izin, 
                  alasan_izin = :alasan_izin,
                  file_izin = :file_izin 
            WHERE id_izin = :id";
      
      $this->db->query($sql);
      $this->db->bind('id', $data['id_izin']);
      $this->db->bind('jenis_izin', $data['jenis_izin']);
      $this->db->bind('mulai_izin', $data['mulai_izin']);
      $this->db->bind('sampai_izin', $data['sampai_izin']);
      $this->db->bind('alasan_izin', $data['keterangan']);
      $this->db->bind('file_izin', $file_izin);
      $this->db->execute();
      
      return true;
   }


      public function hapus_pengajuan_izin($id)
   {
      // Ambil data file terlebih dahulu sebelum dihapus
      $sql_get = "SELECT file_izin FROM izin_siswa WHERE id_izin = :id";
      $this->db->query($sql_get);
      $this->db->bind('id', $id);
      $data = $this->db->single();

      // Hapus file jika ada
      if (!empty($data->file_izin)) {
         $file_path = "../public/smabethel/file_izin/" . $data->file_izin;
         if (file_exists($file_path)) {
            unlink($file_path);
         }
      }

      // Hapus data dari database
      $sql = "DELETE FROM izin_siswa WHERE id_izin = :id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      $this->db->execute();
      
      return true;
   }

   // old without file
   // public function simpan_izin_siswa($data)
   // {
   //    $cek = $this->cek_double_izin($_SESSION['nik'], $data['mulai_izin'], $data['sampai_izin']);
   //    if ($cek) {
   //       return false;
   //    }

   //    $ambil = "SELECT kelas_siswa from siswa where nis=:nis";
   //    $this->db->query($ambil);
   //    $this->db->bind('nis', $_SESSION['nik']);
   //    $ambil1 = $this->db->single();
   //    $kelas = $ambil1->kelas_siswa;

   //    $wakel = "SELECT wali_kelas from jadwal_lengkap where kode_kelas=:kode_kelas";
   //    $this->db->query($wakel);
   //    $this->db->bind('kode_kelas', $kelas);
   //    $wakel1 = $this->db->single();
   //    $wali_kelas = $wakel1->wali_kelas;

   //    $sql = "INSERT INTO izin_siswa (nis_izin, kelas_izin, wali_kelas_izin, jenis_izin, mulai_izin, sampai_izin, tgl_dibuat_izin, alasan_izin, status_izin) values (:nis_izin, :kelas_izin, :wali_kelas_izin, :jenis_izin, :mulai_izin, :sampai_izin, :tgl_dibuat_izin, :alasan_izin, :status_izin)";
   //    $this->db->query($sql);
   //    $this->db->bind('nis_izin', $_SESSION['nik']);
   //    $this->db->bind('kelas_izin', $kelas);
   //    $this->db->bind('wali_kelas_izin', $wali_kelas);
   //    $this->db->bind('jenis_izin', $data['jenis_izin']);
   //    $this->db->bind('mulai_izin', $data['mulai_izin']);
   //    $this->db->bind('sampai_izin', $data['sampai_izin']);
   //    $this->db->bind('tgl_dibuat_izin', date('Y-m-d'));
   //    $this->db->bind('alasan_izin', $data['keterangan']);
   //    $this->db->bind('status_izin', 'Menunggu ACC');
   //    $this->db->execute();
   //    return true;
   // }

   // public function simpan_edit_izin_siswa($data)
   // {
   //    $sql = "UPDATE izin_siswa set jenis_izin=:jenis_izin, mulai_izin=:mulai_izin, sampai_izin=:sampai_izin, alasan_izin=:alasan_izin where id_izin=:id";
   //    $this->db->query($sql);
   //    $this->db->bind('id', $data['id_izin']);
   //    $this->db->bind('jenis_izin', $data['jenis_izin']);
   //    $this->db->bind('mulai_izin', $data['mulai_izin']);
   //    $this->db->bind('sampai_izin', $data['sampai_izin']);
   //    $this->db->bind('alasan_izin', $data['keterangan']);
   //    $this->db->execute();
   //    return true;
   // }

   // public function hapus_pengajuan_izin($id)
   // {
   //    $sql = "DELETE from izin_siswa where id_izin=:id";
   //    $this->db->query($sql);
   //    $this->db->bind('id', $id);
   //    $this->db->execute();
   //    return true;
   // }
   // old without file

   //--IZIN SISWA ------------------
   public function izin_siswa($status)
   {
      if ($status == 'Expired') {
         $sql = "SELECT * from izin_siswa where status_izin=:status_izin and curdate() > sampai_izin order by tgl_dibuat_izin DESC, mulai_izin DESC";
         $this->db->query($sql);
         $this->db->bind('status_izin', 'Menunggu ACC');
      } else if ($status == 'Menunggu ACC') {
         $sql = "SELECT * from izin_siswa where status_izin=:status_izin and curdate() <= sampai_izin order by tgl_dibuat_izin DESC, mulai_izin DESC";
         $this->db->query($sql);
         $this->db->bind('status_izin', $status);
      } else {
         $sql = "SELECT * from izin_siswa where status_izin=:status_izin order by tgl_dibuat_izin DESC, mulai_izin DESC";
         $this->db->query($sql);
         $this->db->bind('status_izin', $status);
      }
      return $this->db->resultSet();
   }

   public function respon_izin($data)
   {
      if ($data['status_izin'] == 'Hapus') {
         $sql = "DELETE from izin_siswa where id_izin=:id";
         $this->db->query($sql);
         $this->db->bind('id', $data['id_izin']);
         $this->db->execute();
         return true;
      } else if ($data['status_izin'] == 'Ditolak') {
         $sql = "UPDATE izin_siswa set status_izin=:status_izin, nik_status_izin=:nik_status_izin where id_izin=:id";
         $this->db->query($sql);
         $this->db->bind('id', $data['id_izin']);
         $this->db->bind('status_izin', $data['status_izin']);
         $this->db->bind('nik_status_izin', $_SESSION['nik']);
         $this->db->execute();
         return true;
      } else {
         $sql = "UPDATE izin_siswa set status_izin=:status_izin, nik_status_izin=:nik_status_izin where id_izin=:id";
         $this->db->query($sql);
         $this->db->bind('id', $data['id_izin']);
         $this->db->bind('status_izin', $data['status_izin']);
         $this->db->bind('nik_status_izin', $_SESSION['nik']);
         $this->db->execute();
         $id_terakhir = $this->db->lastInsertId();
         if ($data['status_izin'] == 'Disetujui') {
            $tgl_m = $data['mulai_izin'];
            $tgl_a = $data['sampai_izin'];
            $tgl1 = new DateTime("$tgl_m");
            $tgl2 = new DateTime("$tgl_a");
            $jumlahhari = $tgl2->diff($tgl1)->days + 1;

            for ($x = 0; $x < $jumlahhari; $x++) {
               $tanggallibur = date('Y-m-d', strtotime($tgl1->format('Y-m-d') . ' + ' . $x . ' days'));

               $dayOfWeek = date('N', strtotime($tanggallibur));
               if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                  continue;
               }

               $sql = "INSERT INTO absen_harian_siswa (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs, id_libur, kelas_ahs, wali_kelas_ahs, id_jadwal_setting_ahs) values (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs, :id_libur, :kelas_ahs, :wali_kelas_ahs, :id_jadwal_setting_ahs)";
               $this->db->query($sql);
               $this->db->bind('nis_ahs', $data['nis']);
               $this->db->bind('tgl_ahs', $tanggallibur);
               $this->db->bind('status_ahs', 'Izin');
               $this->db->bind('jam_masuk_ahs', '07:30:00');
               $this->db->bind('id_libur', $id_terakhir);
               $this->db->bind('kelas_ahs', $data['kelas']);
               $this->db->bind('wali_kelas_ahs', $data['wali_kelas']);
               $this->db->bind('id_jadwal_setting_ahs', $data['semester_aktif']);
               $this->db->execute();
            }
         }
         return true;
      }
   }

   public function ambil_kelas($nik)
   {
      $sql = "SELECT kode_kelas from jadwal_lengkap where wali_kelas=:wali_kelas";
      $this->db->query($sql);
      $this->db->bind('wali_kelas', $nik);
      return $this->db->single();
   }

   public function rekap_presensi($nis, $mulai = null, $sampai = null)
   {
      $sql = "SELECT nis_aks,
      SUM(CASE WHEN absen_jam1 = 'A' THEN 1 ELSE 0 END + 
      CASE WHEN absen_jam2 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam3 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam4 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam5 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam6 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam7 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam8 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam9 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam10 = 'A' THEN 1 ELSE 0 END) AS alpa,
      SUM(CASE WHEN absen_jam1 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam2 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam3 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam4 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam5 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam6 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam7 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam8 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam9 = 'I' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam10 = 'I' THEN 1 ELSE 0 END) AS izin,
      SUM(CASE WHEN absen_jam1 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam2 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam3 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam4 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam5 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam6 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam7 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam8 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam9 = 'S' THEN 1 ELSE 0 END +
      CASE WHEN absen_jam10 = 'S' THEN 1 ELSE 0 END) AS sakit 
      FROM absen_kelas_siswa 
      WHERE nis_aks =:nis and tgl_aks >= :mulai and tgl_aks <= :sampai
      GROUP BY nis_aks;";
      $this->db->query($sql);
      $this->db->bind('nis', $nis);
      $this->db->bind('mulai', $mulai);
      $this->db->bind('sampai', $sampai);
      return $this->db->single();
   }

   public function alpa_terbanyak($mulai = null, $sampai = null)
   {
      $sql = "SELECT absen_kelas_siswa.nis_aks, siswa.nama_siswa, absen_kelas_siswa.kelas_aks,
      SUM(CASE WHEN absen_kelas_siswa.absen_jam1 = 'A' THEN 1 ELSE 0 END + 
      CASE WHEN absen_kelas_siswa.absen_jam2 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam3 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam4 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam5 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam6 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam7 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam8 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam9 = 'A' THEN 1 ELSE 0 END +
      CASE WHEN absen_kelas_siswa.absen_jam10 = 'A' THEN 1 ELSE 0 END) AS alpa
      FROM absen_kelas_siswa 
      LEFT JOIN siswa on absen_kelas_siswa.nis_aks = siswa.nis
      WHERE tgl_aks >= :mulai and tgl_aks <= :sampai
      GROUP BY nis_aks
      ORDER BY alpa desc
      LIMIT 10;";
      $this->db->query($sql);
      $this->db->bind('mulai', $mulai);
      $this->db->bind('sampai', $sampai);
      return $this->db->resultSet();
   }

   public function izin_terbanyak($mulai = null, $sampai = null)
   {
      $sql = "SELECT absen_kelas_siswa.nis_aks, siswa.nama_siswa, absen_kelas_siswa.kelas_aks,
   SUM(CASE WHEN absen_kelas_siswa.absen_jam1 = 'I' THEN 1 ELSE 0 END + 
   CASE WHEN absen_kelas_siswa.absen_jam2 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam3 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam4 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam5 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam6 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam7 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam8 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam9 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam10 = 'I' THEN 1 ELSE 0 END) AS izin, 
   SUM(CASE WHEN absen_kelas_siswa.absen_jam1 = 'S' THEN 1 ELSE 0 END + 
   CASE WHEN absen_kelas_siswa.absen_jam2 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam3 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam4 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam5 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam6 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam7 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam8 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam9 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam10 = 'S' THEN 1 ELSE 0 END) AS sakit,
   (SUM(CASE WHEN absen_kelas_siswa.absen_jam1 = 'I' THEN 1 ELSE 0 END + 
   CASE WHEN absen_kelas_siswa.absen_jam2 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam3 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam4 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam5 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam6 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam7 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam8 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam9 = 'I' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam10 = 'I' THEN 1 ELSE 0 END) + 
   SUM(CASE WHEN absen_kelas_siswa.absen_jam1 = 'S' THEN 1 ELSE 0 END + 
   CASE WHEN absen_kelas_siswa.absen_jam2 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam3 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam4 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam5 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam6 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam7 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam8 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam9 = 'S' THEN 1 ELSE 0 END +
   CASE WHEN absen_kelas_siswa.absen_jam10 = 'S' THEN 1 ELSE 0 END)) AS total_izin
   FROM absen_kelas_siswa 
   LEFT JOIN siswa on absen_kelas_siswa.nis_aks = siswa.nis
   WHERE tgl_aks >= :mulai AND tgl_aks <= :sampai
   GROUP BY nis_aks
   ORDER BY total_izin DESC
   LIMIT 10;";
      $this->db->query($sql);
      $this->db->bind('mulai', $mulai);
      $this->db->bind('sampai', $sampai);
      return $this->db->resultSet();
   }


   public function izin_today()
   {
      $sql = "SELECT * from izin_siswa where status_izin=:status_izin and CURDATE() BETWEEN mulai_izin AND sampai_izin order by kelas_izin ";
      $this->db->query($sql);
      $this->db->bind('status_izin', 'Disetujui');
      return $this->db->resultSet();
   }

   public function semester_aktif()
   {
      $sql = "SELECT * from jadwal_setting where status='1'";
      $this->db->query($sql);
      return $this->db->single();
   }

   public function ambil_isi_absen($tanggal, $bulan, $tahun, $nis)
   {
      $sql = "SELECT * from absen_harian_siswa where day(tgl_ahs)=:tanggal and month(tgl_ahs)=:bulan and year(tgl_ahs)=:tahun and nis_ahs=:nis";
      $this->db->query($sql);
      $this->db->bind('tanggal', $tanggal);
      $this->db->bind('bulan', $bulan);
      $this->db->bind('tahun', $tahun);
      $this->db->bind('nis', $nis);
      return $this->db->single();
   }

   public function ambil_siswa_berdasarkan_wali_kelas($nik_wali_kelas) {

      $sql = "SELECT DISTINCT
      siswa.nis,
      siswa.nama_siswa,
      siswa.kelas_siswa,
      siswa.ruang_siswa,
      jadwal_lengkap.wali_kelas,
      nilai_siswa.nilai_tugas,
      nilai_siswa.nilai_uts,
      nilai_siswa.nilai_uas,
      nilai_siswa.nilai_akhir
      FROM siswa
      JOIN jadwal_lengkap 
         ON siswa.kelas_siswa = jadwal_lengkap.kode_kelas
      LEFT JOIN nilai_siswa 
         ON nilai_siswa.nis = siswa.nis 
         AND nilai_siswa.nik_wali_kelas = jadwal_lengkap.wali_kelas
      WHERE jadwal_lengkap.wali_kelas = :nik_wali_kelas
      AND siswa.status_siswa = 'Aktif'
      AND jadwal_lengkap.validasi = 1
      GROUP BY siswa.nis
      ORDER BY siswa.nama_siswa;";


      $this->db->query($sql);
      $this->db->bind('nik_wali_kelas', $nik_wali_kelas);

      return $this->db->resultSet();
   
   }
}