<li class="nav-header"><b>PRESENSI</b></li>

<li class="nav-item">
   <a href="<?= URLROOT ?>" class="nav-link">
      <i class="nav-icon fas fa-home"></i>
      <p>Beranda</p>
   </a>
</li>

<?php if ($_SESSION['kunci'] != '1') { ?>
   <!-- MENU PEGAWAI ---------------------------- -->
   <?php if ($_SESSION['role'] == 'pegawai') { ?>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/presensi/daftar-hadir" class="nav-link">
            <i class="nav-icon fa fa-check-square"></i>
            <p>Daftar Hadir</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/rekap/rekap" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>Presensi Bulan Ini</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/rekap/bulan" class="nav-link">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>Rekap Presensi Saya</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/pegawai/saya" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Profil Saya</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/pegawai/send_wa" class="nav-link">
            <i class="nav-icon fas fa-paper-plane"></i>
            <p>Notifikasi WA</p>
         </a>
      </li>

      <li class="nav-header"><b>DAR</b></li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/dar/laporan" class="nav-link">
            <i class="nav-icon fas fa-retweet"></i>
            <p>Daily Activity Report</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/dar/admin" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Report Karyawan</p>
         </a>
      </li>

      <?php if ((Middleware::admin('kepala_sekolah') || (Middleware::admin('dar')))) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/admin/DAR" class="nav-link">
               <i class="nav-icon fas fa-user"></i>
               <p>Admin DAR</p>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/dar/wajib" class="nav-link">
               <i class="nav-icon fas fa-user"></i>
               <p>Daftar Wajib DAR</p>
            </a>
         </li>
      <?php } ?>

      <li class="nav-header"><b>AKTIVITAS</b></li>
      <?php if (Middleware::admin('duplikat') || ($_SESSION['username']) == '14820018') { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/device" class="nav-link">
               <i class="nav-icon fas fa-database"></i>
               <p>Device Presensi</p>
            </a>
         </li>
      <?php } ?>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/presensi/hari_libur" class="nav-link">
            <i class="nav-icon fas fa-arrow-up"></i>
            <p>Hari Libur</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/presensi/ajukan_izin" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Ajukan Izin Kerja</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/presensi/izin_jam_kerja" class="nav-link">
            <i class="nav-icon fas fa-envelope-open-text"></i>
            <p>Izin Keluar Jam kerja</p>
         </a>
      </li>

      <li class="nav-header"><b>PRESENSI MENGAJAR</b></li>
      <!--
   <li class="nav-item">
      <a href="<?= URLROOT ?>/absen/absen" class="nav-link">
         <i class="nav-icon fa fa-edit"></i>
         <p>Presensi Mengajar</p>
      </a>
   </li>
   -->
      <li class="nav-item">
         <a href="<?= URLROOT ?>/jadwal/absen" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>Presensi Mengajar</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/absen/jurnal_mengajar" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Jurnal Mengajar</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/absen/izin_mengajar" class="nav-link">
            <i class="nav-icon fa fa-pen"></i>
            <p>Izin Tidak Mengajar</p>
         </a>
      </li>

      <!-- versi biasa
   <li class="nav-item">
      <a href="<?= URLROOT ?>/absen/izin" class="nav-link">
         <i class="nav-icon fa fa-pen"></i>
         <p>Izin Tidak Mengajar</p>
      </a>
   </li>
   -->

      <?php if (Middleware::admin('kepala_sekolah')) { ?>
         <li class="nav-header"><b>LAPORAN</b></li>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/rekap_jam_kerja" class="nav-link">
               <i class="nav-icon fas fa-file"></i>
               <p>Rekap Jam Pegawai</p>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/rekap_wfo_wfh" class="nav-link">
               <i class="nav-icon fas fa-calendar"></i>
               <p>WFO / WFH Pegawai</p>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/daftar_izin" class="nav-link">
               <i class="nav-icon fas fa-user-check"></i>
               <p>Izin Pegawai</p>
            </a>
         </li>
      <?php } ?>

      <?php
      $this->db = new Database;
      $sql = "SELECT distinct(wali_kelas) from jadwal_lengkap group by wali_kelas";
      $this->db->query($sql);
      $wali = $this->db->resultSet();
      $wali_kelas_array = array_column($wali, 'wali_kelas');
      ?>

      <li class="nav-header"><b>SISWA</b></li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/siswa/presensi_harian" class="nav-link">
            <i class="nav-icon fa fa-users" aria-hidden="true"></i>
            <p>Presensi Harian Siswa</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/siswa/rekap_presensi" class="nav-link">
            <i class="nav-icon fa fa-users" aria-hidden="true"></i>
            <p>Presensi Kelas Siswa</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/siswa" class="nav-link">
            <i class="nav-icon fa fa-users" aria-hidden="true"></i>
            <p>Data Siswa</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/siswa/status" class="nav-link">
            <i class="nav-icon fa fa-users" aria-hidden="true"></i>
            <p>Status Siswa</p>
         </a>
      </li>

      <?php if (in_array($_SESSION['nik'], $wali_kelas_array)) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/siswa/kelas_saya" class="nav-link">
               <i class="nav-icon fa fa-users" aria-hidden="true"></i>
               <p>Presensi Kelas Saya</p>
            </a>
         </li>

         <li class="nav-item">
            <a href="<?= URLROOT ?>/siswa/izin_siswa" class="nav-link">
               <i class="nav-icon fa fa-users" aria-hidden="true"></i>
               <p>Izin Siswa</p>
            </a>
         </li>
      <?php } ?>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/siswa/izin_today" class="nav-link">
            <i class="nav-icon fa fa-users" aria-hidden="true"></i>
            <p>Siswa Izin Hari ini</p>
         </a>
      </li>

      <?php if (Middleware::admin('kurikulum')) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/siswa/cek_rfid" class="nav-link">
               <i class="nav-icon fa fa-users" aria-hidden="true"></i>
               <p>Cek Kartu RFID</p>
            </a>
         </li>
      <?php } ?>

      <li class="nav-header"><b>KURIKULUM</b></li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/jadwal/jadwal" class="nav-link">
            <i class="nav-icon fa fa-calendar" aria-hidden="true"></i>
            <p>Jadwal Pelajaran</p>
         </a>
      </li>

      <?php if (in_array($_SESSION['nik'], $wali_kelas_array)) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/jadwal/kelas_saya" class="nav-link">
               <i class="nav-icon fa fa-check-double" aria-hidden="true"></i>
               <p>Kelas Saya</p>
            </a>
         </li>
      <?php } ?>

      <?php if (Middleware::admin('kurikulum') || (Middleware::admin('kepala_sekolah'))) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/absen/rekap_mengajar" class="nav-link">
               <i class="nav-icon fa fa-folder"></i>
               <p>Rekap Mengajar</p>
            </a>
         </li>
      <?php } ?>

      <?php if (Middleware::admin('kurikulum')) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/jadwal/pelajaran" class="nav-link">
               <i class="nav-icon fas fa-flask"></i>
               <p>Mata Pelajaran</p>
            </a>
         </li>
      <?php } ?>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/jadwal/prodi" class="nav-link">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>Program Studi</p>
         </a>
      </li>

      <li class="nav-item">
         <a href="<?= URLROOT ?>/jadwal/wali_kelas" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Wali Kelas</p>
         </a>
      </li>

      <?php if (Middleware::admin('kurikulum')) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/jadwal/guru_aktif" class="nav-link">
               <i class="nav-icon fas fa-user-circle"></i>
               <p>Guru / Pengajar</p>
            </a>
         </li>

         <li class="nav-item">
            <a href="<?= URLROOT ?>/absen/izin_guru" class="nav-link">
               <i class="nav-icon fa fa-file"></i>
               <p>Izin Mengajar Guru</p>
            </a>
         </li>

         <li class="nav-item">
            <a href="<?= URLROOT ?>/admin/kurikulum" class="nav-link">
               <i class="nav-icon fa fa-cog"></i>
               <p>Admin Kurikulum</p>
            </a>
         </li>
      <?php } ?>

      <li class="nav-header"><b>PEGAWAI</b></li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/pegawai" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Guru dan Pegawai</p>
         </a>
      </li>

      <?php if (Middleware::admin('lab')) { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/pegawai/ip_address" class="nav-link">
               <i class="nav-icon fas fa-wifi"></i>
               <p>
                  &nbsp; Atur IP Address
               </p>
            </a>
         </li>
      <?php } ?>

      <li class="nav-header"><b>MASUKAN ANDA</b></li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/backup/pendapat_saya" class="nav-link">
            <i class="nav-icon fas fa-question"></i>
            <p>Pendapat Saya</p>
         </a>
      </li>
      <li class="nav-item">
         <a href="<?= URLROOT ?>/skatel/Presensi.pdf" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Tutorial</p>
         </a>
      </li>

      <?php if ($_SESSION['nik'] == '14820018') { ?>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/jadwal/jadwal" class="nav-link">
               <i class="nav-icon fas fa-folder"></i>
               <p>Jadwal</p>
            </a>
         </li>

         <li class="nav-item">
            <a href="<?= URLROOT ?>/siswa" class="nav-link">
               <i class="nav-icon fas fa-folder"></i>
               <p>Siswa</p>
            </a>
         </li>

         <li class="nav-item">
            <a href="<?= URLROOT ?>/backup/notif" class="nav-link">
               <i class="nav-icon fas fa-folder"></i>
               <p>Notif</p>
            </a>
         </li>
      <?php } ?>


   <?php } ?>
