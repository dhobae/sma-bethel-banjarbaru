<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">
      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         GURU AKTIF / TIDAK AKTIF
      </div>

      <div class="row">
         <div style="font-size:0.88rem; font-family:'calibri'" class="mb-3 col-lg-10 center">
            <b>Status Mengajar &nbsp;&nbsp;:&nbsp;&nbsp; </b>
            <select style="width:150px; border:1px solid #dddddd; height:30px" id="status" onchange="change_status()">
               <option value="Ya" <?= ($data['status'] != 'Tidak') ? 'selected' : '' ?>>Aktif Mengajar</option>
               <option value="Tidak" <?= ($data['status'] == 'Tidak') ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-10 center">
            <table class="table tabel3" id="example">
               <thead style="background-color: azure;">
                  <tr>
                     <th style="height:40px; width:40px">No</th>
                     <th>Nama Guru</th>
                     <th>Status Mengajar</th>
                     <th>Nomor HP</th>
                     <th>Wali Kelas</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $no = 1;
                  foreach ($data['guru_aktif'] as $d) : ?>
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $d->nama ?></td>
                        <td class="text-center"><?= $d->mengajar ?></td>
                        <td class="text-center"><?= $d->nomor_hp ?></td>
                        <td class="text-center"><?= $d->kode_kelas ?></td>
                        <td class="text-center">
                           <?php if ($d->mengajar == 'Ya') { ?>
                              <button type="button" onclick="non_aktifkan('<?= $d->id_pegawai ?>','<?= $d->nama ?>')" class="btn btn-success btn-sm tombol1" title="Rubah status mengajar"><i class="fa fa-edit"></i></button>
                           <?php } else { ?>
                              <button type="button" onclick="aktifkan('<?= $d->id_pegawai ?>','<?= $d->nama ?>')" class="btn btn-success btn-sm tombol1" title="Rubah status mengajar"><i class="fa fa-edit"></i></button>
                           <?php } ?>
                        </td>
                     </tr>
                  <?php $no++;
                  endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>


<script>
   function change_status() {
      var status = document.getElementById('status').value;
      window.location.href = "<?= URLROOT ?>/jadwal/guru_aktif/" + status;
   }
</script>

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
   function non_aktifkan(id, nama) {
      Swal.fire({
         title: "Tidak Aktifkan?",
         html: "Ubah status mengajar " + nama + " menjadi tidak aktif",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Ubah!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/jadwal/status_mengajar_non?id=' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  console.log(response)
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
               },
               error: function(xhr, status, error) {
                  console.error('AJAX Request Error:', status, error);
                  Swal.fire({
                     title: 'Error!',
                     text: 'Terjadi kesalahan.',
                     icon: 'error'
                  });
               }
            });
         }
      });
   }

   function aktifkan(id, nama) {
      Swal.fire({
         title: "Aktifkan?",
         html: "Ubah status mengajar " + nama + " menjadi aktif",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Ubah!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/jadwal/status_mengajar_aktif?id=' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  console.log(response)
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
               },
               error: function(xhr, status, error) {
                  console.error('AJAX Request Error:', status, error);
                  Swal.fire({
                     title: 'Error!',
                     text: 'Terjadi kesalahan.',
                     icon: 'error'
                  });
               }
            });
         }
      });
   }
</script>