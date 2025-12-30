<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Program Studi di SMA Bethel Banjarbaru
      </div>

      <div class="row">
         <div class="col-lg-10 center">

            <div class="mb-2">
               <?php if (Middleware::admin('kurikulum')) { ?>
                  <button type="button" class="btn btn-primary btn-sm tombol3" data-toggle="modal" data-target="#tambah" title="Tambah Prodi"><i class="fa fa-plus-square"></i> &nbsp;Tambah Data</button>
               <?php } else { ?>
                  <button type="button" class="btn btn-primary btn-sm tombol3 disabled" title="Tambah Prodi"><i class="fa fa-plus-square"></i> &nbsp;Tambah Data</button>
               <?php } ?>
            </div>
            <table class="table tabel3" id="example">
               <thead style="background-color: brown; color:white; height:40px">
                  <tr>
                     <th style="width:50px" class="text-center">No</th>
                     <th>Kode Prodi</th>
                     <th>Nama Prodi</th>
                     <th>Ketua Prodi</th>
                     <th>Status</th>
                     <th style="width:60px">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $no = 1;
                  foreach ($data['prodi'] as $d) : ?>
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td class="text-center"><?= $d->kode_prodi ?></td>
                        <td><?= $d->nama_prodi ?></td>
                        <td><?= $d->nama ?></td>
                        <td class="text-center">
                           <?php
                           if ($d->status_prodi == 'Aktif') {
                              echo "Aktif";
                           } else {
                              echo "Tidak Aktif";
                           }
                           ?>
                        </td>
                        <td class="text-center">
                           <?php if (Middleware::admin('kurikulum')) { ?>
                              <button type="button" data-toggle="modal" data-target="#edit<?= $d->id_prodi ?>" class="btn btn-success btn-sm tombol1" title="Edit data"><i class="fa fa-edit"></i></button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-success btn-sm tombol1 disabled" title="Edit data"><i class="fa fa-edit"></i></button>
                           <?php } ?>
                        </td>
                     </tr>
                  <?php $no++;
                  endforeach;
                  ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<!-- TAMBAH ---------------------------- -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content p-1">
         <form method="POST" action="<?= URLROOT ?>/jadwal/simpan_prodi">
            <div class="modal-body">
               <div style="font-weight:bold" class="mb-3">
                  Tambah Program Studi
               </div>
               <table style="width:100%">
                  <tr>
                     <td style="width:170px">Kode Prodi</td>
                     <td>
                        <input type="text" name="kode_prodi" class="form-control form-control-sm" required>
                     </td>
                  </tr>
                  <tr>
                     <td style="width:170px">Nama Lengkap Prodi</td>
                     <td>
                        <input type="text" name="nama_prodi" class="form-control form-control-sm" required>
                     </td>
                  </tr>
                  <tr>
                     <td style="width:170px">Ketua Prodi</td>
                     <td>
                        <select name="ketua_prodi" class="form-control form-control-sm">
                           <option value=""></option>
                           <?php foreach ($data['pegawai'] as $p) : ?>
                              <option value="<?= $p->nik ?>"><?= $p->nama ?></option>
                           <?php endforeach ?>
                        </select>
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
<?php foreach ($data['prodi'] as $d) : ?>
   <div class="modal fade" id="edit<?= $d->id_prodi ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content p-1">
            <form method="POST" action="<?= URLROOT ?>/jadwal/edit_prodi">
               <input type="hidden" name="id_prodi" value="<?= $d->id_prodi ?>">
               <div class="modal-body">
                  <div style="font-weight:bold" class="mb-3">
                     Edit Program Studi
                  </div>
                  <table style="width:100%">
                     <tr>
                        <td style="width:150px">Kode Prodi</td>
                        <td>
                           <input type="text" name="kode_prodi" class="form-control form-control-sm" required value="<?= $d->kode_prodi ?>">
                        </td>
                     </tr>
                     <tr>
                        <td>Nama Lengkap Prodi</td>
                        <td>
                           <input type="text" name="nama_prodi" class="form-control form-control-sm" required value="<?= $d->nama_prodi ?>">
                        </td>
                     </tr>
                     <tr>
                        <td>Ketua Prodi</td>
                        <td>
                           <select name="ketua_prodi" class="form-control form-control-sm">
                              <option value=""></option>
                              <?php foreach ($data['pegawai'] as $p) : ?>
                                 <option value="<?= $p->nik ?>" <?= ($p->nik == $d->ketua_prodi) ? 'selected' : '' ?>><?= $p->nama ?></option>
                              <?php endforeach ?>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td>Status Prodi</td>
                        <td>
                           <select name="status_prodi" class="form-control form-control-sm">
                              <option value="Aktif" <?= ($d->status_prodi == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                              <option value="Tidak" <?= ($d->status_prodi == 'Tidak') ? 'selected' : '' ?>>Tidak Aktif</option>
                           </select>
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