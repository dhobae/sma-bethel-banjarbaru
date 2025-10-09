<head>
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <link href="<?= URLROOT ?>/dist/css/metro-icons.css" rel="stylesheet">
</head>

<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>


<?php



if ($_SESSION['role'] != 'admin') {
   if (isset($_SESSION['password_change_required']) && $_SESSION['password_change_required'] === true) {
      if ($data['notif']->status_notif == '1') {
         echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
         echo '<script>';
         echo 'Swal.fire({
               icon: "' . $data['notif']->icon . '",
               title: "' . $data['notif']->title . '",
               text: "' . $data['notif']->text . '",
               confirmButtonText: "' . $data['notif']->isi_tombol . '",
               confirmButtonColor: "' . $data['notif']->warna_tombol . '",
               background: "' . $data['notif']->background . '",
               customClass: {
                  title: "warna-title",
                  content: "warna-konten"
               }
            }).then(function() {
               window.location.href = "pegawai/send_wa";
            });';
         echo '</script>';
         unset($_SESSION['password_change_required']);
      }
   }
}
?>
<style>
   .warna-title {
      color: <?= $data['notif']->warna_title ?>;
   }

   .warna-konten {
      color: <?= $data['notif']->warna_konten ?>;
   }
</style>

<audio id="myAudio">
   <source src="<?= URLROOT ?>/dist/file/bell.wav" type="audio/wav">
   Your browser does not support the audio element.
</audio>

<div class="row">
   <div class="col-lg-6 text-center d-none d-md-block d-lg-block">
      <div class="card card-primary card-outline" style="margin-top:10px; height:auto; min-height:90px">
         <div class="card-body box-profile" style="padding:7px">
            <h5 class="description-header">
               <span id="jam" style="color: black; font-size:1em"> <?php echo $hari . ", " . $tgl . " " . $bulan . " " . $tahun; ?></span>
               <span id="jam" style="color: black;">
                  <div id="clock" style="margin-bottom: -10px;"></div>
               </span>
            </h5>
         </div>
      </div>
   </div>

   <div class="col-lg-6 text-center">
      <div class="card card-primary card-outline" style="margin-top:10px; height:auto; min-height:90px">
         <div class="card-body box-profile" style="padding:7px">
            <h5 class="description-header">
               <?php
               get_client_ip();
               $ipnya = get_client_ip();
               $i = 0;
               $ada = 0;

               foreach ($data['ip'] as $field_ip) {
                  $i++;
                  if (ip_in_range2($ipnya, $field_ip->ip_address)) {
                     $status[$i] = 1;
                  } else {
                     $status[$i] = 0;
                  }
                  $ada = $ada + $status[$i];
               }
               if ($ada > 0) :
                  echo "<span id='jam3' style='color: black;'><span class='blink'>Anda sedang berada di lingkungan Sekolah</span>";
                  echo "<br />";
                  echo "<span style='font-size:28px;font-weight:bold'>WFO</span><br/>";
               else :
                  echo "<span id='jam3' style='color: black;'><span class='blink'>Anda berada di luar lingkungan Sekolah</span>";
                  echo "<br />";
                  echo "<span style='font-size:28px;font-weight:bold'>WFH</span><br/>";
               endif;
               ?>
            </h5>
         </div>
      </div>
   </div>
</div>


<!--
<?php //if ($_SESSION['role'] != 'admin') {
//$wajib_absen = $this->Mdashboard->wajib_absen($_SESSION['nik']);
//if ($wajib_absen->absen == 'Tidak') {
?>
      <div class="row" style="margin-top:0px">
         <div class="col text-center">
            <div class="card card-danger card-outline">
               <div class="card-body box-profile" style="font-size:25px; font-family:'calibri'; color:red; font-weight:bold">
                  <span class="blink">Anda tidak diwajibkan melakukan Absen Harian</span>
               </div>
            </div>
         </div>
      </div>
<?php //}
//} 
?>
-->

<?php $ada_izin = count($data['ada_izin']) ?>

<?php if ($ada_izin > 0) { ?>
   <?php if ($_SESSION['role'] != 'admin') { ?>
      <div class="row" style="margin-top:0px">
         <div class="col text-center">
            <div class="card">
               <div class="card-body box-profile bg-warning" style="font-size:25px; font-family:'calibri'; color:red; font-weight:bold; padding:10px">
                  <span class="blink">Ada permohonan izin dari siswa yang belum di proses</span>
               </div>
            </div>
         </div>
      </div>
   <?php } ?>
<?php } ?>


