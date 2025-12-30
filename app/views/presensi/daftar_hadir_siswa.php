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

      <div class="mb-2">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="90px"><br />
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
               $niknya = $field->nis;

               $daftar_byid_tanggal = $this->Mpresensi->daftar_byid_tanggal_siswa($niknya, $tanggal);

               if ($daftar_byid_tanggal) :
                  foreach ($daftar_byid_tanggal as $field2) {

                     // masuk belum pulang
                     if ($field2->status_ahs == 'Hadir') { ?>
                        <!-- SUDAH ABSEN MASUK ---------------------------- -->
                        <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                           <?php
                           $warna = 'bg-success';
                           ?>
                           <div class="small-box <?= $warna ?>">
                              <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                                 <p><b><span style="font-family:calibri; font-size:1em;">
                                          <?= $field->nama_siswa; ?> </span>
                                    </b></p>
                              </div>
                              <div class="icon d-block">
                                 <i class="fas fa-user"></i>
                              </div>
                              <a href="#" class="small-box-footer">
                                 <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                                    <?= $field2->status_ahs; ?> |
                                    <?= substr($field2->jam_masuk_ahs, 0, 5); ?>
                                 </span>
                              </a>
                           </div>
                        </div>
                     <?php
                     } else { ?>
                        <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                           <div class="small-box bg-warning">
                              <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                                 <p><b><span style="font-family:calibri; font-size:1em;">
                                          <?= $field->nama_siswa; ?>
                                       </span></b></p>
                              </div>
                              <div class="icon d-block">
                                 <i class="fas fa-user"></i>
                              </div>
                              <a href="#" class="small-box-footer">
                                 <span style="font-family:calibri;font-weight:bold;font-size:0.7em">
                                    <?= $field2->status_ahs; ?>
                                 </span>
                              </a>
                           </div>
                        </div>
                  <?php
                     }
                  }
               // Yang Belum Absen
               else :
                  ?>
                  <div class="col-lg-2 col-6" style="padding: 0px 3px; opacity:0.5;">
                     <div class="small-box bg-secondary">
                        <div class="inner" style="height: 80px; text-align:left;line-height:1.2;">
                           <p><b><span style="font-family:calibri; font-size:1em;">
                                    <?= $field->nama_siswa; ?>
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