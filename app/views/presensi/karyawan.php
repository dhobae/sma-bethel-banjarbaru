<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash2() ?>


<div class="card bg-olive" style="margin-top: 10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>Dosen / Karyawan STMIK Banjarbaru</b>
   </div>

   <div class="card-body">

      <?php if ($_SESSION['role'] == 'admin') { ?>
         <div style="margin-top:-15px; margin-left:-10px;">
            <a href="<?= URLROOT ?>/presensi/karyawan_add" class="myButton11" style="height:25px;padding-top:5px;">Tambah Dosen/Karyawan</a> <br />
         </div>
      <?php } ?>

      <center>
         <img src="<?= URLROOT ?>/dist/gambar/stmik-baru.png" width="60px"> <br />
         <h4>
            Daftar Dosen dan Karyawan STMIK Banjarbaru <br />
         </h4>
      </center>

      <table class="tabeltiga table-bordered table-striped" id="example">
         <thead>
            <tr>
               <th style="width: 40px; height:40px;">No</th>
               <?php if ($_SESSION['role'] == 'admin') { ?>
                  <th style="width: 80px;">Username</th>
               <?php } ?>
               <th style="width: 130px;">NIK / NIP</th>
               <th style="width: 250px;">Nama</th>
               <th>Jabatan</th>
               <th>Telpon</th>
               <?php if ($_SESSION['role'] == 'admin') { ?>
                  <th>Abs</th>
                  <th style="width:60px">Aksi</th>
               <?php } ?>
            </tr>
         </thead>
         <tbody>

            <?php
            $no = 1;
            if ($data['karyawan']) :
               foreach ($data['karyawan'] as $field) :
            ?>
                  <tr>
                     <td style="height:40px;text-align:center;"> <?= $no ?></td>
                     <?php if ($_SESSION['role'] == 'admin') { ?>
                        <td><?= $field->npk ?></td>
                     <?php } ?>
                     <td><?= $field->nik ?></td>
                     <td><?= $field->nama ?></td>
                     <td><?= $field->jabatan1 ?></td>
                     <td><?= $field->telpon ?></td>
                     <?php if ($_SESSION['role'] == 'admin') { ?>
                        <td><?= $field->absen ?></td>
                        <td style="text-align:center">
                           <a href="<?= URLROOT ?>/presensi/karyawan_edit?id=<?= $field->npk ?>" class="btn btn-sm btn-warning tomboltiga mb-1" title="Edit"><i class="fa fa-edit"></i></a>
                           <button type="button" onclick="deleteData('<?= $field->npk ?>')" class="btn btn-sm btn-danger tomboltiga mb-1" title="Hapus"><i class="fa fa-trash"></i></button>
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

<script>
   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 25,
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
            "sSearch": "Cari nama anda disini :"
         }
      });
   });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function deleteData(id) {
      console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
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
               url: '<?= URLROOT ?>/presensi/karyawan_hapus?id=' + id,
               type: 'POST',
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