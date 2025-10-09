<?php
$tanggal = date("Y-m-d");
?>

<div class="card" style="margin-top: 10px; background:beige">
   <div class="card-header bg-danger" style="padding:8px 10px;">
      <b>Daftar User yang Login hari ini </b>
   </div>

   <div class="card-body">
      <div class="tengah mb-4">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="160px">
         <br />
      </div>

      <table class="table tabel3 table-bordered" id="example1">
         <thead>
            <tr>
               <th style="width:50px; text-align:center;height:40px;"> No </th>
               <th> Nama Guru / Pegawai </th>
               <th style="width:135px;"> IP </th>
               <th style="width:115px;"> Status </th>
               <th style="width:130px;"> Tanggal </th>
               <th style="width:115px;"> Jam Login </th>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['aktif']) :
               foreach ($data['aktif'] as $field) :
                  if ($field->dari == 'WFO') {
                     $warna = 'azure';
                  } else {
                     $warna = '';
                  }
                  echo "<tr style='background:$warna'>";
                  echo "<td style='text-align:center;'>" . $no . "</br>";
                  if ($field->npk == 'admin') {
                     $nama = 'Administrator';
                  } else {
                     $nama = $field->namadosen;
                  }
                  echo "<td>" . $nama . "</td>";
                  echo "<td>" . $field->ip . "</td>";
                  echo "<td class='text-center'>" . $field->dari . "</td>";
                  echo "<td class='text-center'>" . dateID($field->tanggal) . "</td>";
                  echo "<td class='text-center'>" . date('H:i:s', $field->online) . "</td>";
                  $no++;
               endforeach;
            else :
               echo "<tr>";
               echo "<td colspan='6'> Data tidak ditemukan </td>";
               echo "</tr>";
            endif;
            ?>
         </tbody>
      </table>
   </div>
</div>


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
         "pageLength": 50,
         "searching": true,
         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
   });
</script>