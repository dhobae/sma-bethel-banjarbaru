<?php
class Mrekap
{
   public function __construct()
   {
      $this->db = new Database;
   }

   public function rekap()
   {
      if (($_SESSION['role'] == 'pegawai') || ($_SESSION['role'] == 'satpam')) {
         $sql = "SELECT * from absen where nik=:nik order by tanggal";
         $this->db->query($sql);
         $this->db->bind('nik', $_SESSION['username']);
         return $this->db->resultSet();
      } else {
         $id = $_SESSION['username'];
         $sql = "SELECT * from pegawai where nik=:npk";
         $this->db->query($sql);
         $this->db->bind('npk', $_SESSION['username']);
         return $this->db->resultSet();
      }
   }

   public function rekap_byid_tanggal($nik, $tanggal)
   {
      if ($_SESSION['role'] == 'pegawai') {
         $query2 = "SELECT absen.*, absen.id as id_absen, libur.* from absen left join libur ON absen.from_masuk=libur.id where absen.nik in(:nik,'all') and absen.tanggal=:tanggal";
         $this->db->query($query2);
         $this->db->bind('nik', $nik);
         $this->db->bind('tanggal', $tanggal);
         return $this->db->resultSet();
      } else {
         $query2 = "SELECT absen.*, absen.id as id_absen, libur.* from absen left join libur ON absen.from_masuk=libur.id where absen.nik in(:nik,'all') and absen.tanggal=:tanggal";
         $this->db->query($query2);
         $this->db->bind('nik', $nik);
         $this->db->bind('tanggal', $tanggal);
         return $this->db->resultSet();
      }
   }

   public function jam_kerja()
   {
      $libur_all = "SELECT * from master_jam limit 1";
      $this->db->query($libur_all);
      return $this->db->single();
   }

   public function jam_kerja_bydate($month, $year)
   {
      $tanggal_absen = $year . '-' . $month . '-01';
      $libur_all = "SELECT * FROM master_jam WHERE berlaku_mulai <= :tanggal_absen ORDER BY berlaku_mulai DESC LIMIT 1";
      $this->db->query($libur_all);
      $this->db->bind('tanggal_absen', $tanggal_absen);
      return $this->db->single();
   }

   //public function jam_libur()
   //{
   //   $libur_all = "SELECT * from master_jam limit 1";
   //   $this->db->query($libur_all);
   //   return $this->db->single();
   //}

   public function rekap_bulanan($nik, $tanggal)
   {
      $query2 = "SELECT absen.*, libur.* from absen left join libur ON absen.from_masuk=libur.id where absen.nik in(:username,'all') and absen.tanggal=:tanggal";
      $this->db->query($query2);
      $this->db->bind('username', $nik);
      $this->db->bind('tanggal', $tanggal);
      return $this->db->resultSet();
   }

   public function ambil_nama()
   {
      $id = $_GET['data'];
      $sql = "SELECT * from pegawai where nik=:npk";
      $this->db->query($sql);
      $this->db->bind('npk', $id);
      return $this->db->single();
   }

   public function ambil_role()
   {
      $id = $_GET['data'];
      $sql = "SELECT * from users where nik_user=:npk";
      $this->db->query($sql);
      $this->db->bind('npk', $id);
      return $this->db->single();
   }

   public function rekap_id_tanggal($tanggal)
   {
      $id = $_GET['data'];
      $query2 = "SELECT absen.*, libur.* from absen left join libur ON absen.from_masuk=libur.id where absen.nik in(:id,'all') and absen.tanggal=:tanggal";
      $this->db->query($query2);
      $this->db->bind('id', $id);
      $this->db->bind('tanggal', $tanggal);
      return $this->db->resultSet();
   }

   public function reset_jam()
   {
      $id = $_GET['id'];
      $tanggal = $_GET['tgl'];
      $status = $_GET['status'];
      if ($status == 'datang') {
         $sql = "DELETE from absen where nik=:nik and tanggal=:tanggal";
         $this->db->query($sql);
         $this->db->bind('nik', $id);
         $this->db->bind('tanggal', $tanggal);
         $this->db->execute();
      } else {
         $sql = "UPDATE absen set jam_pulang=:jam_pulang, status_pulang=:status_pulang, from_pulang=:from_pulang where nik=:nik and tanggal=:tanggal";
         $this->db->query($sql);
         $this->db->bind('jam_pulang', '00:00:00');
         $this->db->bind('status_pulang', '-');
         $this->db->bind('from_pulang', '-');
         $this->db->bind('nik', $id);
         $this->db->bind('tanggal', $tanggal);
         $this->db->execute();
      }
      return true;
   }
}
