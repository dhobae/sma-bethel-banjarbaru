<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Daftar Siswa SMA Bethel Banjarbaru
      </div>

      <?php
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'dash';
      }
      ?>

      <div class="container1 mb-2" style="padding:0px">
         <div class="col" style="padding:0px">

            <a href="<?= URLROOT ?>/siswa?kelas=dash" class="btn btn-outline-info btn-sm tombol3 lebar3 <?= ($kelas == 'dash') ? 'active' : '' ?>">Dashboard</a>

            <a href="<?= URLROOT ?>/siswa?kelas=all" class="btn btn-outline-secondary btn-sm tombol3 lebar3 <?= ($kelas == 'all') ? 'active' : '' ?>">Seluruh Siswa</a>

            <a href="<?= URLROOT ?>/siswa?kelas=XA" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XA') ? 'active' : '' ?>">XA</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XB" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XB') ? 'active' : '' ?>">XB</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XC" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XC') ? 'active' : '' ?>">XC</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XD" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XD') ? 'active' : '' ?>">XD</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XE" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XE') ? 'active' : '' ?>">XE</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XF" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XF') ? 'active' : '' ?>">XF</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XG" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XG') ? 'active' : '' ?>">XG</a>

            <a href="<?= URLROOT ?>/siswa?kelas=XIA" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIA') ? 'active' : '' ?>">XIA</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIB" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIB') ? 'active' : '' ?>">XIB</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIC" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIC') ? 'active' : '' ?>">XIC</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XID" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XID') ? 'active' : '' ?>">XID</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIE" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIE') ? 'active' : '' ?>">XIE</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIF" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIF') ? 'active' : '' ?>">XIF</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIG" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIG') ? 'active' : '' ?>">XIG</a>

            <a href="<?= URLROOT ?>/siswa?kelas=XIIA" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIA') ? 'active' : '' ?>">XIIA</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIIB" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIB') ? 'active' : '' ?>">XIIB</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIIC" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIC') ? 'active' : '' ?>">XIIC</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIID" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIID') ? 'active' : '' ?>">XIID</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIIE" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIE') ? 'active' : '' ?>">XIIE</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIIF" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIF') ? 'active' : '' ?>">XIIF</a>
            <a href="<?= URLROOT ?>/siswa?kelas=XIIG" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIG') ? 'active' : '' ?>">XIIG</a>

            <a href="<?= URLROOT ?>/siswa?kelas=tanpa_kelas" class="btn btn-outline-dark btn-sm tombol3 lebar3 <?= ($kelas == 'tanpa_kelas') ? 'active' : '' ?>">Tanpa Kelas</a>

            <hr style="margin-top:0px">
         </div>
      </div>

      <?php if ($kelas == 'dash') { ?>
         <?php $this->view('siswa/dash', $data); ?>
      <?php } else { ?>
         <?php if (($kelas <> 'all') and ($kelas <> 'tanpa_kelas')) { ?>
            <div class="text-center mb-1" style="font-size:0.95em">
               <b>Wali Kelas &nbsp;:&nbsp;
                  <?php if (isset($data['wali_kelas']) && is_object($data['wali_kelas']) && !empty($data['wali_kelas']->wali_kelas)) {
                     echo $data['wali_kelas']->nama;
                  } else {
                     echo "<span style='color:red'>~Wali kelas belum dipilih~</span>";
                  }
                  ?>
               </b>
            </div>
         <?php } ?>

         <?php if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') { ?>
            <?php if ($kelas == 'all') { ?>
               <div class="mb-3">
                  <a href="<?= URLROOT ?>/siswa/tambah" class="btn btn-primary btn-sm tombol3" title="Tambah data siswa"><i class="fa fa-plus-square"></i> &nbsp;Tambah Data Siswa</a>
               </div>
            <?php } ?>
         <?php } ?>

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
                  <th style="width:90px">Kartu Absen</th>
                  <th style="width:90px !important">Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1;
               foreach ($data['siswa_aktif'] as $d) : ?>
                  <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td class="text-center"><?= $d->nis ?></td>
                     <td><?= $d->nama_siswa ?></td>
                     <?php if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') { ?>
                        <td class="text-center">
                           <select name="PilihProdi" id="PilihProdi" class="kelas_siswa PilihProdi" data-id="<?= $d->id_siswa ?>" data-name="prodi">
                              <?php foreach ($data['m_prodi'] as $p) { ?>
                                 <option value="<?= $p->id_prodi ?>" <?= ($p->id_prodi === $d->prodi) ? 'selected' : '' ?>><?= $p->kode_prodi ?></option>
                              <?php } ?>
                           </select>
                        </td>
                     <?php } else { ?>
                        <td class="text-center">
                           <?= $d->kode_prodi ?>
                        </td>
                     <?php } ?>

                     <?php if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') { ?>
                        <td class="text-center" style="padding-left: 6px !important;padding-right: 6px !important;">
                           <select name="kelas_siswa" id="PilihKelas" class="kelas_siswa PilihKelas" data-id="<?= $d->id_siswa ?>" data-name="kelas_siswa">
                              <option value="-">-</option>
                              <option value="XA" <?= ($d->kelas_siswa == 'XA') ? 'selected' : '' ?>>XA</option>
                              <option value="XB" <?= ($d->kelas_siswa == 'XB') ? 'selected' : '' ?>>XB</option>
                              <option value="XC" <?= ($d->kelas_siswa == 'XC') ? 'selected' : '' ?>>XC</option>
                              <option value="XD" <?= ($d->kelas_siswa == 'XD') ? 'selected' : '' ?>>XD</option>
                              <option value="XE" <?= ($d->kelas_siswa == 'XE') ? 'selected' : '' ?>>XE</option>
                              <option value="XF" <?= ($d->kelas_siswa == 'XF') ? 'selected' : '' ?>>XF</option>
                              <option value="XG" <?= ($d->kelas_siswa == 'XG') ? 'selected' : '' ?>>XG</option>
                              <option disabled>-------</option>
                              <option value="XIA" <?= ($d->kelas_siswa == 'XIA') ? 'selected' : '' ?>>XIA</option>
                              <option value="XIB" <?= ($d->kelas_siswa == 'XIB') ? 'selected' : '' ?>>XIB</option>
                              <option value="XIC" <?= ($d->kelas_siswa == 'XIC') ? 'selected' : '' ?>>XIC</option>
                              <option value="XID" <?= ($d->kelas_siswa == 'XID') ? 'selected' : '' ?>>XID</option>
                              <option value="XIE" <?= ($d->kelas_siswa == 'XIE') ? 'selected' : '' ?>>XIE</option>
                              <option value="XIF" <?= ($d->kelas_siswa == 'XIF') ? 'selected' : '' ?>>XIF</option>
                              <option value="XIG" <?= ($d->kelas_siswa == 'XIG') ? 'selected' : '' ?>>XIG</option>
                              <option disabled>-------</option>
                              <option value="XIIA" <?= ($d->kelas_siswa == 'XIIA') ? 'selected' : '' ?>>XIIA</option>
                              <option value="XIIB" <?= ($d->kelas_siswa == 'XIIB') ? 'selected' : '' ?>>XIIB</option>
                              <option value="XIIC" <?= ($d->kelas_siswa == 'XIIC') ? 'selected' : '' ?>>XIIC</option>
                              <option value="XIID" <?= ($d->kelas_siswa == 'XIID') ? 'selected' : '' ?>>XIID</option>
                              <option value="XIIE" <?= ($d->kelas_siswa == 'XIIE') ? 'selected' : '' ?>>XIIE</option>
                              <option value="XIIF" <?= ($d->kelas_siswa == 'XIIF') ? 'selected' : '' ?>>XIIF</option>
                              <option value="XIIG" <?= ($d->kelas_siswa == 'XIIG') ? 'selected' : '' ?>>XIIG</option>
                           </select>
                        </td>
                     <?php } ?>
                     <?php if (!(Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin')) { ?>
                        <td class="text-center">
                           <?= $d->kelas_siswa ?>
                        </td>
                     <?php } ?>

                     <td class="text-center"><?= $d->nomor_hp ?></td>
                     <td class="text-center"><?= $d->nomor_hp_wali ?></td>

                     <td class="text-center">
                        <?php if ((!$d->rfid) || ($d->rfid == '-')) {
                           echo "-";
                        } else {
                           echo "Ada";
                        } ?>
                     </td>

                     <td class=" text-center">
                        <?php if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') { ?>
                           <a href="<?= URLROOT ?>/siswa/edit/<?= $d->id_siswa ?>" class="btn btn-success btn-sm tombol1" title="Edit data siswa"><i class="fa fa-edit"></i></a>
                        <?php } ?>

                        <a href="<?= URLROOT ?>/siswa/lihat/<?= $d->id_siswa ?>" class="btn btn-info btn-sm tombol1" title="Lihat detail siswa"><i class="fa fa-eye"></i></a>

                        <?php if (Middleware::admin('kurikulum') || $_SESSION['role'] == 'admin') { ?>
                           <a href="javascript:void(0)" onclick="deleteData('<?= $d->nis ?>')" class="btn btn-danger btn-sm tombol1" title="Hapus data siswa"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                     </td>
                  </tr>
               <?php $no++;
               endforeach;
               ?>
            </tbody>
         </table>
      <?php } ?>
   </div>
