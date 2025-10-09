<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="mb-4">
         <h5><b>Notif Dashboard</b></h5>
      </div>
      <div>
         <form method="POST" action="<?= URLROOT ?>/backup/simpan_notif">
            <table class="table tabel2">
               <tr>
                  <td style="width:150px">Status Notif</td>
                  <td>
                     <select name="status_notif" style="width:200px">
                        <option value="0" <?= ($data['notif']->status_notif == '0') ? 'selected' : '' ?>>Tidak Aktif</option>
                        <option value="1" <?= ($data['notif']->status_notif == '1') ? 'selected' : '' ?>>Aktif</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td>Background</td>
                  <td>
                     <input type="color" name="background" value="<?= $data['notif']->background ?>" style="width:50px">
                  </td>
               </tr>
               <tr>
                  <td>Icon</td>
                  <td>
                     <select name="icon" style="width:200px">
                        <option value="none" <?= ($data['notif']->icon == 'none') ? 'selected' : '' ?>>none</option>
                        <option value="success" <?= ($data['notif']->icon == 'success') ? 'selected' : '' ?>>success</option>
                        <option value="error" <?= ($data['notif']->icon == 'error') ? 'selected' : '' ?>>error</option>
                        <option value="warning" <?= ($data['notif']->icon == 'warning') ? 'selected' : '' ?>>warning</option>
                        <option value="info" <?= ($data['notif']->icon == 'info') ? 'selected' : '' ?>>info</option>
                        <option value="question" <?= ($data['notif']->icon == 'question') ? 'selected' : '' ?>>question</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td>Title</td>
                  <td>
                     <input type="text" name="title" value="<?= $data['notif']->title ?>" style="width:300px">
                  </td>
               </tr>
               <tr>
                  <td>Warna Title</td>
                  <td>
                     <input type="color" name="warna_title" value="<?= $data['notif']->warna_title ?>" style="width:50px">
                  </td>
               </tr>
               <tr>
                  <td>Teks/konten</td>
                  <td>
                     <input type="text" name="teks" value="<?= $data['notif']->text ?>" style="width:100%">
                  </td>
               </tr>
               <tr>
                  <td>Warna Teks/konten</td>
                  <td>
                     <input type="color" name="warna_konten" value="<?= $data['notif']->warna_konten ?>" style="width:50px">
                  </td>
               </tr>
               <tr>
                  <td>Teks Tombol</td>
                  <td>
                     <input type="text" name="isi_tombol" value="<?= $data['notif']->isi_tombol ?>" style="width:150px">
                  </td>
               </tr>
               <tr>
                  <td>Warna Tombol</td>
                  <td>
                     <input type="color" name="warna_tombol" value="<?= $data['notif']->warna_tombol ?>" style="width:50px">
                  </td>
               </tr>
            </table>
            <div class="mt-4">
               <button type="submit" class="btn btn-primary tombol2"><i class="fa fa-save"></i> &nbsp;Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>