<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash();

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
   <div class="col-lg-12">
      <div class="card card-primary card-outline" style="margin-top:10px;">

         <div class="card-header bg-warning" style="padding:8px 12px; margin:0px">
            <div class="huruf1">
               <form method="GET" action="" class="form-inline">
                  <label for="date1"><b>Bulan : </b>&nbsp;</label>
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
                  &nbsp;&nbsp;&nbsp;
                  <label for="date1"><b>Tahun : </b>&nbsp;</label>
                  <input type="number" name="tahun" value="<?= $year ?>" style="width: 70px;height:23px;">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <button type="submit" name="submit" class="btn btn-danger btn-sm tombol2" style="height:24px"><i class="fa fa-eye"></i> &nbsp;Tampilkan Filter</button>
               </form>
            </div>
         </div>

         <div class="card-body box-profile">
            <div class="tengah mb-1">
               <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="90px">
            </div>
            <div class="tengah judul1">
               <b>SMA Bethel Banjarbaru</b>
            </div>
            <div class="tengah judul1 mb-4">
               <b>Jurnal Mengajar</b>
            </div>

            <div>
               <?php
               $rekap_per_hari = [];
               foreach ($data['rekap_absen_saya'] as $row) {
                  $tanggal = date('l, d-M-Y', strtotime($row->tgl_absen_kelas));
                  $rekap_per_hari[$tanggal][] = $row;
               }
               ?>
               <form method="POST" action="<?= URLROOT ?>/absen/simpan_jurnal">
                  <input type="hidden" value="<?= $year ?>" name="tahun">
                  <input type="hidden" value="<?= $month ?>" name="bulan">
                  <div>
                     <button type="submit" class="btn btn-primary tombol2" title="Simpan Jurnal"><i class="fa fa-save"></i> &nbsp;Simpan Jurnal Mengajar</button>

                     <?php if ($_SESSION['role'] != 'admin') { ?>
                        <div class="float-right">
                           <a href="<?= URLROOT ?>/absen/cetak_jurnal_saya?bulan=<?= $month ?>&tahun=<?= $year ?>" class="btn btn-danger btn-sm tombol2" title="Cetak" id="printLink"><i class="fa fa-print"></i> &nbsp;Cetak Absen</a>
                        </div>
                     <?php } ?>

                  </div>
                  <div class="mb-2">
                     <small><i><b>Untuk mengisi jurnal, anda bisa langsung mengetikkannya di kolom "Jurnal Mengajar"</b></i></small>
                  </div>

                  <?php foreach ($rekap_per_hari as $tanggal => $data_per_tanggal) : ?>
                     <?php //echo $tanggal; 
                     ?>
                     <div class="table-responsive">
                        <table class="table tabel3">
                           <thead style="background-color:darkslategray;color:white; height:40px">
                              <tr>
                                 <th style="width:50px">No</th>
                                 <th style="width:13%">Hari / tanggal</th>
                                 <th style="width:6%">Jam Ke</th>
                                 <th style="width:6%">Kelas</th>
                                 <th style="width:20%">Mata Pelajaran</th>
                                 <th>Jurnal Mengajar</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php $no = 1; ?>
                              <?php foreach ($data_per_tanggal as $d) : ?>
                                 <tr>
                                    <td class="tengah"><?= $no++ ?></td>
                                    <td class="tengah" style="white-space: nowrap;">
                                       <?= dayID($d->tgl_absen_kelas) ?>, <?= date4ID($d->tgl_absen_kelas) ?>
                                    </td>
                                    <td class="tengah"><?= $d->jam_absen_kelas ?></td>
                                    <td class="tengah"><?= $d->kelas_absen_kelas . $d->ruang_absen_kelas ?></td>
                                    <td class="tengah" style="white-space: nowrap;">
                                       <?= substr($d->mata_pelajaran_lengkap, 0, 30) ?>
                                    </td>
                                    <td style="padding:0px 5px !important; vertical-align:middle;white-space: nowrap;">
                                       <input type="hidden" name="id_absen_kelas[]" value="<?= $d->id_absen_kelas ?>">

                                       <input type="text" name="materi_pelajaran[]" value="<?= $d->materi_pelajaran ?>" style="width:100%" class="materi">
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  <?php endforeach; ?>

               </form>

            </div>
         </div>
      </div>
   </div>
</div>

<style>
   input[type="text"] {
      border-color: red;
      border: 0px;
      background-color: antiquewhite;
      padding: 0px 5px !important;
      margin-bottom: 0px !important;
   }
</style>