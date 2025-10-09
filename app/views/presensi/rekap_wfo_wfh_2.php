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
      ?>

      <table class="table tabel3 table-bordered table-striped" id="example3">
         <thead style="background-color:brown; color:white">
            <tr>
               <th rowspan="2" style="width:50px">No</th>
               <th rowspan="2" style="width:125px;">NIK/NIP</th>
               <th rowspan="2">Nama Dosen / Karyawan</th>
               <th rowspan="2">Hadir</th>
               <th colspan="2" style="text-align:center;">Status Masuk</td>
               <th colspan="2" style="text-align:center;">Masuk</td>
               <th colspan="2" style="text-align:center;">Pulang</td>
               <th colspan="4" style="text-align:center;">Izin</td>
               <th rowspan="2" style="width: 50px;text-align:center;">Libur</th>
            </tr>
            <tr>
               <th style="width: 45px;text-align:center;">Ontime</th>
               <th style="width: 45px;text-align:center;">Telat</th>

               <th style="width: 45px;text-align:center;">WFO</th>
               <th style="width: 45px;text-align:center;">WFH</th>

               <th style="width: 45px;text-align:center;">WFO</th>
               <th style="width: 45px;text-align:center;">WFH</th>

               <th style="width: 45px;text-align:center;">Izin</th>
               <th style="width: 45px;text-align:center;">Sakit</th>
               <th style="width: 45px;text-align:center;">Cuti</th>
               <th style="width: 45px;text-align:center;">T. Luar</th>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['rekap_wfo_wfh']) :
               foreach ($data['rekap_wfo_wfh'] as $field) :
            ?>
                  <tr>
                     <td style="text-align:center;"> <?= $no ?> </td>
                     <td class="text-center"> <?= $field->nik ?> </td>
                     <td> <?= $field->nama ?> </td>
                     <td style="text-align:center; background:black; color:white"> <?= $field->hadir ?> </td>
                     <td style="background-color:#B2FFAD;" class="tengah"><?= $field->ontime ?></td>
                     <td style="background-color:#FFADAD;" class="tengah"><b><?= $field->telat ?></b></td>
                     <td style="text-align:center;"> <?= $field->wfo_masuk ?> </td>
                     <td style=" text-align:center;"> <?= $field->wfh_masuk ?> </td>
                     <td style="text-align:center;"> <?= $field->wfo_masuk ?> </td>
                     <td style=" text-align:center;"> <?= $field->wfh_pulang ?> </td>
                     <td style="text-align:center; background:yellow"> <?= $field->izin ?> </td>
                     <td style="text-align:center; background:orange"> <?= $field->sakit ?> </td>
                     <td style="text-align:center; background:yellowgreen"> <?= $field->cuti ?> </td>
                     <td style="text-align:center; background:burlywood"> <?= $field->tl ?> </td>
                     <td style="text-align:center;"> <?= $libur ?> </td>
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