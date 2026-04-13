<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>


<form method="post" action="<?= URLROOT ?>/pegawai/simpan_jam">
   <input type="hidden" name="id" value="<?= $data['id'] ?>">

   <div class="card-body bg-primary mt-2">
      <div class="row mb-2">
         <div class="col-lg-6">
            <div class="bg-navy col-lg-12" style="background-color:gray; margin:auto; padding:25px;">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label>Jumlah Hari Kerja dalam 1 bulan</label>
                        <input type="number" name="hari_kerja" value="<?= $data['jam']->hari_kerja ?>" class="form-control" style="text-align: center; font-weight:bold; width:70%">
                     </div>
                  </div>
                  <!-- <input type="hidden" name="hari_kerja" value="<?= $data['jam']->hari_kerja ?>"> -->
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label>Berlaku Mulai dari</label>
                        <input type="date" name="berlaku_mulai" value="<?= $data['jam']->berlaku_mulai ?>" class="form-control" style="text-align: center; font-weight:bold; width:70%" required>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-6">
            <div class="bg-navy col-lg-12" style="background-color:gray; margin:auto; padding:25px;">
               <label>Hari Kerja : Senin - Kamis</label>
               <br />
               <br />
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Masuk kerja<br />Status : WFO</small></label>
                        <input type="time" name="masuk" id="masuk" value="<?= $data['jam']->masuk ?>" class="form-control" style="background-color:aquamarine" onchange="hitungJamKerja()">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Pulang kerja<br />Status : WFO</label>
                        <input type="time" name="pulang" id="pulang" value="<?= $data['jam']->pulang ?>" class="form-control" style="background-color:aquamarine" onchange="hitungJamKerja()">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Masuk<br />Status : WFH</small></label>
                        <input type="time" name="wfh_masuk" id="wfh_masuk" value="<?= $data['jam']->wfh_masuk ?>" class="form-control" style="background-color:bisque">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Pulang<br />Status : WFH</label>
                        <input type="time" name="wfh_pulang" id="wfh_pulang" value="<?= $data['jam']->wfh_pulang ?>" class="form-control" style="background-color:bisque">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Jumlah Jam Istirahat<br />WFO dan WFH</label>
                        <input type="number" name="jam_istirahat" id="jam_istirahat" value="<?= $data['jam']->jam_istirahat ?>" class="form-control" style="background-color:thistle; font-weight:bold" onchange="hitungJamKerja()" min="0" step="0.25">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Total Jam Kerja<br />Perhari</label>
                        <input type="text" id="hasil" name="jam_kerja" class="form-control" value="<?= $data['jam']->jam_kerja ?>" readonly>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-lg-6">
            <div class="bg-navy col-lg-12" style="background-color:gray; margin:auto; padding:25px;">
               <label>Hari Kerja : Jumat</label>
               <br />
               <br />
               <div class="row">
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Masuk Kerja<br />Status : WFO</label>
                        <input type="time" name="masuk_jumat" id="masuk_jumat" value="<?= $data['jam']->masuk_jumat ?>" class="form-control" style="background-color:aquamarine" onchange="hitungJamKerja_jumat()">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Pulang Kerja<br />Status : WFO</label>
                        <input type="time" name="pulang_jumat" id="pulang_jumat" value="<?= $data['jam']->pulang_jumat ?>" class="form-control" style="background-color:aquamarine" onchange="hitungJamKerja_jumat()">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Masuk Kerja<br />Status : WFH</label>
                        <input type="time" name="masuk_jumat_wfh" value="<?= $data['jam']->masuk_jumat_wfh ?>" class="form-control" style="background-color:bisque">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Default Jam Pulang Kerja<br />Status : WFH</label>
                        <input type="time" name="pulang_jumat_wfh" value="<?= $data['jam']->pulang_jumat_wfh ?>" class="form-control" style="background-color:bisque">
                     </div>
                  </div>

                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Jumlah Jam Istirahat<br />WFO dan WFH</label>
                        <input type="number" name="jam_istirahat_jumat" id="jam_istirahat_jumat" value="<?= $data['jam']->jam_istirahat_jumat ?>" class="form-control" style="background-color:thistle; font-weight:bold" onchange="hitungJamKerja_jumat()" min="0" step="0.25">
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="form-group">
                        <label style="color:white;">Total Jam Kerja<br />Perhari</label>
                        <input type="text" id="hasil_jumat" name="jam_kerja_jumat" class="form-control" value="<?= $data['jam']->jam_kerja_jumat ?>" readonly>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="form-actions mt-3">
         <button type="submit" name="submit" class="btn btn-warning btn-sm"> <i class="fa fa-save"></i> &nbsp;<b>Simpan</b> </button>
         <button type="button" class="btn btn-danger btn-sm"><a style="color:white;" href="<?= URLROOT ?>/pegawai/master_jam_all"> <i class="fa fa-undo"></i> &nbsp;<b>Kembali</b> </a></button>
      </div>

   </div>
