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
         <h5><b>Pengaturan Umum Jadwal</b></h5>
      </div>
      <div class="text-center mb-2">
         <small>
            Pengaturan umum akan berlaku kepada seluruh jadwal yang sudah dibuat, sebelum membuat jadwal sebaiknya tentukan dulu isian dibawah ini
         </small>
      </div>
      <form method="POST" action="<?= URLROOT ?>/jadwal/simpan_jadwal_setting">
         <input type="hidden" name="id_jadwal_setting" value="<?= $data['jadwal_setting']->id_jadwal_setting ?>">
         <table class="tabel2" style="width:80%; margin:auto">
            <tr>
               <td></td>
               <td></td>
            </tr>
            <tr>
               <td style="width:140px">Tahun Ajaran</td>
               <td>
                  <select name="tahun_ajaran" style="width:140px" required>
                     <option value="">Pilih</option>
                     <?php foreach ($data['tahun_ajaran'] as $t) { ?>
                        <option value="<?= $t->id_tahun_ajaran ?>" <?= ($t->id_tahun_ajaran == $data['jadwal_setting']->id_tahun_ajaran) ? 'selected' : '' ?>><?= $t->tahun_ajaran ?></option>
                     <?php } ?>
                  </select>
               </td>
            </tr>
            <tr>
               <td>Semester</td>
               <td>
                  <select name="semester" style="width:140px" required>
                     <option value="">Pilih</option>
                     <option value="Genap" <?= ($data['jadwal_setting']->semester == 'Genap') ? 'selected' : '' ?>>Genap</option>
                     <option value="Ganjil" <?= ($data['jadwal_setting']->semester == 'Ganjil') ? 'selected' : '' ?>>Ganjil</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td>Blok</td>
               <td>
                  <select name="blok" style="width:100px" required>
                     <option value="">Pilih</option>
                     <option value="I" <?= ($data['jadwal_setting']->blok == 'I') ? 'selected' : '' ?>>I</option>
                     <option value="II" <?= ($data['jadwal_setting']->blok == 'II') ? 'selected' : '' ?>>II</option>
                     <option value="III" <?= ($data['jadwal_setting']->blok == 'III') ? 'selected' : '' ?>>III</option>
                     <option value="IV" <?= ($data['jadwal_setting']->blok == 'IV') ? 'selected' : '' ?>>IV</option>
                     <option value="V" <?= ($data['jadwal_setting']->blok == 'V') ? 'selected' : '' ?>>V</option>
                     <option value="VI" <?= ($data['jadwal_setting']->blok == 'VI') ? 'selected' : '' ?>>VI</option>
                     <option value="VII" <?= ($data['jadwal_setting']->blok == 'VII') ? 'selected' : '' ?>>VII</option>
                  </select>
               </td>
            </tr>
            <tr>
               <td>Berlaku Mulai dari</td>
               <td>
                  <input type="date" name="berlaku" style="width:140px" value="<?= $data['jadwal_setting']->berlaku_dari ?>" required>
               </td>
            </tr>
            <?php if (Middleware::admin('kurikulum')) { ?>
               <tr>
                  <td></td>
                  <td style="text-align:right">
                     <button type="submit" class="btn btn-success btn-sm tombol2" title="Simpan pengatura"><i class="fa fa-save"></i> &nbsp;Simpan</button>
                  </td>
               </tr>
            <?php } ?>
         </table>
      </form>
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
               foreach ($guru as $d) :
               ?>
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
               endforeach;
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
                  foreach ($mpnya as $p) :
                  ?>
                     <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $p->hari ?></td>
                        <td><?= $p->mp ?></td>
                        <td class="text-center"><?= $p->kode_kelas ?></td>
                        <td class="text-center"><?= $p->jam ?></td>
                     </tr>
                  <?php $no++;
                  endforeach;
                  ?>
               </table>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
            </div>
         </div>
      </div>
   </div>
<?php endforeach; ?>