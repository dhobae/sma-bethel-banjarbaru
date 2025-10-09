<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Daftar Guru dan Karyawan
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMK Telkom Banjarbaru
      </div>
   </div>
</div>

<form method="POST" action="<?= URLROOT ?>/pegawai/simpan_edit">
   <input type="hidden" name="id_pegawai" value="<?= $data['pegawai']->id_pegawai ?>">
   <div class="row">
      <div class="col">
         <a href="<?= URLROOT ?>/pegawai" class="btn btn-danger btn-sm tombol2" title="Kemabli"><i class="fa fa-undo"></i> &nbsp;Kembal</a>
      </div>
   </div>
   <div class="row">

      <div class="col-lg-3">
         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile tengah">
               <?php if ($data['pegawai']->avatar) { ?>
                  <img src="<?= URLROOT ?>/skatel/avatar/<?= $data['pegawai']->avatar ?>" width="150px">
               <?php } else { ?>
                  <img src="<?= URLROOT ?>/skatel/avatar/foto1.jpg" width="150px">
               <?php } ?>
            </div>
         </div>
      </div>

      <div class="col-lg-9">
         <div class="card card-primary card-outline" style="margin-top:10px;">
            <div class="card-body box-profile">

               <table class="table tabel2">
                  <?php if ($_SESSION['role'] == 'admin') { ?>
                     <tr>
                        <td style="width:190px">Username</td>
                        <td style="width:20px">:</td>
                        <td style="font-weight:bold"><?= $data['pegawai']->username ?></td>
                     </tr>
                  <?php } ?>
                  <tr>
                     <td>NIK</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->nik ?></td>
                  </tr>
                  <tr>
                     <td>Nama Lengkap</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->nama ?></td>
                  </tr>
                  <tr>
                     <td>Nama Singkat</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->kode ?></td>
                  </tr>
                  <tr>
                     <td>Tempat, Tanggal Lahir</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->tempat_lahir ?>, <?= dateID($data['pegawai']->tgl_lahir) ?></td>
                  </tr>
                  <tr>
                     <td>Jenis Kelamin</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->jk ?></td>
                  </tr>
                  <tr>
                     <td>Agama</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->agama ?></td>
                  </tr>
                  <tr>
                     <td>Alamat</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->alamat ?></td>
                  </tr>
                  <tr>
                     <td>Nomor WhatsApp</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->nomor_hp ?></td>
                  </tr>
                  <tr>
                     <td>Alamat E-Mail</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->email ?></td>
                  </tr>
                  <tr>
                     <td>Pendidikan</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->pendidikan ?></td>
                  </tr>
                  <tr>
                     <td>Jabatan</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->jabatan ?></td>
                  </tr>
                  <tr>
                     <td>Mengajar</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->mengajar ?></td>
                  </tr>
                  <tr>
                     <td>Status Pegawai</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->full_time ?></td>
                  </tr>
                  <tr>
                     <td>Status Absen</td>
                     <td>:</td>
                     <td style="font-weight:bold"><?= $data['pegawai']->absen ?></td>
                  </tr>
               </table>

            </div>
         </div>
      </div>
   </div>

</form>

<br /><br /><br />