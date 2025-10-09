<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>Edit Data Dosen/Karyawan</b>
   </div>

   <div class="card-body">

      <form method="post" action="<?= URLROOT ?>/presensi/karyawan_edit_simpan">

         <div class="bg-white col-sm-8 border" style="margin:auto; padding:25px;">
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>NPK</label>
                     <input type="text" name="npk" class="form-control" value="<?= $data['karyawan']->npk ?>" readonly>
                  </div>
               </div>


               <div class="col-sm-6">
                  <div class="form-group">
                     <label>NIK / NIP</label>
                     <input type="text" name="nik" class="form-control" value="<?= $data['karyawan']->nik ?>">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Nama</label>
                     <input type="text" name="nama" class="form-control" value="<?= $data['karyawan']->nama ?>">
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Jabatan</label>
                     <select name="jabatan" class="form-control" required>
                        <?php
                        foreach ($data['jabatan'] as $field) { ?>
                           <option value='<?= $field->no ?>' <?= ($field->no === $data['karyawan']->jabatan) ? 'selected' : '' ?>><?= $field->jabatan ?> </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Alamat</label>
                     <input type="text" name="alamat" class="form-control" value="<?= $data['karyawan']->alamat ?>">
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Telpon</label>
                     <input type="text" name="telpon" class="form-control" value="<?= $data['karyawan']->telpon ?>">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Jenis Kelamin</label>
                     <div class="full-size">
                        <label class="input-control radio">
                           <input type="radio" name="jenis_kelamin" value="Laki-laki" <?php if ($data['karyawan']->jenis_kelamin == 'Laki-laki') echo 'checked' ?>>
                           <span class="check"></span>
                           Laki-laki
                        </label>
                        &nbsp;&nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="jenis_kelamin" value="Perempuan" <?php if ($data['karyawan']->jenis_kelamin == 'Perempuan') echo 'checked' ?>>
                           <span class="check"></span>
                           Perempuan
                        </label>
                     </div>
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Status Dosen / Karyawan</label>
                     <div class="full-size">
                        <label class="input-control radio">
                           <input type="radio" name="status" value="Dosen" <?php if ($data['karyawan']->status == 'Dosen') echo 'checked' ?>>
                           <span class="check"></span>
                           Dosen
                        </label>
                        &nbsp;&nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="status" value="pegawai" <?php if ($data['karyawan']->status == 'pegawai') echo 'checked' ?>>
                           <span class="check"></span>
                           Pegawai
                        </label>
                     </div>
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Status Presensi</label>
                     <div class="full-size">
                        <label class="input-control radio">
                           <input type="radio" name="absen" value="ya" <?php if ($data['karyawan']->absen == 'ya') echo 'checked' ?>>
                           <span class="check"></span>
                           Ya
                        </label>
                        &nbsp;&nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="absen" value="tidak" <?php if ($data['karyawan']->absen == 'tidak') echo 'checked' ?>>
                           <span class="check"></span>
                           Tidak
                        </label>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row cells2">
               <div class="cell">
                  <button type="submit" name="submit" class="btn btn-success btn-sm">SIMPAN</button>
                  <button type="submit" class="btn btn-danger btn-sm"><a href="<?= URLROOT ?>/presensi/karyawan" style="text-decoration:none;color:white;">BATAL</a></button>
               </div>
            </div>

         </div>

      </form>
   </div>
</div>