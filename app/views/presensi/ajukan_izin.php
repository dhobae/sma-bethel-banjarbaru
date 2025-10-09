<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>


<div class="card card-primary card-outline" style="margin-top:10px;">

   <div class="card-body">
      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="160px"> <br />
      </div>
      <div class="tengah judul1 mb-2">
         <b>SMK Telkom Banjarbaru<br />
            [Daftar Pengajuan Izin tidak masuk kerja saya]</b>
      </div>

      <a href="<?= URLROOT ?>/presensi/ajukan" class="btn btn-primary btn-sm tombol3"><span style="font-size:12px"><i class="fa fa-plus-square"></i> &nbsp;<b>Tambah Pengajuan Izin</b></a>

      <table class="tabeltiga table-bordered table-striped" id="example">
         <thead>
            <tr>
               <th style="width: 50px; height:40px;">No</th>
               <th style="width: 250px;">Nama</th>
               <th style="width: 150px;">Mulai dari</th>
               <th style="width: 150px;">Sampai dengan</th>
               <th style="width: 50px;">Jenis</th>
               <th>Keterangan Libur</th>
               <th style="width: 90px;">Status</th>
               <th style="width: 100px;">Aksi</th>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['ajukan_izin']) :
               foreach ($data['ajukan_izin'] as $field) :

                  $hari = date("l", strtotime($field->tanggal_mulai));
                  if ($hari == "Sunday") {
                     $hari = "Minggu";
                  } elseif ($hari == "Monday") {
                     $hari = "Senin";
                  } elseif ($hari == "Tuesday") {
                     $hari = "Selasa";
                  } elseif ($hari == "Wednesday") {
                     $hari = "Rabu";
                  } elseif ($hari == "Thursday") {
                     $hari = "Kamis";
                  } elseif ($hari == "Friday") {
                     $hari = "Jum'at";
                  } elseif ($hari == "Saturday") {
                     $hari = "Sabtu";
                  }
                  $hari_akhir = date("l", strtotime($field->tanggal_akhir));
                  if ($hari_akhir == "Sunday") {
                     $hari_akhir = "Minggu";
                  } elseif ($hari_akhir == "Monday") {
                     $hari_akhir = "Senin";
                  } elseif ($hari_akhir == "Tuesday") {
                     $hari_akhir = "Selasa";
                  } elseif ($hari_akhir == "Wednesday") {
                     $hari_akhir = "Rabu";
                  } elseif ($hari_akhir == "Thursday") {
                     $hari_akhir = "Kamis";
                  } elseif ($hari_akhir == "Friday") {
                     $hari_akhir = "Jum'at";
                  } elseif ($hari_akhir == "Saturday") {
                     $hari_akhir = "Sabtu";
                  }
                  echo "<tr>";
                  echo "<td style='text-align:center;'>" . $no . "</td>";
                  echo "<td>" . $field->nama . "</td>";
                  echo "<td style='text-align:center;'>" . tanggal_indo($field->tanggal_mulai) . "</td>";
                  echo "<td style='text-align:center;'>" . tanggal_indo($field->tanggal_akhir) . "</td>";

                  if ($field->status_izin == 'Cuti2') {
                     echo "<td style='text-align:center;'>Cuti alasan penting</td>";
                  } else {
                     echo "<td style='text-align:center;'>" . $field->status_izin . "</td>";
                  }

                  echo "<td>" . $field->keterangan_izin . "</td>";
                  echo "<td>" . $field->status . "</td>";
            ?>
                  <td>
                     <a href="<?= URLROOT ?>/presensi/edit_pengajuan_izin/<?= $field->idtmpnya ?>">Edit</a>
                     |
                     <a href="javascript:void(0)" onclick="deleteData(<?= $field->idtmpnya ?>)">Delete</a>
                  </td>
                  </tr>
               <?php

                  $no++;
               endforeach;
            else :
               ?>
               <tr>
                  <td colspan="8">
                     Data tidak ditemukan
                  </td>
               </tr>
            <?php
            endif;
            ?>
         </tbody>
      </table>
   </div>
</div>



<script>
   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 20,
         "paging": false, //Nomor halaman di bawah
         "lengthChange": true, //Jumlah ditampilkan berapa dulu
         "ordering": false,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": "Menampilkan _MENU_ data perhalaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Pencarian disini :"
         }
      });
   });
</script>


<script>
   function deleteData(id) {
      console.log('URL: ' + '<?= URLROOT ?>/presensi/hapus_pengajuan_izin/' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Anda tidak bisa mengembalikan data yang dihapus!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/presensi/hapus_pengajuan_izin/' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  if (response.status == 'success') {
                     // Tampilkan SweetAlert untuk sukses
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        // Redirect atau lakukan tindakan lain setelah penghapusan
                        location.reload();
                     });
                  } else {
                     // Tampilkan SweetAlert untuk kesalahan
                     Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                     });
                  }
               }
            });
         }
      });
   }
</script>