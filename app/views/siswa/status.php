<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Daftar Status Siswa SMA Bethel Banjarbaru
      </div>

      <?php
      if (isset($_GET['status'])) {
         $status = $_GET['status'];
      } else {
         $status = 'aktif';
      }
      ?>

      <div class="container1 mb-2" style="padding:0px">
         <div class="col" style="padding:0px">
            <a href="<?= URLROOT ?>/siswa/status?status=aktif" class="btn btn-outline-success btn-sm tombol3 lebar3 <?= ($status == 'aktif') ? 'active' : '' ?>">Siswa Aktif</a>

            <a href="<?= URLROOT ?>/siswa/status?status=alumni" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($status == 'alumni') ? 'active' : '' ?>">Sudah Alumni</a>

            <a href="<?= URLROOT ?>/siswa/status?status=pindah" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($status == 'pindah') ? 'active' : '' ?>">Pindah Sekolah</a>

            <hr style="margin-top:0px">
         </div>
      </div>


      <table class="table tabel3" id="example">
         <thead style="background-color: azure;">
            <tr class="text-center">
               <th style="height:35px; width:30px;">No</th>
               <th style="width:90px">NIS</th>
               <th>Nama Siswa</th>
               <th style="width:70px">Prodi</th>
               <th style="width:70px">Kelas</th>
               <th style="width:115px">No Telpon</th>
               <th style="width:115px">Telpon Wali</th>
               <th style="width:100px">Status</th>
               <th style="width:50px !important">Detail</th>
            </tr>
         </thead>
         <tbody>
            <?php $no = 1;
            foreach ($data['siswa_aktif'] as $d) : ?>
               <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td class="text-center"><?= $d->nis ?></td>
                  <td><?= $d->nama_siswa ?></td>
                  <td class="text-center"><?= $d->kode_prodi ?></td>
                  <td class="text-center"><?= $d->kelas_siswa ?></td>
                  <td class="text-center"><?= $d->nomor_hp ?></td>
                  <td class="text-center"><?= $d->nomor_hp_wali ?></td>
                  <?php if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') { ?>
                     <td class="text-center" style="padding-left: 6px !important;padding-right: 6px !important;">
                        <select name="status_siswa" class="kelas_siswa PilihStatus" data-id="<?= $d->id_siswa ?>" data-name="status_siswa">
                           <option value="-">-</option>
                           <option value="Aktif" <?= ($d->status_siswa == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                           <option value="Alumni" <?= ($d->status_siswa == 'Alumni') ? 'selected' : '' ?>>Alumni</option>
                           <option value="Pindah" <?= ($d->status_siswa == 'Pindah') ? 'selected' : '' ?>>Pindah</option>
                        </select>
                     </td>
                  <?php } ?>
                  <?php if (!(Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin')) { ?>
                     <td class="text-center">
                        <?= $d->status_siswa ?>
                     </td>
                  <?php } ?>
                  <td class="text-center">
                     <a href="<?= URLROOT ?>/siswa/lihat/<?= $d->id_siswa ?>" class="btn btn-info btn-sm tombol1" title="Lihat detail siswa"><i class="fa fa-eye"></i></a>
                  </td>
               </tr>
            <?php $no++;
            endforeach;
            ?>
         </tbody>
      </table>

   </div>
</div>

<style>
   .lebar {
      width: auto;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
      padding-left: 15px !important;
      padding-right: 15px !important;
   }

   .lebar3 {
      width: auto;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
      padding-left: 15px !important;
      padding-right: 15px !important;
   }

   .container1 {
      display: flex;
   }

   .kelas_siswa {
      width: 100%;
      border: 0px solid red !important;
      background-color: azure;
      text-align: center !important;
   }
</style>

<script>
   var originalTableBorder = $('#example').css('border');
   var originalTablePadding = $('#example').css('padding');

   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 50,
         "paging": true,
         "lengthChange": true,
         "ordering": true,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": " _MENU_ perhalaman",
            "zeroRecords": "Nothing found - sorry",
            //"info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Cari disini :"
         }
      });
   });
</script>

<script>
   $(document).ready(function() {
      $('.PilihStatus').change(function() {
         var pilih_status = $(this).val();
         var id_siswa = $(this).data('id');
         console.log(pilih_status)
         $.ajax({
            url: '<?= URLROOT ?>/siswa/pilih_status',
            type: 'POST',
            data: {
               id_siswa: id_siswa,
               pilih_status: pilih_status
            },
            success: function(response) {
               console.log('Status berhasil diperbarui');
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.error('Error saat memperbarui status:', textStatus, errorThrown);
            }
         });
      });
   });
</script>