<style>
   @keyframes blink {
      0% {
         opacity: 1;
      }

      50% {
         opacity: 0.5;
      }

      100% {
         opacity: 1;
      }
   }

   .blinking {
      animation: blink 2s infinite;
   }
</style>


<?php
$npk_usernya = $_SESSION['nik'];
?>
<div class="row">
   <?php
   //--- JIKA SABTU atau MINGGU -----------------------------------------------------
   if (date('D') == 'Sat' || date('D') == 'Sun') { ?>
      <div class="col-lg-3 col-6">
         <div class="small-box bg-success" style="background-color:black;opacity: 0.7;">
            <div class="inner" style="height:150px;">
               <b>Hari ini adalah hari libur<br />PRESENSI KEHADIRAN <br />di nonaktifkan </b>
            </div>
            <div class="icon d-block">
               <i>
                  <ion-icon name="push-outline"></ion-icon>
               </i>
            </div>
            <a href="#" class="small-box-footer disabled">
               <b>Selamat Beristirahat <i class="fas fa-arrow-circle-up"></i></b>
            </a>
         </div>
      </div>

      <div class="col-lg-3 col-6">
         <div class="small-box bg-danger" style="background-color:black;opacity: 0.7;">
            <div class="inner" style="height:150px;">
               <b>Hari ini adalah hari libur<br />PRESENSI PULANG <br />di nonaktifkan </b>
            </div>
            <div class="icon d-block">
               <i>
                  <ion-icon name="download-outline"></ion-icon>
               </i>
            </div>
            <a href="#" class="small-box-footer disabled">
               <b>Selamat Beristirahat <i class="fas fa-arrow-circle-up"></i></b>
            </a>
         </div>
      </div>
      <?php
   }
   //--- SELAIN SABTU atau MINGGU -----------------------------------------------------
   else {
      //--- JIKA BELUM MELAKUKAN PRESENSI --------------------------------------------
      if (!$data['cek_absen']) :
      ?>

         <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
               <div class="inner" style="height:150px;">
                  <b>PRESENSI DATANG</b>
                  <?php if (!$ada) { ?>
                     <div class="inner" style="height:150px;">
                        <span class="tile-label">
                           <br />
                           <b>Presensi hanya bisa diisi dengan koneksi WIFI Sekolah</b>
                        </span>
                     </div>
                  <?php } ?>
               </div>
               <div class="icon d-block">
                  <i>
                     <ion-icon name="push-outline"></ion-icon>
                  </i>
               </div>
               <?php if ($ada) { ?>
                  <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-success">
                     <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
                  </a>
               <?php } else { ?>
                  <a href="#" class="small-box-footer disabled">
                     <i class="fas fa-arrow-circle-right"></i> <b>Bukan WIFI Sekolah... </b>
                  </a>
               <?php } ?>
            </div>
         </div>

         <div class="col-lg-3 col-6">
            <div class="small-box bg-danger" style="opacity:0.8;">
               <div class="inner" style="height:150px;">
                  <b>PRESENSI PULANG</b>
               </div>
               <div class="icon d-block">
                  <i>
                     <ion-icon name="download-outline"></ion-icon>
                  </i>
               </div>
               <a href="#" class="small-box-footer disabled" disabled>
                  <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
               </a>
            </div>
         </div>

         <?php
      //--- JIKA SUDAH MELAKUKAN PRESENSI --------------------------------------------	
      else :
         foreach ($data['cek_absen'] as $field) {
            // JIKA hari Libur -------------------------------------------------------------------
            if ($field->nik == 'all') { ?>
               <div class="col-lg-3 col-6">
                  <div class="small-box bg-gray" style="background-color:black;opacity: 0.7;">
                     <div class="inner" style="height:150px;">
                        <b><span class="tile-label">Hari ini adalah hari libur <br /> <?= $field->keterangan; ?> <br />
                              PRESENSI KEHADIRAN <br />
                              Di nonaktifkan
                           </span></b>
                     </div>
                     <div class="icon d-block">
                        <i>
                           <ion-icon name="push-outline"></ion-icon>
                        </i>
                     </div>
                     <a href="#" class="small-box-footer disabled">
                        <b>Selamat Hari Libur <i class="fas fa-arrow-circle-up"></i></b>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-6">
                  <div class="small-box bg-gray" style="background-color:black;opacity: 0.7;">
                     <div class="inner" style="height:150px;">
                        <b><span class="tile-label">Hari ini adalah hari libur <br /> <?= $field->keterangan ?> <br />
                              PRESENSI PULANG <br />
                              Di nonaktifkan
                           </span></b>
                     </div>
                     <div class="icon d-block">
                        <i>
                           <ion-icon name="download-outline"></ion-icon>
                        </i>
                     </div>
                     <a href="#" class="small-box-footer disabled">
                        <b>Selamat Hari Libur <i class="fas fa-arrow-circle-up"></i></b>
                     </a>
                  </div>
               </div>
            <?php
            }
            // JIKA SEDANG IZIN -----------------------------------------------------
            else if (($field->nik == $npk_usernya) and (($field->status_masuk == 'Izin') or ($field->status_masuk == 'Cuti') or ($field->status_masuk == 'TL') or ($field->status_masuk == 'Sakit'))) { ?>
               <div class="col-lg-3 col-6">
                  <div class="small-box bg-gray" style="background-color:black;opacity: 0.7;">
                     <div class="inner" style="height:150px;">
                        <b><span class="tile-label">Hari ini anda sedang <?= $field->status_masuk ?> <br /> <?= $field->keterangan ?>
                              PRESENSI KEHADIRAN <br />
                              Di nonaktifkan
                           </span></b>
                     </div>
                     <div class="icon d-block">
                        <i>
                           <ion-icon name="push-outline"></ion-icon>
                        </i>
                     </div>
                     <a href="#" class="small-box-footer disabled">
                        <b>Selamat Beraktivitas <i class="fas fa-arrow-circle-up"></i></b>
                     </a>
                  </div>
               </div>
               <div class="col-lg-3 col-6">
                  <div class="small-box bg-gray" style="background-color:black;opacity: 0.7;">
                     <div class="inner" style="height:150px;">
                        <b><span class="tile-label">Hari ini anda sedang <?= $field->status_masuk ?> <br /> <?= $field->keterangan ?>
                              PRESENSI PULANG <br />
                              Di nonaktifkan
                           </span></b>
                     </div>
                     <div class="icon d-block">
                        <i>
                           <ion-icon name="download-outline"></ion-icon>
                        </i>
                     </div>
                     <a href="#" class="small-box-footer disabled">
                        <b>Selamat Beraktivitas <i class="fas fa-arrow-circle-up"></i></b>
                     </a>
                  </div>
               </div>
            <?php
            }
            // JIKA SUDAH ABSEN DATANG -----------------------------------------------------
            else {
            ?>
               <div class="col-lg-3 col-6">
                  <div class="small-box bg-success">
                     <div class="inner" style="height:150px;">
                        <span class="tile-label"><b>Hari ini <br />Anda Sudah Mengisi Presensi HADIR<br /> Pada Jam <?= $field->jam_masuk ?> <br />Status : <?= $field->from_masuk ?> </b>
                        </span>
                     </div>
                     <div class="icon d-block">
                        <i>
                           <ion-icon name="push-outline"></ion-icon>
                        </i>
                     </div>
                     <a href="#" class="small-box-footer disabled" disabled>
                        <b>Selamat Bekerja <i class="fas fa-arrow-circle-up"></i></b>
                     </a>
                  </div>
               </div>

               <?php
               if ($field->jam_pulang == '00:00:00') {
               ?>
                  <div class="col-lg-3 col-6">
                     <div class="small-box bg-danger">
                        <div class="inner" style="height:150px;">
                           <a onclick="document.getElementById('absenpulang').style.display='block'">
                              <b>PRESENSI PULANG</b>
                           </a>
                           <?php if (!$ada) { ?>
                              <div class="inner" style="height:150px;">
                                 <span class="tile-label">
                                    <br />
                                    <b>Presensi hanya bisa diisi dengan koneksi WIFI Sekolah</b>
                                 </span>
                              </div>
                           <?php } ?>
                        </div>
                        <div class="icon d-block">
                           <i>
                              <ion-icon name="download-outline"></ion-icon>
                           </i>
                        </div>
                        <?php if ($ada) { ?>
                           <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-danger">
                              <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
                           </a>
                        <?php } else { ?>
                           <a href="#" class="small-box-footer disabled">
                              <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
                           </a>
                        <?php } ?>
                     </div>
                  </div>
               <?php
               } else { ?>
                  <div class="col-lg-3 col-6">
                     <div class="small-box bg-danger">
                        <div class="inner" style="height:150px;">
                           <b>
                              Hari ini<br />Anda Sudah Mengisi Presensi PULANG<br />
                              Pada Jam <?= $field->jam_pulang ?> <br />
                              Status : <?= $field->from_pulang ?>
                           </b>
                        </div>
                        <div class="icon d-block">
                           <i>
                              <ion-icon name="download-outline"></ion-icon>
                           </i>
                        </div>
                        <a href="#" class="small-box-footer disabled">
                           <b>Selamat Beristirahat <i class="fas fa-arrow-circle-right"></i></b>
                        </a>
                     </div>
                  </div>
   <?php
               }
            }
         }
      endif;
   }
   ?>




   <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
         <div class="inner" style="height:150px;">
            <b>ABSEN SAYA BULAN INI</b>
         </div>
         <div class="icon d-block">
            <i>
               <ion-icon name="server-outline"></ion-icon>
            </i>
         </div>
         <a href="<?= URLROOT ?>/rekap/rekap" class="small-box-footer">
            <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
         </a>
      </div>
   </div>




   <div class="col-lg-3 col-6">
      <div class="small-box bg-primary">
         <div class="inner" style="height:150px;">
            <b>DAFTAR HADIR</b>
         </div>
         <div class="icon d-block">
            <i>
               <ion-icon name="people-circle-outline"></ion-icon>
            </i>
         </div>
         <a href="<?= URLROOT ?>/presensi/daftar-hadir" class="small-box-footer">
            <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini...</b>
         </a>
      </div>
   </div>

