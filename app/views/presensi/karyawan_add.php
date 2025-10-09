<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>Tambah Data Dosen/Karyawan</b>
   </div>

   <div class="card-body">
      <form method="post" action="<?= URLROOT ?>/presensi/karyawan_simpan">
         <div class="bg-white col-sm-8 border" style="margin:auto; padding:25px;">
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>NPK</label>
                     <input type="text" name="npk" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>NIK / NIP</label>
                     <input type="text" name="nik" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Nama</label>
                     <input type="text" name="nama" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Jabatan</label>
                     <select name="jabatan" class="form-control" required>
                        <option value="">-- pilih Jabatan --</option>
                        <?php
                        foreach ($data['jabatan'] as $field) {
                           echo "<option value='{$field->no}'> {$field->jabatan} </option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Alamat</label>
                     <input type="text" name="alamat" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Telpon</label>
                     <input type="text" name="telpon" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Jenis Kelamin</label>
                     <div class="full-size">
                        <label class="input-control radio">
                           <input type="radio" name="jenis_kelamin" value="Laki-laki" checked><span class="check"></span>
                           Laki-laki
                        </label>
                        &nbsp;&nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="jenis_kelamin" value="Perempuan"><span class="check"></span>
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
                           <input type="radio" name="status" value="Dosen" checked><span class="check"></span>
                           Dosen
                        </label>
                        &nbsp;&nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="status" value="pegawai"><span class="check"></span>
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
                           <input type="radio" name="absen" value="ya"><span class="check"></span>
                           Ya
                        </label>
                        &nbsp;&nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="absen" value="tidak" checked><span class="check"></span>
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