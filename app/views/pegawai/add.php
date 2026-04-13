<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="tengah">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Daftar Guru dan Karyawan
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMA Bethel Banjarbaru
      </div>
   </div>
</div>


<form method="POST" action="<?= URLROOT ?>/pegawai/simpan" enctype="multipart/form-data">
   <div class="row">
      <div class="col">
         <button type="submit" class="btn btn-primary btn-sm tombol2" title="Simpan data"><i class="fa fa-save"></i> &nbsp;Simpan Data</button>

         <a href="<?= URLROOT ?>/pegawai" class="btn btn-danger btn-sm tombol2" title="Kemabli"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-4">
         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile tengah">
               <img src="<?= URLROOT ?>/smabethel/avatar/foto1.jpg" width="150px">
               <br /><br />
               <div class="divtujuh mb-2" style="text-align:right">
                  <input type="file" class="text1" name="avatar">
               </div>

            </div>
         </div>

         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile">
               <div class="form-group">
                  <label class="label2">Nomor RFID <small><i>*[masukkan dengan menempelkan kartu RFID]</i></small></label>
                  <input type="text" name="rfid" class="form-control text1" id="label2" required 
                        autocomplete="off"
                        autofocus
                        onkeydown="return event.key !== 'Enter'">
               </div>
            </div>
         </div>

         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile">
               <div class="form-group">
                  <label class="label1">Username <span style="color:red">*</span></label>
                  <input type="text" name="username" class="form-control text1" style="width:100%" readonly value="Sama dengan NIK">
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
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">NIK (Nomor Induk Kependudukan) <span style="color:red">*</span></label>
                        <input type="text" name="nik" class="form-control text1" style="width:100%" required>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Pendidikan</label>
                        <select name="pendidikan" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="S3">S3</option>
                           <option value="S2">S2</option>
                           <option value="S1">S1</option>
                           <option value="D3">D3</option>
                           <option value="SMA">SMA/SMK</option>
                           <option value="SMP">SMP</option>
                           <option value="SD">SD</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom:7px">
                  <label class="label1">Nama Lengkap <span style="color:red">*</span></label>
                  <input type="text" name="nama" class="form-control text1" style="width:100%" required>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nama Singkat</label>
                        <input type="text" name="kode" class="form-control text1" style="width:100%">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Jenis Kelamin <span style="color:red">*</span></label>
                        <select name="jk" class="form-control text1" style="width:100%" required>
                           <option value="">Pilih</option>
                           <option value="Laki-laki">Laki-laki</option>
                           <option value="Perempuan">Perempuan</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tempat Lahir <span style="color:red">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control text1" style="width:100%">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tanggal Lahir <span style="color:red">*</span></label>
                        <input type="date" name="tgl_lahir" class="form-control text1" style="width:100%;">
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom:7px">
                  <label class="label1">Alamat</label>
                  <input type="text" name="alamat" class="form-control text1" style="width:100%">
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
                        <label class="label1">Nomor WhatsApp <span style="color:red">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control text1" style="width:100%">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Aktifkan Notif Wa</label>
                        <select name="notif_wa" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Ya">Ya, Kirimkan notif WA</option>
                           <option value="Katolik">Tidak, jangan kirim notif WA</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control text1" style="width:100%">
                     </div>
                  </div>

                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Absen Mengajar <span style="color:red">*</span></label>
                        <select name="mengajar" class="form-control text1" style="width:100%" required>
                           <option value="">Pilih</option>
                           <option value="Ya">Ya, Harus mengisi absen mengajar</option>
                           <option value="Tidak">Tidak perlu mengisi absen Mengajar</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom:7px">
                  <label class="label1">Alamat Email</label>
                  <input type="text" name="email" class="form-control text1" style="width:100%">
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Status Pegawai</label>
                        <select name="full_time" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Full Time">Full Time</option>
                           <option value="Part Time">Part Time</option>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Absen Harian<span style="color:red">*</span></label>
                        <select name="absen" class="form-control text1" style="width:100%" required>
                           <option value="">Pilih</option>
                           <option value="Aktif">Aktif (harus absen setiap hari)</option>
                           <option value="Tidak">Tidak Aktif (tidak harus mengisi absen)</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</form>

<br /><br /><br />