<head>
   <title>Daftar Hadir SMA Bethel Banjarbaru</title>
   <link rel="shortcut icon" href="<?= URLROOT; ?>/smabethel/img/icon.png">
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <meta http-equiv="refresh" content="600">
</head>

<?php
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

<body>
   <div class="container-fluid mt-2">
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

                     // MASUK BELUM PULANG
                     if (($field2->status_masuk == 'Hadir') and ($field2->status_pulang == '-')) { ?>

                        <?php
                        // ABSEN MASUK WFO ---------------------------- 
                        if ($field2->from_masuk == 'WFO') {
                           if ($field2->jam_masuk > '08:30:00') {
                              $warna = 'bg-danger';
                           } else {
                              $warna = 'bg-success';
                           } ?>
                           <div class="utama">
                              <div class="circular-image">
                                 <?php if (!$field->avatar) { ?>
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle">
                                 <?php } ?>
                              </div>
                              <div class="isi <?= $warna ?> text-white shadow">
                                 <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
                                    <div class="col" style="text-align:left;padding-left:20px">
                                       <?= $field2->status_masuk; ?>
                                       <br />
                                       (<?= $field2->from_masuk; ?>)
                                    </div>
                                    <div class="col" style="text-align:right;padding-right:20px">
                                       WITA
                                       <br />
                                       <?= substr($field2->jam_masuk, 0, 5); ?>
                                    </div>
                                 </div>
                                 <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
                                    <div class=" col">
                                       <?= substr($field->nama, 0, 21); ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        <?php
                        } else
                        // ABSEN MASUK WFH ---------------------------- 
                        {
                           if ($field2->jam_masuk > '08:30:00') {
                              $warna = 'bg-danger';
                           } else {
                              $warna = 'bg-info';
                           }
                        ?>
                           <div class="utama">
                              <div class="circular-image">
                                 <?php if (!$field->avatar) { ?>
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle">
                                 <?php } ?>
                              </div>
                              <div class="isi <?= $warna ?> text-white shadow">
                                 <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
                                    <div class="col" style="text-align:left;padding-left:20px">
                                       <?= $field2->status_masuk; ?>
                                       <br />
                                       (<?= $field2->from_masuk; ?>)
                                    </div>
                                    <div class="col" style="text-align:right;padding-right:20px">
                                       WITA
                                       <br />
                                       <?= substr($field2->jam_masuk, 0, 5); ?>
                                    </div>
                                 </div>
                                 <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
                                    <div class=" col">
                                       <?= substr($field->nama, 0, 21); ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                     }
                     // masuk dan sudah pulang
                     else if (($field2->status_masuk == 'Hadir') and ($field2->status_pulang == 'Pulang')) { ?>
                        <!-- SUDAH PULANG ---------------------------- -->
                        <div class="utama">
                           <div class="circular-image">
                              <?php if (!$field->avatar) { ?>
                                 <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle" style="filter: grayscale(100%);">
                              <?php } else { ?>
                                 <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="filter: grayscale(100%);">
                              <?php } ?>
                           </div>
                           <div class="isi text-white shadow bg-secondary">
                              <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
                                 <div class="col" style="text-align:left;padding-left:20px">
                                    <?= $field2->status_pulang; ?>
                                    <br />
                                    (<?= $field2->from_pulang; ?>)
                                 </div>
                                 <div class="col" style="text-align:right;padding-right:20px">
                                    WITA
                                    <br />
                                    <?= substr($field2->jam_pulang, 0, 5); ?>
                                 </div>
                              </div>
                              <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
                                 <div class=" col">
                                    <?= substr($field->nama, 0, 21); ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php
                     }
                     // jika tidak masuk
                     else {
                        // JIKA IZIN dan belum jam pulang ----------------------
                        if (date('H:i:s', time()) < date('16:00:00')) { ?>


                           <div class="utama">
                              <div class="circular-image">
                                 <?php if (!$field->avatar) { ?>
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle">
                                 <?php } ?>
                              </div>
                              <div class="isi shadow bg-warning">
                                 <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
                                    <div class="col" style="text-align:left;padding-left:20px">
                                       Sedang<br />
                                       <?= $field2->status_masuk; ?>
                                    </div>
                                    <div class="col" style="text-align:right;padding-right:20px">
                                       &nbsp;
                                    </div>
                                 </div>
                                 <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
                                    <div class=" col">
                                       <?= substr($field->nama, 0, 21); ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        <?php
                        }
                        // JIKA IZIN dan sudah jam pulang ----------------------
                        else { ?>
                           <div class="utama">
                              <div class="circular-image">
                                 <?php if (!$field->avatar) { ?>
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya img-thumbnail rounded-circle" style="filter: grayscale(100%);">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya img-thumbnail rounded-circle" style="filter: grayscale(100%);">
                                 <?php } ?>
                              </div>
                              <div class="isi bg-secondary text-white shadow">
                                 <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
                                    <div class="col" style="text-align:left;padding-left:20px">
                                       Sedang<br />
                                       <?= $field2->status_masuk; ?>
                                    </div>
                                    <div class="col" style="text-align:right;padding-right:20px">
                                       &nbsp;
                                    </div>
                                 </div>
                                 <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
                                    <div class=" col">
                                       <?= substr($field->nama, 0, 21); ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                  <?php
                        }
                     }
                  }
               // Yang Belum Absen
               else :
                  ?>
                  <div class="utama">
                     <div class="circular-image">
                        <?php if (!$field->avatar) { ?>
                           <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle" style="filter: grayscale(100%);">
                        <?php } else { ?>
                           <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="filter: grayscale(100%);">
                        <?php } ?>
                     </div>
                     <div class="isi text-white shadow" style="background-color: #999;">
                        <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
                        <?php if (date('D') == 'Sat' || date('D') == 'Sun') : ?>
                           <div class="col" style="text-align:left;padding-left:20px">
                              Hari<br />Libur
                           </div>
                        <?php else : ?>
                           <div class="col" style="text-align:left;padding-left:20px">
                              Belum<br />Absen
                           </div>
                        <?php endif; ?>
                        <?php if (date('D') == 'Sat' || date('D') == 'Sun') : ?>
                           <div class="col" style="text-align:right;padding-right:20px">
                              WITA<br />00:00
                           </div>
                        <?php else : ?>
                           <div class="col" style="text-align:right;padding-right:20px">
                              WITA<br /><?= date('H:i'); ?>
                           </div>
                        <?php endif; ?>
                        </div>
                        <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
                           <div class=" col">
                              <?= substr($field->nama, 0, 21); ?>
                           </div>
                        </div>
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



   <!-- ASLI -------------------------
   <div class="utama">
      <div class="circular-image">
         <?php if (!$field->avatar) { ?>
            <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle" style="filter: grayscale(100%);">
         <?php } else { ?>
            <img src="<?= URLROOT ?>/smabethel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="filter: grayscale(100%);">
         <?php } ?>
      </div>
      <div class="isi text-white shadow" style="background-color: #999;">
         <div class="row" style="font-family: monospace; font-size:9px; padding:13px 15px 0px">
            <div class="col" style="text-align:left;padding-left:20px">
               Belum<br />Absen
            </div>
            <div class="col" style="text-align:right;padding-right:20px">
               WITA<br />10:15
            </div>
         </div>
         <div class="row" style="font-size:14px; font-family:monospace; padding-top:5px">
            <div class=" col">
               <?= substr($field->nama, 0, 21); ?>
            </div>
         </div>
      </div>
   </div>
   -->



   <div class="container-fluid">
      <div class="row mt-4">
         <?php
         $tgl = $data['tanggal'];
         ?>

         <?php for ($a = 1; $a < 4; $a++) { ?>
            <div class="col">
               <?php
               if ($data['kelas_data_' . $a]) {
                  foreach ($data['kelas_data_' . $a] as $kelas => $absen_kelas) {
               ?>
                     <table class="tabel">
                        <thead style="background-color:darkgreen; color:white; height:30px">
                           <tr style="font-size:11px; font-weight:bold; font-family:'calibri'">
                              <th>&nbsp;KLS&nbsp;</th>
                              <th class="text-nowrap" style="width:10%">JP 1</th>
                              <th class="text-nowrap" style="width:10%">JP 2</th>
                              <th class="text-nowrap" style="width:10%">JP 3</th>
                              <th class="text-nowrap" style="width:10%">JP 4</th>
                              <th class="text-nowrap" style="width:10%">JP 5</th>
                              <th class="text-nowrap" style="width:10%">JP 6</th>
                              <th class="text-nowrap" style="width:10%">JP 7</th>
                              <th class="text-nowrap" style="width:10%">JP 8</th>
                              <th class="text-nowrap" style="width:10%">JP 9</th>
                              <th class="text-nowrap" style="width:10%">JP 10</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           foreach ($absen_kelas as $d) :
                           ?>
                              <tr>
                                 <td style="vertical-align: middle; background-color:darkgreen; color:white">
                                    <span style="font-family: monospace; font-weight:bold; font-size:13px">
                                       <?= $d['kode_kelas'] ?>
                                    </span>
                                    <br />
                                    <span style="font-family: monospace; font-weight:bold; font-size:8px">
                                       &nbsp;
                                    </span>
                                 </td>
                                 <?php for ($i = 1; $i <= 10; $i++) : ?>
                                    <?php
                                    $cek_absen = $this->Mjadwal->cek_absen($tgl, $d['kelas'], $d['ruang'], $i);
                                    ?>
                                    <?php if ($cek_absen) {
                                       echo "<td style='background:#DDFFBD'>";
                                       echo "<span style='font-family:monospace; font-size:13px;'><b>" . str_replace([" X", " XI", " XII", "XI", "XII"], "", substr($d['singkatan' . $i], 0, 7)) . "</b></span>";
                                       echo "<br/>";
                                       echo "<span style='font-size:8px; font-family:monospace'>" . substr($d['nama' . $i], 0, 10) . "</span>";
                                       echo "</td>";
                                    } else {
                                       echo "<td>";
                                       echo "<span style='font-family:monospace; font-size:13px;'><b>" . str_replace([" X", " XI", " XII", "XI", "XII"], "", substr($d['singkatan' . $i], 0, 7)) . "</b></span>";
                                       echo "<br/>";
                                       echo "<span style='font-size:8px; font-family:monospace'>" . substr($d['nama' . $i], 0, 10) . "</span>";
                                       echo "</td>";
                                    } ?>
                                    </td>
                                 <?php endfor; ?>
                              </tr>
                           <?php $no++;
                           endforeach;
                           ?>
                        </tbody>
                     </table>
                  <?php } ?>
               <?php } else { ?>
                  <table class="tabel">
                     <thead style="background-color:darkgreen; color:white; height:30px">
                        <tr style="font-size:11px; font-weight:bold; font-family:'calibri'">
                           <th>&nbsp;KLS&nbsp;</th>
                           <th class="text-nowrap" style="width:10%">JP 1</th>
                           <th class="text-nowrap" style="width:10%">JP 2</th>
                           <th class="text-nowrap" style="width:10%">JP 3</th>
                           <th class="text-nowrap" style="width:10%">JP 4</th>
                           <th class="text-nowrap" style="width:10%">JP 5</th>
                           <th class="text-nowrap" style="width:10%">JP 6</th>
                           <th class="text-nowrap" style="width:10%">JP 7</th>
                           <th class="text-nowrap" style="width:10%">JP 8</th>
                           <th class="text-nowrap" style="width:10%">JP 9</th>
                           <th class="text-nowrap" style="width:10%">JP 10</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td colspan="11" style="height:230px">
                              <span style="font-size:20px; font-family:monospace">Tidak ada Jadwal</span>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               <?php } ?>
            </div>
         <?php } ?>
      </div>
   </div>