</form>





<script>
   function hitungJamKerja() {
      const jamMasuk = document.getElementById('masuk').value;
      const jamPulang = document.getElementById('pulang').value;
      const jamIstirahat = parseFloat(document.getElementById('jam_istirahat').value);

      if (jamMasuk && jamPulang && !isNaN(jamIstirahat)) {
         const [jamMasukJam, jamMasukMenit] = jamMasuk.split(':').map(Number);
         const [jamPulangJam, jamPulangMenit] = jamPulang.split(':').map(Number);

         const totalMenitMasuk = (jamMasukJam * 60) + jamMasukMenit;
         const totalMenitPulang = (jamPulangJam * 60) + jamPulangMenit;

         let totalMenitKerja = totalMenitPulang - totalMenitMasuk;
         totalMenitKerja -= (jamIstirahat * 60);

         const jamKerja = Math.floor(totalMenitKerja / 60);
         const menitKerja = totalMenitKerja % 60;

         const totalJamKerja = jamKerja + (menitKerja / 60);

         document.getElementById('hasil').value = totalJamKerja.toFixed(2);
      } else {
         document.getElementById('hasil').value = '';
      }
   }

   document.getElementById('masuk').addEventListener('input', hitungJamKerja);
   document.getElementById('pulang').addEventListener('input', hitungJamKerja);
   document.getElementById('jam_istirahat').addEventListener('input', hitungJamKerja);
</script>

<script>
   function hitungJamKerja_jumat() {
      const jamMasuk = document.getElementById('masuk_jumat').value;
      const jamPulang = document.getElementById('pulang_jumat').value;
      const jamIstirahat = parseFloat(document.getElementById('jam_istirahat_jumat').value);

      if (jamMasuk && jamPulang && !isNaN(jamIstirahat)) {
         const [jamMasukJam, jamMasukMenit] = jamMasuk.split(':').map(Number);
         const [jamPulangJam, jamPulangMenit] = jamPulang.split(':').map(Number);

         const totalMenitMasuk = (jamMasukJam * 60) + jamMasukMenit;
         const totalMenitPulang = (jamPulangJam * 60) + jamPulangMenit;

         let totalMenitKerja = totalMenitPulang - totalMenitMasuk;
         totalMenitKerja -= (jamIstirahat * 60);

         const jamKerja = Math.floor(totalMenitKerja / 60);
         const menitKerja = totalMenitKerja % 60;

         const totalJamKerja = jamKerja + (menitKerja / 60);

         document.getElementById('hasil_jumat').value = totalJamKerja.toFixed(2);
      } else {
         document.getElementById('hasil_jumat').value = '';
      }
   }

   document.getElementById('masuk').addEventListener('input', hitungJamKerja_jumat);
   document.getElementById('pulang').addEventListener('input', hitungJamKerja_jumat);
   document.getElementById('jam_istirahat').addEventListener('input', hitungJamKerja_jumat);
</script>