</div>

<style>
   .lebar {
      width: 42px !important;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
   }

   .lebar2 {
      width: 90px !important;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
   }

   .lebar3 {
      width: auto;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
      padding-left: 10px !important;
      padding-right: 10px !important;
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
      $('.PilihKelas').change(function() {
         var pilih_kelas = $(this).val();
         var id_siswa = $(this).data('id');
         var nama_field = $(this).data('name');
         console.log(pilih_kelas)
         $.ajax({
            url: '<?= URLROOT ?>/siswa/pilih_kelas',
            type: 'POST',
            data: {
               id_siswa: id_siswa,
               nama_field: nama_field,
               pilih_kelas: pilih_kelas
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

   $(document).ready(function() {
      $('.PilihProdi').change(function() {
         var pilih_prodi = $(this).val();
         var id_siswa = $(this).data('id');
         var nama_field = $(this).data('name');
         console.log(pilih_prodi)
         $.ajax({
            url: '<?= URLROOT ?>/siswa/pilih_prodi',
            type: 'POST',
            data: {
               id_siswa: id_siswa,
               nama_field: nama_field,
               pilih_prodi: pilih_prodi
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

<script>
   function deleteData(id) {
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Anda tidak bisa mengembalikan data yang dihapus!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/siswa/hapus_siswa?id=' + id,
               type: 'POST',
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