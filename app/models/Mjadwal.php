<?php
class Mjadwal
{
   public function __construct()
   {
      $this->db = new Database;
   }

   public function jadwal()
   {
      $sql = "SELECT * from pegawai where absen=:absen order by nama";
      $this->db->query($sql);
      $this->db->bind('absen', 'Aktif');
      return $this->db->resultSet();
   }

   public function jadwal_kelas($kelas)
   {
      $sql = "select jadwal_lengkap.*,
      pegawai1.nama as nama1,
      pegawai2.nama as nama2,
      pegawai3.nama as nama3,
      pegawai4.nama as nama4,
      pegawai5.nama as nama5,
      pegawai6.nama as nama6,
      pegawai7.nama as nama7,
      pegawai8.nama as nama8,
      pegawai9.nama as nama9,
      pegawai10.nama as nama10,
      pegawai11.nama as nama11,
      m_pelajaran1.mata_pelajaran as mata_pelajaran1, m_pelajaran1.singkatan as singkatan1,
      m_pelajaran2.mata_pelajaran as mata_pelajaran2, m_pelajaran2.singkatan as singkatan2,
      m_pelajaran3.mata_pelajaran as mata_pelajaran3, m_pelajaran3.singkatan as singkatan3,
      m_pelajaran4.mata_pelajaran as mata_pelajaran4, m_pelajaran4.singkatan as singkatan4,
      m_pelajaran5.mata_pelajaran as mata_pelajaran5, m_pelajaran5.singkatan as singkatan5,
      m_pelajaran6.mata_pelajaran as mata_pelajaran6, m_pelajaran6.singkatan as singkatan6,
      m_pelajaran7.mata_pelajaran as mata_pelajaran7, m_pelajaran7.singkatan as singkatan7,
      m_pelajaran8.mata_pelajaran as mata_pelajaran8, m_pelajaran8.singkatan as singkatan8,
      m_pelajaran9.mata_pelajaran as mata_pelajaran9, m_pelajaran9.singkatan as singkatan9,
      m_pelajaran10.mata_pelajaran as mata_pelajaran10, m_pelajaran10.singkatan as singkatan10,
      m_pelajaran11.mata_pelajaran as mata_pelajaran11, m_pelajaran11.singkatan as singkatan11
      from jadwal_lengkap 
      left join pegawai as pegawai1 on jadwal_lengkap.guru1 = pegawai1.nik
      left join pegawai as pegawai2 on jadwal_lengkap.guru2 = pegawai2.nik
      left join pegawai as pegawai3 on jadwal_lengkap.guru3 = pegawai3.nik
      left join pegawai as pegawai4 on jadwal_lengkap.guru4 = pegawai4.nik
      left join pegawai as pegawai5 on jadwal_lengkap.guru5 = pegawai5.nik
      left join pegawai as pegawai6 on jadwal_lengkap.guru6 = pegawai6.nik
      left join pegawai as pegawai7 on jadwal_lengkap.guru7 = pegawai7.nik
      left join pegawai as pegawai8 on jadwal_lengkap.guru8 = pegawai8.nik
      left join pegawai as pegawai9 on jadwal_lengkap.guru9 = pegawai9.nik
      left join pegawai as pegawai10 on jadwal_lengkap.guru10 = pegawai10.nik
      left join pegawai as pegawai11 on jadwal_lengkap.guru11 = pegawai11.nik
      left join m_pelajaran as m_pelajaran1 on jadwal_lengkap.mp1 = m_pelajaran1.id_pelajaran
      left join m_pelajaran as m_pelajaran2 on jadwal_lengkap.mp2 = m_pelajaran2.id_pelajaran
      left join m_pelajaran as m_pelajaran3 on jadwal_lengkap.mp3 = m_pelajaran3.id_pelajaran
      left join m_pelajaran as m_pelajaran4 on jadwal_lengkap.mp4 = m_pelajaran4.id_pelajaran
      left join m_pelajaran as m_pelajaran5 on jadwal_lengkap.mp5 = m_pelajaran5.id_pelajaran
      left join m_pelajaran as m_pelajaran6 on jadwal_lengkap.mp6 = m_pelajaran6.id_pelajaran
      left join m_pelajaran as m_pelajaran7 on jadwal_lengkap.mp7 = m_pelajaran7.id_pelajaran
      left join m_pelajaran as m_pelajaran8 on jadwal_lengkap.mp8 = m_pelajaran8.id_pelajaran
      left join m_pelajaran as m_pelajaran9 on jadwal_lengkap.mp9 = m_pelajaran9.id_pelajaran
      left join m_pelajaran as m_pelajaran10 on jadwal_lengkap.mp10 = m_pelajaran10.id_pelajaran 
      left join m_pelajaran as m_pelajaran11 on jadwal_lengkap.mp11 = m_pelajaran11.id_pelajaran 
      where kode_kelas=:kode_kelas order by id_jadwal_lengkap";
      $this->db->query($sql);
      $this->db->bind('kode_kelas', $kelas);
      return $this->db->resultSet();
   }

   public function wali_kelas($kelas)
   {
      $query = "SELECT jadwal_lengkap.id_jadwal_lengkap, jadwal_lengkap.kode_kelas, jadwal_lengkap.wali_kelas, pegawai.nama, jadwal_lengkap.validasi, validasi_oleh, tanggal_validasi from jadwal_lengkap LEFT JOIN pegawai on jadwal_lengkap.wali_kelas=pegawai.nik where kode_kelas=:kode_kelas";
      $this->db->query($query);
      $this->db->bind('kode_kelas', $kelas);
      return $this->db->single();
   }

   public function hapus_semua_wali_kelas()
   {
      $sql = "UPDATE jadwal_lengkap set wali_kelas=:wali_kelas";
      $this->db->query($sql);
      $this->db->bind('wali_kelas', NULL);
      $this->db->execute();
      return true;
   }

