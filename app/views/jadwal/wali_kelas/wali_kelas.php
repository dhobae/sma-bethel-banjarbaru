<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         DAFTAR WALI KELAS
      </div>
      <div class="row">
         <div class="col-lg-7 center">
            <div class="mb-2">
               <?php if (Middleware::admin('kurikulum')) { ?>
                  <button type="button" onclick="kosongkan()" class="btn btn-danger btn-sm tombol2" title="Kosongkan semua"><i class="fa fa-times"></i> &nbsp; Hapus Semua</button>
               <?php } else { ?>
                  <button type="button" class="btn btn-danger btn-sm tombol2 disabled" title="Kosongkan semua"><i class="fa fa-times"></i> &nbsp; Hapus Semua</button>
               <?php } ?>
            </div>
            <table class="table tabel3">
               <thead style="background-color: azure">
                  <tr>
                     <th style="height:40px; width:60px">No</th>
                     <th style="width:90px">Kelas</th>
                     <th>Wali Kelas</th>
                     <th>Prodi</th>
                     <th style="width:70px">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $no = 1;
                  foreach ($data['wali_kelas'] as $d) : ?>
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center"><?= $d->kode_kelas ?></td>
                        <td><?= $d->nama ?></td>
                        <td class="text-center"><?= $d->prodi ?></td>
                        <td class="text-center">
                           <?php if (Middleware::admin('kurikulum')) { ?>
                              <button type="button" data-toggle="modal" data-target="#edit<?= $d->kode_kelas ?>" class="btn btn-primary btn-sm tombol1" title="edit data"><i class="fa fa-edit"></i></button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-primary btn-sm tombol1 disabled" title="edit data"><i class="fa fa-edit"></i></button>
                           <?php } ?>
                        </td>
                     </tr>
                  <?php $no++;
                  endforeach ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>




<?php
foreach ($data['wali_kelas'] as $d) :
?>
   <div class="modal fade" id="edit<?= $d->kode_kelas ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content p-1">
            <form method="POST" action="<?= URLROOT ?>/jadwal/edit_wali_kelas">
               <div class="modal-body">
                  <div style="font-weight:bold" class="mb-3">
                     Edit Data Kelas &nbsp;:&nbsp; <?= $d->kode_kelas ?>
                  </div>

                  <input type="hidden" name="kode_kelas" value="<?= $d->kode_kelas ?>">

                  <div class="form-group">
                     <label>Wali Kelas</label>
                     <select name="wali_kelas" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($data['nama_guru'] as $p) : ?>
                           <option value="<?= $p->nik ?>" <?= ($p->nik == $d->wali_kelas) ? 'selected' : '' ?>><?= $p->nama ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>

                  <div class="form-group">
                     <label>Prodi</label>
                     <select name="prodi" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($data['prodi'] as $p) : ?>
                           <option value="<?= $p->kode_prodi ?>" <?= ($p->kode_prodi == $d->prodi) ? 'selected' : '' ?>><?= $p->nama_prodi ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>

               </div>
               <div style="text-align:right">
                  <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                  <button type="submit" class="btn btn-success  btn-sm tombol3"><i class="fa fa-save"></i> Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php
endforeach;
?>


<script>
   function kosongkan() {
      //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
      Swal.fire({
         title: "Hapus Semua Wali Kelas?",
         text: "Jika anda hapus, maka semua wali kelas harus di isi ulang!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/jadwal/hapus_semua_wali_kelas',
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