<?php } else { ?>
   <!-- AKUN TERKUNCI ---->
<?php } ?>




<!-- MENU ADMIN ---------------------------- -->
<?php if ($_SESSION['role'] == 'admin') { ?>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/daftar_hadir" class="nav-link">
         <i class="nav-icon fas fa-calendar-check"></i>
         <p>Daftar Hadir</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/today" class="nav-link">
         <i class="nav-icon fas fa-list"></i>
         <p>Hari ini</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/isikan_presensi" class="nav-link">
         <i class="nav-icon fas fa-plus-square"></i>
         <p>Isikan Presensi</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/pegawai/send_wa" class="nav-link">
         <i class="nav-icon fas fa-paper-plane"></i>
         <p>Notifikasi WA</p>
      </a>
   </li>

   <li class="nav-header"><b>LAPORAN</b></li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/hari_libur" class="nav-link">
         <i class="nav-icon fas fa-retweet"></i>
         <p>Hari Libur</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="#" class="nav-link">
         <i class="nav-icon fas fa-user-clock"></i>
         <p>Rekap Presensi
            <i class="fas fa-angle-down right"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/rekap_jam_kerja" class="nav-link">
               <i class="nav-icon fas fa-x"></i>
               <p>
                  Rekap Jam
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/rekap_wfo_wfh" class="nav-link">
               <i class="nav-icon fas fa-x"></i>
               <p>
                  Rekap WFO / WFH
               </p>
            </a>
         </li>
      </ul>
   </li>


   <li class="nav-item">
      <a href="#" class="nav-link">
         <i class="nav-icon fas fa-user-check"></i>
         <p>
            Izin Kerja
            <i class="fas fa-angle-down right"></i>
         </p>
      </a>
      <ul class="nav nav-treeview">
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/daftar_izin" class="nav-link">
               <i class="nav-icon fas fa-x"></i>
               <p>
                  Izin / Sakit / Cuti
               </p>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= URLROOT ?>/presensi/permohonan_izin" class="nav-link">
               <i class="nav-icon fas fa-x"></i>
               <p>
                  Permohonan Izin
               </p>
            </a>
         </li>
      </ul>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/rekap_cuti" class="nav-link">
         <i class="nav-icon fas fa-edit"></i>
         <p>Rekap Cuti</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/izin_jam_kerja" class="nav-link">
         <i class="nav-icon fas fa-envelope-open-text"></i>
         <p>Izin Keluar Jam kerja</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/absen/rekap_mengajar" class="nav-link">
         <i class="nav-icon fas fa-edit"></i>
         <p>Rekap Mengajar</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/absen/izin_guru" class="nav-link">
         <i class="nav-icon fas fa-pen"></i>
         <p>Izin Mengajar</p>
      </a>
   </li>

   <li class="nav-header"><b>PENGATURAN</b></li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/pegawai" class="nav-link">
         <i class="nav-icon fas fa-users"></i>
         <p>
            Pegawai
         </p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/admin" class="nav-link">
         <i class="nav-icon fas fa-user-plus"></i>
         <p>
            Admin Aplikasi
         </p>
      </a>
   </li>

   <!--
   <li class="nav-item">
      <a href="<?= $_url ?>user" class="nav-link">
         <i class="nav-icon fas fa-user-plus"></i>
         <p>
            User Aplikasi
         </p>
      </a>
   </li>
-->

   <li class="nav-item">
      <a href="<?= URLROOT ?>/pegawai/master_jam_all" class="nav-link">
         <i class="nav-icon fas fa-user-clock"></i>
         <p>
            Default Jam Kerja
         </p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/pegawai/ip_address" class="nav-link">
         <i class="nav-icon fas fa-wifi"></i>
         <p>
            &nbsp; Atur IP Address
         </p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/dashboard/setting" class="nav-link">
         <i class="nav-icon fas fa-wrench"></i>
         <p>
            &nbsp; Setting Aplikasi
         </p>
      </a>
   </li>

   <li class="nav-header"><b>MASUKAN ANDA</b></li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/backup/pendapat_pegawai" class="nav-link">
         <i class="nav-icon fas fa-question"></i>
         <p>Pendapat Pegawai</p>
      </a>
   </li>

   <!--
   <li class="nav-item">
      <a href="<?= $_url ?>karyawan/jab" class="nav-link">
         <i class="nav-icon fas fa-user-lock"></i>
         <p>
            Master Jabatan
         </p>
      </a>
   </li>
-->



   <li class="nav-item">
      <a href="<?= URLROOT ?>/siswa" class="nav-link">
         <i class="nav-icon fas fa-folder"></i>
         <p>Siswa</p>
      </a>
   </li>


<?php } ?>



