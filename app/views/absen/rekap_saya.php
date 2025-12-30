<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<?php
$year = date('Y');
$month = date('m');

if (isset($_GET['submit'])) {
   $year = date('Y');
   $month = date('m');

   $bln = date($_GET['bulan']);
   $thn = date($_GET['tahun']);

   if (!empty($bln)) {
      $year = $thn;
      $month = $bln;
   }
}
?>

<div class="row">
   <div class="col-lg-3">
      <div class="card card-primary card-outline" style="margin-top:10px;">
         <div class="card-body box-profile">
            <div class="tengah mb-1">
               <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="90px">
            </div>
            <div class="tengah judul1">
               <b>SMA Bethel Banjarbaru</b>
            </div>
            <div class="tengah judul1 mb-4">
               <b>Rekap</b>
            </div>

            <div class="huruf1 mb-2">
               <form method="GET" action="" class="form-inline">
                  <table class="rekap_saya">
                     <tr>
                        <td><label for="date1"><b>Bulan : </b>&nbsp;</label></td>
                        <td>
                           <select class="" name="bulan" style="height:23px; width:150px">
                              <option value="">-</option>
                              <option value="01" <?= ($month == '01') ? 'selected' : '' ?>>Januari</option>
                              <option value="02" <?= ($month == '02') ? 'selected' : '' ?>>Februari</option>
                              <option value="03" <?= ($month == '03') ? 'selected' : '' ?>>Maret</option>
                              <option value="04" <?= ($month == '04') ? 'selected' : '' ?>>April</option>
                              <option value="05" <?= ($month == '05') ? 'selected' : '' ?>>Mei</option>
                              <option value="06" <?= ($month == '06') ? 'selected' : '' ?>>Juni</option>
                              <option value="07" <?= ($month == '07') ? 'selected' : '' ?>>Juli</option>
                              <option value="08" <?= ($month == '08') ? 'selected' : '' ?>>Agustus</option>
                              <option value="09" <?= ($month == '09') ? 'selected' : '' ?>>September</option>
                              <option value="10" <?= ($month == '10') ? 'selected' : '' ?>>Oktober</option>
                              <option value="11" <?= ($month == '11') ? 'selected' : '' ?>>November</option>
                              <option value="12" <?= ($month == '12') ? 'selected' : '' ?>>Desember</option>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <label for="date1"><b>Tahun : </b>&nbsp;</label>
                        </td>
                        <td>
                           <input type="number" name="tahun" value="<?= $year ?>" style="width: 70px;height:23px;">
                        </td>
                     </tr>
                     <tr>
                        <td></td>
                        <td>
                           <button type="submit" name="submit" class="btn btn-primary btn-sm tombol2" style="width:100%"><i class="fa fa-eye"></i> &nbsp;Tampilkan</button>
                        </td>
                     </tr>
                  </table>
               </form>
            </div>
            <div class="tengah mt-4">
               <b>Total Jam mengajar</b>
               <br />
               <span style="font-size:60px; font-weight:bold; color:red" class="blink">
                  <?= count($data['rekap_absen_saya']) ?>
               </span>
            </div>
         </div>
      </div>

      <div class="mt-2 mb-2">
         <a href="<?= URLROOT ?>/jadwal/absen" class="btn btn-danger btn-sm tombol2" title="Kembali"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
      </div>
   </div>

   <div class="col-lg-9">
      <div class="card card-primary card-outline" style="margin-top:10px;">
         <div class="card-body box-profile">

            <div class="tengah mb-1">
               <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="90px">
            </div>
            <div class="tengah judul1">
               <b>SMA Bethel Banjarbaru</b>
            </div>
            <div class="tengah judul1 mb-3">
               <b>Daftar Presensi Mengajar Saya</b>
            </div>

            <div class="mb-2">
               <a href="<?= URLROOT ?>/absen/jurnal_mengajar" class="btn btn-primary btn-sm tombol2" title="Isi Jurnal mengajar"><i class="fa fa-edit"></i> &nbsp;Isi Jurnal Mengajar</a>

               <?php if ($_SESSION['role'] != 'admin') { ?>
                  <div class="float-right">
                     <a href="<?= URLROOT ?>/absen/cetak_jurnal_saya?bulan=<?= $month ?>&tahun=<?= $year ?>" class="btn btn-danger btn-sm tombol2" title="Cetak" id="printLink"><i class="fa fa-print"></i> &nbsp;Cetak Absen</a>
                  </div>
               <?php } ?>

            </div>

            <?php
            $rekap_per_hari = [];
            foreach ($data['rekap_absen_saya'] as $row) {
               $tanggal = date('l, d-M-Y', strtotime($row->tgl_absen_kelas));
               $rekap_per_hari[$tanggal][] = $row;
            }
            ?>

            <?php foreach ($rekap_per_hari as $tanggal => $data_per_tanggal) : ?>
               <?php //echo $tanggal; 
               ?>
               <div>
                  <table class="table tabel3">
                     <thead style="background-color:darkslategray;color:white; height:40px">
                        <tr>
                           <th style="width:50px">No</th>
                           <th style="width:18%">Hari / tanggal</th>
                           <th style="width:7%">Jam Ke</th>
                           <th style="width:8%">Kelas</th>
                           <th style="width:25%">Mata Pelajaran</th>
                           <th>Jurnal Mengajar</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data_per_tanggal as $d) : ?>
                           <tr>
                              <td class="tengah"><?= $no++ ?></td>
                              <td class="tengah">
                                 <?= dayID($d->tgl_absen_kelas) ?>, <?= date4ID($d->tgl_absen_kelas) ?>
                              </td>
                              <td class="tengah"><?= $d->jam_absen_kelas ?></td>
                              <td class="tengah"><?= $d->kelas_absen_kelas . $d->ruang_absen_kelas ?></td>
                              <td class="tengah">
                                 <?= substr($d->mata_pelajaran_lengkap, 0, 25) ?>
                              </td>
                              <td>
                                 <?= $d->materi_pelajaran ?>
                              </td>
                           </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>
               </div>
            <?php endforeach; ?>
         </div>
      </div>
   </div>
</div>

<style>
   .rekap_saya td {
      padding: 3px;
   }
</style>