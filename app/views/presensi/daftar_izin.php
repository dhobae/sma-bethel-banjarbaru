<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div style="margin-top:-10px;">
         <?php
         if ($_SESSION['role'] == 'admin') { ?>
            <a href="<?= URLROOT ?>/presensi/tambah_izin" class="btn btn-primary btn-sm tombol3"><i class="fa fa-plus-square"></i> &nbsp;Tambah Data izin Pegawai</a>
         <?php } ?>
      </div>

      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:22px; font-weight:bold">
         SMK Telkom Banjarbaru
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         [Daftar izin pegawai]
      </div>

      <table class="table tabel3 table-striped" id="example">
         <thead style="background-color: brown; color:white">
            <tr>
               <th style="width: 35px; height:45px;">No</th>
               <th style="width: 90px;">NIK/NIP</th>
               <th style="width: 230px;">Nama</th>
               <th style="width: 120px;">Mulai dari</th>
               <th style="width: 120px;">Sampai dengan</th>
               <th style="width: 50px;">Status</th>
               <th>Keterangan Izin</th>
               <?php
               if ($_SESSION['role'] == 'admin') { ?>
                  <th style="width: 60px;">Aksi</th>
               <?php } ?>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['daftar_izin']) :
               foreach ($data['daftar_izin'] as $field) :
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
                  echo "<td style='text-align:center;height:35px;'>" . $no . "</td>";
                  echo "<td>" . $field->nip . "</td>";
                  echo "<td>" . $field->namadosen . "</td>";
                  echo "<td>" . tanggal_indo($field->tanggal_mulai) . "</td>";
                  echo "<td>" . tanggal_indo($field->tanggal_akhir) . "</td>";
                  echo "<td>" . $field->status_izin . "</td>";
                  echo "<td>" . $field->keterangan_izin . "</td>";

                  if ($_SESSION['role'] == 'admin') { ?>
                     <td>
                        <a class="btn btn-success btn-sm tombol1 mt-1" href="<?= URLROOT ?>/presensi/edit_izin/<?= $field->id ?>" title="Edit izin pegawai"><i class="fa fa-edit"></i></a>

                        <a href="javascript:void(0)" onclick="hapus('<?= $field->id ?>')" class="btn btn-danger btn-sm tombol1 mt-1" title="Hapus izin"><i class="fa fa-trash"></i></a>
                     </td>
                     </tr>
               <?php }

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

</body>



<script>
   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 100,
         "paging": true, //Nomor halaman di bawah
         "lengthChange": true, //Jumlah ditampilkan berapa dulu
         "ordering": false,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": " _MENU_ perhalaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Cari disini :"
         }
      });
   });
</script>


<script>
   function hapus(id) {
      console.log('URL: ' + '<?= URLROOT ?>/presensi/hapus_izin/' + id);
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
               url: '<?= URLROOT ?>/presensi/hapus_izin/' + id,
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