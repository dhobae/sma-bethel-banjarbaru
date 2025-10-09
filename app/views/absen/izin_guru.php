<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
         Daftar Izin Tidak Masuk Mengajar
      </div>
      <div class="huruf1 tengah mb-1" style="font-size:20px; font-weight:bold; margin-top:-6px">
         SMK Telkom Banjarbaru
      </div>

      <div class="table-responsive">
         <table class="table tabel5 table-striped table-hover" id="example">
            <thead style="height:40px; background:azure">
               <tr>
                  <th style="width:25px" class="text-center">No</th>
                  <th>Nama Guru</th>
                  <th style="width:150px; text-align:center">Tanggal Izin</th>
                  <th>Keterangan</th>
                  <th style="width:110px; padding-left:0px; padding-right:0px" class="text-center">Acc</th>
                  <th style="width:80px; padding-left:0px; padding-right:0px" class="text-center">Aksi</th>
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

                        <td style="vertical-align: middle;">
                           <?php
                           $nm = $this->Mabsen->pegawai_by_nik($d->nik);
                           echo $nm->nama;
                           echo "<br/>";
                           echo "<small>[" . $nm->nomor_hp . "] - </small>";
                           ?>
                           <small>
                              <a href="#" data-toggle="modal" data-target="#kirim" title="kirim WA ke nomor guru"><b>Kirim Wa</b></a>
                           </small>
                        </td>

                        <td style="vertical-align:middle !important; text-align:center">
                           <span style="color:blue;">
                              <?= dayID($d->tanggal_awal) ?>, <?= date4ID($d->tanggal_awal) ?>
                           </span>
                           <br />s/d<br />
                           <span style="color:blue;">
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

                        <td class="text-center" style="vertical-align: middle;padding-left:0px; padding-right:0px">
                           <?php
                           if ($d->acc == 'Sudah') {
                              echo "<span class='badge badge-success'>Sudah ACC</span>";
                           } else {
                              echo "<span class='badge badge-danger'>Belum ACC</span>";
                           } ?>
                        </td>

                        <td class="text-center" style="vertical-align:middle !important; padding-left:0px; padding-right:0px">
                           <a href="#" onclick="acc('<?= $d->id_izin ?>','<?= $nm->nomor_hp ?>')" class="btn btn-success btn-sm tombol3 mb-1 mt-1" title="Acc"><i class="fa fa-check"></i></a>
                           <a href="#" onclick="deleteData('<?= $d->id_izin ?>')" class="btn btn-danger btn-sm tombol3 mb-1 mt-1" title="Hapus data"><i class="fa fa-trash"></i></a>
                        </td>
                     </tr>
               <?php $no++;
                  endforeach;
               } else {
                  echo "<tr style='height:35px'><td colspan='6' style='vertical-align:middle'>Belum ada data</td></tr>";
               }
               ?>
            </tbody>
         </table>
      </div>
   </div>
</div>


<script>
   var originalTableBorder = $('#example').css('border');
   var originalTablePadding = $('#example').css('padding');

   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 100,
         "paging": true,
         "lengthChange": true,
         "ordering": false,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": " _MENU_ perhalaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Cari disini :"
         }
      });
   });
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

   function acc(id, hp) {
      Swal.fire({
         title: "Yakin di ACC?",
         text: "Anda yakin memberi ACC ke izin ini!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, Beri ACC!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/absen/acc_izin?id=' + id + '&hp=' + hp,
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
      font-size: 0.95em;
      font-family: 'calibri';
   }

   .tabel5 td {
      border: 1px solid #dddddd;
      padding-top: 5px !important;
      padding-bottom: 5px !important;
   }

   .tabel5 th {
      border: 1px solid #dddddd;
   }
</style>