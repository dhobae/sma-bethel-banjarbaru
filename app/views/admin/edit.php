<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Tambah Admin/Jabatan
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMK Telkom Banjarbaru
      </div>


      <form action="<?= URLROOT; ?>/admin/edit" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="id" value="<?= $data['admin']->id; ?>">
         <div class="form-group row">
            <label class="col">Nama Jabatan &nbsp;:&nbsp; <?= $data['admin']->nama_admin ?> </label>
            <div class="col-sm-9">
               <input type="hidden" class="form-control" id="nip" name="nip" value="<?= $data['admin']->nama_admin ?>" readonly>
            </div>
         </div>
         <h6>Daftar Admin/pejabat</h6>
         <ul>
            <?php
            foreach ($data['pegawai'] as $k) {
            ?>
               <input type="hidden" name="pegawai[]" value="<?= $k->nik; ?>">
               <li><?= $k->nama ?> (<?= $k->nik ?>) <a href="<?= URLROOT; ?>/admin/deleteAdmin/<?php echo $data['admin']->id . '-' . $k->nik ?>"> &nbsp;&nbsp;<b><span style="color:red">Hapus</span></b></a></li>
            <?php
            }
            ?>
         </ul>
         <div class="form-group col-lg-6">
            <select class="select2-pegawai-pejabat form-control" name="pegawai[]" id="select2SinglePlaceholder">
               <option value="">Select</option>
               <?php
               foreach ($data['daftar_pegawai'] as $pegi) {
               ?>
                  <option value="<?= $pegi->nik ?>"><?= $pegi->nama ?> (<?= $pegi->nik ?>)</option>
               <?php
               }
               ?>

            </select>
         </div>
         <div class="pb-4"></div>
         <div class="form-group row">
            <div class="col-sm-10">
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> &nbsp;Tambah Admin</button>
               <?php if ($_SESSION['role'] == 'admin') { ?>
                  <a href="<?= URLROOT; ?>/admin" class="btn btn-danger btn-sm"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
               <?php } else { ?>
                  <a href="<?= URLROOT; ?>/admin/kurikulum" class="btn btn-danger btn-sm"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
               <?php } ?>
            </div>
         </div>
      </form>


   </div>
</div>