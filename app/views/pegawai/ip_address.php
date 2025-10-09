<?php
$tanggal = date("Y-m-d");
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card" style="margin-top: 10px;">
   <div class="card-header bg-danger" style="height:35px; padding:5px 10px;">
      <b>IP Address yang terdaftar sebagai WFO</b>
   </div>

   <div class="card-body">
      <div style="margin-top:-10px;">
         <button type="button" class="btn btn-primary btn-sm tombol3" data-toggle="modal" data-target="#tambah" title="tambah blok IP address"></i> &nbsp;<b>Tambah Blok IP Address</b></button>
      </div>

      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="160px">
      </div>
      <div class="tengah huruf1">
         <h5><b>IP Address Yang Terdaftar sebagai WFO</b></h5>
         <br />
      </div>

      <table class="table tabel3 table-bordered table-striped">
         <thead style="background-color: brown; color:white">
            <tr>
               <th style="width:60px; text-align:center; height:40px;"> No </th>
               <th style="width:200px;"> Blok IP Address </th>
               <th> Keterangan </th>
               <th style="width:120px; text-align:center;"> Aksi </th>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['ip']) :
               foreach ($data['ip'] as $field) :
                  echo "<tr>";
                  echo "<td style='text-align:center;'>" . $no . "</td>";
                  echo "<td>" . $field->ip_address . "</td>";
                  echo "<td>" . $field->keterangan . "</td>";
                  echo "<td style='text-align:center;'>";
            ?>
                  <button type="button" data-toggle="modal" data-target="#edit<?= $field->id ?>" class="btn btn-success btn-sm tombol1 mb-1" title="Edit Data"><i class="fa fa-edit"></i></button>
                  <button type="button" onclick="deleteData('<?= $field->id ?>')" class="btn btn-danger btn-sm tombol1 mb-1" title="hapus Data"><i class="fa fa-trash"></i></button>
                  </td>
            <?php
                  $no++;
               endforeach;
            else :
               echo "<tr>";
               echo "<td colspan='4'> Data tidak ditemukan </td>";
               echo "</tr>";
            endif;
            ?>
         </tbody>
      </table>
   </div>
</div>

<!-- Modal TAMBAH -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form method="POST" action="<?= URLROOT ?>/pegawai/simpan_ip_address">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">Tambah Blok IP</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label class="huruf1">Blok IP</label>
                  <input type="text" name="ip_address" class="form-control text1">
               </div>

               <div class="form-group">
                  <label class="huruf1">Nama / Keterangan</label>
                  <input type="text" name="keterangan" class="form-control text1">
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
               <button type="submit" class="btn btn-primary btn-sm tombol3"><i class="fa fa-save"></i> &nbsp;Simpan</button>
            </div>
         </div>
      </form>
   </div>
</div>

<!-- EDIT -- -->
<?php
foreach ($data['ip'] as $d) :
?>
   <div class="modal fade" id="edit<?= $d->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <form method="POST" action="<?= URLROOT ?>/pegawai/edit_ip_address">
            <input type="hidden" name="id" value="<?= $d->id ?>">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Tambah Blok IP</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <label class="huruf1">Blok IP</label>
                     <input type="text" name="ip_address" value="<?= $d->ip_address ?>" class="form-control text1">
                  </div>

                  <div class="form-group">
                     <label class="huruf1">Nama / Keterangan</label>
                     <input type="text" name="keterangan" value="<?= $d->keterangan ?>" class="form-control text1">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                  <button type="submit" class="btn btn-primary btn-sm tombol3"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               </div>
            </div>
         </form>
      </div>
   </div>
<?php
endforeach;
?>


<script>
   function deleteData(id) {
      console.log('URL: ' + '<?= URLROOT ?>/pegawai/hapus_ip_address/' + id);
      console.log(id);
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
               url: '<?= URLROOT ?>/pegawai/hapus_ip_address/' + id,
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