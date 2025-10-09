<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="bg-danger col-sm-6" style="background-color:red; margin:auto; padding:25px;">

         <div class="mb-3">
            <h5><b>Reset Presensi Pegawai</b></h5>
         </div>

         <form method="POST" action="<?= URLROOT ?>/presensi/simpan_absen_admin">
            <input type="hidden" name="id_absen" value="<?= $data['reset']->id_absen ?>">
            <table class="table tabel2" style="color:white !important">
               <tr>
                  <td style="width:120px">NIK</td>
                  <td style="width:20px">:</td>
                  <td><?= $data['reset']->nik ?></td>
               </tr>

               <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td><?= $data['reset']->nama ?></td>
               </tr>

               <tr>
                  <td>Tanggal</td>
                  <td>:</td>
                  <td><?= dateID($data['reset']->tanggal) ?></td>
               </tr>

               <tr>
                  <td>Jam Masuk</td>
                  <td>:</td>
                  <td>
                     <input type="time" name="jam_masuk" value="<?= $data['reset']->jam_masuk ?>" style="width:120px">
                  </td>
               </tr>

               <tr>
                  <td>Status Masuk</td>
                  <td>:</td>
                  <td>
                     <select name="from_masuk" style="width:100px">
                        <option value="-">-</option>
                        <option value="WFO" <?= ($data['reset']->from_masuk == 'WFO') ? 'selected' : '' ?>>WFO</option>
                        <option value="WFH" <?= ($data['reset']->from_masuk == 'WFH') ? 'selected' : '' ?>>WFH</option>
                     </select>
                  </td>
               </tr>

               <tr>
                  <td>Jam Pulang</td>
                  <td>:</td>
                  <td>
                     <input type="time" name="jam_pulang" value="<?= $data['reset']->jam_pulang ?>" style="width:120px">
                  </td>
               </tr>

               <tr>
                  <td>Status Pulang</td>
                  <td>:</td>
                  <td>
                     <select name="from_pulang" style="width:100px">
                        <option value="-">-</option>
                        <option value="WFO" <?= ($data['reset']->from_pulang == 'WFO') ? 'selected' : '' ?>>WFO</option>
                        <option value="WFH" <?= ($data['reset']->from_pulang == 'WFH') ? 'selected' : '' ?>>WFH</option>
                     </select>
                  </td>
               </tr>
            </table>
            <div class="mt-4">
               <button type="submit" class="btn btn-success btn-sm tombol2" title="Simpan Data"><i class="fa fa-save"></i> &nbsp;Simpan</button>

               <a href="<?= URLROOT ?>/presensi/today" class="btn btn-warning btn-sm tombol2" title="Kembali"><i class="fa fa-undo"></i> &nbsp;Kembali</a>

               <div class="float-right">
                  <a href="javascript:void(0)" onclick="deleteData('<?= $data['reset']->id_absen ?>')" class="btn btn-primary btn-sm tombol2" title="Hapus presensi"><i class="fa fa-trash"></i> &nbsp;Hapus Presensi</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function deleteData(id) {
      //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Data presensi pegawai bersangkutan akan dihapus, dan pegawai diharuskkan untuk absen ulang",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, reset!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/presensi/reset_absen?id=' + id,
               type: 'POST',
               dataType: 'json',
               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        //location.reload();
                        window.location.href = '<?= URLROOT ?>/presensi/today';
                     });
                  } else {
                     Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                     });
                  }
               }
            });
         }
      });
   }
</script>