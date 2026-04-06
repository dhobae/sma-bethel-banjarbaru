<?php
// FUNGSI
require APPROOT . '../../public/dist/lib/ip.php';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-outline card-primary" style="margin-top: 10px;">

   <div class="card-body">
      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px"> <br />
      </div>
      <div class="tengah judul1 mb-2">
         <b>SMA Bethel Banjarbaru<br />
            [Daftar Hari Libur Kelas]</b>
      </div>

      <div class="mb-2">
         <?php
         if ($_SESSION['role'] == 'admin') { ?>
            <div style="margin-top:-15px;">
               <a href="<?= URLROOT ?>/presensi/tambah_libur_kelas" class="btn btn-primary btn-sm tombol3"><i class="fa fa-plus-square"></i>&nbsp; Tambah/Isi Libur Kelas </a>
            </div>
         <?php } ?>
      </div>

      <div class="table-responsive">
         <table class="tabeltiga table-bordered table-striped" id="example">
            <thead>
               <tr>
                  <th style="width:40px;height:35px;">No</th>
                  <th style="width:170px;">Mulai dari</th>
                  <th style="width:170px;">Sampai dengan</th>
                  <th style="width:70px;">Kelas</th>
                  <th>Keterangan Libur</th>
                  <?php
                  if ($_SESSION['role'] == 'admin') { ?>
                     <th style="width:90px;">Aksi</th>
                  <?php } ?>
               </tr>
            </thead>

            <tbody>
               <?php
               $no = 1;
               if ($data['libur_kelas']) :
                  foreach ($data['libur_kelas'] as $field) :

                     $hari = date("l", strtotime($field->tanggal_mulai));
                     $hari = ($hari == "Sunday") ? "Minggu" : (($hari == "Monday") ? "Senin" : (($hari == "Tuesday") ? "Selasa" : (($hari == "Wednesday") ? "Rabu" : (($hari == "Thursday") ? "Kamis" : (($hari == "Friday") ? "Jum'at" : "Sabtu")))));
                     
                     $hari_akhir = date("l", strtotime($field->tanggal_akhir));
                     $hari_akhir = ($hari_akhir == "Sunday") ? "Minggu" : (($hari_akhir == "Monday") ? "Senin" : (($hari_akhir == "Tuesday") ? "Selasa" : (($hari_akhir == "Wednesday") ? "Rabu" : (($hari_akhir == "Thursday") ? "Kamis" : (($hari_akhir == "Friday") ? "Jum'at" : "Sabtu")))));
               ?>
                     <tr>
                        <td style="text-align:center;"> <?= $no ?> </td>
                        <td> <?= $hari ?>, <?= tanggal_indo($field->tanggal_mulai) ?> </td>
                        <td> <?= $hari_akhir ?>, <?= tanggal_indo($field->tanggal_akhir) ?> </td>
                        <td style="text-align:center;"> <?= $field->kelas ?> </td>
                        <td> <?= $field->keterangan_libur ?> </td>
                        <?php
                        if ($_SESSION['role'] == 'admin') { ?>
                           <td style="text-align:center;">
                              <a href="javascript:void(0)" onclick="hapus('<?= $field->id ?>')" style="color:red; font-weight:bold;"> Delete</a>
                           </td>
                        <?php } ?>
                     </tr>
                  <?php
                     $no++;
                  endforeach;
               else :
                  ?>
                  <tr>
                     <td colspan="6">
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
</div>

<script>
   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 20,
         "paging": true, //Nomor halaman di bawah
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
   function hapus(id) {
      console.log('URL: ' + '<?= URLROOT ?>/presensi/hapus_libur_kelas/' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Anda tidak bisa mengembalikan data yang dihapus!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/presensi/hapus_libur_kelas/' + id,
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