</body>











<style>
   body {
      background: url(smabethel/img/hexa.jpg) no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
   }


   .utama {
      border: 0px solid red;
      width: 180px;
      height: 117px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      position: relative;
      text-align: center;
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      font-size: 13px;
      margin: 5px;
      font-weight: bold;
   }

   .foto {
      height: 50%;
      border: 0px solid red;
      display: flex;
      justify-content: center;
      align-items: center;
   }

   .isi {
      margin-top: 40px;
      height: 60%;
      border: 0px solid blue;
      width: 100%;
      border-radius: 40px 40px 10px 10px;
   }

   .circular-image {
      width: 78px;
      height: 78px;
      top: 20%;
      border-radius: 50%;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      transform: translateY(-30%);
      border: 3px solid #ddd;
   }

   .circular-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }



   ::-webkit-scrollbar {
      width: 5px;
   }

   ::-webkit-scrollbar-track {
      background: #f1f1f1;
   }

   ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 6px;
   }

   ::-webkit-scrollbar-thumb:hover {
      background: #555;
   }

   .scroll-container {
      width: 300px;
      height: 200px;
      overflow-y: scroll;
      border: 1px solid #ccc;
   }

   .tabel {
      width: 100% !important;
      border: 1px solid #ddd;
      font-size: 9px
   }

   .tabel th {
      border: 1px solid #ddd;
      text-align: center;
      padding: 4px 0px;
      font-family: monospace;
   }

   .tabel td {
      border: 1px solid #ddd;
      text-align: center;
      padding: 4px 0px;
   }
</style>