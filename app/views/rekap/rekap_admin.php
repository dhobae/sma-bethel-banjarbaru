<?php
require APPROOT . '../../public/dist/lib/ip.php';
$bulanindo = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <?php
      if ($_SESSION['role'] == 'admin') {
         echo "<div style='margin-top:-15px'>";
         echo "<a href='" . URLROOT . "/presensi/today' class='myButton11'> Kembali </a> ";
         echo "</div>";
      }
      ?>

      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         SMK Telkom Banjarbaru
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:18px; font-weight:bold; margin-top:-6px">
         Rekap Presensi : <?= $data['nm']->nama ?><br />
         [<?= $bulanindo[$month = date('m')] . "-" . $year = date('Y') ?>]
      </div>

      <div class="table-responsive">
         <table class="table tabel3 table-striped" id="example3">
            <thead style="background-color: brown; color:white">
               <tr>
                  <th style="width: 45px;" rowspan=2>No</th>
                  <th style="width: 100px;" rowspan=2>Hari</th>
                  <th rowspan=2>Tanggal</th>
                  <th style="width: 85px;" rowspan=2>Presensi</th>
                  <th colspan=2>Presensi Masuk</th>
                  <th colspan=2>Presensi Pulang</th>
                  <th rowspan=2 style="width: 70px;">Durasi</th>
               </tr>
               <tr>
                  <th style="width: 85px;">Jam</th>
                  <th style="width: 85px;">Status</th>
                  <th style="width: 85px;">Jam</th>
                  <th style="width: 85px;">Status</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $year = date('Y'); //Mengambil tahun saat ini
               $month = date('m'); //Mengambil bulan saat ini
               $total = 0;
               $totallibur = 0;
               $ttllbur = 0;
               $totallibur_all = 0;
               $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
               for ($x = 1; $x <= $number_of_days; $x++) {
                  //membuat nama hari
                  $hari = date("l", strtotime($x . "-" . $month . "-" . $year));
                  if ($hari == "Sunday") {
                     $hari = "Minggu";
                  } elseif ($hari == "Monday") {
                     $hari = "Senin";
                  } elseif ($hari == "Tuesday") {
                     $hari = "Selasa";
                  } elseif ($hari == "Wednesday") {
                     $hari = "Rabu";
                  } elseif ($hari == "Thursday") {
                     $hari = "Kamis";
                  } elseif ($hari == "Friday") {
                     $hari = "Jum'at";
                  } elseif ($hari == "Saturday") {
                     $hari = "Sabtu";
                  }

                  $bulan = date("F", strtotime($x . "-" . $month . "-" . $year));
                  if ($bulan == "January") {
                     $bulan = " Januari ";
                  } elseif ($bulan == "February") {
                     $bulan = " Februari ";
                  } elseif ($bulan == "March") {
                     $bulan = " Maret ";
                  } elseif ($bulan == "April") {
                     $bulan = " April ";
                  } elseif ($bulan == "May") {
                     $bulan = " Mei ";
                  } elseif ($bulan == "June") {
                     $bulan = " Juni ";
                  } elseif ($bulan == "July") {
                     $bulan = " Juli ";
                  } elseif ($bulan == "August") {
                     $bulan = " Agustus ";
                  } elseif ($bulan == "September") {
                     $bulan = " September ";
                  } elseif ($bulan == "October") {
                     $bulan = " Oktober ";
                  } elseif ($bulan == "November") {
                     $bulan = " November ";
                  } elseif ($bulan == "December") {
                     $bulan = " Desember ";
                  }

                  $bulan2 = date("m", strtotime($x . "-" . $month . "-" . $year));
                  $tanggal2 = str_pad($x, 2, "0", STR_PAD_LEFT);
                  $tanggal3 = $year . "-" . $bulan2 . "-" . $tanggal2;

               ?>
                  <tr>
                     <td style="text-align:center;"> <?= $x ?> </td>

                     <?php
                     $id = $_GET['data'];
                     if ($tanggal3 == date('Y-m-d')) {
                        echo "<td style='width: 80px;'>" . $hari . " | <a href='" . URLROOT . "/rekap/reset/" . $id . "/" . $tanggal3 . "'><b> Reset </b></a> </td>";
                     } else {
                        echo "<td style='width: 80px;'>" . $hari . "</td>";
                     }
                     ?>

                     <?php
                     if (($hari == "Sabtu") || ($hari == "Minggu")) {
                        echo "<td>" . tanggal_indo($tanggal3) . "</td>";
                        echo "<td colspan=6 style='text-align:center;background:#ffb2b2;'> Libur Akhir Pekan </td>";
                     } else {
                     ?>
                        <td style="width: 160px;"> <?= tanggal_indo($tanggal3) ?> </td>
                     <?php

                        $rekap_id_tanggal = $this->Mrekap->rekap_id_tanggal($tanggal3);

                        if ($rekap_id_tanggal) :
                           foreach ($rekap_id_tanggal as $field2) {
                              if ($field2->nik == "all") {
                                 echo "<td colspan=6 style='text-align:center;background:#F7EE5A;'>" . $field2->keterangan_libur . "</td>";

                                 $jam_libur_all = $data['jam_kerja']->jam_kerja;

                                 $detiklibur_all = $jam_libur_all * 3600;
                                 $ttllbur_all = $detiklibur_all;
                                 $totallibur_all = $totallibur_all + $ttllbur_all;
                              } else {
                                 echo "<td>" . $field2->status_masuk . "</td>";
                                 if (($field2->status_masuk == 'Izin') or ($field2->status_masuk == 'Cuti') or ($field2->status_masuk == 'TL') or ($field2->status_masuk == 'Sakit') or ($field2->status_masuk == 'Libur')) {
                                    echo "<td colspan='5'> - </td>";

                                    $jam_libur = $data['jam_kerja']->jam_kerja;

                                    $detiklibur = $jam_libur * 3600;
                                    $ttllbur = $detiklibur;
                                    $totallibur = $totallibur + $ttllbur;
                                 } else {
                                    echo "<td>" . $field2->jam_masuk . "</td>";
                                    echo "<td>" . $field2->from_masuk . "</td>";
                                    echo "<td>" . $field2->jam_pulang . "</td>";
                                    echo "<td>" . $field2->from_pulang . "</td>";

                                    $waktu_awal = strtotime($field2->jam_masuk);
                                    $waktu_akhir = strtotime($field2->jam_pulang);

                                    $diff   = $waktu_akhir - $waktu_awal;
                                    if ($diff < 0) {
                                       $diff = 0;
                                    } else {
                                       $diff = $diff;
                                    }

                                    $jam    = floor($diff / (60 * 60));
                                    $menit  = $diff - $jam * (60 * 60);
                                    if ($diff < 0) {
                                       echo "<td width='100px;'>0</td>";
                                    } else {
                                       echo "<td width='100px;'>" . $jam .  '.' . floor($menit / 60) . " jam</td>";
                                    }
                                    $total = $total + $diff;
                                 }
                              }
                           }
                        else : {
                              echo "<td>-</td>";
                              echo "<td>-</td>";
                              echo "<td>-</td>";
                              echo "<td>-</td>";
                              echo "<td>-</td>";
                              echo "<td>-</td>";
                           }
                        endif;
                     }
                     ?>
                  </tr>

               <?php } ?>

            </tbody>
         </table>
      </div>
      <?php

      $jam_kerja = $data['jam_kerja']->jam_kerja;
      $hari_kerja = $data['jam_kerja']->hari_kerja;

      //Total Jam kerja sebulan
      $detikkerja = $jam_kerja * $hari_kerja * 3600;
      $jamkerja = floor($detikkerja / (60 * 60));
      $menitkerja = ($detikkerja - $jamkerja * (60 * 60)) / 60;

      //Total jam Kerja sebulan
      $detik1  = $total;
      $jam1    = floor($total / (60 * 60));
      $menit1  = ($total - $jam1 * (60 * 60)) / 60;

      //Jam Izin atau Sakit atau Cuti atau Libur
      $ttllibur = $totallibur + $totallibur_all;
      $jamlbr    = floor($ttllibur / (60 * 60));
      $menitlbr  = ($ttllibur - $jamlbr * (60 * 60)) / 60;


      //Kurang jam 
      $detik2 = $detikkerja - ($detik1 + $ttllibur);
      $jamkurang = floor($detik2 / (60 * 60));
      $menitkurang  = ($detik2 - $jamkurang * (60 * 60)) / 60;
      ?>

      <style>
         .tabelbawah {
            font-family: Trebuchet MS;
            font-weight: Bold;
            font-size: 12px;
         }
      </style>

      <span class="tabelbawah"><u>Keterangan :</u></span>
      <p>
      <table>
         <tr>
            <td class="tabelbawah">Total Jam Kerja Perbulan</td>
            <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
            <td class="tabelbawah"><?= $jamkerja ?> Jam, <?= floor($menitkerja) ?> Menit</td>
         </tr>
         <tr>
            <td class="tabelbawah">Total Jam Kerja Anda</td>
            <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
            <td class="tabelbawah"><?= $jam1 ?> jam, <?= floor($menit1) ?> Menit</td>
         </tr>
         <tr>
            <td class="tabelbawah">Jam Libur/Izin/Sakit/Cuti/TL</td>
            <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
            <td class="tabelbawah"><?= $jamlbr ?> jam, <?= floor($menitlbr) ?> Menit</td>
         </tr>
         <tr>
            <td colspan="3">-----------------------------------------------------------</td>
         </tr>
         <tr>
            <td class="tabelbawah">Kekurangan Jam Kerja Anda</td>
            <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
            <td class="tabelbawah"><?= $jamkurang ?> jam, <?= floor($menitkurang) ?> Menit</td>
         </tr>
         <tr>
            <td colspan="3">-----------------------------------------------------------</td>
         </tr>

      </table>

   </div>
</div>




<script>
   $(function() {
      $("#example3").DataTable({
         "lengthChange": true,
         "lengthMenu": [
            [10, 25, 50, 100, 150, 200, -1],
            [10, 25, 50, 100, 150, 200, "All"]
         ],
         "responsive": true,
         "autoWidth": false,
         "pageLength": 80,
         "searching": true,
         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
   });
</script>


<style>
   .dataTables_wrapper .dt-buttons button {
      background-color: #A1A1A1;
      color: white;
      border: none;
      border-radius: 0px;
      padding: 2px 8px;
      margin-right: -2px;
      cursor: pointer;
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      font-size: 0.75em;
   }

   .dataTables_wrapper .dt-buttons button:hover {
      background-color: #45a049;
   }

   .dataTables_wrapper .dt-buttons button:active {
      background-color: #3e8e41;
   }
</style>