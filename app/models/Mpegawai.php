<?php
class Mpegawai
{
   public function __construct()
   {
      $this->db = new Database;
   }

   public function pegawai()
   {
      $sql = "SELECT * from pegawai where absen=:absen order by nama";
      $this->db->query($sql);
      $this->db->bind('absen', 'Aktif');
      return $this->db->resultSet();
   }

   public function pegawai_bystatus($status)
   {
      $sql = "SELECT * from pegawai where absen=:absen and hapus_pegawai=:hapus_pegawai order by nama";
      $this->db->query($sql);
      $this->db->bind('absen', $status);
      $this->db->bind('hapus_pegawai', '0');
      return $this->db->resultSet();
   }

   public function pegawai_byid($id)
   {
      $sql = "SELECT * from pegawai where id_pegawai=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function saya()
   {
      $saya = $_SESSION['nik'];
      $sql = "SELECT * from pegawai where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $saya);
      return $this->db->single();
   }


   public function cek_nik($nik)
   {
      $sql = "SELECT * from pegawai where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function cek_username($username)
   {
      $sql = "SELECT * from users where username=:username";
      $this->db->query($sql);
      $this->db->bind('username', $username);
      return $this->db->single();
   }

   public function simpan($data, $files)
   {
      $sql = "INSERT into pegawai (id_pegawai, nik, username, nama, kode, jabatan, full_time, jk, agama, nomor_hp, notif_wa, tempat_lahir, tgl_lahir, alamat, pendidikan, email, absen, mengajar) values (:id_pegawai, :nik, :username, :nama, :kode, :jabatan, :full_time, :jk, :agama, :nomor_hp, :notif_wa, :tempat_lahir, :tgl_lahir, :alamat, :pendidikan, :email, :absen, :mengajar)";
      $this->db->query($sql);
      $this->db->bind('id_pegawai', NULL);
      $this->db->bind('nik', $data['nik']);
      $this->db->bind('username', $data['nik']);
      $this->db->bind('nama', $data['nama']);
      $this->db->bind('kode', $data['kode']);
      $this->db->bind('jabatan', $data['jabatan']);
      $this->db->bind('full_time', $data['full_time']);
      $this->db->bind('jk', $data['jk']);
      $this->db->bind('mengajar', $data['mengajar']);
      $this->db->bind('agama', $data['agama']);
      $this->db->bind('nomor_hp', $data['nomor_hp']);
      $this->db->bind('notif_wa', $data['notif_wa']);
      $this->db->bind('tempat_lahir', $data['tempat_lahir']);
      $this->db->bind('tgl_lahir', $data['tgl_lahir']);
      $this->db->bind('alamat', $data['alamat']);
      $this->db->bind('pendidikan', $data['pendidikan']);
      $this->db->bind('email', $data['email']);
      $this->db->bind('absen', $data['absen']);
      $this->db->execute();

      $sql2 = "INSERT INTO users (id_user, nik_user, username, nama_user, password, role) values (:id_user, :nik_user, :username, :nama_user, :password, :role)";
      $this->db->query($sql2);
      $this->db->bind('id_user', NULL);
      $this->db->bind('nik_user', $data['nik']);
      $this->db->bind('username', $data['nik']);
      $this->db->bind('nama_user', $data['nama']);
      $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
      $this->db->bind('role', 'pegawai');
      $this->db->execute();

      $sql3 = "INSERT INTO send_wa (id_send_wa, nik_send_wa, absen_datang, absen_pulang, notif_datang, notif_pulang) values (:id_send_wa, :nik_send_wa, :absen_datang, :absen_pulang, :notif_datang, :notif_pulang)";
      $this->db->query($sql3);
      $this->db->bind('id_send_wa', NULL);
      $this->db->bind('nik_send_wa', $data['nik']);
      $this->db->bind('absen_datang', '0');
      $this->db->bind('absen_pulang', '0');
      $this->db->bind('notif_datang', '0');
      $this->db->bind('notif_pulang', '0');
      $this->db->execute();

      $newAvatarName = $_SESSION['avatar'];
      if ($files['avatar']['size'] > 0) {
         $file_extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
         $allowed_extension = array(
            "png",
            "jpg",
            "jpeg"
         );

         if (!in_array($file_extension, $allowed_extension)) {
            echo "tes";
         }

         if ($_SESSION['role'] == 'admin') {
            $newAvatarName = $data['nik'] . '.' . $file_extension;
         } else {
            $newAvatarName = $_SESSION['nik'] . '.' . $file_extension;
         }

         if ($files['avatar']['size'] < 2000 * 1000) {
            if ($_SESSION['avatar'] == NULL) {
               move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
            } else {
               if (unlink("../public/img/avatar/" . $_SESSION['avatar'])) {
                  move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
               } else {
                  move_uploaded_file($files['avatar']['tmp_name'], "../public/skatel/avatar/" . $newAvatarName);
               }
            }
         } else {
            return false;
         }
      }

      $query = "UPDATE pegawai SET avatar=:avatar WHERE nik=:nik";
      $this->db->query($query);
      if ($_SESSION['role'] == 'admin') {
         $this->db->bind(':nik', $data['nik']);
      } else {
         $this->db->bind(':nik', $_SESSION['nik']);
      }
      $this->db->bind(':avatar', $newAvatarName);
      $this->db->execute();


      return true;
   }

   public function simpan_edit($data)
   {
      $sql = "UPDATE pegawai set nik=:nik, username=:username, nama=:nama, kode=:kode, jabatan=:jabatan, full_time=:full_time, jk=:jk, agama=:agama, nomor_hp=:nomor_hp, tempat_lahir=:tempat_lahir, tgl_lahir=:tgl_lahir, alamat=:alamat, pendidikan=:pendidikan, email=:email, absen=:absen, mengajar=:mengajar, notif_wa=:notif_wa where id_pegawai=:id";
      $this->db->query($sql);
      $this->db->bind('id', $data['id_pegawai']);
      $this->db->bind('nik', $data['nik']);
      $this->db->bind('username', $data['username']);
      $this->db->bind('nama', $data['nama']);
      $this->db->bind('kode', $data['kode']);
      $this->db->bind('jabatan', $data['jabatan']);
      $this->db->bind('full_time', $data['full_time']);
      $this->db->bind('jk', $data['jk']);
      $this->db->bind('mengajar', $data['mengajar']);
      $this->db->bind('agama', $data['agama']);
      $this->db->bind('nomor_hp', $data['nomor_hp']);
      $this->db->bind('tempat_lahir', $data['tempat_lahir']);
      $this->db->bind('tgl_lahir', $data['tgl_lahir']);
      $this->db->bind('alamat', $data['alamat']);
      $this->db->bind('pendidikan', $data['pendidikan']);
      $this->db->bind('email', $data['email']);
      $this->db->bind('absen', $data['absen']);
      $this->db->bind('notif_wa', $data['notif_wa']);
      $this->db->execute();

      //$password = MD5($data['password']);
      if ($data['password']) {
         $sql2 = "UPDATE users set password=:password where nik_user=:nik_user";
         $this->db->query($sql2);
         $this->db->bind('nik_user', $data['nik_lama']);
         $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
         $this->db->execute();
      }

      $sql2 = "UPDATE users set nik_user=:nik_user, username=:username, nama_user=:nama_user where nik_user=:nik_lama";
      $this->db->query($sql2);
      $this->db->bind('nik_lama', $data['nik_lama']);
      $this->db->bind('nik_user', $data['nik']);
      $this->db->bind('username', $data['username']);
      $this->db->bind('nama_user', $data['nama']);
      $this->db->execute();

      return true;
   }

   public function master_jam_all()
   {
      $sql = "SELECT * from master_jam order by berlaku_mulai DESC";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function master_jam()
   {
      $sql = "SELECT * from master_jam limit 1";
      $this->db->query($sql);
      return $this->db->single();
   }

   public function master_jam_byid($id)
   {
      if ($id == 'kosong') {
         $sql = "SELECT * from master_jam order by berlaku_mulai DESC limit 1";
         $this->db->query($sql);
      } else {
         $sql = "SELECT * from master_jam WHERE id=:id";
         $this->db->query($sql);
         $this->db->bind('id', $id);
      }
      return $this->db->single();
   }

   public function simpan_jam($data)
   {
      $cari = "SELECT * from master_jam where id=:id";
      $this->db->query($cari);
      $this->db->bind('id', $data['id']);
      $cari1 = $this->db->single();
      if ($cari1) {
         $sql = "UPDATE master_jam set hari_kerja=:hari_kerja, berlaku_mulai=:berlaku_mulai, jam_kerja=:jam_kerja, masuk=:masuk, pulang=:pulang, wfh_masuk=:wfh_masuk, wfh_pulang=:wfh_pulang, jam_istirahat=:jam_istirahat, masuk_jumat=:masuk_jumat, pulang_jumat=:pulang_jumat, masuk_jumat_wfh=:masuk_jumat_wfh, pulang_jumat_wfh=:pulang_jumat_wfh, jam_kerja_jumat=:jam_kerja_jumat, jam_istirahat_jumat=:jam_istirahat_jumat  where id=:id";
      } else {
         $sql = "INSERT INTO master_jam (berlaku_mulai, hari_kerja, jam_kerja, masuk, pulang, wfh_masuk, wfh_pulang, jam_istirahat, masuk_jumat, pulang_jumat, masuk_jumat_wfh, pulang_jumat_wfh, jam_kerja_jumat, jam_istirahat_jumat) values (:berlaku_mulai, :hari_kerja, :jam_kerja, :masuk, :pulang, :wfh_masuk, :wfh_pulang, :jam_istirahat, :masuk_jumat, :pulang_jumat, :masuk_jumat_wfh, :pulang_jumat_wfh, :jam_kerja_jumat, :jam_istirahat_jumat)";
      }

      $this->db->query($sql);
      if ($cari1) {
         $this->db->bind('id', $data['id']);
      }
      $this->db->bind('hari_kerja', $data['hari_kerja']);
      $this->db->bind('berlaku_mulai', $data['berlaku_mulai']);
      $this->db->bind('jam_kerja', $data['jam_kerja']);
      $this->db->bind('masuk', $data['masuk']);
      $this->db->bind('pulang', $data['pulang']);
      $this->db->bind('wfh_masuk', $data['wfh_masuk']);
      $this->db->bind('wfh_pulang', $data['wfh_pulang']);
      $this->db->bind('masuk_jumat', $data['masuk_jumat']);
      $this->db->bind('pulang_jumat', $data['pulang_jumat']);
      $this->db->bind('masuk_jumat_wfh', $data['masuk_jumat_wfh']);
      $this->db->bind('pulang_jumat_wfh', $data['pulang_jumat_wfh']);
      $this->db->bind('jam_kerja_jumat', $data['jam_kerja_jumat']);
      $this->db->bind('jam_istirahat', $data['jam_istirahat']);
      $this->db->bind('jam_istirahat_jumat', $data['jam_istirahat_jumat']);
      $this->db->execute();
      return true;
   }

   //------------------------------------
   public function ip_address()
   {
      $sql = "SELECT * from ip_address";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function simpan_ip_address($data)
   {
      $sql = "INSERT INTO ip_address (id, ip_address, keterangan) values (:id, :ip_address, :keterangan)";
      $this->db->query($sql);
      $this->db->bind('id', NULL);
      $this->db->bind('ip_address', $data['ip_address']);
      $this->db->bind('keterangan', $data['keterangan']);
      $this->db->execute();
      return true;
   }

   public function edit_ip_address($data)
   {
      $sql = "UPDATE ip_address set ip_address=:ip_address, keterangan=:keterangan where id=:id";
      $this->db->query($sql);
      $this->db->bind('id', $data['id']);
      $this->db->bind('ip_address', $data['ip_address']);
      $this->db->bind('keterangan', $data['keterangan']);
      $this->db->execute();
      return true;
   }

   public function hapus_ip_address($id)
   {
      $sql = "DELETE from ip_address where id=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      $this->db->execute();
      return true;
   }

   //--- KHUSUS ------------------------------
   public function simpan_foto($data, $files)
   {
      $newAvatarName = $_SESSION['avatar'];
      if ($files['avatar']['size'] > 0) {
         $file_extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
         $allowed_extension = array(
            "png",
            "jpg",
            "jpeg"
         );

         if (!in_array($file_extension, $allowed_extension)) {
            echo "tes";
         }

         if ($_SESSION['role'] == 'admin') {
            $newAvatarName = $data['nik'] . '.' . $file_extension;
         } else {
            $newAvatarName = $_SESSION['nik'] . '.' . $file_extension;
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
      }

      $query = "UPDATE pegawai SET avatar=:avatar WHERE nik=:nik";
      $this->db->query($query);
      if ($_SESSION['role'] == 'admin') {
         $this->db->bind(':nik', $data['nik']);
      } else {
         $this->db->bind(':nik', $_SESSION['nik']);
      }
      $this->db->bind(':avatar', $newAvatarName);
      $this->db->execute();
      return true;
   }

   public function simpan_nomor_hp($data)
   {
      $sql = "UPDATE pegawai set nomor_hp=:nomor_hp where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $data['nik']);
      $this->db->bind('nomor_hp', $data['nomor_hp']);
      $this->db->execute();
      return true;
   }

   public function hapus($id)
   {
      $sql = "UPDATE pegawai set hapus_pegawai=:hapus_pegawai where id_pegawai=:id";
      $this->db->query($sql);
      $this->db->bind('hapus_pegawai', '1');
      $this->db->bind('id', $id);
      $this->db->execute();
      return true;
   }

   //--SEND WA --------------------
   public function send_wa()
   {
      $sql = "SELECT * from send_wa left join pegawai on send_wa.nik_send_wa=pegawai.nik where absen='aktif' order by pegawai.nama";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function send_wa_bynik($nik)
   {
      $sql = "SELECT * from send_wa left join pegawai on send_wa.nik_send_wa=pegawai.nik where nik_send_wa=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function simpan_send_wa($data)
   {
      $sql = "UPDATE send_wa set absen_datang=:absen_datang, absen_pulang=:absen_pulang, notif_datang=:notif_datang, notif_pulang=:notif_pulang where nik_send_wa=:nik";
      $this->db->query($sql);
      $this->db->bind('absen_datang', $data['absen_datang']);
      $this->db->bind('absen_pulang', $data['absen_pulang']);
      $this->db->bind('notif_datang', $data['notif_datang']);
      $this->db->bind('notif_pulang', $data['notif_pulang']);
      $this->db->bind('nik', $_SESSION['nik']);
      $this->db->execute();
      return true;
   }

   public function edit_send_wa($id)
   {
      $sql = "SELECT * from send_wa left join pegawai on send_wa.nik_send_wa=pegawai.nik where id_send_wa=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function simpan_edit_send_wa($data)
   {
      $sql = "UPDATE send_wa set absen_datang=:absen_datang, absen_pulang=:absen_pulang, notif_datang=:notif_datang, notif_pulang=:notif_pulang where id_send_wa=:id";
      $this->db->query($sql);
      $this->db->bind('absen_datang', $data['absen_datang']);
      $this->db->bind('absen_pulang', $data['absen_pulang']);
      $this->db->bind('notif_datang', $data['notif_datang']);
      $this->db->bind('notif_pulang', $data['notif_pulang']);
      $this->db->bind('id', $data['id_send_wa']);
      $this->db->execute();
      return true;
   }

   public function kunci($id)
   {
      $sql = "UPDATE pegawai set kunci=:kunci where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('kunci', '1');
      $this->db->bind('nik', $id);
      $this->db->execute();
      return true;
   }

   public function bukakunci($id)
   {
      $sql = "UPDATE pegawai set kunci=:kunci where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('kunci', NULL);
      $this->db->bind('nik', $id);
      $this->db->execute();
      return true;
   }
}
