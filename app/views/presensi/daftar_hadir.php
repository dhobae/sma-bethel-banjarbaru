<?php
// FUNGSI
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

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="mb-2 d-flex align-items-center">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
         <div class="ml-3 pt-3 mb-0" style="font-family:calibri; font-size: 1.2rem; font-weight:bold;">SMA Bethel Banjarbaru</div>
      </div>

      <div class="mb-3">
         <span style="font-family:calibri; font-size: 1.2rem; font-weight:bold;">Daftar Hadir : <?= $hari_indonesia[$hari] ?>, <?= tanggal_indo($tanggal) ?> </span>

         <?php if ($_SESSION['role'] == 'admin') { ?>
            <br />
            <a href="<?= URLROOT ?>/presensi/setting_urutan" class="btn btn-danger btn-sm tombol2" title="Atur susuan daftar"><i class="fa fa-sort"></i> &nbsp;Setting Urutan daftar hadir</a>
         <?php } ?>
      </div>




      <div class="row">
         <?php
         $tanggal = date("Y-m-d");
         $no = 1;
         if ($data['daftar']) :
            foreach ($data['daftar'] as $field) :
               $niknya = $field->nik;

               $daftar_byid_tanggal = $this->Mpresensi->daftar_byid_tanggal($niknya, $tanggal);

               if ($daftar_byid_tanggal) :
                  foreach ($daftar_byid_tanggal as $field2) {

                     // masuk belum pulang
                     if (($field2->status_masuk == 'Hadir') and ($field2->status_pulang == '-')) {
                        // Atur WFH dizinkan atau tidak
                        //if (($_SESSION['role'] == 'admin') and ($field2->from_masuk == 'WFH')) {
                        //   echo "<a href='" . URLROOT . "/presensi/wfh_status/" . $field->nik . "'>";
                        //} else {
                        //   echo "<a href='tes'>";
                        //}
         ?>
                        <!-- ABSEN MASUK DAN BELUM PULANG ---------------------------- -->
                        <?php
                        // ABSEN MASUK WFO ---------------------------- 
                        if ($field2->from_masuk == 'WFO') { ?>
                           <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                              <?php
                              if ($field2->jam_masuk > '08:30:00') {
                                 $warna = 'bg-pink';
                              } else {
                                 $warna = 'bg-success';
                              }
                              ?>
                              <div class="small-box <?= $warna ?>">
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
                              <?php
                              if ($field2->jam_masuk > '08:30:00') {
                                 $warna = 'bg-danger';
                              } else {
                                 $warna = 'bg-info';
                              }
                              ?>
                              <div class="small-box <?= $warna ?>">
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
                        if (date('H:i:s', time()) < date('16:00:00')) { ?>
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
                                       <?php
                                       if ($field2->status_masuk == 'Cuti2') {
                                          echo "Cuti alasan penting";
                                       } else {
                                          echo $field2->status_masuk;
                                       }
                                       ?>
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