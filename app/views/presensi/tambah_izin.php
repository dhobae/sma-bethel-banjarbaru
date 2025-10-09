<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>Tambah Data Izin / Sakit / Cuti / Tugas Luar</b>
   </div>

   <div class="card-body">
      <div class="bg-danger col-sm-6" style="background-color:red; margin:auto; padding:25px;">
         <form method="post" action="<?= URLROOT ?>/presensi/simpan_tambah_izin">
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Nama Dosen / Karyawan</label>
                     <select name="npk" class="form-control" required>
                        <option value="">-- pilih dosen / karyawan --</option>
                        <?php foreach ($data['daftar'] as $field) { ?>
                           <option value='<?= $field->nik ?>'> <?= $field->nama ?> </option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Jenis Izin</label>
                     <div class="full-size">
                        <label class="input-control radio">
                           <input type="radio" name="status" value="Sakit"><span class="check"></span> Sakit
                        </label>
                        &nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="status" value="Cuti"> <span class="check"></span> Cuti
                        </label>
                        &nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="status" value="Izin" checked> <span class="check"></span> Izin
                        </label>
                        &nbsp;
                        <label class="input-control radio">
                           <input type="radio" name="status" value="TL"> <span class="check"></span> Tugas Luar
                        </label>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Mulai Tanggal</label>
                     <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="" class="form-control" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label for="tanggal_akhir">Sampai Tanggal</label>
                     <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Keterangan</label>
                     <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" name="submit" class="btn btn-warning btn-sm"> <i class="fa fa-save"></i><b> &nbsp;Simpan</b> </button>
               <button type="button" class="btn btn-primary btn-sm"><a style="color:white;" href="<?= URLROOT ?>/presensi/daftar_izin"> <i class="fa fa-undo"></i><b> &nbsp; Kembali</b></a></button>
            </div>
         </form>
      </div>
   </div>
</div>