<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         Tambah / Buat izin mengajar
      </div>
   </div>
</div>

<div class="card-body" style="margin-top:-20px">
   <div class="bg-danger col" style="background-color:red; margin:auto; padding:25px;">

      <form method="POST" action="<?= URLROOT ?>/absen/simpan_edit_izin_mengajar" enctype="multipart/form-data">

         <input type="hidden" name="id_izin" value="<?= $data['izin']->id_izin ?>">

         <div class="mb-2"><small><i>*Isi tanggal yang sama jika hanya 1 hari</i></small></div>
         <div class="row">
            <div class="col-sm-3">
               <div class="form-group">
                  <label>Mulai Tanggal</label>
                  <input type="date" name="tanggal_awal" value="<?= $data['izin']->tanggal_awal ?>" class="form-control text1" required>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="form-group">
                  <label for="tanggal_akhir">Sampai Tanggal</label>
                  <input type="date" name="tanggal_akhir" value="<?= $data['izin']->tanggal_akhir ?>" class="form-control text1" required>
               </div>
            </div>
         </div>

         <div class="mb-2">
            <button type="button" onclick="tambahBaris()" class="btn btn-primary btn-sm" title="tambah keterangan"><i class="fa fa-plus-square"></i> &nbsp;Tambah Kelas/Keterangan</button>
         </div>

         <div>
            <table id="transaksiTable" class="table tabel1 table-striped table-hover tabelmerah">
               <thead style="height:40px">
                  <tr style="text-align:center">
                     <th style="width:45px">No</th>
                     <th style="width:110px">Kelas</th>
                     <th style="width:30%">Mata Pelajaran</th>
                     <th style="width:110px">Status Izin</th>
                     <th>Keterangan / Catatan</th>
                     <th style="width:45px">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $no = 1;
                  foreach ($data['transaksi'] as $t) : ?>
                     <input type="hidden" name="id_transaksi[]" value="<?= $t->id_transaksi ?>">
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td>
                           <select name="kelas[]" class="isian" style="width:100%" required>
                              <option value="">- Pilih -</option>
                              <option value="XA" <?= ($t->kelas == 'XA') ? 'selected' : '' ?>>XA</option>
                              <option value="XB" <?= ($t->kelas == 'XB') ? 'selected' : '' ?>>XB</option>
                              <option value="XC" <?= ($t->kelas == 'XC') ? 'selected' : '' ?>>XC</option>
                              <option value="XD" <?= ($t->kelas == 'XD') ? 'selected' : '' ?>>XD</option>
                              <option value="XE" <?= ($t->kelas == 'XE') ? 'selected' : '' ?>>XE</option>
                              <option value="XF" <?= ($t->kelas == 'XF') ? 'selected' : '' ?>>XF</option>
                              <option value="XG" <?= ($t->kelas == 'XG') ? 'selected' : '' ?>>XG</option>
                              <option value="XIA" <?= ($t->kelas == 'XIA') ? 'selected' : '' ?>>XIA</option>
                              <option value="XIB" <?= ($t->kelas == 'XIB') ? 'selected' : '' ?>>XIB</option>
                              <option value="XIC" <?= ($t->kelas == 'XIC') ? 'selected' : '' ?>>XIC</option>
                              <option value="XID" <?= ($t->kelas == 'XID') ? 'selected' : '' ?>>XID</option>
                              <option value="XIE" <?= ($t->kelas == 'XIE') ? 'selected' : '' ?>>XIE</option>
                              <option value="XIF" <?= ($t->kelas == 'XIF') ? 'selected' : '' ?>>XIF</option>
                              <option value="XIG" <?= ($t->kelas == 'XIG') ? 'selected' : '' ?>>XIG</option>
                              <option value="XIIA" <?= ($t->kelas == 'XIIA') ? 'selected' : '' ?>>XIIA</option>
                              <option value="XIIB" <?= ($t->kelas == 'XIIB') ? 'selected' : '' ?>>XIIB</option>
                              <option value="XIIC" <?= ($t->kelas == 'XIIC') ? 'selected' : '' ?>>XIIC</option>
                              <option value="XIID" <?= ($t->kelas == 'XIID') ? 'selected' : '' ?>>XIID</option>
                              <option value="XIIE" <?= ($t->kelas == 'XIIE') ? 'selected' : '' ?>>XIIE</option>
                              <option value="XIIF" <?= ($t->kelas == 'XIIF') ? 'selected' : '' ?>>XIIF</option>
                              <option value="XIIG" <?= ($t->kelas == 'XIIG') ? 'selected' : '' ?>>XIIG</option>
                           </select>
                        </td>
                        <td>
                           <select name="mata_pelajaran[]" class="isian" style="width:100%">
                              <option value="">~Pilih~</option>
                              <?php foreach ($data['pelajaran'] as $p) { ?>
                                 <option value="<?= $p->mata_pelajaran ?>" <?= ($p->mata_pelajaran == $t->mata_pelajaran) ? 'selected' : '' ?>><?= $p->mata_pelajaran ?></option>
                              <?php } ?>
                           </select>
                        </td>
                        <td><select name="status_izin[]" class="isian" style="width:100%" required>
                              <option value="">~Pilih~</option>
                              <option value="Izin" <?= ($t->status_izin == 'Izin') ? 'selected' : '' ?>>Izin</option>
                              <option value="Sakit" <?= ($t->status_izin == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                              <option value="Cuti" <?= ($t->status_izin == 'Cuti') ? 'selected' : '' ?>>Cuti</option>
                              <option value="TL" <?= ($t->status_izin == 'TL') ? 'selected' : '' ?>>TL</option>
                              <option value="Lainnya" <?= ($t->status_izin == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                           </select>
                        </td>
                        <td>
                           <input type="text" name="alasan_izin[]" class="isian" value="<?= $t->alasan_izin ?>" style="width:100%">
                        </td>
                        <td class="tengah tengah2">
                           <?php if (!$t->id_transaksi) { ?>
                              <button onclick="hapusBaris(this)" class="btn btn-danger btn-sm tombolsatu" title="Hapus transaksi ini..."><i class="fa fa-trash"></i></button>
                           <?php } else { ?>
                              <button type="button" onclick="deleteData('<?= $t->id_transaksi ?>')" class="btn btn-danger btn-sm tombolsatu" title="Hapus transaksi ini..."><i class="fa fa-trash"></i></a>
                              <?php } ?>
                        </td>
                     </tr>
                  <?php $no++;
                  endforeach;
                  ?>
               </tbody>
            </table>
         </div>

         <div class="form-group row">
            <div class="col-sm-10">
               <button type="submit" class="btn btn-success tomboldua"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               <a href="<?= URLROOT; ?>/absen/izin_mengajar" class="btn btn-warning tomboldua"><i class="fa fa-arrow-left"></i> &nbsp;Kembali</a>
            </div>
         </div>
      </form>
   </div>
</div>


<script>
   document.addEventListener("DOMContentLoaded", function() {
      // Jangan panggil tambahBaris() di sini untuk menghindari penambahan baris default pertama
   });

   function tambahBaris() {
      var rowCount = $('#transaksiTable tr').length;

      var newRow = '<tr>';
      newRow += '<td class="tengah tengah2">' + rowCount + '</td>';

      newRow += '<td><select name="kelas2[]" class="isian" style="width:100%" required>';
      newRow += '<option value="">- Pilih -</option>';
      newRow += '<option value="XA">XA</option>';
      newRow += '<option value="XB">XB</option>';
      newRow += '<option value="XC">XC</option>';
      newRow += '<option value="XD">XD</option>';
      newRow += '<option value="XE">XE</option>';
      newRow += '<option value="XF">XF</option>';
      newRow += '<option value="XG">XG</option>';
      newRow += '<option value="XIA">XIA</option>';
      newRow += '<option value="XIB">XIB</option>';
      newRow += '<option value="XIC">XIC</option>';
      newRow += '<option value="XID">XID</option>';
      newRow += '<option value="XIE">XIE</option>';
      newRow += '<option value="XIF">XIF</option>';
      newRow += '<option value="XIG">XIG</option>';
      newRow += '<option value="XIIA">XIIA</option>';
      newRow += '<option value="XIIB">XIIB</option>';
      newRow += '<option value="XIIC">XIIC</option>';
      newRow += '<option value="XIID">XIID</option>';
      newRow += '<option value="XIIE">XIIE</option>';
      newRow += '<option value="XIIF">XIIF</option>';
      newRow += '<option value="XIIG">XIIG</option>';
      newRow += '</select></td>';

      //newRow += '<td><input type="text" name="mata_pelajaran2[]" class="isian" style="width:100%"></td>';
      newRow += '<td><select name="mata_pelajaran2[]" class="isian" style="width:100%">';
      newRow += '<option value="">~Pilih~</option>';
      <?php foreach ($data['pelajaran'] as $p) { ?>
         newRow += '<option value="<?= $p->mata_pelajaran ?>"><?= $p->mata_pelajaran ?></option>';
      <?php } ?>
      newRow += '</td>';

      newRow += '<td><select name="status_izin2[]" class="isian" style="width:100%" required>';
      newRow += '<option value="">~Pilih~</option>';
      newRow += '<option value="Izin">Izin</option>';
      newRow += '<option value="Sakit">Sakit</option>';
      newRow += '<option value="Cuti">Cuti</option>';
      newRow += '<option value="TL">TL</option>';
      newRow += '<option value="Lainnya">Lainnya</option>';
      newRow += '</select></td>';

      newRow += '<td><input type="text" name="alasan_izin2[]" class="isian" style="width:100%"></td>';

      newRow += '<td class="tengah tengah2"><button onclick="hapusBaris(this)" class="btn btn-danger btn-sm tombolsatu" title="Hapus Baris"><i class="fa fa-trash"></i></button></td>';
      newRow += '</tr>';

      $('#transaksiTable').append(newRow);
      renumberRows();
   }

   function hapusBaris(button) {
      $(button).closest('tr').remove();
      renumberRows();
   }

   function renumberRows() {
      $('#transaksiTable tr').each(function(index) {
         $(this).find('td:first').text(index);
      });
   }
</script>

<script>
   function deleteData(id) {
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Data yang dihapus tidak bisa dikembalikan lagi!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/absen/hapus_transaksi_izin_mengajar/' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        location.reload();
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

<style>
   .tabelmerah td {
      background-color: white;
      color: gray;
   }

   .isian {
      height: 30px !important;
      border: 1px solid #dddddd;
      background-color: antiquewhite;
   }
</style>