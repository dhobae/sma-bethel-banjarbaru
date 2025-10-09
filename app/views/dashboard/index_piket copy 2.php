<head>
   <title>Daftar Hadir SMK Telkom Banjarbaru</title>
   <link rel="shortcut icon" href="<?= URLROOT; ?>/skatel/img/ts_icon1.png">
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
                           if ($field2->jam_masuk > '08:00:00') {
                              $warna = 'bg-danger';
                           } else {
                              $warna = 'bg-success';
                           } ?>
                           <div class="utama">
                              <div class="circular-image">
                                 <?php if (!$field->avatar) { ?>
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle" style="border:2px solid white">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/skatel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="border:2px solid white">
                                 <?php } ?>
                              </div>

                              <div class="isi <?= $warna ?> text-white shadow">

                                 <div class="row" style="font-size:10px; margin-top:14px; font-family:monospace">

                                    <div class="col" style="text-align:left; padding-left:30px">
                                       <?= $field2->status_masuk; ?>
                                       <br />
                                       (<?= $field2->from_masuk; ?>)
                                    </div>

                                    <div class="col" style="text-align:right; padding-right:30px">
                                       <?= substr($field2->jam_masuk, 0, 5); ?>
                                       <br />
                                       WITA
                                    </div>
                                 </div>

                                 <div class="row" style="margin-top:5px; font-size:14px; font-family:monospace">
                                    <div class="col">
                                       <?= substr($field->nama, 0, 21); ?>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        <?php
                        } else
                        // ABSEN MASUK WFH ---------------------------- 
                        {
                           if ($field2->jam_masuk > '08:00:00') {
                              $warna = 'bg-danger';
                           } else {
                              $warna = 'bg-info';
                           }
                        ?>
                           <div class="utama">
                              <div class="circular-image">
                                 <?php if (!$field->avatar) { ?>
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle" style="border:2px solid white">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/skatel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="border:2px solid white">
                                 <?php } ?>
                              </div>
                              <div class="isi <?= $warna ?> text-white shadow">
                                 <div class="row" style="font-size:11px; margin-top:14px">
                                    <div class="col" style="text-align:center; padding-right:80px">
                                       <?= $field2->status_masuk; ?>
                                       <br />
                                       (<?= $field2->from_masuk; ?>)
                                    </div>
                                    <div class="col" style="text-align:center; padding-right:25px">
                                       <?= substr($field2->jam_masuk, 0, 5); ?>
                                       <br />
                                       WITA
                                    </div>
                                 </div>

                                 <div class="row" style="margin-top:5px; font-size:14px; font-family:monospace">
                                    <div class="col">
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
                                 <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya img-thumbnail rounded-circle" style="filter: grayscale(100%);">
                              <?php } else { ?>
                                 <img src="<?= URLROOT ?>/skatel/avatar/<?= $field->avatar ?>" class="fotonya img-thumbnail rounded-circle" style="filter: grayscale(100%);">
                              <?php } ?>
                           </div>
                           <div class="isi bg-secondary text-white shadow">
                              <div class="row" style="font-size:11px; margin-top:14px">
                                 <div class="col" style="text-align:center; padding-right:40px">
                                    <?= $field2->status_pulang; ?>
                                    <br />
                                    (<?= $field2->from_pulang; ?>)
                                 </div>
                                 <div class="col" style="text-align:center;padding-right:10px">
                                    <?= substr($field2->jam_pulang, 0, 5); ?>
                                    <br />
                                    WITA
                                 </div>
                              </div>

                              <div class="row" style="margin-top:5px; font-size:14px; font-family:monospace">
                                 <div class="col">
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
                                    <img src="<?= URLROOT ?>/img/avatar/no_avatar.png" class="fotonya rounded-circle" style="border:2px solid white">
                                 <?php } else { ?>
                                    <img src="<?= URLROOT ?>/skatel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="border:2px solid white">
                                 <?php } ?>
                              </div>
                              <div class="isi bg-warning shadow">
                                 <div class="row" style="font-size:11px; margin-top:14px">
                                    <div class="col" style="text-align:center; padding-right:50px">
                                       Sedang<br />
                                       <?= $field2->status_masuk; ?>
                                    </div>
                                    <div class="col" style="text-align:center;">
                                       <?php // substr($field2->jam_pulang, 0, 5); 
                                       ?>
                                    </div>
                                 </div>

                                 <div class="row" style="margin-top:5px; font-size:14px; font-family:monospace">
                                    <div class="col">
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
                                    <img src="<?= URLROOT ?>/skatel/avatar/<?= $field->avatar ?>" class="fotonya img-thumbnail rounded-circle" style="filter: grayscale(100%);">
                                 <?php } ?>
                              </div>
                              <div class="isi bg-secondary text-white shadow">
                                 <div class="row" style="font-size:11px; margin-top:14px">
                                    <div class="col" style="text-align:center; padding-right:40px">
                                       Sedang<br />
                                       <?= $field2->status_masuk; ?>
                                    </div>
                                    <div class="col" style="text-align:center; padding-right:25px">
                                    </div>
                                 </div>

                                 <div class="row" style="margin-top:5px; font-size:14px; font-family:monospace">
                                    <div class="col">
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
                           <img src="<?= URLROOT ?>/skatel/avatar/<?= $field->avatar ?>" class="fotonya rounded-circle" style="filter: grayscale(100%);">
                        <?php } ?>
                     </div>

                     <div class="isi text-white shadow bg-success" style="background-color: #999;">
                        <div class="row" style="font-size:14px; font-family:monospace; margin-top:33px">
                           <div class="col">
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



   <div class="container-fluid">
      <div class="row bg-white mt-2">
         <div class="col-4">
            <div class="table-responsive">
               <table class="tabel">
                  <thead>
                     <tr style="font-family:'calibri'">
                        <th>Kelas</th>
                        <th class="text-nowrap">Jam<br />Ke 1</th>
                        <th class="text-nowrap">Jam<br />Ke 2</th>
                        <th class="text-nowrap">Jam<br />Ke 3</th>
                        <th class="text-nowrap">Jam<br />Ke 4</th>
                        <th class="text-nowrap">Jam<br />Ke 5</th>
                        <th class="text-nowrap">Jam<br />Ke 6</th>
                        <th class="text-nowrap">Jam<br />Ke 7</th>
                        <th class="text-nowrap">Jam<br />Ke 8</th>
                        <th class="text-nowrap">Jam<br />Ke 9</th>
                        <th class="text-nowrap">Jam<br />Ke 10</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php for ($a = 1; $a < 11; $a++) { ?>
                        <tr>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>

         <div class="col-4">
            <div class="table-responsive">
               <table class="tabel">
                  <thead>
                     <tr style="font-family:'calibri'">
                        <th>Kelas</th>
                        <th class="text-nowrap">Jam<br />Ke 1</th>
                        <th class="text-nowrap">Jam<br />Ke 2</th>
                        <th class="text-nowrap">Jam<br />Ke 3</th>
                        <th class="text-nowrap">Jam<br />Ke 4</th>
                        <th class="text-nowrap">Jam<br />Ke 5</th>
                        <th class="text-nowrap">Jam<br />Ke 6</th>
                        <th class="text-nowrap">Jam<br />Ke 7</th>
                        <th class="text-nowrap">Jam<br />Ke 8</th>
                        <th class="text-nowrap">Jam<br />Ke 9</th>
                        <th class="text-nowrap">Jam<br />Ke 10</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php for ($a = 1; $a < 11; $a++) { ?>
                        <tr>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>

         <div class="col-4">
            <div class="table-responsive">
               <table class="tabel">
                  <thead>
                     <tr style="font-size:12px; font-weight:bold; font-family:'calibri'">
                        <th>&nbsp;KLS&nbsp;</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 1</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 2</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 3</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 4</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 5</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 6</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 7</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 8</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 9</th>
                        <th class="text-nowrap" style="width:10%">Jam<br />Ke 10</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php for ($a = 1; $a < 11; $a++) { ?>
                        <tr>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>Abc</td>
                           <td>
                              <span style="font-size:12px; font-weight:bold">B. Indo</span>
                              <br />
                              Pahdi
                           </td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>




</body>











<style>
   body {
      background: url(skatel/img/skatel3.jpg) no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
   }


   .utama {
      border: 0px solid red;
      width: 180px;
      height: 100px;
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
   }

   .tabel td {
      border: 1px solid #ddd;
      text-align: center;
   }
</style>