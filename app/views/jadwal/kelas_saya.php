<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<?php
$tgl = $data['tanggal'];
$timestamp = strtotime($tgl);
$satu_minggu = date('N', $timestamp);

$senin1   = strtotime("-" . ($satu_minggu - 1) . " days", $timestamp);
$selasa1  = strtotime("+1 day", $senin1);
$rabu1    = strtotime("+1 day", $selasa1);
$kamis1   = strtotime("+1 day", $rabu1);
$jumat1   = strtotime("+1 day", $kamis1);

$senin   = date('Y-m-d', $senin1);
$selasa  = date('Y-m-d', $selasa1);
$rabu    = date('Y-m-d', $rabu1);
$kamis   = date('Y-m-d', $kamis1);
$jumat   = date('Y-m-d', $jumat1);

$tanggal_hari = array($senin, $selasa, $rabu, $kamis, $jumat);
?>


<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Presensi Kelas Saya
      </div>

      <div class="mb-2">
         Pilih Tanggal/Minggu &nbsp;&nbsp;:&nbsp;&nbsp;
         <input type="date" id="tanggal" style="height: 25px;" onchange="submitForm()" value="<?= $tgl ?>">
      </div>

      <hr style="margin-top:0px; margin-bottom:0px">

      <div class="table-responsive">
         <table class="table tabel1">
            <thead class="text-center">
               <tr>
                  <th rowspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Hari&nbsp;&nbsp;&nbsp;&nbsp;</th>
                  <th colspan="10">Jam Ke</th>
               </tr>
               <tr>
                  <th style="width:10%">1</th>
                  <th style="width:10%">2</th>
                  <th style="width:10%">3</th>
                  <th style="width:10%">4</th>
                  <th style="width:10%">5</th>
                  <th style="width:10%">6</th>
                  <th style="width:10%">7</th>
                  <th style="width:10%">8</th>
                  <th style="width:10%">9</th>
                  <th style="width:10%">10</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $counter = 0;
               foreach ($data['absen'] as $d) :
               ?>
                  <tr>
                     <td class="text-center" style="background-color:azure; vertical-align:middle; white-space: nowrap; padding-left:10px !important; padding-right:10px !important; padding-top:9px !important; ; padding-bottom:9px !important">
                        <b>
                           <span style="font-weight:bold; font-size:18px"><?= $d->hari ?></span><br />
                           <small><b><?= date4ID($tanggal_hari[$counter]) ?></b></small>
                        </b>
                     </td>

                     <?php for ($i = 1; $i <= 10; $i++) : ?>
                        <?php
                        $cek_absen = $this->Mjadwal->cek_absen($tanggal_hari[$counter], $d->kelas, $d->ruang, $i);
                        if ($cek_absen) {
                           $warna = 'lime';
                        } else {
                           $warna = '';
                        }
                        ?>

                        <td class="text-center" style="background-color: <?= $warna ?>; padding-top:9px !important; padding-bottom:9px !important; white-space: nowrap;">
                           <?php if ($cek_absen) { ?>
                              <span class="kode_pegawai"><?= $d->{'kode_pegawai' . $i} ?><br /></span>
                              <span class="mata_pelajaran"><?= substr($d->{'mata_pelajaran' . $i}, 0, 12) ?>...</span>
                           <?php } else { ?>
                              <span class="singkatan"><?= $d->{'singkatan' . $i} ?></span>
                              <br />
                              <span class="guru"><?= substr($d->{'nama' . $i}, 0, 12) ?>..</span>
                           <?php } ?>
                        </td>

                     <?php endfor; ?>

                  </tr>
               <?php
                  $counter++;
               endforeach;
               ?>
            </tbody>
         </table>
      </div>
   </div>
</div>


<script>
   function submitForm() {
      var tanggal = document.getElementById('tanggal').value;
      window.location.href = '<?= URLROOT ?>/jadwal/kelas_saya?tanggal=' + tanggal;
   }
</script>

<style>
   .kode_pegawai {
      font-weight: bold;
      font-size: 20px;
      color: brown;
   }

   .mata_pelajaran {
      font-size: 13px;
      color: brown;
   }

   .singkatan {
      font-weight: bold;
      font-size: 20px;
   }

   .guru {
      font-size: 13px;
      color: red;
   }
</style>