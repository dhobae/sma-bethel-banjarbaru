<div class="card" style="margin-top: 10px; background:azure">
   <div class="card-header bg-danger" style="padding:8px 10px;">
      <b>Saran dan Masukan saya </b>
   </div>

   <div class="card-body">
      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="160px">
         <br />
      </div>
      <div class="tengah judul1 mb-4">
         <b>Berikan Pendapat anda</b>
      </div>

      <form method="POST" action="<?= URLROOT ?>/backup/simpan_pendapat">
         <div class="row justify-content-md-center">
            <di class="col-lg-8 tengah">
               <div>
                  <b>Menurut anda, Apakah Presensi ini tetap digunakan untuk tidak?</b>
                  <div class="mt-2">
                     <select name="pendapat" required>
                        <option value="">~Pilih~</option>
                        <option value="Ya">Ya, tetap di gunakan presensi ini</option>
                        <option value="Tidak">Tidak, gunakan yang sudah ada saja</option>
                     </select>
                  </div>
               </div>
               <div class="mt-3">
                  <b>Berikan Catatan dan saran anda di bawah</b>
                  <div>
                     <textarea style="width:70%" rows="10" name="saran"></textarea>
                  </div>
               </div>
               <div class="mt-2">
                  <button type="submit" class="btn btn-primary btn-sm tombol3" title="Kirim kritik dan saran anda" style="width:90px">Kirim Catatan</button>
                  <a href="<?= URLROOT ?>" class="btn btn-danger btn-sm tombol3" title="Kembali" style="width:90px">Batal kirim</a>
               </div>
            </di>
         </div>
      </form>
   </div>
</div>