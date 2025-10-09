<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>PENGAJUAN IZIN TIDAK MASUK KERJA</b>
   </div>

   <div class="card-body">

      <div class="bg-danger" style="background-color:red; width:500px; margin:auto; padding:25px;">
         <form method="post" action="<?= URLROOT ?>/presensi/simpan_edit_pengajuan_izin">
            <input type="hidden" name="npk" id="npk" value="<?= $_SESSION['username'] ?>">
            <input type="hidden" name="id" id="id" value="<?= $data['ajukan_izin_byid']->id ?>">
            <div class="huruf1 tengah mb-3" style="color:white; font-weight:bold; font-size:20px">
               ~ Edit Pengajuan Permohonan Izin tidak masuk kerja ~
            </div>
            <div class="form-group">
               <label>Jenis Izin</label>
               <div class="full-size">
                  <label class="input-control radio">
                     <input type="radio" name="status" value="Sakit" <?php if ($data['ajukan_izin_byid']->status_izin == 'Sakit') echo 'checked' ?>> <span class="check"></span> <span style="color:white; font-weight: bold;"> Sakit </span>
                  </label>
                  &nbsp;
                  <label class="input-control radio">
                     <input type="radio" name="status" value="Cuti" <?php if ($data['ajukan_izin_byid']->status_izin == 'Cuti') echo 'checked' ?>> <span class="check"></span> <span style="color:white; font-weight: bold;"> Cuti Tahunan </span>
                  </label>
                  &nbsp;
                  <label class="input-control radio">
                     <input type="radio" name="status" value="Cuti2" <?php if ($data['ajukan_izin_byid']->status_izin == 'Cuti2') echo 'checked' ?>> <span class="check"></span> <span style="color:white; font-weight: bold;"> Cuti alasan penting</span>
                  </label>
                  &nbsp;
                  <label class="input-control radio">
                     <input type="radio" name="status" value="TL" <?php if ($data['ajukan_izin_byid']->status_izin == 'TL') echo 'checked' ?>> <span class="check"></span> <span style="color:white; font-weight: bold;">Tugas Luar</span>
                  </label>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Mulai Tanggal</label>
                     <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="<?= $data['ajukan_izin_byid']->tanggal_mulai ?>">
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Sampai Tanggal</label>
                     <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" value="<?= $data['ajukan_izin_byid']->tanggal_akhir ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <label>Keterangan</label>
               <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?= $data['ajukan_izin_byid']->keterangan_izin ?>">
            </div>

            <div class="form-actions">
               <button type="submit" name="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               <button type="button" class="btn btn-primary btn-sm"><a style="color:white;" href="<?= URLROOT ?>/presensi/ajukan_izin"><i class="fa fa-undo"></i> &nbsp;Kembali</a></button>
            </div>
      </div>
      </form>
   </div>
</div>
</div>