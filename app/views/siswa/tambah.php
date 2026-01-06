<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('rfidInput').addEventListener('keydown', function(event) {
         if (event.key === 'Enter') {
            event.preventDefault();
            // Tambahkan kode untuk memproses data RFID di sini jika diperlukan
            console.log('RFID scanned:', event.target.value);
         }
      });
   });
</script>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah" style="font-size:20px; font-weight:bold">
         Tambah Data Siswa SMA Bethel Banjarbaru
      </div>
   </div>
</div>


<form method="POST" action="<?= URLROOT ?>/siswa/simpan" enctype="multipart/form-data">
   <div class="row">
      <div class="col">
         <button type="submit" class="btn btn-primary btn-sm tombol2" title="Simpan data"><i class="fa fa-save"></i> &nbsp;Simpan Data</button>

         <a href="<?= URLROOT ?>/siswa" class="btn btn-danger btn-sm tombol2" title="Kemabli"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-4">
         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile tengah">
               <img src="<?= URLROOT ?>/smabethel/avatar/foto1.jpg" width="150px">
               <br /><br />
               <div class="divtujuh mb-2" style="text-align:right">
                  <input type="file" class="text1" name="avatar" accept=".jpg, .jpeg, .png">
               </div>
            </div>
         </div>

         <?php if (Middleware::admin('kurikulum')) { ?>
            <div class="card card-primary card-outline" style="margin-top:10px;">
               <div class="card-body box-profile">
                  <div class="form-group">
                     <label class="label1">Nomor RFID <small><i>*[masukkan dengan menempelkan kartu RFID]</i></small></label>
                     <input type="text" class="form-control text1" name="nomor_rfid" id="rfidInput" placeholder="RFID">
                  </div>
               </div>
            </div>
         <?php } ?>

         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile">
               <div class="form-group">
                  <label class="label1">Username <span style="color:red">*</span></label>
                  <input type="text" name="username" class="form-control text1" style="width:100%" readonly value="Sama dengan NIS">
               </div>

               <div class="form-group">
                  <label class="label1">Password (default)</label>
                  <input type="text" name="password" class="form-control text1" style="width:100%" value="SMABETHEL" readonly>
               </div>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile">
               <div class="row">
                  <div class="col-lg-4">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">NIS <span style="color:red">*</span></label>
                        <input type="text" name="nis" class="form-control text1" style="width:100%" maxlength="10" required>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nama Lengkap <span style="color:red">*</span></label>
                        <input type="text" name="nama" class="form-control text1" style="width:100%" required>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Prodi <span style="color:red">*</span></label>
                        <select name="prodi" class="form-control text1" required>
                           <option value="">Pilih</option>
                           <?php foreach ($data['prodi'] as $p) : ?>
                              <option value="<?= $p->id_prodi ?>"><?= $p->kode_prodi ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tahun Masuk <span style="color:red">*</span></label>
                        <input type="number" name="tahun_masuk" class="form-control text1" style="width:100%" required>
                     </div>
                  </div>

                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Kelas <span style="color:red">*</span></label>
                        <select name="kelas_siswa" class="form-control text1" required>
                           <option value="">Pilih</option>
                           <option value="X">X (Sepuluh)</option>
                           <option value="XI">XI (Sebelas)</option>
                           <option value="XII">XII (Dua Belas)</option>
                        </select>
                     </div>
                  </div>

                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Ruang <span style="color:red">*</span></label>
                        <select name="ruang_siswa" class="form-control text1" required>
                           <option value="">Pilih</option>
                           <option value="A">A</option>
                           <option value="B">B</option>
                           <option value="C">C</option>
                           <option value="D">D</option>
                           <option value="E">E</option>
                           <option value="F">F</option>
                           <option value="G">G</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control text1" style="width:100%">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control text1" style="width:100%;">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Laki-laki">Laki-laki</option>
                           <option value="Perempuan">Perempuan</option>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nomor WhatsApp</label>
                        <input type="text" name="nomor_hp" class="form-control text1" style="width:100%">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Agama</label>
                        <select name="agama" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Islam">Islam</option>
                           <option value="Katolik">Katolik</option>
                           <option value="Protestan">Protestan</option>
                           <option value="Budha">Budha</option>
                           <option value="Hindu">Hindu</option>
                           <option value="Kepercayaan">Kepercayaan</option>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">NISN</label>
                        <input type="text" name="nisn" class="form-control text1" style="width:100%">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Alamat</label>
                        <input type="text" name="alamat" class="form-control text1" style="width:100%">
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Propinsi</label>
                        <select id="propinsiSelect" name="propinsi" style="width:100%" class="form-control text1">
                           <option value="">Pilih</option>
                           <?php foreach ($data['propinsi'] as $p) : ?>
                              <option value="<?= $p->id_propinsi ?>"><?= $p->nama_propinsi ?></option>
                           <?php endforeach; ?>
                        </select>
                     </div>
                  </div>

                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Kabupaten</label>
                        <select id="kabupatenSelect" name="kabupaten" style="width:100%" class="form-control text1">
                           <option value="">Pilih</option>
                        </select>
                     </div>
                  </div>

                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Kecamatan</label>
                        <select id="kecamatanSelect" name="kecamatan" style="width:100%" class="form-control text1">
                           <option value="">Pilih</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control text1" style="width:100%">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nama Ibu Kandung</label>
                        <input type="text" name="nama_ibu" class="form-control text1" style="width:100%">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nomor HP Wali <span style="color:red">*</span></label>
                        <input type="text" name="nomor_hp_wali" class="form-control text1" style="width:100%" required>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col-8">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Alamat Wali</label>
                        <input type="text" name="alamat_wali" class="form-control text1" style="width:100%">
                     </div>
                  </div>

                  <div class="col-4">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" class="form-control text1" style="width:100%">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>





<script>
   $(document).ready(function() {
      $('#propinsiSelect').select2();
      $('#kabupatenSelect').select2();
      $('#kecamatanSelect').select2();

      $('#propinsiSelect').change(function() {
         var propinsiId = $(this).val();
         if (propinsiId !== '') {
            $.ajax({
               url: '<?= URLROOT ?>/siswa/kabupaten',
               method: 'GET',
               data: {
                  propinsiId: propinsiId
               },
               success: function(response) {
                  $('#kabupatenSelect').html(response);
               },
               error: function(xhr, status, error) {
                  console.error(xhr.responseText);
               }
            });
         } else {
            $('#kabupatenSelect').html('<option value="">Pilih Kabupaten</option>');
         }
      });

      $('#kabupatenSelect').change(function() {
         var kabupatenId = $(this).val();
         if (kabupatenId !== '') {
            $.ajax({
               url: '<?= URLROOT ?>/siswa/kecamatan',
               method: 'GET',
               data: {
                  kabupatenId: kabupatenId
               },
               success: function(response) {
                  $('#kecamatanSelect').html(response);
               },
               error: function(xhr, status, error) {
                  console.error(xhr.responseText);
               }
            });
         } else {
            $('#kecamatanSelect').html('<option value="">Pilih</option>');
         }
      });
   });
</script>