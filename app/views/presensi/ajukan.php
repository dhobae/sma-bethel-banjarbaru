<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>PENGAJUAN IZIN TIDAK MASUK KERJA</b>
   </div>

   <div class="card-body">


      <div class="bg-danger col-sm-6" style="background-color:red; margin:auto; padding:25px;">
         <form method="post" action="<?= URLROOT ?>/presensi/simpan_pengajuan_izin">
            <input type="hidden" name="npk" id="npk" value="<?= $_SESSION['username'] ?>">
            <div class="huruf1 tengah mb-3" style="color:white; font-weight:bold; font-size:20px">
               ~ Pengajuan Permohonan Izin tidak masuk kerja ~
            </div>
            <div class="form-group">
               <label>Jenis Izin</label>
               <div class="full-size">
                  <label class="input-control radio">
                     <input type="radio" name="status" value="Sakit"> <span class="check"></span> Sakit
                  </label>
                  &nbsp;
                  <label class="input-control radio">
                     <input type="radio" name="status" value="Cuti"> <span class="check"></span> Cuti Tahunan
                  </label>
                  &nbsp;
                  <label class="input-control radio">
                     <input type="radio" name="status" value="Cuti2" checked> <span class="check"></span> Cuti alasan penting
                  </label>
                  &nbsp;
                  <label class="input-control radio">
                     <input type="radio" name="status" value="TL"> <span class="check"></span> Tugas Luar
                  </label>
               </div>
            </div>

            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Mulai Tanggal</label>
                     <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="" min=now() required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Sampai Tanggal</label>
                     <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" value="" min=now() required>
                  </div>
               </div>
            </div>

            <div class="form-group">
               <label>Keterangan</label>
               <input type="text" class="form-control" name="keterangan" id="keterangan" required>
            </div>

            <div class="form-actions">
               <button type="submit" name="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               <button type="button" class="btn btn-primary btn-sm"><a style="color:white;" href="<?= URLROOT ?>/presensi/ajukan_izin"><i class="fa fa-undo"></i> &nbsp;Kembali</a></button>
            </div>
         </form>
      </div>

   </div>
</div>