</div>




<div style="margin-top:-10px;">
   <div class="row">
      <div class="col-6 col-sm-6 col-md-2">
         <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
               <span class="info-box-text"><b>Pegawai</b></span>
               <span class="info-box-number">
                  <?= count($data['jumlahkaryawan']); ?>
               </span>
            </div>
         </div>
      </div>
      <div class="col-6 col-sm-6 col-md-2">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-building"></i></span>
            <div class="info-box-content">
               <span class="info-box-text"><b>Dari Sekolah</b></span>
               <span class="info-box-number">
                  <?= count($data['jumlahwfo']); ?>
               </span>
            </div>
         </div>
      </div>

      <div class="clearfix hidden-md-up"></div>

      <div class="col-6 col-sm-6 col-md-2">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-home"></i></span>

            <div class="info-box-content">
               <span class="info-box-text"><b>Dari Rumah</b></span>
               <span class="info-box-number">
                  <?= count($data['jumlahwfh']); ?>
               </span>
            </div>
         </div>
      </div>
      <div class="col-6 col-sm-6 col-md-2">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-door-open"></i></span>
            <div class="info-box-content">
               <span class="info-box-text"><b>Belum Abs.</b></span>
               <span class="info-box-number">
                  <?= $data['jumlahbelum']; ?>
               </span>
            </div>
         </div>
      </div>

      <div class="col-6 col-sm-6 col-md-2">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hospital"></i></span>
            <div class="info-box-content">
               <span class="info-box-text"><b>Izin</b></span>
               <span class="info-box-number">
                  <?= count($data['jumlahizin']); ?>
               </span>
            </div>
         </div>
      </div>

      <div class="col-6 col-sm-6 col-md-2">
         <div class="info-box mb-3">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-folder-open"></i></span>
            <div class="info-box-content">
               <span class="info-box-text"><b>Cuti</b></span>
               <span class="info-box-number">
                  <?= count($data['jumlahcuti']); ?>
               </span>
            </div>
         </div>
      </div>
   </div>
