<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<?php
$kelas_x = $this->Mjadwal->ringkasan_x();
$kelas_xi = $this->Mjadwal->ringkasan_xi();
$kelas_xii = $this->Mjadwal->ringkasan_xii();
$guru =  $this->Mjadwal->guru_aktif('Ya');
?>

<div class="row">
   <!-- KIRI ------------------------ -->
   <div class="col-lg-6">
      <div class="text-center">
         <h5><b>Pengaturan Jadwal Aktif</b></h5>
      </div>
      <div class="text-center mb-3">
         <small>
            Pilih jadwal yang akan diaktifkan. Jadwal yang aktif akan ditampilkan pada sistem.
         </small>
      </div>

      <div style="max-width: 500px; margin: auto;">
         <div class="card card-secondary card-outline">
            <div class="card-body">
               <label for="semester"><b>Pilih Semester:</b></label>
               <select id="semester" class="form-control" style="width:100%">
                  <option value="">-- Pilih Semester --</option>
                  <?php foreach ($data['list_jadwal_setting'] as $js) : 
                     $th = $this->Mjadwal->tahun_ajaran_byid($js->id_tahun_ajaran);
                     $label_aktif = ($js->status == 1) ? ' (Aktif)' : ''; // Perbaikan di sini
                  ?>
                     <option value="<?= $js->id_jadwal_setting ?>" 
                           data-tahun="<?= $th->tahun_ajaran ?>"
                           data-semester="<?= $js->semester ?>"
                           data-blok="<?= $js->blok ?>"
                           data-berlaku="<?= date3ID($js->berlaku_dari) ?>"
                           <?= ($js->status == 1) ? 'selected' : '' ?>>
                        <?= $th->tahun_ajaran ?> - Semester <?= $js->semester ?> - Blok <?= $js->blok ?><?= $label_aktif ?>
                     </option>
                  <?php endforeach; ?>
               </select>

               <div id="info-jadwal" class="mt-3" style="display:none;">
                  <hr>
                  <table class="table table-sm table-borderless">
                     <tr>
                        <td width="120px"><b>Tahun Ajaran</b></td>
                        <td>: <span id="info-tahun"></span></td>
                     </tr>
                     <tr>
                        <td><b>Semester</b></td>
                        <td>: <span id="info-semester"></span></td>
                     </tr>
                     <tr>
                        <td><b>Blok</b></td>
                        <td>: <span id="info-blok"></span></td>
                     </tr>
                     <tr>
                        <td><b>Berlaku dari</b></td>
                        <td>: <span id="info-berlaku"></span></td>
                     </tr>
                  </table>
               </div>

               <?php if (Middleware::admin('kurikulum')) { ?>
               <div class="text-right mt-3">
                  <button type="button" id="btn-aktifkan" class="btn btn-success btn-sm tombol2" disabled>
                     <i class="fa fa-check"></i> &nbsp;Aktifkan Jadwal
                  </button>
               </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>

   <!-- KANAN ------------------------ -->
   <div class="col-lg-6">
      <?php if ($data['belum_ada_guru']) { ?>
         <div class="text-center mb-3">
            <span style="font-weight:bold; color:red; font-size:1.2em">
               Total JP yang belum ada nama Gurunya
            </span>
            <br />
            <span style="font-weight:bold; color:red; font-size:2em">
               <?= $data['belum_ada_guru']['belum_ada_guru'] ?> JP
            </span>
         </div>
      <?php } ?>

      <div class="table-responsive">
         <table class="tabel1" id="example" style="width:100%">
            <thead>
               <tr>
                  <th rowspan="2" style="height:35px; width:30px" class="text-center">No</th>
                  <th rowspan="2">Nama Guru</th>
                  <th colspan="4" class="text-center">JP Perminggu</th>
               </tr>
               <tr>
                  <th class="text-center" style="width:9%">Kls X</th>
                  <th class="text-center" style="width:9%">Kls XI</th>
                  <th class="text-center" style="width:9%">Kls XII</th>
                  <th class="text-center" style="width:9%">Total</th>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1;
               foreach ($guru as $d) : ?>
                  <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td>
                        <span style="float: left;"><?= $d->nama ?></span>
                        <span style="float: right;">
                           <small><b>
                                 <a href="#" type="button" data-toggle="modal" data-target="#lihat<?= $d->nik ?>">Lihat</a>
                              </b></small>
                        </span>
                     </td>
                     <td class="text-center">
                        <?php echo substr_count($kelas_x, $d->nik) ?>
                     </td>
                     <td class="text-center">
                        <?php echo substr_count($kelas_xi, $d->nik) ?>
                     </td>
                     <td class="text-center">
                        <?php echo substr_count($kelas_xii, $d->nik) ?>
                     </td>
                     <td class="text-center" style="font-weight:bold; background:azure">
                        <?php echo substr_count($kelas_x, $d->nik) + substr_count($kelas_xi, $d->nik) + substr_count($kelas_xii, $d->nik); ?>
                     </td>
                  </tr>
               <?php $no++;
               endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<script>
   $(document).ready(function() {
      // Inisialisasi DataTable
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

      // Handle perubahan dropdown
      $('#semester').on('change', function() {
         var selectedOption = $(this).find(':selected');
         
         if ($(this).val()) {
            // Tampilkan info
            $('#info-tahun').text(selectedOption.data('tahun'));
            $('#info-semester').text(selectedOption.data('semester'));
            $('#info-blok').text(selectedOption.data('blok'));
            $('#info-berlaku').text(selectedOption.data('berlaku'));
            $('#info-jadwal').show();
            $('#btn-aktifkan').prop('disabled', false);
         } else {
            $('#info-jadwal').hide();
            $('#btn-aktifkan').prop('disabled', true);
         }
      });

      // Trigger change saat load jika ada yang selected
      if ($('#semester').val()) {
         $('#semester').trigger('change');
      }

      // Handle klik tombol aktifkan
      $('#btn-aktifkan').on('click', function() {
         var id_jadwal_setting = $('#semester').val();
         var selectedOption = $('#semester').find(':selected');
         
         if (!id_jadwal_setting) {
            Swal.fire({
               icon: 'warning',
               title: 'Perhatian',
               text: 'Pilih jadwal setting terlebih dahulu!'
            });
            return;
         }

         Swal.fire({
            title: 'Aktifkan Jadwal?',
            html: 'Anda akan mengaktifkan:<br><b>' + selectedOption.text().replace(' (Aktif)', '') + '</b>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
                  url: '<?= URLROOT ?>/jadwal/aktifkan_jadwal_setting',
                  type: 'POST',
                  data: {
                     id_jadwal_setting: id_jadwal_setting
                  },
                  dataType: 'json',
                  success: function(response) {
                     if (response.status == 'success') {
                        Swal.fire({
                           title: 'Sukses!',
                           text: response.message,
                           icon: 'success'
                        }).then(() => {
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
                  error: function() {
                     Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server',
                        icon: 'error'
                     });
                  }
               });
            }
         });
      });
   });
</script>

<?php foreach ($guru as $d) : ?>
   <div class="modal fade" id="lihat<?= $d->nik ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">Detail Jam Pelajaran</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <table style="width:100%" class="table tabel1">
                  <thead>
                     <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Hari</th>
                        <th>Mata Pelajaran</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Jam</th>
                     </tr>
                  </thead>
                  <?php
                  $mpnya = $this->Mjadwal->mata_pelajaran_ringkasan($d->nik);
                  $no = 1;
                  foreach ($mpnya as $p) : ?>
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $p->hari ?></td>
                        <td><?= $p->mp ?></td>
                        <td class="text-center"><?= $p->kode_kelas ?></td>
                        <td class="text-center"><?= $p->jam ?></td>
                     </tr>
                  <?php $no++;
                  endforeach; ?>
               </table>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
            </div>
         </div>
      </div>
   </div>
<?php endforeach; ?>