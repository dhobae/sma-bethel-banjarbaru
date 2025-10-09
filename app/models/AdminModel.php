<?php

class AdminModel
{
   private $table = 'admin';
   private $db;

   public function __construct()
   {
      $this->db = new Database;
   }


   public function get()
   {
      $query = "SELECT * FROM " . $this->table;
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function get_pegawai()
   {
      $query = "SELECT * FROM users LEFT join pegawai on users.nik_user=pegawai.nik WHERE users.role=:role and absen='Aktif' order by nama";
      $this->db->query($query);
      $this->db->bind('role', "PEGAWAI");

      return $this->db->resultSet();
   }

   public function getAllNIP($nip_pegawai)
   {
      $array = explode(',', $nip_pegawai);
      $array = implode("','", $array);
      $query = "SELECT * FROM pegawai WHERE nik IN ('" . $array . "')";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function getById($id)
   {
      $query = "SELECT * FROM " . $this->table . " WHERE id=:id";
      $this->db->query($query);
      $this->db->bind('id', $id);
      return $this->db->single();
   }


   //-- ADMIN KURIKULUM ------------------
   public function get_kurikulum()
   {
      $query = "SELECT * FROM admin where hak_akses=:hak_akses";
      $this->db->query($query);
      $this->db->bind('hak_akses', 'kurikulum');
      return $this->db->resultSet();
   }


   //-- ADMIN DAR ------------------
   public function get_dar()
   {
      $query = "SELECT * FROM admin where hak_akses=:hak_akses";
      $this->db->query($query);
      $this->db->bind('hak_akses', 'dar');
      return $this->db->resultSet();
   }















   public function getPegawai($hak_akses)
   {
      $query = "SELECT * FROM " . $this->table . " WHERE hak_akses=:hak_akses";
      $this->db->query($query);
      $this->db->bind('hak_akses', $hak_akses);
      $admin = $this->db->single();

      $array = explode(',', $admin->nip_pegawai);
      $nip_pegawai = implode("','", $array);
      $query = "SELECT * FROM users WHERE nip IN ('" . $nip_pegawai . "')";
      $this->db->query($query);

      return $this->db->resultSet();
   }

   public function cekAkses($hak_akses)
   {
      $query = "SELECT * FROM " . $this->table . " WHERE hak_akses=:hak_akses";
      $this->db->query($query);
      $this->db->bind('hak_akses', $hak_akses);
      $jabatan = $this->db->single();

      $nip_pegawai = explode(',', $jabatan->nip_pegawai);
      if (in_array($_SESSION['nik'], $nip_pegawai, TRUE)) {
         return 1;
      }
      return 0;
   }

   public function update($data)
   {
      $pegawai = implode(',', $data['pegawai']);
      $query = "UPDATE " . $this->table . " SET nip_pegawai=:nip_pegawai WHERE id=:id";
      $this->db->query($query);
      $this->db->bind('id', $data['id']);
      $this->db->bind('nip_pegawai', $pegawai);
      $this->db->execute();

      return $this->db->rowCount();
   }
}
