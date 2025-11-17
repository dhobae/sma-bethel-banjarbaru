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
   <div class="col">
      <div class="card card-primary card-outline" style="margin-top:10px;">
         <div class="card-body box-profile">
            <div class="tengah mb-1">
               <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
            </div>
            <div class="tengah judul1">
               <b>SMA Bethel Banjarbaru</b>
            </div>
            <div class="tengah judul1 mb-4">
               <b>Rekap Jam Mengajar Guru Mata Pelajaran</b>
            </div>


            <div class="huruf1 mb-2">
               <form method="GET" action="" class="form-inline">
                  <label for="date1"><b>Pilih : </b>&nbsp;</label>
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
                  &nbsp;
                  <input type="number" name="tahun" value="<?= $year ?>" style="width: 70px;height:23px;">
                  &nbsp;
                  <button type="submit" name="submit" class="btn btn-primary btn-sm tombol2" style="height:23px;padding:0px 10px;">Tampilkan</button>
               </form>
            </div>

            <table class="table tabel3 khusus" id="example3">
               <thead style="background-color:darkslategray;color:white; height:45px">
                  <tr>
                     <th style="width:6%">No</th>
                     <th style="width:17%">NIK</th>
                     <th>Nama</th>
                     <th>Kode</th>
                     <th style="width:4%">M1</th>
                     <th style="width:4%">M2</th>
                     <th style="width:4%">M3</th>
                     <th style="width:4%">M4</th>
                     <th style="width:4%">M5</th>
                     <th style="width:9%">Jumlah</th>
                     <th style="width:9%">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $no = 1;
                  foreach ($data['rekap_absen_admin'] as $d) :
                  ?>
                     <tr>
                        <td class="tengah"><?= $no ?></td>
                        <td class="tengah"><?= $d->nik ?></td>
                        <td><?= $d->nama ?></td>
                        <td class="text-center"><?= $d->kode ?></td>

                        <td class="text-center">
                           <?= ($d->minggu_1 > 0) ? $d->minggu_1 : '' ?>
                        </td>
                        <td class="text-center">
                           <?= ($d->minggu_2 > 0) ? $d->minggu_2 : '' ?>
                        </td>
                        <td class="text-center">
                           <?= ($d->minggu_3 > 0) ? $d->minggu_3 : '' ?>
                        </td>
                        <td class="text-center">
                           <?= ($d->minggu_4 > 0) ? $d->minggu_4 : '' ?>
                        </td>
                        <td class="text-center">
                           <?= ($d->minggu_5 > 0) ? $d->minggu_5 : '' ?>
                        </td>

                        <td class="tengah">
                           <b><?= ($d->jumlah > 0) ? $d->jumlah : '' ?></b>
                        </td>
                        <td class="tengah">
                           <?php if ($d->jumlah > 0) { ?>
                              <a href="<?= URLROOT ?>/absen/rekap?nik=<?= $d->nik ?>" title="lihat rekap absen"><b>Lihat</b></a>
                           <?php } ?>
                        </td>
                     </tr>
                  <?php $no++;
                  endforeach;
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<style>
   .khusus td {
      font-size: 1.1rem;
   }
</style>
<script>
   $(function() {
      $("#example1").DataTable({
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