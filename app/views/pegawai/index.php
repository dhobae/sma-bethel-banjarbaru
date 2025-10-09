<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Daftar Guru dan Karyawan
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMK Telkom Banjarbaru
      </div>

      <div class="mb-2">
         <?php if (($_SESSION['role'] == 'admin') || (Middleware::admin('kurikulum'))) { ?>
            <a href="<?= URLROOT ?>/pegawai/add" class="btn btn-primary btn-sm tombol2"><i class="fa fa-plus-square"></i> &nbsp;Tambah Data Guru/Karyawan</a>
         <?php } ?>


         <div class="float-right" style="font-size:0.88rem; font-family:'calibri'">
            Status Absen :
            <select style="width:100px" id="status" onchange="change_status()">
               <option value="Aktif" <?= ($data['status'] != 'Tidak') ? 'selected' : '' ?>>Aktif</option>
               <option value="Tidak" <?= ($data['status'] == 'Tidak') ? 'selected' : '' ?>>Tidak</option>
            </select>
         </div>
      </div>
      <div class="table-responsive">
         <table class="table tabel1 table-striped table-hover" id="example">
            <thead style="height:40px">
               <tr>
                  <th class="tengah" style="width:30px">No</th>
                  <?php if (($_SESSION['role'] == 'admin') || (Middleware::admin('kurikulum'))) { ?>
                     <th class="tengah" style="width:80px">Username</th>
                  <?php } ?>
                  <th class="tengah" style="width:80px">NIK</th>
                  <th class="tengah">Nama</th>
                  <th class="tengah" style="width:105px">Telpon</th>
                  <?php if ($_SESSION['role'] == 'admin') { ?>
                     <th class="tengah" style="width:60px">Notif<br />WA</th>
                  <?php } ?>
                  <th class="tengah" style="width:58px">Fulltime</th>
                  <th class="tengah" style="width:58px">Absen<br />Harian</th>
                  <th class="tengah" style="width:60px">Absen<br />Mengajar</th>
                  <th class="tengah" style="width:55px">Foto</th>
                  <?php if ($_SESSION['role'] == 'admin') { ?>
                     <th class="tengah" style="width:35px">Lock</th>
                  <?php } ?>
                  <th class="tengah" style="width:90px">Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $no = 1;
               foreach ($data['pegawai'] as $d) :
               ?>
                  <tr>
                     <td class="text-center"><?= $no ?></td>
                     <?php if (($_SESSION['role'] == 'admin') || (Middleware::admin('kurikulum'))) { ?>
                        <td class="text-center"><?= $d->username ?></td>
                     <?php } ?>
                     <td class="text-center"><?= $d->nik ?></td>
                     <td><?= $d->nama ?></td>
                     <td class="text-center">
                        <?php
                        if (substr($d->nomor_hp, 0, 1) != '0') {
                           echo "<span style='color:orange; font-weight:bold'>" . $d->nomor_hp . "</span>";
                        } else {
                           echo "<span style='color:green; font-weight:bold'>" . $d->nomor_hp . "</span>";
                        }
                        ?>
                     </td>
                     <?php if ($_SESSION['role'] == 'admin') { ?>
                        <td class="tengah"><?= $d->notif_wa ?></td>
                     <?php } ?>
                     <td class="text-center">
                        <?php if ($d->full_time == 'Full Time') {
                           echo "Ya";
                        } else {
                           echo "Tidak";
                        } ?>
                     </td>
                     <td class="text-center"><?= $d->absen ?></td>
                     <td class="tengah"><?= $d->mengajar ?></td>
                     <td class="text-center">
                        <?php if ($d->avatar) {
                           echo "Ada";
                        } else {
                           echo "-";
                        } ?>
                     </td>

                     <?php if ($_SESSION['role'] == 'admin') { ?>
                        <td class="text-center">
                           <?php if ($d->kunci != '1') { ?>
                              <a href="javascript:void(0)" onclick="kunci('<?= $d->nik ?>')" title="Klik, untuk mengunci akun">
                                 <i class="fa fa-lock-open" style="color:green; font-size:0.8em"></i>
                              </a>
                           <?php } else { ?>
                              <a href="javascript:void(0)" onclick="bukakunci('<?= $d->nik ?>')" title="Klik, untuk membuka kunci">
                                 <i class=" fa fa-lock" style="color:red; font-size:0.8em"></i>
                              </a>
                           <?php } ?>
                        </td>
                     <?php } ?>

                     <td class="tengah">
                        <?php if (($_SESSION['role'] == 'admin') || (Middleware::admin('kurikulum'))) { ?>
                           <a href="<?= URLROOT ?>/pegawai/edit/<?= $d->id_pegawai ?>" class="btn btn-success btn-sm tombol1"><i class="fa fa-edit tombol"></i></a>
                        <?php } ?>
                        <a href="<?= URLROOT ?>/pegawai/lihat/<?= $d->id_pegawai ?>" class="btn btn-info btn-sm tombol1"><i class="fa fa-eye tombol"></i></a>
                        <?php if ($_SESSION['role'] == 'admin') { ?>
                           <button type="button" onclick="hapus('<?= $d->id_pegawai ?>','<?= $d->nama ?>')" class="btn btn-danger btn-sm tombol1"><i class="fa fa-trash tombol"></i></button>
                        <?php } ?>
                     </td>
                  </tr>
               <?php
                  $no++;
               endforeach;
               ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<script>
   function change_status() {
      var status = document.getElementById('status').value;
      window.location.href = "<?= URLROOT ?>/pegawai/" + status;
   }
</script>



<script>
   var originalTableBorder = $('#example').css('border');
   var originalTablePadding = $('#example').css('padding');

   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 100,
         "paging": true,
         "lengthChange": true,
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function hapus(id, nama) {
      console.log('URL: ' + '<?= URLROOT ?>/pegawai/hapus?id=' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Pegawai : " + nama + " apakah yakin ingin dihapus",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/pegawai/hapus?id=' + id,
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

<script>
   function kunci(id) {
      console.log('URL: ' + '<?= URLROOT ?>/pegawai/kunci/' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Untuk mengunci akun yang anda pilih",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, kunci!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/pegawai/kunci?nik=' + id,
               type: 'POST',
               dataType: 'json',
               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        location.reload();
                     });
                  } else {
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

<script>
   function bukakunci(id) {
      console.log('URL: ' + '<?= URLROOT ?>/pegawai/bukakunci/' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Untuk membuka kunci akun yang anda pilih",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, buka!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/pegawai/bukakunci?nik=' + id,
               type: 'POST',
               dataType: 'json',
               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        location.reload();
                     });
                  } else {
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