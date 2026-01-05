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

<style>
   * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
   }

   body {
      background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 15px;
      position: relative;
      overflow-x: hidden;
   }

   body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
      pointer-events: none;
      z-index: 0;
   }

   .container-fluid {
      position: relative;
      z-index: 1;
   }

   .row {
      display: flex;
      flex-wrap: wrap;
      margin: -5px;
   }

   .utama {
      width: 190px;
      height: 125px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      position: relative;
      text-align: center;
      font-family: 'Segoe UI', 'Trebuchet MS';
      font-size: 13px;
      margin: 5px;
      font-weight: bold;
      animation: fadeInUp 0.6s ease backwards;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
   }

   .utama:hover {
      transform: translateY(-8px) scale(1.02);
   }

   .circular-image {
      width: 85px;
      height: 85px;
      top: 18%;
      border-radius: 50%;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      transform: translateY(-30%);
      border: 4px solid white;
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
      z-index: 2;
      transition: all 0.3s ease;
   }

   .utama:hover .circular-image {
      transform: translateY(-35%) scale(1.08);
      box-shadow: 0 12px 30px rgba(0,0,0,0.35);
   }

   .circular-image::before {
      content: '';
      position: absolute;
      width: 95px;
      height: 95px;
      border-radius: 50%;
      background: linear-gradient(135deg, #00d2ff, #3a7bd5);
      z-index: -1;
      animation: rotate 4s linear infinite;
   }

   .circular-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: all 0.3s ease;
   }

   .fotonya {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }

   .isi {
      margin-top: 45px;
      height: 65%;
      width: 100%;
      border-radius: 20px 20px 15px 15px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
   }

   .isi::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(90deg, rgba(255,255,255,0.5), transparent);
   }

   .utama:hover .isi {
      box-shadow: 0 15px 40px rgba(0,0,0,0.3);
   }

   .bg-success {
      background: linear-gradient(135deg, #11998e, #38ef7d) !important;
   }

   .bg-danger {
      background: linear-gradient(135deg, #eb3349, #f45c43) !important;
   }

   .bg-info {
      background: linear-gradient(135deg, #4facfe, #00f2fe) !important;
   }

   .bg-secondary {
      background: linear-gradient(135deg, #bdc3c7, #7f8c8d) !important;
   }

   .bg-warning {
      background: linear-gradient(135deg, #f093fb, #f5576c) !important;
   }

   .tabel {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-bottom: 20px;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      animation: fadeInUp 0.8s ease;
   }

   .tabel thead {
      background: linear-gradient(135deg, #00a8cc, #00d2ff);
      color: white;
   }

   .tabel th {
      border: 1px solid rgba(255,255,255,0.2);
      text-align: center;
      padding: 12px 8px;
      font-family: 'Segoe UI', monospace;
      font-size: 11px;
      font-weight: 600;
   }

   .tabel td {
      border: 1px solid #e8e8e8;
      text-align: center;
      padding: 12px 8px;
      transition: all 0.3s ease;
      background: white;
   }

   .tabel td:hover {
      background: #f8f9fa;
      transform: scale(1.03);
   }

   .tabel tbody tr:nth-child(even) td {
      background: #fafafa;
   }

   .tabel tbody tr:nth-child(even) td:hover {
      background: #f0f0f0;
   }

   .tabel td[style*="background:#DDFFBD"] {
      background: linear-gradient(135deg, #d4fc79, #96e6a1) !important;
      font-weight: 600;
   }

   .tabel td[style*="background-color:darkgreen"] {
      background: linear-gradient(135deg, #00a8cc, #00d2ff) !important;
   }

   @keyframes fadeInUp {
      from {
         opacity: 0;
         transform: translateY(30px);
      }
      to {
         opacity: 1;
         transform: translateY(0);
      }
   }

   @keyframes rotate {
      from {
         transform: rotate(0deg);
      }
      to {
         transform: rotate(360deg);
      }
   }

   ::-webkit-scrollbar {
      width: 10px;
      height: 10px;
   }

   ::-webkit-scrollbar-track {
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
   }

   ::-webkit-scrollbar-thumb {
      background: linear-gradient(135deg, #00d2ff, #3a7bd5);
      border-radius: 10px;
   }

   ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(135deg, #3a7bd5, #00d2ff);
   }

   @media (max-width: 768px) {
      .utama {
         width: 170px;
         height: 115px;
         margin: 4px;
      }

      .circular-image {
         width: 75px;
         height: 75px;
      }
   }
</style>

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
                           if ($field2->jam_masuk > '08:00:00') {
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
                     <div class="isi text-white shadow" style="background: linear-gradient(135deg, #ff7e5f, #feb47b);">
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