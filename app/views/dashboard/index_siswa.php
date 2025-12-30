<head>
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   <link href="<?= URLROOT ?>/dist/css/metro-icons.css" rel="stylesheet">
</head>
<?php
require APPROOT . '../../public/dist/lib/ip.php';

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

$year = date('Y');
$month = date('m');
$total = 0;
$totallibur = 0;
$ttllbur = 0;
$totallibur_all = 0;
$number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$days = [
   "Sunday" => "Minggu",
   "Monday" => "Senin",
   "Tuesday" => "Selasa",
   "Wednesday" => "Rabu",
   "Thursday" => "Kamis",
   "Friday" => "Jum'at",
   "Saturday" => "Sabtu"
];
?>

<div class="row">
   <div class="col">
      <div class="card card-primary card-outline" style="margin-top:10px;">
         <div class="card-body text-center" style="padding:10px; line-height:23px">
            <div style="font-size:25px;" class="mb-1">
               <b><?= $_SESSION['nama'] ?></b>
            </div>
            <div>
               Kelas : <b><?= $data['siswa']->kelas_siswa ?></b>
            </div>
            <div>
               Wali Kelas : <b><?= $data['wali_kelas']->nama ?></b>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="row">
   <div class="col-lg-6">
      <div class="row">
         <div class="col">
            <div class="card card-outline card-danger">
               <div class="card-body" style="padding:15px">
                  <div class="row">
                     <?php
                     if (date('D') == 'Sat' || date('D') == 'Sun') { ?>
                        <div class="col-lg-6 col-6">
                           <div class="small-box bg-success" style="margin-bottom:0px; background-color:black;opacity: 0.7;">
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

                        <?php
                     }
                     //--- SELAIN SABTU atau MINGGU -----------------------------------------------------
                     else {
                        //--- JIKA BELUM MELAKUKAN PRESENSI --------------------------------------------
                        if (!$data['cek_absen_siswa']) :
                           if ($ada) {
                        ?>
                              <div class="col-lg-6 col-6">
                                 <div class="small-box bg-success" style="margin-bottom:0px;">
                                    <div class="inner" style="height:150px;">
                                       <b>PRESENSI DATANG</b>
                                       <div class="text-center mt-2">
                                          Klik tombol "Tekan disini"<br />Untuk melakukan Presensi
                                       </div>
                                    </div>
                                    <div class="icon d-block">
                                       <i>
                                          <ion-icon name="push-outline"></ion-icon>
                                       </i>
                                    </div>
                                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-success">
                                       <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
                                    </a>
                                 </div>
                              </div>
                              <!-- BUKAN WIFI SEKOLAH --------------------------------- -->
                           <?php } else { ?>
                              <div class="col-lg-6 col-6">
                                 <div class="small-box bg-success" style="margin-bottom:0px;">
                                    <div class="inner" style="height:150px;">
                                       <b>PRESENSI DATANG</b>
                                       <div class="text-center mt-2">
                                          Klik tombol "Tekan disini"<br />Untuk melakukan Presensi
                                       </div>
                                    </div>
                                    <div class="icon d-block">
                                       <i>
                                          <ion-icon name="push-outline"></ion-icon>
                                       </i>
                                    </div>
                                    <a href="#" class="small-box-footer" data-toggle="modal" data-target="#modal-wifi">
                                       <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini... </b>
                                    </a>
                                 </div>
                              </div>
                           <?php } ?>

                           <?php
                        //--- JIKA SUDAH MELAKUKAN PRESENSI --------------------------------------------	
                        else :
                           foreach ($data['cek_absen_siswa'] as $field) {
                              // JIKA hari Libur -------------------------------------------------------------------
                              if ($field->nis_ahs == 'all') { ?>
                                 <div class="col-lg-6 col-6">
                                    <div class="small-box bg-gray" style="background-color:black;opacity: 0.7; margin-bottom:0px;">
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
                              <?php
                              }
                              // JIKA SEDANG IZIN -----------------------------------------------------
                              else if (($field->nis_ahs == $_SESSION['nik']) and (($field->status_ahs == 'Izin') or ($field->status_ahs == 'Sakit'))) { ?>
                                 <div class="col-lg-6 col-6">
                                    <div class="small-box bg-gray" style="background-color:black;opacity: 0.7;margin-bottom:0px;">
                                       <div class="inner" style="height:150px;">
                                          <b><span class="tile-label">Hari ini anda sedang <?= $field->status_ahs ?> <br /> <?= $field->keterangan ?>
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
                              <?php
                              }
                              // JIKA SUDAH ABSEN DATANG -----------------------------------------------------
                              else {
                              ?>
                                 <div class="col-lg-6 col-6">
                                    <div class="small-box bg-success" style="margin-bottom:0px;">
                                       <div class="inner" style="height:150px;">
                                          <span class="tile-label"><b>Hari ini <br />Anda Sudah Mengisi Presensi HADIR<br /> Pada Jam <?= $field->jam_masuk_ahs ?></b>
                                             <div class="mt-3 text-center d-none d-sm-block">
                                                <b>SMA Bisa..!!!</b>
                                             </div>
                                          </span>
                                       </div>
                                       <div class="icon d-block">
                                          <i>
                                             <ion-icon name="push-outline"></ion-icon>
                                          </i>
                                       </div>
                                       <a href="#" class="small-box-footer disabled" disabled>
                                          <b>Selamat Belajar <i class="fas fa-arrow-circle-up"></i></b>
                                       </a>
                                    </div>
                                 </div>
                     <?php }
                           }
                        endif;
                     } ?>


                     <div class="col-lg-6 col-6">
                        <div class="small-box bg-warning" style="margin-bottom:0px;">
                           <div class="inner" style="height:150px;">
                              <b>DAFTAR HADIR SISWA</b>
                              <div>
                                 <b>Kelas : <?= $data['siswa']->kelas_siswa ?></b>
                              </div>
                           </div>
                           <div class="icon d-block">
                              <i>
                                 <ion-icon name="people-circle-outline"></ion-icon>
                              </i>
                           </div>
                           <a href="<?= URLROOT ?>/presensi/teman_hadir" class="small-box-footer">
                              <i class="fas fa-arrow-circle-right"></i> <b>Tekan disini...</b>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col">
            <div class="card card-outline card-primary">
               <div class="card-body" style="padding:15px;">

                  <div style="margin-top:-7px" class="mb-3">
                     <?php
                     if (isset($_GET['kelas'])) {
                        $kelas = $_GET['kelas'];
                     } else {
                        $kelas = 'dash';
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
                     ?>
                     <div style=" margin-top:0px !important; font-family:'Trebuchet MS', 'Lucida Sans Unicode' , 'Lucida Grande' , 'Lucida Sans' , Arial, sans-serif; font-size:0.65em; font-weight:bold" class="mb-2">
                        Dari tanggal :
                        <input type="date" class="textini" value="<?= $mulai ?>" id="mulai" onchange="submitForm()">
                        s/d
                        <input type="date" class="textini" value="<?= $sampai ?>" id="sampai" onchange="submitForm()">
                        &nbsp;
                        <a href="<?= URLROOT ?>" class="btn btn-danger btn-sm tombol2 khusus2"><i class="fa fa-undo"></i> &nbsp;Reset</a>
                     </div>
                  </div>
                  <script>
                     var kelas = '<?= $kelas ?>';

                     function submitForm() {
                        var mulai = document.getElementById('mulai').value;
                        var sampai = document.getElementById('sampai').value;
                        window.location.href = '<?= URLROOT ?>/index_siswa?kelas=' + kelas + '&mulai=' + mulai + '&sampai=' + sampai;
                     }
                  </script>

                  <div class="text-center mb-2">
                     <b>Rekap Ketidakhadiran di kelas</b>
                  </div>
                  <div style="margin-bottom:-10px">
                     <table class="table tabel3 khusus">
                        <tr>
                           <th colspan="2" class="bg-danger">Alpa</th>
                           <th colspan="2" class="bg-primary">Izin</th>
                           <th colspan="2" class="bg-success">Sakit</th>
                        </tr>
                        <tr>
                           <th style="width:16%" class="bg-danger">Per JP</th>
                           <th style="width:17%" class="bg-danger">[Hari]</th>
                           <th style="width:16%" class="bg-primary">Per JP</th>
                           <th style="width:18%" class="bg-primary">[Hari]</th>
                           <th style="width:16%" class="bg-success">Per JP</th>
                           <th style="width:17%" class="bg-success">[Hari]</th>
                        </tr>

                        <?php
                        $alpa = $this->Msiswa->rekap_presensi($_SESSION['nik'], $mulai, $sampai);
                        ?>
                        <tr>
                           <td class="text-center bg-danger">
                              <?php if ($alpa) {
                                 echo $alpa->alpa;
                              } else {
                                 echo "-";
                              }
                              ?>
                           </td>
                           <td class="text-center bg-danger">
                              <?php if ($alpa) {
                                 echo convertNumber($alpa->alpa);
                              } else {
                                 echo "-";
                              } ?>
                           </td>
                           <td class="text-center bg-primary">
                              <?php if ($alpa) {
                                 echo $alpa->izin;
                              } else {
                                 echo "-";
                              }
                              ?>
                           </td>
                           <td class="text-center bg-primary">
                              <?php if ($alpa) {
                                 echo convertNumber($alpa->izin);
                              } else {
                                 echo "-";
                              }
                              ?>
                           </td>
                           <td class="text-center bg-success">
                              <?php if ($alpa) {
                                 echo $alpa->sakit;
                              } else {
                                 echo "-";
                              }
                              ?>
                           </td>
                           <td class="text-center bg-success">

                           </td>
                        </tr>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <div class="col-lg-6">
      <div class="card card-success card-outline">
         <div class="card-body">
            <div class="text-center mb-3">
               <b>Presensi Kehadiran Bulan ini</b>
            </div>
            <div class="table-responsive">
               <table class="table tabel4 table-striped">
                  <thead style="background-color:brown !important; color:white">
                     <tr>
                        <th style="width: 20%; height:40px">Hari</th>
                        <th style="width: 20%;">Tanggal</th>
                        <th style="width: 20%;">Absen</th>
                        <th style="width: 20%;">Jam</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     for ($x = 1; $x <= $number_of_days; $x++) {
                        $hari = date("l", strtotime($x . "-" . $month . "-" . $year));
                        $hari = $days[$hari] ?? $hari;
                        $bulan2 = date("m", strtotime($x . "-" . $month . "-" . $year));
                        $tanggal2 = str_pad($x, 2, "0", STR_PAD_LEFT);
                        $tanggal3 = $year . "-" . $bulan2 . "-" . $tanggal2;
                        $absen = isset($data['absensi_by_date'][$tanggal3]) ? $data['absensi_by_date'][$tanggal3] : null;
                        $status = $absen ? $absen->status_ahs : '-';
                        $jam_hadir = $absen ? $absen->jam_masuk_ahs : '';
                        $catatan = ($jam_hadir && strtotime($jam_hadir) > strtotime('07:45:00')) ? 'Telat' : '';
                     ?>
                        <tr>
                           <?php
                           //-- Jika sabtu dan minggu --------------------------------- --
                           if (($hari == "Sabtu") || ($hari == "Minggu")) {
                              echo "<td style='background:#bbbbbb '></td>";
                              echo "<td style='background:#bbbbbb;'></td>";
                              echo "<td style='background:#bbbbbb '></td>";
                              echo "<td style='background:#bbbbbb;'></td>";
                              echo "<td style='background:#bbbbbb;'></td>";
                           } else { ?>
                              <!-- Hari belajar normal ------------------------------- -->
                              <td class="tengah"><?= $hari ?></td>
                              <td class="no-wrap tengah"> <?= date3ID($tanggal3) ?> </td>
                              <td class="text-center"><?= $status ?></td>
                              <td class="text-center"><?= $jam_hadir ?></td>
                              <td class="text-center"><?= $catatan ?></td>
                           <?php } ?>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
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
         <form method="post" action="<?= URLROOT ?>/dashboard/hadir_siswa">
            <input type="hidden" name="kelas" value="<?= $data['siswa']->kelas_siswa ?>">
            <input type="hidden" name="wali_kelas" value="<?= $data['wali_kelas']->wali_kelas ?>">
            <input type="hidden" name="semester_aktif" value="<?= $data['semester_aktif']->id_jadwal_setting ?>">
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



<!-- Modal harus WIFI sekolah -->
<div class="modal fade" id="modal-wifi">
   <div class="modal-dialog">
      <div class="modal-content bg-danger">
         <div class="modal-header">
            <span class="huruf" style="font-size:20px; color: white;font-weight:bold;">PERHATIAN..!!!</span>
         </div>
         <form method="post" action="<?= URLROOT ?>/dashboard/hadir_siswa">
            <div class="modal-body text-center" style="color:white; font-weight:bold; font-size:20px">
               <br />
               Presensi hanya bisa disini dengan koneksi WIFI sekolah...!!!<br />
               Koneksikan HP/Laptop anda dengan WIFI Sekolah
               <br />
               <br />
            </div>
            <div class="modal-footer justify-content-between">
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

<style>
   .khusus th {
      height: 36px;
   }

   .khusus td {
      height: 36px;
      vertical-align: middle;
   }

   .khusus2 {
      font-size: 0.73em !important;
   }
</style>

<?php
function convertNumber($number)
{
   if ($number <= 0) {
      return 0;
   } elseif ($number >= 1 && $number <= 9) {
      return 0;
   } elseif ($number == 10 || ($number >= 11 && $number <= 17)) {
      return 1;
   } elseif ($number >= 18 && $number <= 20) {
      return 2;
   } else {
      return floor($number / 10);
   }
}