</div>


<?php
$diff = 0;
$total = 0;
foreach ($data['absen_kerja'] as $d) :

   $month = date('m', strtotime($d->tanggal));
   $year = date('Y', strtotime($d->tanggal));
   $jam_k = $this->Mdashboard->jam_kerja_bydate($month, $year);

   $timestamp1 = strtotime($d->tanggal);
   $dayOfWeek = date('N', $timestamp1);
   if ($dayOfWeek == 5) {
      $beban = $jam_k->jam_kerja_jumat;
      $istirahat = $jam_k->jam_istirahat_jumat;
   } else {
      $beban = $jam_k->jam_kerja;
      $istirahat = $jam_k->jam_istirahat;
   }
   $istirahatDetik = $istirahat * 3600;

   $waktu_awal = strtotime($d->jam_masuk);
   $waktu_akhir = strtotime($d->jam_pulang);
   $diff   = $waktu_akhir - $waktu_awal;
   $diff -= $istirahatDetik;

   if ($diff < 0) {
      $diff = 0;
   } else {
      $diff = $diff;
   }
   $jam    = floor($diff / (60 * 60));
   $menit  = $diff - $jam * (60 * 60);
   $total = $total + $diff;
endforeach;

$month2 = date('m');
$year2 = date('Y');

if (isset($jam_k)) {
   $jam_k_normal = $jam_k->jam_kerja * hari_normal($month2, $year2);
   $jam_k_jumat = $jam_k->jam_kerja_jumat * hari_jumat($month, $year);
   $ttl_jam_kerja = $jam_k_normal + $jam_k_jumat;


   $jam1 = floor($total / 3600);
   $persen = ($jam1 / $ttl_jam_kerja) * 100;
} else {
   $persen = 0;
}
?>

