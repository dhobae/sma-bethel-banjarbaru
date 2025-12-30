<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Mata Pelajaran SMA Bethel Banjarbaru
      </div>

      <div class="mb-2">
         <button type="button" class="btn btn-primary btn-sm tombol3" data-toggle="modal" data-target="#tambah" title="Tambah Mata Pelajaran"><i class="fa fa-plus-square"></i> &nbsp;Tambah Data</button>
      </div>
      <table class="table tabel3" id="example">
         <thead style="background-color: brown; color:white; height:40px">
            <tr>
               <th style="width:60px" class="text-center">No</th>
               <th>Mata Pelajaran</th>
               <th>Singkatan</th>
               <th>Prodi</th>
               <th style="width:60px">Aksi</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $no = 1;
            foreach ($data['pelajaran'] as $d) : ?>
               <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td><?= $d->mata_pelajaran ?></td>
                  <td class="text-center"><?= $d->singkatan ?></td>
                  <td class="text-center">
                     <?= $d->prodi ?>
                  </td>
                  <td class="text-center">
                     <button type="button" data-toggle="modal" data-target="#edit<?= $d->id_pelajaran ?>" class="btn btn-success btn-sm tombol1" title="Edit data"><i class="fa fa-edit"></i></button>

                     <button onclick="deleteData('<?= $d->id_pelajaran ?>')" type="button" class="btn btn-danger btn-sm tombol1" title="Hapus data"><i class="fa fa-trash"></i></button>
                  </td>
               </tr>
            <?php $no++;
            endforeach;
            ?>
         </tbody>
      </table>
   </div>
</div>

<!-- TAMBAH ---------------------------- -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content p-1">
         <form method="POST" action="<?= URLROOT ?>/jadwal/simpan_pelajaran">
            <div class="modal-body">
               <div style="font-weight:bold" class="mb-3">
                  Tambah Mata Pelajaran
               </div>
               <table style="width:100%">
                  <tr>
                     <td style="width:170px">Mata Pelajaran</td>
                     <td>
                        <input type="text" name="mata_pelajaran" class="form-control form-control-sm" required>
                     </td>
                  </tr>
                  <tr>
                     <td>Singkatan <small><i>[*Maks 10 huruf]</i></small></td>
                     <td>
                        <input type="text" name="singkatan" class="form-control form-control-sm" maxlength="10" style="width:150px" required>
                     </td>
                  </tr>
                  <tr>
                     <td style="vertical-align: top;">Prodi / Jurusan</td>
                     <td>
                        <?php foreach ($data['prodi'] as $p) { ?>
                           <input type="checkbox" name="prodi[]" value="<?= $p->kode_prodi ?>">
                           <?= $p->nama_prodi ?>
                           <br />
                        <?php } ?>
                     </td>
                  </tr>
               </table>
            </div>
            <div style="text-align:right">
               <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
               <button type="submit" class="btn btn-success  btn-sm tombol3"><i class="fa fa-save"></i> Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>




<!-- EDIT ---------------------------- -->
<?php foreach ($data['pelajaran'] as $d) : ?>
   <div class="modal fade" id="edit<?= $d->id_pelajaran ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content p-1">
            <form method="POST" action="<?= URLROOT ?>/jadwal/edit_pelajaran">
               <input type="hidden" name="id_pelajaran" value="<?= $d->id_pelajaran ?>">
               <div class="modal-body">
                  <div style="font-weight:bold" class="mb-3">
                     Edit Mata Pelajaran
                  </div>
                  <table style="width:100%">
                     <tr>
                        <td style="width:170px">Mata Pelajaran</td>
                        <td>
                           <input type="text" name="mata_pelajaran" class="form-control form-control-sm" value="<?= $d->mata_pelajaran ?>" required>
                        </td>
                     </tr>
                     <tr>
                        <td>Singkatan <small><i>[*Maks 10 huruf]</i></small></td>
                        <td>
                           <input type="text" name="singkatan" class="form-control form-control-sm" maxlength="10" style="width:150px" value="<?= $d->singkatan ?>" required>
                        </td>
                     </tr>
                     <tr>
                        <td style="vertical-align: top">Prodi</td>
                        <td>
                           <?php
                           if (is_string($d->prodi)) {
                              $selected_prodi = explode(',', $d->prodi);
                           }
                           ?>
                           <?php foreach ($data['prodi'] as $p) { ?>
                              <input type="checkbox" name="prodi[]" value="<?= $p->kode_prodi ?>" <?= in_array($p->kode_prodi, $selected_prodi) ? 'checked' : '' ?>>
                              <?= $p->nama_prodi ?>
                              <br />
                           <?php } ?>
                        </td>
                     </tr>
                  </table>
               </div>
               <div style="text-align:right">
                  <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
                  <button type="submit" class="btn btn-success  btn-sm tombol3"><i class="fa fa-save"></i> Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php endforeach; ?>


<script>
   function deleteData(id) {
      console.log('URL: ' + '<?= URLROOT ?>/jadwal/hapus_pelajaran/' + id);
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
               url: '<?= URLROOT ?>/jadwal/hapus_pelajaran/' + id,
               type: 'GET',
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