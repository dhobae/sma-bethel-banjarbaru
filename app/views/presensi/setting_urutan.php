<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Setting Urutan Daftar Hadir
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMA Bethel Banjarbaru
      </div>

      <form method="POST" action="<?= URLROOT ?>/presensi/simpan_urutan">
         <div class="mb-2 mt-2">
            <button type="button" onclick="reset_urutan()" class="btn btn-danger btn-sm tombol2" title="Reset semua urutan"><i class="fa fa-undo"></i> &nbsp;Reset Semua Urutan</button>
            <button type="submit" class="btn btn-primary btn-sm tombol2" title="Simpan semua urutan"><i class="fa fa-save"></i> &nbsp;Simpan Semua Urutan</button>
         </div>
         <div class="table-responsive">
            <table class="table tabel3 table-striped table-hover" id="example">
               <thead style="height:40px; background:brown; color:white">
                  <tr>
                     <th class="tengah" style="width:50px">No</th>
                     <th class="tengah" style="width:120px">NIK</th>
                     <th class="tengah">Nama</th>
                     <th class="tengah">Urutan</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $no = 1;
                  foreach ($data['pegawai'] as $d) :
                  ?>
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center"><?= $d->nik ?></td>
                        <td><?= $d->nama ?></td>
                        <td class="tengah">
                           <input type="hidden" name="nik[]" value="<?= $d->nik ?>" style="width:80px; text-align:center">
                           <input type="number" name="urutan[]" value="<?= $d->urutan ?>" style="width:80px; text-align:center">
                        </td>
                     </tr>
                  <?php
                     $no++;
                  endforeach;
                  ?>
               </tbody>
            </table>
         </div>
      </form>
   </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function reset_urutan() {
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Reset urutan akan mengakibatkan semua urutan akan menjadi sama",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, Reset!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/presensi/reset_urutan',
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