<!-- MENU SISWA ---------------------------- -->
<?php if ($_SESSION['role'] == 'siswa') { ?>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/siswa/saya" class="nav-link">
         <i class="nav-icon fas fa-user"></i>
         <p>Profil Saya</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/jadwal/jadwal_pelajaran" class="nav-link">
         <i class="nav-icon fa fa-calendar" aria-hidden="true"></i>
         <p>Jadwal Pelajaran</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/siswa/absen_kelas" class="nav-link">
         <i class="nav-icon fa fa-check-double" aria-hidden="true"></i>
         <p>Absen Kelas</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/siswa/pengajuan_izin" class="nav-link">
         <i class="nav-icon fa fa-file" aria-hidden="true"></i>
         <p>Pengajuan Izin</p>
      </a>
   </li>
<?php } ?>



<!-- MENU KHUSUS ---------------------------- -->
<?php if ($_SESSION['username'] == 'SB003') { ?>
   <li class="nav-header"><b>KHUSUS</b></li>
   <li class="nav-item">
      <a href="<?= $_url ?>pahdi/all" class="nav-link">
         <i class="nav-icon fas fa-edit"></i>
         <p>All</p>
      </a>
   </li>
<?php } ?>


<!-- MENU SATPAM ---------------------------- -->
<?php if ($_SESSION['role'] == 'satpam') { ?>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/presensi/daftar-hadir" class="nav-link">
         <i class="nav-icon fa fa-check-square"></i>
         <p>Daftar Hadir</p>
      </a>
   </li>

   <li class="nav-item">
      <a href="<?= URLROOT ?>/rekap/rekap" class="nav-link">
         <i class="nav-icon fas fa-list"></i>
         <p>Presensi Bulan Ini</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/rekap/bulan" class="nav-link">
         <i class="nav-icon fas fa-folder-open"></i>
         <p>Rekap Presensi Saya</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/pegawai/saya" class="nav-link">
         <i class="nav-icon fas fa-user"></i>
         <p>Profil Saya</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="<?= URLROOT ?>/pegawai/send_wa" class="nav-link">
         <i class="nav-icon fas fa-paper-plane"></i>
         <p>Notifikasi WA</p>
      </a>
   </li>
<?php } ?>