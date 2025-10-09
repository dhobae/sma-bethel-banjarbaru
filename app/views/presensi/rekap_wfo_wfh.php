<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<?php
if (isset($_GET['bulan'])) {
   $month = $_GET['bulan'];
} else {
   $month = date('m');
}

if (isset($_GET['tahun'])) {
   $year = $_GET['tahun'];
} else {
   $year = date('Y');
}

$bulan1 = array('01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER');
?>

<div class="card" style="margin-top: 10px; background-color:cornsilk">
   <div class="card-header bg-primary" style="height:35px; padding:5px 10px;">
      <span style="font-family:Trebuchet MS; font-size: 13px;">
         <form method="GET" action="" class="form-inline">
            <label for="date1"><b>Pilih Bulan dan Tahun &nbsp; : &nbsp;&nbsp; </b></label>
            <select name="bulan" style="height:20px;">
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
            &nbsp;&nbsp;
            <input type="number" name="tahun" value="<?= $year ?>" style="width: 70px; height:20px;">
            &nbsp;&nbsp;
            <button type="submit" name="submit" class="myButton6" style="height:20px; padding:0px 10px;">Tampilkan</button>
         </form>
      </span>
   </div>


   <div class="card-body box-profile">
      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         SMK Telkom Banjarbaru
      </div>
      <div class="huruf1 tengah" style="font-size:18px; font-weight:bold; margin-top:-6px">
         Rekap Bulan <b><?php echo $bulan1[$month] ?> </b>, Tahun <b><?= $year ?></b>
      </div>

      <?php
      if ($data['query_libur']) :
         foreach ($data['query_libur'] as $fieldlibur) {
            $libur = $fieldlibur->libur;
         }
      else :
         $libur = '0';
      endif;
      $j_hari = jumlahhari($month, $year);

      $hari_efektif = $j_hari - $libur;
      ?>

      <table class="table tabel3 table-bordered table-striped" id="example3">
         <thead style="background-color:brown; color:white">
            <tr>
               <th rowspan="2" style="width:50px">No</th>
               <th rowspan="2" style="width:120px;">NIK/NIP</th>
               <th rowspan="2">Nama Dosen / Karyawan</th>
               <th rowspan="2" style="width:45px">Hari<br />Kerja</th>
               <th rowspan="2" style="width:45px">Hadir</th>
               <th colspan="2" style="text-align:center;">Status Masuk</td>
               <th colspan="2" style="text-align:center;">Masuk</td>
               <th colspan="2" style="text-align:center;">Pulang</td>
               <th colspan="4" style="text-align:center;">Izin</td>
               <th rowspan="2" style="width: 50px;text-align:center;">Libur</th>
            </tr>
            <tr>
               <th style="width: 45px;text-align:center;">Ontime</th>
               <th style="width: 45px;text-align:center;">Telat</th>

               <th style="width: 42px;text-align:center;">WFO</th>
               <th style="width: 42px;text-align:center;">WFH</th>

               <th style="width: 42px;text-align:center;">WFO</th>
               <th style="width: 42px;text-align:center;">WFH</th>

               <th style="width: 39px;text-align:center;">I</th>
               <th style="width: 39px;text-align:center;">S</th>
               <th style="width: 39px;text-align:center;">Ct</th>
               <th style="width: 39px;text-align:center;">TL</th>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['rekap_wfo_wfh']) :
               foreach ($data['rekap_wfo_wfh'] as $field) :
            ?>
                  <tr>
                     <td class="text-center"> <?= $no ?> </td>
                     <td class="text-center"> <?= $field->nik ?> </td>
                     <td> <?= $field->nama ?> </td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important">
                        <?= $hari_efektif ?>
                     </td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important">
                        <?= $field->hadir ?>
                     </td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important">
                        <?= $field->ontime ?>
                     </td>
                     <td class="text-center"><b>
                           <?php if ($field->telat != 0) {
                              echo $field->telat;
                           } else {
                              echo "-";
                           } ?>
                        </b></td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important">
                        <?php if ($field->wfo_masuk != 0) {
                           echo $field->wfo_masuk;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center">
                        <?php if ($field->wfh_masuk != 0) {
                           echo $field->wfh_masuk;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important">
                        <?php if ($field->wfo_pulang != 0) {
                           echo $field->wfo_pulang;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center">
                        <?php if ($field->wfh_pulang != 0) {
                           echo $field->wfh_pulang;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important">
                        <?php if ($field->izin != 0) {
                           echo $field->izin;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center">
                        <?php if ($field->sakit != 0) {
                           echo $field->sakit;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center">
                        <?php if ($field->cuti != 0) {
                           echo $field->cuti;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center">
                        <?php if ($field->tl != 0) {
                           echo $field->tl;
                        } else {
                           echo "-";
                        } ?>
                     </td>
                     <td class="text-center" style="border-left:2px solid #bbbbbb !important"> <?= $libur ?> </td>
                  </tr>
               <?php
                  $no++;
               endforeach;
            else :
               ?>
               <tr>
                  <td colspan="7">
                     Data tidak ditemukan
                  </td>
               </tr>
            <?php
            endif;
            ?>
      </table>
   </div>
</div>



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

<?php
function jumlahhari($bulan, $tahun)
{
   $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
   $jumlahHariKerja = 0;
   for ($i = 1; $i <= $jumlahHari; $i++) {
      $timestamp = mktime(0, 0, 0, $bulan, $i, $tahun);
      $hari = date('N', $timestamp);
      if ($hari != 6 && $hari != 7) {
         $jumlahHariKerja++;
      }
   }
   return $jumlahHariKerja;
}
?>