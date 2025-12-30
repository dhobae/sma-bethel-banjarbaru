<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Daftar Izin Tidak Masuk Mengajar
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMA Bethel Banjarbaru
      </div>

      <div class="mb-2">
         <a href="<?= URLROOT ?>/absen/tambah" class="btn btn-primary btn-sm tombol2" title="Tambah Izin Mengajar"><i class="fa fa-plus-square"></i> &nbsp;Tambah Izin Mengajar</a>
      </div>

      <div class="table-responsive">
         <table class="table tabel5 table-striped table-hover" id="example">
            <thead style="height:40px; background:azure">
               <tr>
                  <th style="width:55px" class="text-center">No</th>
                  <th style="width:22%" class="text-center">Tanggal Izin</th>
                  <th>Keterangan</th>
                  <th style="width:130px" class="text-center">Acc</th>
                  <th style="width:80px" class="text-center">Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $no = 1;
               if ($data['izin']) {
                  foreach ($data['izin'] as $d) :
               ?>
                     <tr>
                        <td class="text-center" style="vertical-align:middle !important"><?= $no ?></td>
                        <td style="vertical-align:middle !important" class="text-center">
                           <span style="color:orangered; font-weight:bold">
                              <?= dayID($d->tanggal_awal) ?>, <?= date4ID($d->tanggal_awal) ?>
                           </span>
                           <br />s/d<br />
                           <span style="color:orangered; font-weight:bold">
                              <?= dayID($d->tanggal_akhir) ?>, <?= date4ID($d->tanggal_akhir) ?>
                           </span>
                        </td>

                        <td>
                           <ul style="padding-left:20px; margin-bottom:0px">
                              <?php
                              $transaksi = $this->Mabsen->izin_transaksi_by_nik($d->id_izin);
                              foreach ($transaksi as $t) {
                              ?>
                                 <li>
                                    Kelas : <b><?= $t->kelas ?></b>,
                                    Pelajaran : <b><?= $t->mata_pelajaran ?></b>
                                    <br />
                                    Keterangan : <b><?= $t->status_izin ?></b> (<?= $t->alasan_izin ?>)
                                 </li>
                              <?php } ?>
                           </ul>
                        </td>

                        <td class="text-center" style="vertical-align: middle;">
                           <?php
                           if ($d->acc == 'Sudah') {
                              echo "<span class='badge badge-success'>Sudah ACC</span>";
                           } else {
                              echo "<span class='badge badge-danger'>Belum ACC</span>";
                           } ?>
                        </td>

                        <td class="text-center" style="vertical-align:middle !important">
                           <?php
                           if ($d->acc == 'Sudah') {
                              $disabled = 'disabled';
                           } else {
                              $disabled = '';
                           }
                           ?>
                           <a href="<?= URLROOT ?>/absen/edit_izin_mengajar/<?= $d->id_izin ?>" class="btn btn-success btn-sm tombol3 mb-1 mt-1 <?= $disabled ?>" title="Edit data"><i class="fa fa-edit"></i></a>
                           <a href="#" onclick="deleteData('<?= $d->id_izin ?>')" class="btn btn-danger btn-sm tombol3 mb-1 mt-1 <?= $disabled ?>" title="Hapus data"><i class="fa fa-trash"></i></a>
                        </td>
                     </tr>
               <?php $no++;
                  endforeach;
               } else {
                  echo "<tr style='height:35px'><td colspan='5' style='vertical-align:middle'>Belum ada data</td></tr>";
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</div>



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
               url: '<?= URLROOT ?>/absen/hapus_izin_mengajar/' + id,
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
   .tabel5 {
      border: 1px solid #dddddd;
   }

   .tabel5 td {
      border: 1px solid #dddddd;
   }

   .tabel5 th {
      border: 1px solid #dddddd;
   }
</style>