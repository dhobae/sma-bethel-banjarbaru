<?php
class Mdashboard
{
   public function __construct()
   {
      $this->db = new Database;
   }

   public function polling()
   {
      $sql = "SELECT * from polling limit 1";
      $this->db->query($sql);
      return $this->db->single();
   }

   public function notif()
   {
      $sql = "SELECT * from notif where id_notif='1'";
      $this->db->query($sql);
      return $this->db->single();
   }

   public function pegawai_all()
   {
      $sql = "SELECT * from pegawai where absen=:absen order by nama";
      $this->db->query($sql);
      $this->db->bind('absen', 'Aktif');
      return $this->db->resultSet();
   }

   public function cek_absen()
   {
      $tanggal = date("Y-m-d");
      $username = $_SESSION['username'];
      $query = "SELECT absen.*, libur.keterangan_libur as keterangan from absen left join libur on absen.from_masuk=libur.id where absen.nik in ('$username','all') and absen.tanggal='$tanggal'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function wajib_absen($nik)
   {
      $sql = "SELECT * from pegawai where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function ip()
   {
      $query = "SELECT * from ip_address";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function jumlahkaryawan()
   {
      $query = "SELECT * from pegawai where absen=:absen";
      $this->db->query($query);
      $this->db->bind('absen', 'Aktif');
      return $this->db->resultSet();
   }

   public function jumlahwfo()
   {
      $query = "SELECT * from absen left join pegawai on absen.nik=pegawai.nik where tanggal=CURDATE() and from_masuk='WFO' and absen='Aktif'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function jumlahwfh()
   {
      $query = "SELECT * from absen left join pegawai on absen.nik=pegawai.nik where tanggal=CURDATE() and from_masuk = 'WFH' and absen='Aktif'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function jumlahizin()
   {
      $query = "SELECT * from absen where tanggal=CURDATE() and status_masuk = 'Izin'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function jumlahcuti()
   {
      $query = "SELECT * from absen where tanggal=CURDATE() and status_masuk = 'Cuti'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function beban_kerja()
   {
      $query = "SELECT * from master_jam limit 1";
      $this->db->query($query);
      return $this->db->single();
   }

   public function absen_kerja($nik)
   {
      $sql = "SELECT * FROM absen WHERE (nik = :nik OR nik = 'all') AND DATE_FORMAT(tanggal, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')";
      $this->db->query($sql);
      $this->db->bind(':nik', $nik);
      return $this->db->resultSet();
   }

   public function settingan()
   {
      $query = "SELECT * from settingan limit 1";
      $this->db->query($query);
      $result = $this->db->single();
      return $result;
   }

   public function hadir($data)
   {
      require APPROOT . '../../public/dist/lib/ip.php';
      $nik = $_SESSION['username'];
      $tanggal = date("Y-m-d");
      $status_masuk = 'Hadir';
      $loc_masuk = $data['loc_masuk'];

      $sql_wfh = "SELECT * from master_jam limit 1";
      $this->db->query($sql_wfh);
      $result = $this->db->single();
      if ($result) {
         $wfh_masuk = $result->wfh_masuk;
         $wfh_pulang = $result->wfh_pulang;
      }

      get_client_ip();
      $ipnya = get_client_ip();
      $i = 0;
      $ada = 0;

      $sql_ip = "SELECT * from ip_address";
      $this->db->query($sql_ip);
      $result2 = $this->db->resultSet();
      foreach ($result2 as $r) {
         $i++;
         if (ip_in_range2($ipnya, $r->ip_address)) {
            $status[$i] = 1;
         } else {
            $status[$i] = 0;
         }
         $ada = $ada + $status[$i];
      }

      if ($ada > 0) :
         $from_masuk = 'WFO';
      else :
         $from_masuk = 'WFH';
      endif;

if ((date('H:i:s', time()) < $wfh_masuk) and ($from_masuk == 'WFH')) {
         if ((Middleware::admin('satpam')) || (Middleware::admin('cs'))) {
            $jam3 = date('H:i:s', time() - 300);
         } else {
            $jam3 = $wfh_masuk;
         }
      } else {
         $jam3 = date('H:i:s', time() - 300);
      }

      $jikaduakali = "SELECT * from absen where nik=:nik and tanggal=:tanggal";
      $this->db->query($jikaduakali);
      $this->db->bind('nik', $nik);
      $this->db->bind('tanggal', $tanggal);
      $result3 = $this->db->resultSet();

      if ($result3) {
         $queryupdate = "UPDATE absen set jam_masuk=:jam3, status_masuk=:status_masuk, from_masuk=:from_masuk, loc_masuk=:loc_masuk where nik=:nik and tanggal=:tanggal";
         $this->db->query($queryupdate);
         $this->db->bind('nik', $nik);
         $this->db->bind('tanggal', $tanggal);
         $this->db->bind('jam3', $jam3);
         $this->db->bind('status_masuk', $status_masuk);
         $this->db->bind('from_masuk', $from_masuk);
         $this->db->bind('loc_masuk', $loc_masuk);
         $this->db->execute();
      } else {
         $queryupdate = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan, loc_masuk, loc_pulang, visitid) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan, :loc_masuk, :loc_pulang, :visitid)";
         $this->db->query($queryupdate);
         $this->db->bind('id', NULL);
         $this->db->bind('nik', $nik);
         $this->db->bind('tanggal', $tanggal);
         $this->db->bind('jam_masuk', $jam3);
         $this->db->bind('status_masuk', $status_masuk);
         $this->db->bind('from_masuk', $from_masuk);
         $this->db->bind('jam_pulang', '00:00:00');
         $this->db->bind('status_pulang', '-');
         $this->db->bind('from_pulang', '-');
         $this->db->bind('keterangan', '-');
         $this->db->bind('loc_masuk', $loc_masuk);
         $this->db->bind('loc_pulang', '-');
         $this->db->bind('visitid', $data['visitid']);
         $this->db->execute();
      }

      $no_hp = $this->ambil_nomor_datang($nik);
      $data['no_telp'] = $no_hp->nomor_hp;
      $data['isi_pesan'] = "[Presensi SMA Bethel BJB].\n\nSelamat Bekerja " . $no_hp->nama . ", anda sudah melakukan presensi datang pada jam " . $jam3 . ", status : " . $from_masuk;
      notifWA($data);

      return true;
   }

   public function pulang($data)
   {
      require APPROOT . '../../public/dist/lib/ip.php';
      $nik = $_SESSION['username'];
      $tanggal = date("Y-m-d");
      $status_pulang = 'Pulang';
      $loc_pulang = $data['loc_pulang'];

      $sql_wfh = "SELECT * from master_jam limit 1";
      $this->db->query($sql_wfh);
      $result = $this->db->single();
      if ($result) {
         $wfh_masuk = $result->wfh_masuk;
         $wfh_pulang = $result->wfh_pulang;
      }

      get_client_ip();
      $ipnya = get_client_ip();
      $i = 0;
      $ada = 0;

      $sql_ip = "SELECT * from ip_address";
      $this->db->query($sql_ip);
      $result2 = $this->db->resultSet();
      foreach ($result2 as $r) {
         $i++;
         if (ip_in_range2($ipnya, $r->ip_address)) {
            $status[$i] = 1;
         } else {
            $status[$i] = 0;
         }
         $ada = $ada + $status[$i];
      }

      if ($ada > 0) :
         $from_pulang = 'WFO';
      else :
         $from_pulang = 'WFH';
      endif;

      if ((date('H:i:s', time()) > $wfh_pulang) and ($from_pulang == 'WFH')) {
         if ((Middleware::admin('satpam')) || (Middleware::admin('cs'))) {
            $jam3 = date('H:i:s');
         } else {
            $jam3 = $wfh_pulang;
         }
      } else {
         $jam3 = date('H:i:s');
      }

      $queryupdate = "UPDATE absen set jam_pulang=:jam_pulang, status_pulang=:status_pulang, from_pulang=:from_pulang, loc_pulang=:loc_pulang, visitid_pulang=:visitid_pulang where nik=:nik and tanggal=:tanggal";
      $this->db->query($queryupdate);
      $this->db->bind('nik', $nik);
      $this->db->bind('tanggal', $tanggal);
      $this->db->bind('jam_pulang', $jam3);
      $this->db->bind('status_pulang', $status_pulang);
      $this->db->bind('from_pulang', $from_pulang);
      $this->db->bind('loc_pulang', $loc_pulang);
      $this->db->bind('visitid_pulang', $data['visitid_pulang']);
      $this->db->execute();

      $no_hp = $this->ambil_nomor_pulang($nik);
      $data['no_telp'] = $no_hp->nomor_hp;
      $data['isi_pesan'] = "[Presensi SMA Bethel BJB].\n\nSelamat Beristirahat " . $no_hp->nama . ", anda sudah melakukan presensi pulang pada jam " . $jam3 . ", status : " . $from_pulang;
      notifWA($data);

      return true;
   }

   public function setting()
   {
      $query = "SELECT * FROM settingan limit 1";
      $this->db->query($query);
      return $this->db->single();
   }

   public function simpan_setting($data)
   {
      $sql = "UPDATE settingan set home_dosen=:home_dosen, kontak=:kontak where id=:id";
      $this->db->query($sql);
      $this->db->bind('id', '1');
      $this->db->bind('home_dosen', $data['home_dosen']);
      $this->db->bind('kontak', $data['kontak']);
      $this->db->execute();
      return true;
   }

   public function ambil_nomor($nik)
   {
      $sql = "SELECT nama, nomor_hp from pegawai where nik=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function ambil_nomor_datang($nik)
   {
      $sql = "SELECT pegawai.nama, pegawai.nomor_hp from pegawai left join send_wa on pegawai.nik=send_wa.nik_send_wa where pegawai.nik=:nik and send_wa.absen_datang='1'";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function ambil_nomor_pulang($nik)
   {
      $sql = "SELECT pegawai.nama, pegawai.nomor_hp from pegawai left join send_wa on pegawai.nik=send_wa.nik_send_wa where pegawai.nik=:nik and send_wa.absen_pulang='1'";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function ambil_password($nik)
   {
      $sql = "SELECT password from users where nik_user=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   public function ambil_respon($nik)
   {
      $sql = "SELECT nik_pendapat from pendapat where nik_pendapat=:nik";
      $this->db->query($sql);
      $this->db->bind('nik', $nik);
      return $this->db->single();
   }

   // KHUSUS RFID -----------------
   public function ambil_pegawai_by_rfid($rfid)
   {
      $sql = "SELECT * from pegawai where rfid=:rfid";
      $this->db->query($sql);
      $this->db->bind('rfid', $rfid);
      return $this->db->single();
   }

   // public function cek_absen_rfid($nik)
   // {
   //    $sql = "SELECT * from absen where nik=:nik and tanggal=:tanggal";
   //    $this->db->query($sql);
   //    $this->db->bind('nik', $nik);
   //    $this->db->bind('tanggal', date('Y-m-d'));
   //    return $this->db->single();
   // }

   // public function hadir_rfid($data)
   // {
   //    $jikaduakali = "SELECT * from absen where nik=:nik and tanggal=:tanggal";
   //    $this->db->query($jikaduakali);
   //    $this->db->bind('nik', $data['nik']);
   //    $this->db->bind('tanggal', date('Y-m-d'));
   //    $result3 = $this->db->resultSet();

   //    if ($result3) {
   //       $queryupdate = "UPDATE absen set jam_masuk=:jam3, status_masuk=:status_masuk, from_masuk=:from_masuk where nik=:nik and tanggal=:tanggal";
   //       $this->db->query($queryupdate);
   //       $this->db->bind('nik', $data['nik']);
   //       $this->db->bind('tanggal', date('Y-m-d'));
   //       $this->db->bind('jam3', date('H:i:s', time() - 300));
   //       $this->db->bind('status_masuk', 'Hadir');
   //       $this->db->bind('from_masuk', 'WFO');
   //       $this->db->execute();
   //    } else {
   //       $queryupdate = "INSERT INTO absen (id, nik, tanggal, jam_masuk, status_masuk, from_masuk, jam_pulang, status_pulang, from_pulang, keterangan) values (:id, :nik, :tanggal, :jam_masuk, :status_masuk, :from_masuk, :jam_pulang, :status_pulang, :from_pulang, :keterangan)";
   //       $this->db->query($queryupdate);
   //       $this->db->bind('id', NULL);
   //       $this->db->bind('nik', $data['nik']);
   //       $this->db->bind('tanggal', date('Y-m-d'));
   //       $this->db->bind('jam_masuk', date('H:i:s', time() - 300));
   //       $this->db->bind('status_masuk', 'Hadir');
   //       $this->db->bind('from_masuk', 'WFO');
   //       $this->db->bind('jam_pulang', '00:00:00');
   //       $this->db->bind('status_pulang', '-');
   //       $this->db->bind('from_pulang', '-');
   //       $this->db->bind('keterangan', '-');
   //       $this->db->execute();
   //    }
   //    return true;
   // }

   // public function pulang_rfid($data)
   // {
   //    $queryupdate = "UPDATE absen set jam_pulang=:jam_pulang, status_pulang=:status_pulang, from_pulang=:from_pulang where id=:id";
   //    $this->db->query($queryupdate);
   //    $this->db->bind('id', $data['id_absen']);
   //    $this->db->bind('jam_pulang', date('H:i:s'));
   //    $this->db->bind('status_pulang', "Pulang");
   //    $this->db->bind('from_pulang', "WFO");
   //    $this->db->execute();
   //    return true;
   // }


   public function kelas_1($hari)
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
      m_pelajaran1.id_pelajaran as id_pelajaran1,
      m_pelajaran2.id_pelajaran as id_pelajaran2,
      m_pelajaran3.id_pelajaran as id_pelajaran3,
      m_pelajaran4.id_pelajaran as id_pelajaran4,
      m_pelajaran5.id_pelajaran as id_pelajaran5,
      m_pelajaran6.id_pelajaran as id_pelajaran6,
      m_pelajaran7.id_pelajaran as id_pelajaran7,
      m_pelajaran8.id_pelajaran as id_pelajaran8,
      m_pelajaran9.id_pelajaran as id_pelajaran9,
      m_pelajaran10.id_pelajaran as id_pelajaran10
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
      left join m_pelajaran as m_pelajaran10 on jadwal_lengkap.mp10 = m_pelajaran10.id_pelajaran 
      where kelas='X' and hari=:hari and jadwal_lengkap.berlaku_jadwal_dari = (
                        SELECT berlaku_dari 
                        FROM jadwal_setting 
                        WHERE status = 1 
                        LIMIT 1
                    )
      ORDER BY id_jadwal_lengkap";
      $this->db->query($sql);
      $this->db->bind('hari', $hari);
      return $this->db->resultSet();
   }

   public function kelas_2($hari)
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
      m_pelajaran1.id_pelajaran as id_pelajaran1,
      m_pelajaran2.id_pelajaran as id_pelajaran2,
      m_pelajaran3.id_pelajaran as id_pelajaran3,
      m_pelajaran4.id_pelajaran as id_pelajaran4,
      m_pelajaran5.id_pelajaran as id_pelajaran5,
      m_pelajaran6.id_pelajaran as id_pelajaran6,
      m_pelajaran7.id_pelajaran as id_pelajaran7,
      m_pelajaran8.id_pelajaran as id_pelajaran8,
      m_pelajaran9.id_pelajaran as id_pelajaran9,
      m_pelajaran10.id_pelajaran as id_pelajaran10
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
      left join m_pelajaran as m_pelajaran10 on jadwal_lengkap.mp10 = m_pelajaran10.id_pelajaran 
      where kelas='XI' and hari=:hari and jadwal_lengkap.berlaku_jadwal_dari = (
                        SELECT berlaku_dari 
                        FROM jadwal_setting 
                        WHERE status = 1 
                        LIMIT 1
                    )
      ORDER BY id_jadwal_lengkap";
      $this->db->query($sql);
      $this->db->bind('hari', $hari);
      return $this->db->resultSet();
   }

   public function kelas_3($hari)
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
      m_pelajaran1.id_pelajaran as id_pelajaran1,
      m_pelajaran2.id_pelajaran as id_pelajaran2,
      m_pelajaran3.id_pelajaran as id_pelajaran3,
      m_pelajaran4.id_pelajaran as id_pelajaran4,
      m_pelajaran5.id_pelajaran as id_pelajaran5,
      m_pelajaran6.id_pelajaran as id_pelajaran6,
      m_pelajaran7.id_pelajaran as id_pelajaran7,
      m_pelajaran8.id_pelajaran as id_pelajaran8,
      m_pelajaran9.id_pelajaran as id_pelajaran9,
      m_pelajaran10.id_pelajaran as id_pelajaran10
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
      left join m_pelajaran as m_pelajaran10 on jadwal_lengkap.mp10 = m_pelajaran10.id_pelajaran 
      where kelas='XII' and hari=:hari and jadwal_lengkap.berlaku_jadwal_dari = (
                        SELECT berlaku_dari 
                        FROM jadwal_setting 
                        WHERE status = 1 
                        LIMIT 1
                    )
      ORDER BY id_jadwal_lengkap";
      $this->db->query($sql);
      $this->db->bind('hari', $hari);
      return $this->db->resultSet();
   }

   public function siswa_by_id($nis)
   {
      $sql = "SELECT kelas_siswa from siswa where nis=:nis";
      $this->db->query($sql);
      $this->db->bind('nis', $nis);
      return $this->db->single();
   }

   public function ambil_wali_kelas()
   {
      $cari = "SELECT kelas_siswa from siswa where nis=:nis";
      $this->db->query($cari);
      $this->db->bind('nis', $_SESSION['nik']);
      $cari1 = $this->db->single();
      $kelas = $cari1->kelas_siswa;

      $sql = "SELECT jadwal_lengkap.wali_kelas, pegawai.nama from jadwal_lengkap left join pegawai on jadwal_lengkap.wali_kelas=pegawai.nik where jadwal_lengkap.kode_kelas=:id";
      $this->db->query($sql);
      $this->db->bind('id', $kelas);
      return $this->db->single();
   }

   public function semester_aktif()
   {
      $sql = "SELECT * from jadwal_setting where status='1'";
      $this->db->query($sql);
      return $this->db->single();
   }

   //--HADIR SISWA--------------------------------
   public function cek_absen_siswa()
   {
      $tanggal = date("Y-m-d");
      $nis = $_SESSION['nik'];
      //$query = "SELECT absen.*, libur.keterangan_libur as keterangan from absen left join libur on absen.from_masuk=libur.id where absen.nik in ('$username','all') and absen.tanggal='$tanggal'";
      $query = "SELECT absen_harian_siswa.*, libur.keterangan_libur as keterangan from absen_harian_siswa left join libur on absen_harian_siswa.status_ahs=libur.id where absen_harian_siswa.nis_ahs in ('$nis','all') and absen_harian_siswa.tgl_ahs='$tanggal'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function cek_absen_siswa_bulan($year, $month)
   {
      $nis = $_SESSION['nik'];
      $query = "SELECT absen_harian_siswa.*, libur.keterangan_libur as keterangan from absen_harian_siswa left join libur on absen_harian_siswa.status_ahs=libur.id where absen_harian_siswa.nis_ahs in ('$nis','all') and year(absen_harian_siswa.tgl_ahs)='$year' and month(absen_harian_siswa.tgl_ahs)='$month'";
      $this->db->query($query);
      return $this->db->resultSet();
   }

   public function hadir_siswa($data)
   {
      $nis = $_SESSION['nik'];
      $tanggal = date("Y-m-d");

      $sudah_absen = "SELECT * from absen_harian_siswa where nis_ahs=:nis and tgl_ahs=:tanggal";
      $this->db->query($sudah_absen);
      $this->db->bind('nis', $nis);
      $this->db->bind('tanggal', $tanggal);
      $result3 = $this->db->resultSet();
      if ($result3) {
         return true;
      }

      $queryupdate = "INSERT INTO absen_harian_siswa (nis_ahs, tgl_ahs, status_ahs, jam_masuk_ahs, kelas_ahs, wali_kelas_ahs, id_jadwal_setting_ahs) values (:nis_ahs, :tgl_ahs, :status_ahs, :jam_masuk_ahs, :kelas_ahs, :wali_kelas_ahs, :id_jadwal_setting_ahs)";
      $this->db->query($queryupdate);
      $this->db->bind('nis_ahs', $nis);
      $this->db->bind('tgl_ahs', $tanggal);
      $this->db->bind('status_ahs', 'Hadir');
      $this->db->bind('jam_masuk_ahs', date('H:i:s'));
      $this->db->bind('id_jadwal_setting_ahs', $data['semester_aktif']);
      $this->db->bind('kelas_ahs', $data['kelas']);
      $this->db->bind('wali_kelas_ahs', $data['wali_kelas']);
      $this->db->execute();

      return true;
   }

   public function ada_izin()
   {
      $sql = "SELECT * from izin_siswa where status_izin='Menunggu ACC' and curdate() <= sampai_izin";
      $this->db->query($sql);
      return $this->db->resultSet();
   }

   public function jam_kerja_bydate($month, $year)
   {
      $tanggal_absen = $year . '-' . $month . '-01';
      $libur_all = "SELECT * FROM master_jam WHERE berlaku_mulai <= :tanggal_absen ORDER BY berlaku_mulai DESC LIMIT 1";
      $this->db->query($libur_all);
      $this->db->bind('tanggal_absen', $tanggal_absen);
      return $this->db->single();
   }
   public function update_password($nik, $hashed_password)
   {
      $sql = "UPDATE users SET password=:password WHERE nik_user=:nik";
      $this->db->query($sql);
      $this->db->bind('password', $hashed_password);
      $this->db->bind('nik', $nik);
      $this->db->execute();
      return true;
   }

   // RFID BUKA/TUTUP -----------------
   public function get_rfid_status()
   {
      $sql = "SELECT rfid_masuk_buka, rfid_masuk_tutup, rfid_pulang_buka, rfid_pulang_tutup FROM settingan LIMIT 1";
      $this->db->query($sql);
      return $this->db->single();
   }

   public function update_rfid_jadwal($data)
   {
      $sql = "UPDATE settingan SET 
                rfid_masuk_buka = :rfid_masuk_buka, 
                rfid_masuk_tutup = :rfid_masuk_tutup,
                rfid_pulang_buka = :rfid_pulang_buka, 
                rfid_pulang_tutup = :rfid_pulang_tutup
              WHERE id = 1";
      $this->db->query($sql);
      $this->db->bind('rfid_masuk_buka', $data['rfid_masuk_buka']);
      $this->db->bind('rfid_masuk_tutup', $data['rfid_masuk_tutup']);
      $this->db->bind('rfid_pulang_buka', $data['rfid_pulang_buka']);
      $this->db->bind('rfid_pulang_tutup', $data['rfid_pulang_tutup']);
      return $this->db->execute();
   }
}
