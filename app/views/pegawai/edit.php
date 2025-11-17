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

<form method="POST" action="<?= URLROOT ?>/pegawai/simpan_edit">
   <input type="hidden" name="id_pegawai" value="<?= $data['pegawai']->id_pegawai ?>">
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
               <?php if ($data['pegawai']->avatar) { ?>
                  <img src="<?= URLROOT ?>/smabethel/avatar/<?= $data['pegawai']->avatar ?>" width="150px">
               <?php } else { ?>
                  <img src="<?= URLROOT ?>/smabethel/avatar/foto1.jpg" width="150px">
               <?php } ?>
               <br /><br />
               <div class="divtujuh mb-2" style="text-align:right">
                  <a href="#" data-toggle="modal" data-target="#gantifoto" style="font-size:0.9em"><b><i class="fa fa-edit"></i> Pilih Foto Profil</b></a>
               </div>
            </div>
         </div>

         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile">
               <div class="form-group">
                  <label class="label2">Nomor RFID <small><i>*[masukkan dengan menempelkan kartu RFID]</i></small></label>
                  <input type="text" name="rfid" class="form-control text1" id="label2" required 
                        value="<?= $data['pegawai']->rfid; ?>"
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

                  <?php if ($_SESSION['role'] == ' admin') { ?>
                     <input type="text" name="username" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->username ?>">
                  <?php } else { ?>
                     <input type="text" name="username" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->username ?>" readonly>
                  <?php } ?>

                  <input type="hidden" name="username_lama" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->username ?>">
               </div>

               <div class="form-group">
                  <label class="label1">Password <small><i><b>(kosongkan jika tidak ingin merubah password)</b></i></small></label>
                  <input type="text" name="password" class="form-control text1" style="width:100%">
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
                        <label class="label1">NIK (Nomor Induk Karyawan) <span style="color:red">*</span></label>

                        <?php if ($_SESSION['role'] == ' admin') { ?>
                           <input type="text" name="nik" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->nik ?>">
                        <?php } else { ?>
                           <input type="text" name="nik" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->nik ?>" readonly>
                        <?php } ?>

                        <input type="hidden" name="nik_lama" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->nik ?>">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Pendidikan</label>
                        <select name="pendidikan" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="S3" <?= ($data['pegawai']->pendidikan == 'S3') ? 'selected' : '' ?>>S3</option>
                           <option value="S2" <?= ($data['pegawai']->pendidikan == 'S2') ? 'selected' : '' ?>>S2</option>
                           <option value="S1" <?= ($data['pegawai']->pendidikan == 'S1') ? 'selected' : '' ?>>S1</option>
                           <option value="D3" <?= ($data['pegawai']->pendidikan == 'D3') ? 'selected' : '' ?>>D3</option>
                           <option value="SMA" <?= ($data['pegawai']->pendidikan == 'SMA') ? 'selected' : '' ?>>SMA/SMK</option>
                           <option value="SMP" <?= ($data['pegawai']->pendidikan == 'SMP') ? 'selected' : '' ?>>SMP</option>
                           <option value="SD" <?= ($data['pegawai']->pendidikan == 'SD') ? 'selected' : '' ?>>SD</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom:7px">
                  <label class="label1">Nama Lengkap <span style="color:red">*</span></label>
                  <input type="text" name="nama" class="form-control text1" style="width:100%" required value="<?= $data['pegawai']->nama ?>">
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nama Singkat</label>
                        <input type="text" name="kode" class="form-control text1" style="width:100%" value="<?= $data['pegawai']->kode ?>">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Jenis Kelamin <span style="color:red">*</span></label>
                        <select name="jk" class="form-control text1" style="width:100%" required>
                           <option value="">Pilih</option>
                           <option value="Laki-laki" <?= ($data['pegawai']->jk == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                           <option value="Perempuan" <?= ($data['pegawai']->jk == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tempat Lahir <span style="color:red">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control text1" style="width:100%" value="<?= $data['pegawai']->tempat_lahir ?>">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control text1" style="width:100%;" value="<?= $data['pegawai']->tgl_lahir ?>">
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom:7px">
                  <label class="label1">Alamat</label>
                  <input type="text" name="alamat" class="form-control text1" style="width:100%" value="<?= $data['pegawai']->alamat ?>">
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Agama</label>
                        <select name="agama" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Islam" <?= ($data['pegawai']->agama == 'Islam') ? 'selected' : '' ?>>Islam</option>
                           <option value="Katolik" <?= ($data['pegawai']->agama == 'Katolik') ? 'selected' : '' ?>>Katolik</option>
                           <option value="Protestan" <?= ($data['pegawai']->agama == 'Protestan') ? 'selected' : '' ?>>Protestan</option>
                           <option value="Budha" <?= ($data['pegawai']->agama == 'Budha') ? 'selected' : '' ?>>Budha</option>
                           <option value="Hindu" <?= ($data['pegawai']->agama == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
                           <option value="Kepercayaan" <?= ($data['pegawai']->agama == 'Kepercayaan') ? 'selected' : '' ?>>Kepercayaan</option>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Nomor WhatsApp <span style="color:red">*</span></label>
                        <input type="text" name="nomor_hp" class="form-control text1" style="width:100%" value="<?= $data['pegawai']->nomor_hp ?>">
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Mendapatkan Notif WA</span></label>
                        <select name="notif_wa" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Ya" <?= ($data['pegawai']->notif_wa == 'Ya') ? 'selected' : '' ?>>Ya, kirimkan notif WA</option>
                           <option value="Tidak" <?= ($data['pegawai']->notif_wa == 'Tidak') ? 'selected' : '' ?>>Tidak, tidak perlu notif</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control text1" style="width:100%" value="<?= $data['pegawai']->jabatan ?>">
                     </div>
                  </div>

                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Absen Mengajar</label>
                        <select name="mengajar" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Ya" <?= ($data['pegawai']->mengajar == 'Ya') ? 'selected' : '' ?>>Ya, Harus mengisi absen mengajar</option>
                           <option value="Tidak" <?= ($data['pegawai']->mengajar == 'Tidak') ? 'selected' : '' ?>>Tidak perlu mengisi absen Mengajar</option>
                        </select>
                     </div>
                  </div>
               </div>

               <div class="form-group" style="margin-bottom:7px">
                  <label class="label1">Alamat Email</label>
                  <input type="text" name="email" class="form-control text1" style="width:100%" value="<?= $data['pegawai']->email ?>">
               </div>

               <div class="row">
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Status Pegawai</label>
                        <select name="full_time" class="form-control text1" style="width:100%">
                           <option value="">Pilih</option>
                           <option value="Full Time" <?= ($data['pegawai']->full_time == 'Full Time') ? 'selected' : '' ?>>Full Time</option>
                           <option value="Part Time" <?= ($data['pegawai']->full_time == 'Part Time') ? 'selected' : '' ?>>Part Time</option>
                        </select>
                     </div>
                  </div>
                  <div class="col">
                     <div class="form-group" style="margin-bottom:7px">
                        <label class="label1">Status Absen <span style="color:red">*</span></label>
                        <select name="absen" class="form-control text1" style="width:100%" required>
                           <option value="">Pilih</option>
                           <option value="Aktif" <?= ($data['pegawai']->absen == 'Aktif') ? 'selected' : '' ?>>Aktif (harus absen setiap hari)</option>
                           <option value="Tidak" <?= ($data['pegawai']->absen == 'Tidak') ? 'selected' : '' ?>>Tidak Aktif (tidak harus mengisi absen)</option>
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


<div class="modal fade" id="gantifoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <form action="<?= URLROOT; ?>/pegawai/simpan_foto" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="nik" value="<?= $data['pegawai']->nik ?>">
         <input type="hidden" name="id_pegawai" value="<?= $data['pegawai']->id_pegawai ?>">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Ganti Foto</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <label>Pilih File foto yang baru *<i>png / jpg / jpeg</i></label>
               <input type="file" name="avatar" class="form-control" required accept=".jpg, .png, .jpeg">
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan Foto</button>
            </div>
         </div>
      </form>
   </div>
</div>