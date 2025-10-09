<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:35px; padding:5px 10px;">
      <b>Pengaturan Hari Libur Kerja</b>
   </div>

   <div class="card-body">
      <div class="bg-danger col-sm-6" style="background-color:red; margin:auto; padding:25px;">
         <form method="post" action="<?= URLROOT ?>/presensi/simpan_libur">
            <b>Pada hari/tanggal hari libur, tombol presensi karyawan otomatis akan di nonaktifkan, perhatikan tanggal hari libur yang dimasukkan</b> <br /><br />
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Libur Mulai Tanggal</label>
                     <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="" class="form-control" required style="width:200px">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>libur Sampai Tanggal</label>
                     <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="" class="form-control" required style="width:200px">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Keterangan / Hari Libur apa</label>
                     <input type="text" name="keterangan" id="keterangan" value="" class="form-control" required>
                  </div>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" name="submit" class="btn btn-warning btn-sm"> <b>Simpan</b> </button>
               <button type="button" class="btn btn-success btn-sm"><a style="color:white;" href="<?= URLROOT ?>/presensi/hari_libur"> <b>Kembali</b></a></button>
            </div>
         </form>
      </div>
   </div>
</div>