<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-body" style="padding:10px 10px 15px !important">
            <div class="huruf2 mb-2"><b>Progres Presensi saya bulan ini</b></div>
            <div class="progress" style="height:30px">
               <div class="progress-bar bg-danger progress-bar-striped" style="width:<?= $persen ?>%;" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span style="font-size:15px"><b><?= round($persen) ?>%</b></span></div>
            </div>
         </div>
      </div>
   </div>
</div>



<style>
   .coba90 ul {
      display: block;
      list-style-type: disc;
      margin-top: -0.8em;
      margin-bottom: 0.5em;
      margin-left: 0;
      margin-right: 0;
      padding-left: 40px;
   }
</style>

<div class="row">
   <div class="col-12 col-sm-9 col-md-9">
      <div class="small-box coba90" style="padding:10px;text-align:left;">
         <?= $data['settingan']->home_dosen ?>
      </div>
   </div>
   <div class="col-12 col-sm-3 col-md-3">
      <div class="small-box coba90 bg-danger" style="padding:10px;text-align:left;">
         <?= $data['settingan']->kontak ?>
      </div>
   </div>
</div>





<!-- Modal Absen Datang -->
<div class="modal fade" id="modal-success">
   <div class="modal-dialog">
      <div class="modal-content bg-success">
         <div class="modal-header">
            <span class="huruf" style="font-size:20px; color: black;font-weight:bold;">PRESENSI KEHADIRAN</span>
         </div>
         <form method="post" action="<?= URLROOT ?>/dashboard/hadir">
            <div class="modal-body" style="color:black;">
               <center>
                  <input type="hidden" name="loc_masuk" id="loc_masuk" />
                  <b>
                     Selamat Pagi <br />
                     <h3> <span id="jam"> <?= $_SESSION['nama'] ?> </span> </h3>
                     Anda akan melakukan Presensi Kehadiran untuk Hari/Tanggal
                     <br />
                     <span id="jam2">
                        <?php echo $hari . ", " . $tgl . " " . $bulan . " " . $tahun; ?>
                     </span>
                     </br>
                  </b>
               </center>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="submit" class="btn btn-danger btn-sm" name="hadirkan" onclick="window.navigator.vibrate(300);"> Presensi Masuk </button>
               <button type="button" class="btn btn-outline-light btn-sm" data-dismiss="modal"> Keluar </button>
            </div>
         </form>
      </div>
   </div>
</div>


<!-- Modal Absen Pulang -->
<div class="modal fade" id="modal-danger">
   <div class="modal-dialog">
      <div class="modal-content bg-danger">
         <div class="modal-header">
            <span class="huruf" style="font-size:20px; font-weight:bold;">PRESENSI PULANG</span>
         </div>
         <form method="post" action="<?= URLROOT ?>/dashboard/pulang">
            <div class="modal-body">
               <center>
                  <input type="hidden" name="loc_pulang" id="loc_pulang" />
                  <b>
                     Selamat Siang/Sore <br />
                     <h3> <span id="jam" style="color:white !important;"> <?= $_SESSION['nama'] ?> </span> </h3>
                     Anda akan melakukan Presensi Pulang untuk Hari/Tanggal
                     <br />
                     <span id="jam2" style="color:white !important;">
                        <?php echo $hari . ", " . $tgl . " " . $bulan . " " . $tahun; ?>
                     </span>
                     </br>
                  </b>
               </center>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="submit" class="btn btn-outline-light btn-sm" name="pulangkan" onclick="window.navigator.vibrate(300);"> Presensi Pulang </button>
               <button type="button" class="btn btn-outline-light btn-sm" data-dismiss="modal"> Keluar </button>
            </div>
         </form>
      </div>
   </div>
</div>