   public function edit_jadwal_kelas($id)
   {
      $sql = "SELECT * from jadwal_lengkap where id_jadwal_lengkap=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function pelajaran()
   {
      $sql = "SELECT * from m_pelajaran order by mata_pelajaran";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function prodi()
   {
      $sql = "SELECT m_prodi.*, pegawai.nama from m_prodi left join pegawai on m_prodi.ketua_prodi=pegawai.nik where status_prodi=:status_prodi order by kode_prodi";
      $this->db->query($sql);
      $this->db->bind('status_prodi', 'Aktif');
      return $this->db->resultSet();
   }

   public function prodi_all()
   {
      $sql = "SELECT m_prodi.*, pegawai.nama from m_prodi left join pegawai on m_prodi.ketua_prodi=pegawai.nik order by kode_prodi";
      $this->db->query($sql);
      $this->db->bind('status_prodi', 'Aktif');
      return $this->db->resultSet();
   }

   public function guru()
   {
      $sql = "SELECT * from pegawai where mengajar='Ya' order by nama";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function simpan_edit_jadwal($data)
   {
      $sql = "UPDATE jadwal_lengkap set mp1=:mp1, guru1=:guru1, mp2=:mp2, guru2=:guru2, mp3=:mp3, guru3=:guru3, mp4=:mp4, guru4=:guru4, mp5=:mp5, guru5=:guru5, mp6=:mp6, guru6=:guru6, mp7=:mp7, guru7=:guru7, mp8=:mp8, guru8=:guru8, mp9=:mp9, guru9=:guru9, mp10=:mp10, guru10=:guru10, mp11=:mp11, guru11=:guru11 where id_jadwal_lengkap=:id";
      $this->db->query($sql);
      $this->db->bind('id', $data['id_jadwal_lengkap']);
      for ($i = 1; $i <= 11; $i++) {

         if ($data['guru' . $i]) {
            $guru[$i] = implode(',', $data['guru' . $i]);
         }

         $this->db->bind('mp' . $i, $data['mp' . $i]);
         $this->db->bind('guru' . $i, $guru[$i]);
      }
      $this->db->execute();

      $sql2 = "UPDATE jadwal_lengkap set validasi=:validasi where kode_kelas=:kode_kelas";
      $this->db->query($sql2);
      $this->db->bind('validasi', '0');
      $this->db->bind('kode_kelas', $data['kelasnya']);
      $this->db->execute();
      return true;
   }

   public function simpan_wali_kelas($data)
   {
      $sql = "UPDATE jadwal_lengkap set wali_kelas=:wali_kelas where id_jadwal_lengkap=:id";
      $this->db->query($sql);
      $this->db->bind('id', $data['id_jadwal_lengkap']);
      $this->db->bind('wali_kelas', $data['wali_kelas']);
      $this->db->execute();
      return true;
   }

   public function validasi_jadwal($kode_kelas)
   {
      $query = "UPDATE jadwal_lengkap set validasi=:validasi, validasi_oleh=:validasi_oleh, tanggal_validasi=:tanggal_validasi where kode_kelas=:id";
      $this->db->query($query);
      $this->db->bind('validasi', '1');
      $this->db->bind('validasi_oleh', $_SESSION['nik']);
      $this->db->bind('tanggal_validasi', date('Y-m-d'));
      $this->db->bind('id', $kode_kelas);
      $this->db->execute();
      return true;
   }

   public function kosongkan_jadwal($kode_kelas)
   {
      $sql = "UPDATE jadwal_lengkap set mp1=:mp1, guru1=:guru1, mp2=:mp2, guru2=:guru2, mp3=:mp3, guru3=:guru3, mp4=:mp4, guru4=:guru4, mp5=:mp5, guru5=:guru5, mp6=:mp6, guru6=:guru6, mp7=:mp7, guru7=:guru7, mp8=:mp8, guru8=:guru8, mp9=:mp9, guru9=:guru9, mp10=:mp10, guru10=:guru10 where kode_kelas=:kode_kelas";
      $this->db->query($sql);
      $this->db->bind('kode_kelas', $kode_kelas);
      for ($i = 1; $i <= 10; $i++) {
         $this->db->bind('mp' . $i, '-');
         $this->db->bind('guru' . $i, '-');
      }
      $this->db->execute();
      return true;
   }

   public function ambil_nama($nik)
   {
      $query = "SELECT nama, kode from pegawai where nik=:nik";
      $this->db->query($query);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   //--- SIMPAN PELAJARAN --------------------------------- 
   public function simpan_pelajaran($data)
   {
      $query = "INSERT INTO m_pelajaran (id_pelajaran, mata_pelajaran, singkatan, prodi) values (:id_pelajaran, :mata_pelajaran, :singkatan, :prodi)";
      $this->db->query($query);
      $this->db->bind('id_pelajaran', NULL);
      $this->db->bind('mata_pelajaran', $data['mata_pelajaran']);
      $this->db->bind('singkatan', $data['singkatan']);
      $prodi = implode(',', $data['prodi']);
      $this->db->bind('prodi', $prodi);
      $this->db->execute();
      return true;
   }

   public function edit_pelajaran($data)
   {
      $query = "UPDATE m_pelajaran set mata_pelajaran=:mata_pelajaran, singkatan=:singkatan, prodi=:prodi WHERE id_pelajaran=:id";
      $this->db->query($query);
      $this->db->bind('id', $data['id_pelajaran']);
      $this->db->bind('mata_pelajaran', $data['mata_pelajaran']);
      $this->db->bind('singkatan', $data['singkatan']);
      $prodi = implode(',', $data['prodi']);
      $this->db->bind('prodi', $prodi);
      $this->db->execute();
      return true;
   }

   public function hapus_pelajaran($id)
   {
      $sql = "DELETE from m_pelajaran where id_pelajaran=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      $this->db->execute();
      return true;
   }

   //-- ABSEN --------------------------
   public function absen($hari)
   {
      $sql = "SELECT jadwal_lengkap.*,
      pegawai1.nama as nama1, pegawai1.kode as kode_pegawai1,
      pegawai2.nama as nama2, pegawai2.kode as kode_pegawai2,
      pegawai3.nama as nama3, pegawai3.kode as kode_pegawai3,
      pegawai4.nama as nama4, pegawai4.kode as kode_pegawai4,
      pegawai5.nama as nama5, pegawai5.kode as kode_pegawai5,
      pegawai6.nama as nama6, pegawai6.kode as kode_pegawai6,
      pegawai7.nama as nama7, pegawai7.kode as kode_pegawai7,
      pegawai8.nama as nama8, pegawai8.kode as kode_pegawai8,
      pegawai9.nama as nama9, pegawai9.kode as kode_pegawai9,
      pegawai10.nama as nama10,  pegawai10.kode as kode_pegawai10,
      pegawai11.nama as nama11,  pegawai11.kode as kode_pegawai11,
      m_pelajaran1.mata_pelajaran as mata_pelajaran1, m_pelajaran1.singkatan as singkatan1,
      m_pelajaran2.mata_pelajaran as mata_pelajaran2, m_pelajaran2.singkatan as singkatan2,
      m_pelajaran3.mata_pelajaran as mata_pelajaran3, m_pelajaran3.singkatan as singkatan3,
      m_pelajaran4.mata_pelajaran as mata_pelajaran4, m_pelajaran4.singkatan as singkatan4,
      m_pelajaran5.mata_pelajaran as mata_pelajaran5, m_pelajaran5.singkatan as singkatan5,
      m_pelajaran6.mata_pelajaran as mata_pelajaran6, m_pelajaran6.singkatan as singkatan6,
      m_pelajaran7.mata_pelajaran as mata_pelajaran7, m_pelajaran7.singkatan as singkatan7,
      m_pelajaran8.mata_pelajaran as mata_pelajaran8, m_pelajaran8.singkatan as singkatan8,
      m_pelajaran9.mata_pelajaran as mata_pelajaran9, m_pelajaran9.singkatan as singkatan9,
      m_pelajaran10.mata_pelajaran as mata_pelajaran10, m_pelajaran10.singkatan as singkatan10,
      m_pelajaran11.mata_pelajaran as mata_pelajaran11, m_pelajaran11.singkatan as singkatan11,
      m_pelajaran1.id_pelajaran as id_pelajaran1,
      m_pelajaran2.id_pelajaran as id_pelajaran2,
      m_pelajaran3.id_pelajaran as id_pelajaran3,
      m_pelajaran4.id_pelajaran as id_pelajaran4,
      m_pelajaran5.id_pelajaran as id_pelajaran5,
      m_pelajaran6.id_pelajaran as id_pelajaran6,
      m_pelajaran7.id_pelajaran as id_pelajaran7,
      m_pelajaran8.id_pelajaran as id_pelajaran8,
      m_pelajaran9.id_pelajaran as id_pelajaran9,
      m_pelajaran10.id_pelajaran as id_pelajaran10,
      m_pelajaran11.id_pelajaran as id_pelajaran11
      from jadwal_lengkap 
      left join pegawai as pegawai1 on jadwal_lengkap.guru1 = pegawai1.nik
      left join pegawai as pegawai2 on jadwal_lengkap.guru2 = pegawai2.nik
      left join pegawai as pegawai3 on jadwal_lengkap.guru3 = pegawai3.nik
      left join pegawai as pegawai4 on jadwal_lengkap.guru4 = pegawai4.nik
      left join pegawai as pegawai5 on jadwal_lengkap.guru5 = pegawai5.nik
      left join pegawai as pegawai6 on jadwal_lengkap.guru6 = pegawai6.nik
      left join pegawai as pegawai7 on jadwal_lengkap.guru7 = pegawai7.nik
      left join pegawai as pegawai8 on jadwal_lengkap.guru8 = pegawai8.nik
      left join pegawai as pegawai9 on jadwal_lengkap.guru9 = pegawai9.nik
      left join pegawai as pegawai10 on jadwal_lengkap.guru10 = pegawai10.nik
      left join pegawai as pegawai11 on jadwal_lengkap.guru11 = pegawai11.nik
      left join m_pelajaran as m_pelajaran1 on jadwal_lengkap.mp1 = m_pelajaran1.id_pelajaran
      left join m_pelajaran as m_pelajaran2 on jadwal_lengkap.mp2 = m_pelajaran2.id_pelajaran
      left join m_pelajaran as m_pelajaran3 on jadwal_lengkap.mp3 = m_pelajaran3.id_pelajaran
      left join m_pelajaran as m_pelajaran4 on jadwal_lengkap.mp4 = m_pelajaran4.id_pelajaran
      left join m_pelajaran as m_pelajaran5 on jadwal_lengkap.mp5 = m_pelajaran5.id_pelajaran
      left join m_pelajaran as m_pelajaran6 on jadwal_lengkap.mp6 = m_pelajaran6.id_pelajaran
      left join m_pelajaran as m_pelajaran7 on jadwal_lengkap.mp7 = m_pelajaran7.id_pelajaran
      left join m_pelajaran as m_pelajaran8 on jadwal_lengkap.mp8 = m_pelajaran8.id_pelajaran
      left join m_pelajaran as m_pelajaran9 on jadwal_lengkap.mp9 = m_pelajaran9.id_pelajaran
      left join m_pelajaran as m_pelajaran10 on jadwal_lengkap.mp10 = m_pelajaran10.id_pelajaran 
      left join m_pelajaran as m_pelajaran11 on jadwal_lengkap.mp11 = m_pelajaran11.id_pelajaran 
      where hari=:hari order by id_jadwal_lengkap";
      $this->db->query($sql);
      $this->db->bind('hari', $hari);
      return $this->db->resultSet();
   }

   public function cek_absen($tgl, $kelas, $ruang, $jam)
   {
      $sql = "SELECT absen_kelas.*, pegawai.nama as nama, pegawai.kode as nama_pendek from absen_kelas left join pegawai on absen_kelas.nik_absen_kelas=pegawai.nik where tgl_absen_kelas=:tgl and kelas_absen_kelas=:kelas and ruang_absen_kelas=:ruang and jam_absen_kelas=:jam";
      $this->db->query($sql);
      $this->db->bind('tgl', $tgl);
      $this->db->bind('kelas', $kelas);
      $this->db->bind('ruang', $ruang);
      $this->db->bind('jam', $jam);
      return $this->db->single();
   }

   public function cek_absen_nama($nik, $tgl, $kelas, $ruang, $jam)
   {
      $sql = "SELECT absen_kelas.*, pegawai.nama as nama, pegawai.kode as nama_pendek from absen_kelas left join pegawai on absen_kelas.nik_absen_kelas=pegawai.nik where tgl_absen_kelas=:tgl and kelas_absen_kelas=:kelas and ruang_absen_kelas=:ruang and jam_absen_kelas=:jam and nik_absen_kelas=:nik";
      $this->db->query($sql);
      $this->db->bind('tgl', $tgl);
      $this->db->bind('kelas', $kelas);
      $this->db->bind('ruang', $ruang);
      $this->db->bind('jam', $jam);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function cek_absen_kelas_saya($tgl, $kelas, $ruang, $jam)
   {
      $sql = "SELECT absen_kelas.*, pegawai.nama as nama, pegawai.kode as nama_pendek from absen_kelas left join pegawai on absen_kelas.nik_absen_kelas=pegawai.nik where tgl_absen_kelas=:tgl and kelas_absen_kelas=:kelas and ruang_absen_kelas=:ruang and jam_absen_kelas=:jam";
      $this->db->query($sql);
      $this->db->bind('tgl', $tgl);
      $this->db->bind('kelas', $kelas);
      $this->db->bind('ruang', $ruang);
      $this->db->bind('jam', $jam);
      return $this->db->single();
   }

   public function wakel()
   {
      $sql = "SELECT jadwal_lengkap.*, pegawai.nama from jadwal_lengkap left join pegawai on jadwal_lengkap.wali_kelas=pegawai.nik group by jadwal_lengkap.kode_kelas order by kode_kelas";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function nama_guru()
   {
      $sql = "SELECT * from pegawai order by nama";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function nama_guru_byid($nik)
   {
      $sql = "SELECT * from pegawai where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function edit_wali_kelas($data)
   {
      $sql = "UPDATE jadwal_lengkap set prodi=:prodi, wali_kelas=:wali_kelas where kode_kelas=:kode_kelas";
      $this->db->query($sql);
      $this->db->bind('prodi', $data['prodi']);
      $this->db->bind('wali_kelas', $data['wali_kelas']);
      $this->db->bind('kode_kelas', $data['kode_kelas']);
      $this->db->execute();
      return true;
   }

   public function guru_aktif($status)
   {
      $sql = "SELECT pegawai.*, jadwal_lengkap.* from pegawai left join jadwal_lengkap on pegawai.nik=jadwal_lengkap.wali_kelas where mengajar=:mengajar group by pegawai.nik order by nama";
      $this->db->query($sql);
      $this->db->bind('mengajar', $status);
      return $this->db->resultSet();
   }

   public function status_mengajar_non($id)
   {
      $sql = "UPDATE pegawai set mengajar=:mengajar where id_pegawai=:id_pegawai";
      $this->db->query($sql);
      $this->db->bind('mengajar', 'Tidak');
      $this->db->bind('id_pegawai', $id);
      $this->db->execute();
      return true;
   }

   public function status_mengajar_aktif($id)
   {
      $sql = "UPDATE pegawai set mengajar=:mengajar where id_pegawai=:id_pegawai";
      $this->db->query($sql);
      $this->db->bind('mengajar', 'Ya');
      $this->db->bind('id_pegawai', $id);
      $this->db->execute();
      return true;
   }

   //-- KELAS SAYA ------------------------
   public function absen_saya($hari)
   {
      $nik = $_SESSION['nik'];
      $sql = "SELECT jadwal_lengkap.*,
      pegawai1.nama as nama1, pegawai1.kode as kode_pegawai1,
      pegawai2.nama as nama2, pegawai2.kode as kode_pegawai2,
      pegawai3.nama as nama3, pegawai3.kode as kode_pegawai3,
      pegawai4.nama as nama4, pegawai4.kode as kode_pegawai4,
      pegawai5.nama as nama5, pegawai5.kode as kode_pegawai5,
      pegawai6.nama as nama6, pegawai6.kode as kode_pegawai6,
      pegawai7.nama as nama7, pegawai7.kode as kode_pegawai7,
      pegawai8.nama as nama8, pegawai8.kode as kode_pegawai8,
      pegawai9.nama as nama9, pegawai9.kode as kode_pegawai9,
      pegawai10.nama as nama10,  pegawai10.kode as kode_pegawai10,
      m_pelajaran1.mata_pelajaran as mata_pelajaran1, m_pelajaran1.singkatan as singkatan1,
      m_pelajaran2.mata_pelajaran as mata_pelajaran2, m_pelajaran2.singkatan as singkatan2,
      m_pelajaran3.mata_pelajaran as mata_pelajaran3, m_pelajaran3.singkatan as singkatan3,
      m_pelajaran4.mata_pelajaran as mata_pelajaran4, m_pelajaran4.singkatan as singkatan4,
      m_pelajaran5.mata_pelajaran as mata_pelajaran5, m_pelajaran5.singkatan as singkatan5,
      m_pelajaran6.mata_pelajaran as mata_pelajaran6, m_pelajaran6.singkatan as singkatan6,
      m_pelajaran7.mata_pelajaran as mata_pelajaran7, m_pelajaran7.singkatan as singkatan7,
      m_pelajaran8.mata_pelajaran as mata_pelajaran8, m_pelajaran8.singkatan as singkatan8,
      m_pelajaran9.mata_pelajaran as mata_pelajaran9, m_pelajaran9.singkatan as singkatan9,
      m_pelajaran10.mata_pelajaran as mata_pelajaran10, m_pelajaran10.singkatan as singkatan10
      from jadwal_lengkap 
      left join pegawai as pegawai1 on jadwal_lengkap.guru1 = pegawai1.nik
      left join pegawai as pegawai2 on jadwal_lengkap.guru2 = pegawai2.nik
      left join pegawai as pegawai3 on jadwal_lengkap.guru3 = pegawai3.nik
      left join pegawai as pegawai4 on jadwal_lengkap.guru4 = pegawai4.nik
      left join pegawai as pegawai5 on jadwal_lengkap.guru5 = pegawai5.nik
      left join pegawai as pegawai6 on jadwal_lengkap.guru6 = pegawai6.nik
      left join pegawai as pegawai7 on jadwal_lengkap.guru7 = pegawai7.nik
      left join pegawai as pegawai8 on jadwal_lengkap.guru8 = pegawai8.nik
      left join pegawai as pegawai9 on jadwal_lengkap.guru9 = pegawai9.nik
      left join pegawai as pegawai10 on jadwal_lengkap.guru10 = pegawai10.nik
      left join m_pelajaran as m_pelajaran1 on jadwal_lengkap.mp1 = m_pelajaran1.id_pelajaran
      left join m_pelajaran as m_pelajaran2 on jadwal_lengkap.mp2 = m_pelajaran2.id_pelajaran
      left join m_pelajaran as m_pelajaran3 on jadwal_lengkap.mp3 = m_pelajaran3.id_pelajaran
      left join m_pelajaran as m_pelajaran4 on jadwal_lengkap.mp4 = m_pelajaran4.id_pelajaran
      left join m_pelajaran as m_pelajaran5 on jadwal_lengkap.mp5 = m_pelajaran5.id_pelajaran
      left join m_pelajaran as m_pelajaran6 on jadwal_lengkap.mp6 = m_pelajaran6.id_pelajaran
      left join m_pelajaran as m_pelajaran7 on jadwal_lengkap.mp7 = m_pelajaran7.id_pelajaran
      left join m_pelajaran as m_pelajaran8 on jadwal_lengkap.mp8 = m_pelajaran8.id_pelajaran
      left join m_pelajaran as m_pelajaran9 on jadwal_lengkap.mp9 = m_pelajaran9.id_pelajaran
      left join m_pelajaran as m_pelajaran10 on jadwal_lengkap.mp10 = m_pelajaran10.id_pelajaran where wali_kelas=:wali_kelas  order by id_jadwal_lengkap";
      $this->db->query($sql);
      //$this->db->bind('hari', $hari);
      $this->db->bind('wali_kelas', $nik);
      return $this->db->resultSet();
   }

   //-- PROGRAM STUDI ---------------------------
   public function pegawai()
   {
      $sql = "SELECT * from pegawai order by nama";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function simpan_prodi($data)
   {
      $sql = "INSERT into m_prodi (id_prodi, kode_prodi, nama_prodi, ketua_prodi, status_prodi) values (:id_prodi, :kode_prodi, :nama_prodi, :ketua_prodi, :status_prodi)";
      $this->db->query($sql);
      $this->db->bind('id_prodi', NULL);
      $this->db->bind('kode_prodi', $data['kode_prodi']);
      $this->db->bind('nama_prodi', $data['nama_prodi']);
      $this->db->bind('ketua_prodi', $data['ketua_prodi']);
      $this->db->bind('status_prodi', 'Aktif');
      $this->db->execute();
      return true;
   }

   public function edit_prodi($data)
   {
      $sql = "UPDATE m_prodi set kode_prodi=:kode_prodi, nama_prodi=:nama_prodi, ketua_prodi=:ketua_prodi, status_prodi=:status_prodi where id_prodi=:id_prodi";
      $this->db->query($sql);
      $this->db->bind('id_prodi', $data['id_prodi']);
      $this->db->bind('kode_prodi', $data['kode_prodi']);
      $this->db->bind('nama_prodi', $data['nama_prodi']);
      $this->db->bind('ketua_prodi', $data['ketua_prodi']);
      $this->db->bind('status_prodi', $data['status_prodi']);
      $this->db->execute();
      return true;
   }

   public function ringkasan_x()
   {
      $sql = "SELECT CONCAT_WS(', ', guru1, guru2, guru3, guru4, guru5, guru6, guru7, guru8, guru9, guru10) AS ringkasan_x FROM jadwal_lengkap where kelas='X'";
      $this->db->query($sql);
      $result = $this->db->resultSet();
      $array_guru = array();
      foreach ($result as $row) {
         $array_guru[] = $row->ringkasan_x;
      }
      $guru_string = implode(', ', $array_guru);
      return $guru_string;
   }
   public function ringkasan_xi()
   {
      $sql = "SELECT CONCAT_WS(', ', guru1, guru2, guru3, guru4, guru5, guru6, guru7, guru8, guru9, guru10) AS ringkasan_xi FROM jadwal_lengkap where kelas='XI'";
      $this->db->query($sql);
      $result = $this->db->resultSet();
      $array_guru = array();
      foreach ($result as $row) {
         $array_guru[] = $row->ringkasan_xi;
      }
      $guru_string = implode(', ', $array_guru);
      return $guru_string;
   }
   public function ringkasan_xii()
   {
      $sql = "SELECT CONCAT_WS(', ', guru1, guru2, guru3, guru4, guru5, guru6, guru7, guru8, guru9, guru10) AS ringkasan_xii FROM jadwal_lengkap where kelas='XII'";
      $this->db->query($sql);
      $result = $this->db->resultSet();
      $array_guru = array();
      foreach ($result as $row) {
         $array_guru[] = $row->ringkasan_xii;
      }
      $guru_string = implode(', ', $array_guru);
      return $guru_string;
   }

   public function tahun_ajaran()
   {
      $sql = "SELECT * from m_tahun_ajaran";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function jadwal_setting()
   {
      $sql = "SELECT * from jadwal_setting where status='1'";
      $this->db->query($sql);
      return $this->db->single();
   }

   public function tahun_ajaran_byid($id)
   {
      $sql = "SELECT * from m_tahun_ajaran where id_tahun_ajaran=:id";
      $this->db->query($sql);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function simpan_jadwal_setting($data)
   {
      $tahun_ajaran = $data['tahun_ajaran'];
      $semester = $data['semester'];
      $blok = $data['blok'];

      $sql = "SELECT * from jadwal_setting where id_tahun_ajaran=:id_tahun_ajaran and semester=:semester and blok=:blok";
      $this->db->query($sql);
      $this->db->bind('id_tahun_ajaran', $tahun_ajaran);
      $this->db->bind('semester', $semester);
      $this->db->bind('blok', $blok);
      $cek = $this->db->single();

      if (!$cek) {
         $matikan = "UPDATE jadwal_setting set status=:status";
         $this->db->query($matikan);
         $this->db->bind('status', '0');
         $this->db->execute();

         $proses = "INSERT into jadwal_setting (id_jadwal_setting, id_tahun_ajaran, semester, blok, berlaku_dari, tanggal_dirubah, status) values (:id_jadwal_setting, :id_tahun_ajaran, :semester, :blok, :berlaku_dari, :tanggal_dirubah, :status)";
         $this->db->query($proses);
         $this->db->bind('id_jadwal_setting', NULL);
         $this->db->bind('id_tahun_ajaran', $data['tahun_ajaran']);
         $this->db->bind('semester', $data['semester']);
         $this->db->bind('blok', $data['blok']);
         $this->db->bind('berlaku_dari', $data['berlaku']);
         $this->db->bind('tanggal_dirubah', date('Y-m-d'));
         $this->db->bind('status', '1');
         $this->db->execute();

         $proses2 = "UPDATE jadwal_lengkap set berlaku_jadwal_dari=:berlaku_jadwal_dari";
         $this->db->query($proses2);
         $this->db->bind('berlaku_jadwal_dari', $data['berlaku']);
         $this->db->execute();
      } else {
         $matikan = "UPDATE jadwal_setting set status=:status";
         $this->db->query($matikan);
         $this->db->bind('status', '0');
         $this->db->execute();

         if ($data['id_jadwal_setting'] == $cek->id_jadwal_setting) {
            $id = $data['id_jadwal_setting'];
         } else {
            $id = $cek->id_jadwal_setting;
         }

         $proses = "UPDATE jadwal_setting set id_tahun_ajaran=:id_tahun_ajaran, semester=:semester, blok=:blok, berlaku_dari=:berlaku_dari, tanggal_dirubah=:tanggal_dirubah, status=:status where id_jadwal_setting=:id";
         $this->db->query($proses);
         $this->db->bind('id', $id);
         $this->db->bind('id_tahun_ajaran', $data['tahun_ajaran']);
         $this->db->bind('semester', $data['semester']);
         $this->db->bind('blok', $data['blok']);
         $this->db->bind('berlaku_dari', $data['berlaku']);
         $this->db->bind('tanggal_dirubah', date('Y-m-d'));
         $this->db->bind('status', '1');
         $this->db->execute();

         $proses2 = "UPDATE jadwal_lengkap set berlaku_jadwal_dari=:berlaku_jadwal_dari";
         $this->db->query($proses2);
         $this->db->bind('berlaku_jadwal_dari', $data['berlaku']);
         $this->db->execute();
      }
      return true;
   }

   public function belum_ada_guru()
   {
      $satu = "SELECT COUNT(*) AS satu FROM jadwal_lengkap WHERE guru1 IS NULL and hari !='senin' and mp1 != '33' and mp1 != '34'";
      $this->db->query($satu);
      $satu = $this->db->single();

      $dua = "SELECT COUNT(*) AS dua FROM jadwal_lengkap WHERE guru2 IS NULL and mp2 != '33' and mp2 != '34'";
      $this->db->query($dua);
      $dua = $this->db->single();

      $tiga = "SELECT COUNT(*) AS tiga FROM jadwal_lengkap WHERE guru3 IS NULL and mp3 != '33' and mp3 != '34'";
      $this->db->query($tiga);
      $tiga = $this->db->single();

      $empat = "SELECT COUNT(*) AS empat FROM jadwal_lengkap WHERE guru4 IS NULL and mp4 != '33' and mp4 != '34'";
      $this->db->query($empat);
      $empat = $this->db->single();

      $lima = "SELECT COUNT(*) AS lima FROM jadwal_lengkap WHERE guru5 IS NULL and mp5 != '33' and mp5 != '34'";
      $this->db->query($lima);
      $lima = $this->db->single();

      $enam = "SELECT COUNT(*) AS enam FROM jadwal_lengkap WHERE guru6 IS NULL and mp6 != '33' and mp6 != '34'";
      $this->db->query($enam);
      $enam = $this->db->single();

      $tujuh = "SELECT COUNT(*) AS tujuh FROM jadwal_lengkap WHERE guru7 IS NULL and mp7 != '33' and mp7 != '34'";
      $this->db->query($tujuh);
      $tujuh = $this->db->single();

      $delapan = "SELECT COUNT(*) AS delapan FROM jadwal_lengkap WHERE guru8 IS NULL and mp8 != '33' and mp8 != '34'";
      $this->db->query($delapan);
      $delapan = $this->db->single();

      $sembilan = "SELECT COUNT(*) AS sembilan FROM jadwal_lengkap WHERE guru9 IS NULL and mp9 != '33' and mp9 != '34'";
      $this->db->query($sembilan);
      $sembilan = $this->db->single();

      $sepuluh = "SELECT COUNT(*) AS sepuluh FROM jadwal_lengkap WHERE guru10 IS NULL and mp10 != '33' and mp10 != '34'";
      $this->db->query($sepuluh);
      $sepuluh = $this->db->single();

      $belum_ada_guru = $satu->satu + $dua->dua + $tiga->tiga + $empat->empat + $lima->lima + $enam->enam + $tujuh->tujuh + $delapan->delapan + $sembilan->sembilan + $sepuluh->sepuluh;

      return [
         'jsatu' => $satu->satu,
         'jdua' => $dua->dua,
         'jtiga' => $tiga->tiga,
         'jempat' => $empat->empat,
         'jlima' => $lima->lima,
         'jenam' => $enam->enam,
         'jtujuh' => $tujuh->tujuh,
         'jdelapan' => $delapan->delapan,
         'jsembilan' => $sembilan->sembilan,
         'jsepuluh' => $sepuluh->sepuluh,
         'belum_ada_guru' => $belum_ada_guru
      ];
   }


   public function mata_pelajaran_ringkasan($nik)
   {
      $sql = "SELECT * from (SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru1, ',', numbers.n), ',', -1) AS guru, 1 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp1 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru1) - CHAR_LENGTH(REPLACE(j.guru1, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru2, ',', numbers.n), ',', -1) AS guru, 2 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp2 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru2) - CHAR_LENGTH(REPLACE(j.guru2, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru3, ',', numbers.n), ',', -1) AS guru, 3 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp3 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru3) - CHAR_LENGTH(REPLACE(j.guru3, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru4, ',', numbers.n), ',', -1) AS guru, 4 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp4 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru4) - CHAR_LENGTH(REPLACE(j.guru4, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru5, ',', numbers.n), ',', -1) AS guru, 5 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp5 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru5) - CHAR_LENGTH(REPLACE(j.guru5, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru6, ',', numbers.n), ',', -1) AS guru, 6 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp6 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru6) - CHAR_LENGTH(REPLACE(j.guru6, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru7, ',', numbers.n), ',', -1) AS guru, 7 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp7 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru7) - CHAR_LENGTH(REPLACE(j.guru7, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru8, ',', numbers.n), ',', -1) AS guru, 8 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp8 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru8) - CHAR_LENGTH(REPLACE(j.guru8, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru9, ',', numbers.n), ',', -1) AS guru, 9 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp9 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru9) - CHAR_LENGTH(REPLACE(j.guru9, ',', '')) >= numbers.n - 1
      UNION ALL
      SELECT j.id_jadwal_lengkap, j.hari, j.kode_kelas, j.kelas, j.ruang, p.mata_pelajaran AS mp, SUBSTRING_INDEX(SUBSTRING_INDEX(j.guru10, ',', numbers.n), ',', -1) AS guru, 10 AS jam
      FROM jadwal_lengkap j
      INNER JOIN m_pelajaran p ON j.mp10 = p.id_pelajaran
      INNER JOIN(SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3) numbers 
      ON CHAR_LENGTH(j.guru10) - CHAR_LENGTH(REPLACE(j.guru10, ',', '')) >= numbers.n - 1) as result
      WHERE guru=:gurunya
      ORDER BY id_jadwal_lengkap, kelas, ruang, jam ";
      $this->db->query($sql);
      $this->db->bind(':gurunya', $nik);
      return $this->db->resultSet();
   }

   //------------------------------------
   public function ambil_isi_kelas($kelas)
   {
      $query = "SELECT siswa.nis, siswa.nama_siswa, m_prodi.kode_prodi from siswa LEFT JOIN m_prodi on siswa.prodi=m_prodi.id_prodi where kelas_siswa=:kelas_siswa order by nama_siswa";
      $this->db->query($query);
      $this->db->bind('kelas_siswa', $kelas);
      return $this->db->resultSet();
   }

   public function mata_pelajaran_byid($id)
   {
      $query = "SELECT * from m_pelajaran where id_pelajaran=:id";
      $this->db->query($query);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function simpan_isi_absen($data)
   {
      $cari = "SELECT * from m_pelajaran where id_pelajaran=:id_pelajaran";
      $this->db->query($cari);
      $this->db->bind('id_pelajaran', $data['id_pelajaran']);
      $result = $this->db->single();

      $singkatan = $result->singkatan;
      $panjang = $result->mata_pelajaran;

      $sql = "INSERT into absen_kelas (id_absen_kelas, nik_absen_kelas, tgl_absen_kelas, kelas_absen_kelas, ruang_absen_kelas, jam_absen_kelas, mata_pelajaran, mata_pelajaran_lengkap, materi_pelajaran, wali_kelas_absen) values (:id_absen_kelas, :nik_absen_kelas, :tgl_absen_kelas, :kelas_absen_kelas, :ruang_absen_kelas, :jam_absen_kelas, :mata_pelajaran, :mata_pelajaran_lengkap, :materi_pelajaran, :wali_kelas)";
      $this->db->query($sql);
      $this->db->bind('id_absen_kelas', null);
      $this->db->bind('nik_absen_kelas', $data['nik']);
      $this->db->bind('tgl_absen_kelas', $data['tgl']);
      $this->db->bind('kelas_absen_kelas', $data['kelas']);
      $this->db->bind('ruang_absen_kelas', $data['ruang']);
      $this->db->bind('jam_absen_kelas', $data['jam']);
      $this->db->bind('mata_pelajaran', $singkatan);
      $this->db->bind('mata_pelajaran_lengkap', $panjang);
      $this->db->bind('materi_pelajaran', $data['materi']);
      $this->db->bind('wali_kelas', $data['wali_kelas']);
      $this->db->execute();

      $id_terakhir = $this->db->lastInsertId();

      $jumlah_siswa = $data['jumlah_siswa'];
      $jam = $data['jam'];

      for ($a = 0; $a < $jumlah_siswa; $a++) {
         $sql_cari = "SELECT * from absen_kelas_siswa where tgl_aks=:tgl_aks and nis_aks=:nis_aks";
         $this->db->query($sql_cari);
         $this->db->bind('tgl_aks', $data['tgl']);
         $this->db->bind('nis_aks', $data['nis'][$a]);
         $ada = $this->db->single();

         if ($ada) {
            $sql_update = "UPDATE absen_kelas_siswa SET id_jam" . $jam . "=:id_jam, absen_jam" . $jam . "=:absen_jam WHERE tgl_aks=:tgl_aks AND nis_aks=:nis_aks";
            $this->db->query($sql_update);
            $this->db->bind('id_jam', $id_terakhir);
            $this->db->bind('absen_jam', $data['absen'][$a]);
            $this->db->bind('tgl_aks', $data['tgl']);
            $this->db->bind('nis_aks', $data['nis'][$a]);
            $this->db->execute();
         } else {
            $sql_isi = "INSERT INTO absen_kelas_siswa (tgl_aks, nis_aks, kelas_aks, wali_kelas_aks, id_jam1, id_jam2, id_jam3, id_jam4, id_jam5, id_jam6, id_jam7, id_jam8, id_jam9, id_jam10, absen_jam1, absen_jam2, absen_jam3, absen_jam4, absen_jam5, absen_jam6, absen_jam7, absen_jam8, absen_jam9, absen_jam10)
            VALUES (:tgl_aks, :nis_aks, :kelas_aks, :wali_kelas_aks, :id_jam1, :id_jam2, :id_jam3, :id_jam4, :id_jam5, :id_jam6, :id_jam7, :id_jam8, :id_jam9, :id_jam10, :absen_jam1, :absen_jam2, :absen_jam3, :absen_jam4, :absen_jam5, :absen_jam6, :absen_jam7, :absen_jam8, :absen_jam9, :absen_jam10)";
            $this->db->query($sql_isi);
            $this->db->bind('tgl_aks', $data['tgl']);
            $this->db->bind('nis_aks', $data['nis'][$a]);
            $this->db->bind('kelas_aks', $data['kelas'] . $data['ruang']);
            $this->db->bind('wali_kelas_aks', $data['wali_kelas']);

            for ($i = 1; $i <= 10; $i++) {
               $id_jam_param = 'id_jam' . $i;
               $absen_jam_param = 'absen_jam' . $i;

               if ($i == $jam) {
                  $this->db->bind($id_jam_param, $id_terakhir);
                  $this->db->bind($absen_jam_param, $data['absen'][$a]);
               } else {
                  $this->db->bind($id_jam_param, null);
                  $this->db->bind($absen_jam_param, null);
               }
            }
            $this->db->execute();
         }
      }

      return true;
   }

   public function simpan_edit_isi_absen($data)
   {
      $sql = "UPDATE absen_kelas set materi_pelajaran=:materi_pelajaran where id_absen_kelas=:id";
      $this->db->query($sql);
      $this->db->bind('id', $data['id_absen']);
      $this->db->bind('materi_pelajaran', $data['materi']);
      $this->db->execute();

      $jam = $data['jam'];
      for ($a = 0; $a < $data['jumlah_siswa']; $a++) {
         $sql_cari = "SELECT * from absen_kelas_siswa where tgl_aks=:tgl_aks and nis_aks=:nis_aks";
         $this->db->query($sql_cari);
         $this->db->bind('tgl_aks', $data['tgl']);
         $this->db->bind('nis_aks', $data['nis'][$a]);
         $ada = $this->db->single();

         if ($ada) {
            $sql_update = "UPDATE absen_kelas_siswa SET absen_jam" . $jam . "=:absen_jam WHERE tgl_aks=:tgl_aks AND nis_aks=:nis_aks";
            $this->db->query($sql_update);
            $this->db->bind('absen_jam', $data['absen'][$a]);
            $this->db->bind('tgl_aks', $data['tgl']);
            $this->db->bind('nis_aks', $data['nis'][$a]);
            $this->db->execute();
         }
      }

      return true;
   }

   public function absen_byid($id)
   {
      $sql_cari = "SELECT * from absen_kelas where id_absen_kelas=:id";
      $this->db->query($sql_cari);
      $this->db->bind('id', $id);
      return $this->db->single();
   }

   public function absen_kelas_byid($id, $jam)
   {
      $id_jam = 'id_jam' . $jam;
      $absen_jam = 'absen_jam' . $jam;

      $sql_cari = "SELECT absen_kelas_siswa.nis_aks, absen_kelas_siswa.$absen_jam, siswa.nama_siswa from absen_kelas_siswa left join siswa on absen_kelas_siswa.nis_aks=siswa.nis where $id_jam=:id order by nama_siswa";
      $this->db->query($sql_cari);
      $this->db->bind('id', $id);
      return $this->db->resultSet();
   }

   //-KELAS SAYA SISWA ---------------------------------
   public function kelas_saya_siswa()
   {
      $sql = "SELECT kelas_siswa from siswa where nis=:nis";
      $this->db->query($sql);
      $this->db->bind('nis', $_SESSION['nik']);
      return $this->db->single();
   }

   //---CEK IZIN ----------------------------------- 
   public function cek_izin($tgl, $kelas)
   {
      $sql = "SELECT izin_siswa.*, siswa.nama_siswa from izin_siswa left join siswa on izin_siswa.nis_izin=siswa.nis where :tgl BETWEEN mulai_izin AND sampai_izin and kelas_izin=:kelas_izin and status_izin='Disetujui' order by siswa.nama_siswa";
      $this->db->query($sql);
      $this->db->bind('tgl', $tgl);
      $this->db->bind('kelas_izin', $kelas);
      return $this->db->resultSet();
   }
}
