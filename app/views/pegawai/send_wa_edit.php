<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="mb-4 mt-3">
         <h4><b>Pengaturan Notifikasi WhatsApp</b></h4>
      </div>

      <form method="POST" action="<?= URLROOT ?>/pegawai/simpan_edit_send_wa">
         <input type="hidden" name="id_send_wa" value="<?= $data['send']->id_send_wa ?>">
         <table class="tabel2 tinggi" style="width:100%">
            <tr>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td style="width:260px">NIK</td>
               <td><b><?= $data['send']->nik_send_wa ?></b></td>
            </tr>
            <tr>
               <td>Nama</td>
               <td><b><?= $data['send']->nama ?></b></td>
            </tr>
            <tr>
               <td>
                  Nomor WhatsApp<br />
                  <small><i>edit nomor di menu "Profil Saya</i></small>
               </td>
               <td><b>
                     <?= $data['send']->nomor_hp ?>
                  </b>
               </td>
            </tr>
            <tr>
               <td>
                  Notif Isi Presensi Datang<br />
                  <small><i>terkirim saat berhasil presensi datang</i></small>
               </td>
               <td>
                  <select name="absen_datang" style="width:200px" class="form-control form-control-sm">
                     <option value="0" <?= ($data['send']->absen_datang != '1') ? 'selected' : '' ?>>Tidak Aktif</option>
                     <option value="1" <?= ($data['send']->absen_datang == '1') ? 'selected' : '' ?>>Aktif</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td>
                  Notif Isi Presensi Pulang<br />
                  <small><i>terkirim saat berhasil presensi pulang</i></small>
               </td>
               <td>
                  <select name="absen_pulang" style="width:200px" class="form-control form-control-sm">
                     <option value="0" <?= ($data['send']->absen_pulang != '1') ? 'selected' : '' ?>>Tidak Aktif</option>
                     <option value="1" <?= ($data['send']->absen_pulang == '1') ? 'selected' : '' ?>>Aktif</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td>
                  Reminder Presensi Datang<br />
                  <small><i>terkirim pada jam 08:30 jika belum absen</i></small>
               </td>
               <td>
                  <select name="notif_datang" style="width:200px" class="form-control form-control-sm">
                     <option value="0" <?= ($data['send']->notif_datang != '1') ? 'selected' : '' ?>>Tidak Aktif</option>
                     <option value="1" <?= ($data['send']->notif_datang == '1') ? 'selected' : '' ?>>Aktif</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td>
                  Reminder Presensi Pulang<br />
                  <small><i>terkirim pada jam 16:30 jika belum absen</i></small>
               </td>
               <td>
                  <select name="notif_pulang" style="width:200px" class="form-control form-control-sm">
                     <option value="0" <?= ($data['send']->notif_pulang != '1') ? 'selected' : '' ?>>Tidak Aktif</option>
                     <option value="1" <?= ($data['send']->notif_pulang == '1') ? 'selected' : '' ?>>Aktif</option>
                  </select>
               </td>
            </tr>
         </table>
         <div class="mt-4">
            <button type="submit" class="btn btn-success btn-sm tombol2" title="Simpan"><i class="fa fa-save"></i> &nbsp;Simpan Pengaturan</button>
            <a href="<?= URLROOT ?>/pegawai/send_wa" class="btn btn-danger btn-sm tombol2" title="Kembali"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
         </div>
      </form>
   </div>
</div>

<style>
   .tinggi td {
      height: 0px;
   }
</style>