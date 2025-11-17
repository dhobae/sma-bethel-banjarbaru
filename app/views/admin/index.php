<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Halaman Pengaturan Admin Aplikasi
      </div>
      <div class="huruf1 tengah mb-3" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMA Bethel Banjarbaru
      </div>
      <table class="table tabel3 table-hovered table-striped table-bordered khusus">
         <thead style="background-color: brown; color:white;">
            <tr style="height:40px; text-align:center; vertical-align:middle">
               <th style="width:50px">No</th>
               <th style="width:30%">Admin</th>
               <th>Pegawai</th>
               <th style="width:50px">Aksi</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $no = 0;
            $number = 1;
            foreach ($data['admin'] as $row) {
            ?>
               <tr>
                  <td class="tengah"><?= $number ?></td>
                  <td><?= $row->nama_admin ?></td>
                  <td>
                     <?php
                     if (!$data['pegawai'][$no]) {
                     ?>
                        <ul style="padding:0px">
                           <li style="list-style-type: none;color:red; margin-bottom:-10px">Tidak ada pegawai terdaftar.</li>
                        </ul>
                        <?php
                     } else {
                        foreach ($data['pegawai'][$no] as $k) {
                        ?>
                           <ul style="padding-left:20px">
                              <li style="margin-bottom:-10px">
                                 <?= $k->nama ?> (<?= $k->nik ?>)
                              </li>
                           </ul>
                     <?php
                        }
                     }
                     ?>
                  </td>
                  <td class="tengah">
                     <a href="<?= URLROOT; ?>/admin/edit/<?= $row->id ?>" class="btn btn-primary btn-sm tombol3"><i class="fa fa-edit"></i></a>
                  </td>
               </tr>
            <?php
               $no++;
               $number++;
            }
            ?>
         </tbody>
      </table>
   </div>
</div>

<style>
   .khusus {
      font-size: 17px;
      font-family: 'calibri' !important;
      font-weight: bold;
   }

   .khusus td {
      padding-top: 10px !important;
      padding-bottom: 10px !important;
   }
</style>