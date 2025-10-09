<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:20px; font-weight:bold">
         Notifikasi WhatsApp Guru dan Karyawan
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMK Telkom Banjarbaru
      </div>

      <div class="mt-3">
         <table class="table tabel3">
            <thead>
               <tr>
                  <th>No</th>
                  <th>NIK</th>
                  <th>Nama Pegawai</th>
                  <th>Absen Datang</th>
                  <th>Absen Pulang</th>
                  <th>Reminder<br />Absen Datang</th>
                  <th>Reminder<br />Absen Pulang</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1;
               foreach ($data['send'] as $d) : ?>
                  <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td class="text-center"><?= $d->nik_send_wa ?></td>
                     <td><?= $d->nama ?></td>
                     <td class="text-center">
                        <?php
                        if ($d->absen_datang == '1') {
                           echo "<span style='color:green; font-weight:bold'>Aktif</span>";
                        } else {
                           echo "Tidak Aktif";
                        }
                        ?>
                     </td>
                     <td class="text-center">
                        <?php
                        if ($d->absen_pulang == '1') {
                           echo "<span style='color:green; font-weight:bold'>Aktif</span>";
                        } else {
                           echo "Tidak Aktif";
                        }
                        ?>
                     </td>
                     <td class="text-center">
                        <?php
                        if ($d->notif_datang == '1') {
                           echo "<span style='color:green; font-weight:bold'>Aktif</span>";
                        } else {
                           echo "Tidak Aktif";
                        }
                        ?>
                     </td>
                     <td class="text-center">
                        <?php
                        if ($d->notif_pulang == '1') {
                           echo "<span style='color:green; font-weight:bold'>Aktif</span>";
                        } else {
                           echo "Tidak Aktif";
                        }
                        ?>
                     </td>
                     <td class="text-center">
                        <a href="<?= URLROOT ?>/pegawai/edit_send_wa/<?= $d->id_send_wa ?>" class="btn btn-success btn-sm tombol1" title="Edit Data"><i class="fa fa-edit"></i></a>
                     </td>
                  </tr>
               <?php $no++;
               endforeach ?>
            </tbody>
         </table>
      </div>

   </div>
</div>