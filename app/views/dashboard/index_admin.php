<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<div class="row">
   <div class="col-lg-6 text-center">
      <div class="card card-primary card-outline" style="margin-top:10px; height:auto; min-height:110px">
         <div class="card-body box-profile">
            <h5 class="description-header">
               <span id="jam" style="color: black;"> <?php echo $hari . ", " . $tgl . " " . $bulan . " " . $tahun; ?></span>
               <span id="jam" style="color: black;">
                  <div id="clock" style="margin-bottom: -10px;"></div>
               </span>
            </h5>
         </div>
      </div>
   </div>

   <div class="col-lg-6 text-center">
      <div class="card card-primary card-outline" style="margin-top:10px; height:auto; min-height:110px">
         <div class="card-body box-profile">
            <h5 class="description-header">
               <?php
               require_once APPROOT . '/helpers/location_helper.php';
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
                  // IP cocok = langsung WFO
                  echo "<span id='wfo-status-box' data-ip-wfo='1' style='color: black;'><span class='blink'>Anda sedang berada di lingkungan Sekolah</span>";
                  echo "<br />";
                  echo "<span style='font-size:28px;font-weight:bold'>WFO</span><br/>";
               else :
                  // IP tidak cocok = tampilkan placeholder, JS akan update berdasarkan GPS
                  echo "<span id='wfo-status-box' data-ip-wfo='0' style='color: black;'><span class='blink' id='wfo-status-text'>Mendeteksi lokasi Anda...</span>";
                  echo "<br />";
                  echo "<span id='wfo-status-label' style='font-size:28px;font-weight:bold'>...</span><br/>";
               endif;
               ?>
            </h5>
         </div>
      </div>
   </div>
</div>


<div class="row">
   <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
         <div class="inner">
            <h3> <?= count($data['jumlahkaryawan']); ?> </h3>
            <p><b>Guru & Karyawan</b></p>
         </div>
         <div class="icon">
            <i class="fa fa-users"></i>
         </div>
         <a href="<?= URLROOT ?>/pegawai" class="small-box-footer"><b>Lihat</b> <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
         <div class="inner">
            <h3> <?= count($data['jumlahwfo']); ?> </h3>
            <p><b>Work From Office</b></p>
         </div>
         <div class="icon">
            <i class="fa fa-check-square"></i>
         </div>
         <a href="<?= URLROOT ?>/presensi/daftar_hadir_wfo" class="small-box-footer"><b>Lihat</b> <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
         <div class="inner">
            <h3> <?= count($data['jumlahwfh']); ?> </h3>
            <p><b>Work From Home</b></p>
         </div>
         <div class="icon">
            <i class="fa fa-plus-square"></i>
         </div>
         <a href="<?= URLROOT ?>/presensi/daftar_hadir_wfh" class="small-box-footer"><b>Lihat</b> <i class="fas fa-arrow-circle-right"></i></a>
      </div>
   </div>
   <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
         <div class="inner">
            <h3> <?= $data['jumlahbelum']; ?> </h3>
            <p><b>Belum Absen</b></p>
         </div>
         <div class="icon">
            <i class="fa fa-window-close"></i>
         </div>
         <a href="<?= URLROOT ?>/presensi/belum_absen" class="small-box-footer"><b>Lihat</b> <i class="fas fa-arrow-circle-right"></i></a>
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
               <span class="info-box-text"><b>WF-Office</b></span>
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
               <span class="info-box-text"><b>WF-Home</b></span>
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



<div class="row">
   <div class="col-12 col-sm-9 col-md-9">
      <div class="small-box coba90" style="padding:10px;text-align:left;">
         <?= $data['settingan']->home_dosen ?>
      </div>
   </div>
   <div class="col-12 col-sm-3 col-md-3">
      <div class="small-box coba90" style="padding:10px;text-align:left;">
         <?= $data['settingan']->kontak ?>
      </div>
   </div>
</div>