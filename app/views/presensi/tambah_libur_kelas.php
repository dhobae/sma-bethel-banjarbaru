


        

<div class="card card-primary" style="margin-top:10px;">
   <div class="card-header" style="height:1px; padding:1px;">
   </div>
   <div class="card-body">
   <div class="bg-danger col-sm-6 mb-1" style="margin:auto; padding:10px 25px;">
      <b>Perhatian :</b><br />
      <ul style="margin-bottom:0px; padding-left:20px">
         <li>Sebelum mengisikan libur kelas, pastikan terlebih dahulu memang siswa tidak ada yang sedang melakukan presensi dan pengajuan izin pada rentang tanggal tersebut</li>
         <li>Pastikan tanggal mulai dan tanggal sampai tidak menabrak data yang sudah di masukkan sebelumnya (misal : sudah mengatur libur kelas XII di tanggal 10 April 2026, maka tidak boleh mengisi 2x)</li>
         <li>Pastikan tanggal diplih bukan tanggal libur spesial seperti libur nasional, perayaan hari raya, dll.</li>
      </ul>
   </div>
      <div class="bg-danger col-sm-6" style="background-color:red; margin:auto; padding:25px;">
         <form method="post" action="<?= URLROOT ?>/presensi/simpan_libur_kelas">
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
                     <label>Libur Sampai Tanggal</label>
                     <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="" class="form-control" required style="width:200px">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Kelas</label>
                     <select name="kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="X">Kelas X (10)</option>
                        <option value="XI">Kelas XI (11)</option>
                        <option value="XII">Kelas XII (12)</option>
                     </select>
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
               <div>
                  <button type="submit" class="btn btn-success btn-sm tombol2" title="Simpan Data"><i class="fa fa-save"></i> &nbsp;Simpan</button>
                  <a href="<?= URLROOT ?>/presensi/libur_kelas" class="btn btn-warning btn-sm tombol2" title="Kembali"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
