<?php
require APPROOT . '../../public/dist/lib/ip.php';
$tanggal = date("Y-m-d");
$hari   = date('l', microtime($tanggal));
$hari_indonesia = array(
   'Monday'  => 'Senin',
   'Tuesday'  => 'Selasa',
   'Wednesday' => 'Rabu',
   'Thursday' => 'Kamis',
   'Friday' => 'Jumat',
   'Saturday' => 'Sabtu',
   'Sunday' => 'Minggu'
);
?>

<center>
   <div style="line-height:1.2">
      <img src="<?= URLROOT ?>/dist/gambar/stmik-baru.png" width="60px"><br />
      <span style="font-family:calibri; font-size: 12pt;font-weight:bold;">Daftar Hadir : <?= $hari_indonesia[$hari] ?>, <?= tanggal_indo($tanggal) ?> </span><br />
      <span style="font-family:calibri;">Sekolah Tinggi Manajemen Informatika dan Komputer (STMIK) Banjarbaru</span>
   </div>
</center>

<div class="mb-3 mt-2 text-center" style="font-weight:bold; font-size:24px;">
   WORK FROM HOME (WFH)
</div>

<div class="row">

   <?php
   $tanggal = date("Y-m-d");
   $karyawan_wfh = $this->Mpresensi->karyawan_wfh_byid($tanggal);
   $no = 1;
   if ($karyawan_wfh) :
      foreach ($karyawan_wfh as $field) :
         $npknya = $field->npk;

         $karyawan_wfh_nik_tanggal = $this->Mpresensi->karyawan_wfh_npk_tanggal($npknya, $tanggal);

         if ($karyawan_wfh_nik_tanggal) :
            foreach ($karyawan_wfh_nik_tanggal as $field2) {
               // masuk belum pulang
               if (($field2->status_masuk == 'Hadir') and ($field2->status_pulang == '-')) {
                  // Atur WFH dizinkan atau tidak
                  if (($_SESSION['role'] == 'admin') and ($field2->from_masuk == 'WFH')) {
                     echo "<a href='" . URLROOT . "presensi/wfh-status/" . $field->npk . "'>";
                  } else {
                     echo "<a href='#'>";
                  }
   ?>
                  <!-- ABSEN MASUK DAN BELUM PULANG ---------------------------- -->
                  <?php
                  // ABSEN MASUK WFO ---------------------------- 
                  if ($field2->from_masuk == 'WFO') { ?>
                     <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                        <div class="small-box bg-success">
                           <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                              <p><b><span style="font-family:calibri; font-size:1em;">
                                       <?= $field->nama; ?> </span>
                                 </b></p>
                           </div>
                           <div class="icon d-block">
                              <i class="fas fa-user"></i>
                           </div>
                           <a href="#" class="small-box-footer">
                              <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                                 <?= $field2->status_masuk; ?> |
                                 <?= $field2->from_masuk; ?> |
                                 <?= $field2->keterangan; ?> |
                                 <?= substr($field2->jam_masuk, 0, 5); ?>
                              </span>
                           </a>
                        </div>
                     </div>
                  <?php
                  } else
                  // ABSEN MASUK WFH ---------------------------- 
                  { ?>
                     <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                        <div class="small-box bg-info">
                           <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                              <p><b><span style="font-family:calibri; font-size:1em;">
                                       <?= $field->nama; ?>
                                    </span></b></p>
                           </div>
                           <div class="icon d-block">
                              <i class="fas fa-user"></i>
                           </div>
                           <a href="#" class="small-box-footer">
                              <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                                 <?= $field2->status_masuk; ?> |
                                 <?= $field2->from_masuk; ?> |
                                 <?= $field2->keterangan; ?> |
                                 <?= substr($field2->jam_masuk, 0, 5); ?>
                              </span>
                           </a>
                        </div>
                     </div>
                  <?php
                  }
               }
               // masuk dan sudah pulang
               else if (($field2->status_masuk == 'Hadir') and ($field2->status_pulang == 'Pulang')) { ?>

                  <!-- SUDAH PULANG ---------------------------- -->
                  <div class="col-lg-2 col-6" style="padding: 0px 3px; opacity:0.9;">
                     <div class="small-box bg-gray">
                        <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                           <p><b><span style="font-family:calibri; font-size:1em;">
                                    <?= $field->nama; ?>
                                 </span></b></p>
                        </div>
                        <div class="icon d-block">
                           <i class="fas fa-user"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                           <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                              <?= $field2->status_pulang; ?> |
                              <?= $field2->from_pulang; ?> |
                              <?= $field2->keterangan; ?> |
                              <?= substr($field2->jam_pulang, 0, 5); ?>
                           </span>
                        </a>
                     </div>
                  </div>

                  <?php
               }
               // jika tidak masuk
               else {
                  // JIKA IZIN dan belum jam pulang ----------------------
                  if (date('H:i:s', time()) < date('14:00:00')) { ?>
                     <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                        <div class="small-box bg-warning">
                           <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                              <p><b><span style="font-family:calibri; font-size:1em;">
                                       <?= $field->nama; ?>
                                    </span></b></p>
                           </div>
                           <div class="icon d-block">
                              <i class="fas fa-user"></i>
                           </div>
                           <a href="#" class="small-box-footer">
                              <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                                 <?= $field2->status_masuk; ?>
                              </span>
                           </a>
                        </div>
                     </div>
                  <?php
                  }
                  // JIKA IZIN dan sudah jam pulang ----------------------
                  else { ?>
                     <div class="col-lg-2 col-6" style="padding: 0px 3px; opacity:0.9;">
                        <div class="small-box bg-gray">
                           <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                              <p><b><span style="font-family:calibri; font-size:1em;">
                                       <?= $field->nama; ?>
                                    </span></b></p>
                           </div>
                           <div class="icon d-block">
                              <i class="fas fa-user"></i>
                           </div>
                           <a href="#" class="small-box-footer">
                              <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                                 <?= $field2->status_masuk; ?> | Jam Pulang
                              </span>
                           </a>
                        </div>
                     </div>

            <?php
                  }
               }
            }
         // Yang Belum Absen
         else :
            ?>
            <div class="col-lg-2 col-6" style="padding: 0px 3px; opacity:0.5;">
               <div class="small-box bg-secondary">
                  <div class="inner" style="height: 80px; text-align:left;line-height:1.2;">
                     <p><b><span style="font-family:calibri; font-size:1em;">
                              <?= $field->nama; ?>
                           </span></b></p>
                  </div>
                  <div class="icon d-block">
                     <i class="fas fa-user"></i>
                  </div>
                  <a href="#" class="small-box-footer">
                     <span style="font-family:calibri;font-weight:bold;font-size:10pt"> Belum Absen </span>
                  </a>
               </div>
            </div>
   <?php
         endif;

      endforeach;
   else :
      echo "Data tidak ditemukan	";
   endif;
   ?>

</div>

</div>
</div>
</div>
</body>





<!-- Modal Edit aktifkan ---------------------------------------------------------------------------------------------->
<div class="example-modal">
   <div id="modalaktifkan" class="modal fade" role="dialog" style="display:none;">
      <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Akifkan/Nonaktifkan Absensi</h4>
            </div>

            isinya

         </div>
      </div>
   </div>
</div>
<!-- akhir Modal Edit aktifkan ---------------------------------------------------------------------------------------------->