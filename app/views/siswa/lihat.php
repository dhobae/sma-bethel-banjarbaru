<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:20px; font-weight:bold">
         Data Siswa Skatel Banjarbaru
      </div>
   </div>
</div>


<div class="row">
   <div class="col">
      <button type="submit" class="btn btn-primary btn-sm tombol2" title="Simpan data"><i class="fa fa-save"></i> &nbsp;Simpan Data</button>

      <a href="<?= URLROOT ?>/siswa" class="btn btn-danger btn-sm tombol2" title="Kemabli"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
   </div>
</div>

<input type="hidden" name="id_siswa" value="<?= $data['siswa']->id_siswa ?>">

<div class="row">
   <div class="col-lg-4">
      <div class="card card-primary card-outline" style="margin-top:10px;">
         <div class="card-body box-profile tengah">
            <?php if ($data['siswa']->foto_siswa) { ?>
               <img src="<?= URLROOT ?>/skatel/avatar/<?= $data['siswa']->foto_siswa ?>" width="150px">
            <?php } else { ?>
               <img src="<?= URLROOT ?>/skatel/avatar/foto1.jpg" width="150px">
            <?php } ?>
            <br /><br />
            <div class="divtujuh mb-2" style="text-align:right">
               <input type="file" class="text1" name="avatar">
            </div>
         </div>
      </div>

   </div>

   <input type="hidden" name="id_siswa" value="<?= $data['siswa']->id_siswa ?>">

   <div class="col">
      <div class="card card-primary card-outline" style="margin-top:10px;">
         <div class="card-body box-profile">
            <div class="row">
               <div class="col">

                  <table class="tabel_detail">
                     <tr>
                        <td>NIS / Username</td>
                        <td>:</td>
                        <td><?= $data['siswa']->nis ?></td>
                     </tr>
                     <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><?= $data['siswa']->nama_siswa ?></td>
                     </tr>
                     <tr>
                        <td>Prodi</td>
                        <td>:</td>
                        <td>
                           <?php $prodi1 = $this->Msiswa->prodi_by_id($data['siswa']->prodi);
                           echo $prodi1->nama_prodi;
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Tahun Masuk</td>
                        <td>:</td>
                        <td><?= $data['siswa']->tahun_masuk ?></td>
                     </tr>
                     <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td><?= ($data['siswa']->kelas_siswa) ?></td>
                     </tr>
                     <tr>
                        <td>TTL.</td>
                        <td>:</td>
                        <td>
                           <?= $data['siswa']->tempat_lahir ?>,
                           <?php if (($data['siswa']->tanggal_lahir != '0000-00-00') && ($data['siswa']->tanggal_lahir != '-') && ($data['siswa']->tanggal_lahir != NULL)) {
                              echo dateID($data['siswa']->tanggal_lahir);
                           } else {
                              echo $data['siswa']->tanggal_lahir;
                           } ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><?= $data['siswa']->jenis_kelamin ?></td>
                     </tr>
                     <tr>
                        <td>Nomor Whatsapp</td>
                        <td>:</td>
                        <td><?= $data['siswa']->nomor_hp ?></td>
                     </tr>
                     <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?= $data['siswa']->agama ?></td>
                     </tr>
                     <tr>
                        <td>NISN</td>
                        <td>:</td>
                        <td><?= $data['siswa']->NISN ?></td>
                     </tr>
                     <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $data['siswa']->alamat ?></td>
                     </tr>
                     <tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>
                           <?php
                           if ($data['siswa']->kecamatan) {
                              $nm_kec = $this->Msiswa->nama_kecamatan($data['siswa']->kecamatan);
                              echo $nm_kec->nama_kecamatan;
                           } else {
                              echo "-";
                           }
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Kabupaten</td>
                        <td>:</td>
                        <td>
                           <?php
                           if ($data['siswa']->kabupaten) {
                              $nm_kab = $this->Msiswa->nama_kabupaten($data['siswa']->kabupaten);
                              echo $nm_kab->nama_kabupaten;
                           } else {
                              echo "-";
                           }
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Propinsi</td>
                        <td>:</td>
                        <td>
                           <?php
                           if ($data['siswa']->propinsi) {
                              $nm_propinsi = $this->Msiswa->nama_propinsi($data['siswa']->propinsi);
                              echo $nm_propinsi->nama_propinsi;
                           } else {
                              echo "-";
                           }
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Nama Wali</td>
                        <td>:</td>
                        <td><?= $data['siswa']->nama_wali ?></td>
                     </tr>
                     <tr>
                        <td>Nama Ibu</td>
                        <td>:</td>
                        <td><?= $data['siswa']->nama_ibu ?></td>
                     </tr>
                     <tr>
                        <td>Nomor HP Wali</td>
                        <td>:</td>
                        <td><?= $data['siswa']->nomor_hp_wali ?></td>
                     </tr>
                     <tr>
                        <td>Alamat Wali</td>
                        <td>:</td>
                        <td><?= $data['siswa']->alamat_wali ?></td>
                     </tr>
                     <tr>
                        <td>Pekerjaan Wali</td>
                        <td>:</td>
                        <td><?= $data['siswa']->pekerjaan_wali ?></td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
   .tabel_detail {
      width: 100%;
      font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
   }

   .tabel_detail td {
      padding: 3px;
      border-bottom: 1px solid #dddddd;
   }

   .tabel_detail td:nth-child(1) {
      width: 150px;
      font-weight: bold;
      vertical-align: top;
   }

   .tabel_detail td:nth-child(2) {
      width: 30px;
      text-align: center;
      vertical-align: top;
   }

   .tabel_detail td:nth-child(3) {
      vertical-align: top;
   }
</style>