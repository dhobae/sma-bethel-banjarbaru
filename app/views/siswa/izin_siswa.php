<div class="row">
   <div class="col">
      <div class="card card-outline card-primary" style="margin-top:15px">
         <div class="card-body">

            <div class="text-center mb-3" style="font-size: 20px; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
               <b>DAFTAR IZIN SISWA</b>
            </div>

            <?php
            if (isset($_GET['status'])) {
               $status = $_GET['status'];
            } else {
               $status = 'Menunggu ACC';
            }
            ?>

            <div class="container1 mb-2" style="padding:0px">
               <div class="col" style="padding:0px">
                  <a href="<?= URLROOT ?>/siswa/izin_siswa?status=Menunggu ACC" class="btn btn-outline-primary btn-sm tombol3 lebar2 <?= ($status == 'Menunggu ACC') ? 'active' : '' ?>">Menunggu ACC</a>

                  <a href="<?= URLROOT ?>/siswa/izin_siswa?status=Disetujui" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($status == 'Disetujui') ? 'active' : '' ?>">Sudah disetujui</a>

                  <a href="<?= URLROOT ?>/siswa/izin_siswa?status=Ditolak" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($status == 'Ditolak') ? 'active' : '' ?>">&nbsp;&nbsp;Izin ditolak&nbsp;&nbsp;</a>

                  <a href="<?= URLROOT ?>/siswa/izin_siswa?status=Expired" class="btn btn-outline-warning btn-sm tombol3 lebar <?= ($status == 'Expired') ? 'active' : '' ?>">&nbsp;&nbsp;Izin Expired&nbsp;&nbsp;</a>
               </div>
            </div>
            <hr style="margin-top:-9px">

            <div>
               <button type="button" class="btn btn-primary btn-sm tombol2 mb-3 disabled" title="Tambah izin siswa"><i class="fa fa-plus-square"></i> &nbsp;Tambah data izin</button>
            </div>

            <div class="table-responsive">
               <table class="table tabel2 khusus table-bordered table-hover" id="example">
                  <thead>
                     <tr style="text-align:center; height:50px">
                        <th style="width:30px">No</th>
                        <th style="width:20%">Nama Siswa</th>
                        <th style="width:20%">Wali Kelas</th>
                        <th style="width:150px">Tanggal Izin</th>
                        <th>Keterangan</th>
                        <th style="width:100px">Status</th>
                        <th style="width:50px">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1;
                     foreach ($data['izin_siswa'] as $d) : ?>
                        <tr>
                           <td class="text-center"><?= $no ?></td>
                           <!-- NAMA ------------------- -->
                           <td>
                              <?php
                              $nm = $this->Msiswa->siswa_by_nis($d->nis_izin);
                              $nm1 = strtolower($nm->nama_siswa);
                              echo "<b>" . ucwords($nm1) . "</b>";
                              ?>
                              <br />
                              [<?= $d->nis_izin ?>]
                              <br />
                              Tgl dibuat : <?= date4ID($d->tgl_dibuat_izin) ?>
                           </td>
                           <!-- WALI KELAS ------------------- -->
                           <td>
                              <?php
                              $wakel = $this->Msiswa->wali_kelas_by_nik($d->wali_kelas_izin);
                              echo $wakel->nama;
                              ?>
                              <br />
                              Kls : <?= $d->kelas_izin ?>
                           </td>
                           <!-- TANGGAL IZIN ------------------- -->
                           <td class="text-center">
                              <?= dayID($d->mulai_izin) ?>, <?= date4ID($d->mulai_izin) ?><br />
                              s/d <br />
                              <?= dayID($d->mulai_izin) ?>, <?= date4ID($d->sampai_izin) ?><br />
                           </td>
                           <!-- TANGGAL IZIN ------------------- -->
                           <td>
                              <b><?= $d->jenis_izin ?></b><br />
                              Ket : <?= $d->alasan_izin ?>
                           </td>
                           <!-- STATUS IZIN ------------------- -->
                           <td class="text-center">
                              <?php if ($d->status_izin == 'Menunggu ACC') {
                                 echo "<span style='color:orange; font-weight:bold'>" . $d->status_izin . "</span>";
                              } else if ($d->status_izin == 'Disetujui') {
                                 echo "<span style='color:green; font-weight:bold'>" . $d->status_izin . "</span>";
                                 echo "<div style='font-size:12px; line-height:18px' class='mt-1'>";
                                 echo "Ttd.<br/>";
                                 echo $d->wali_kelas_izin;
                                 echo "</div>";
                              } else if ($d->status_izin == 'Ditolak') {
                                 echo "<span style='color:red; font-weight:bold'>" . $d->status_izin . "</span>";
                                 echo "<div style='font-size:12px; line-height:18px' class='mt-1'>";
                                 echo "Ttd.<br/>";
                                 echo $d->wali_kelas_izin;
                                 echo "</div>";
                              }
                              ?>
                           </td>
                           <!-- TOMBOL -------------------- -->
                           <td>
                              <?php if ($status == 'Menunggu ACC') { ?>
                                 <button type="button" data-toggle="modal" data-target="#respon<?= $d->id_izin ?>" class="btn btn-success btn-sm tombol3 mt-1" title="Berikan respon">Respon</button>
                              <?php } else { ?>
                                 <button type="button" class="btn btn-success btn-sm tombol3 mt-1 disabled" title="Berikan respon">Respon</button>
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
</div>

<!-- Modal edit -->
<?php foreach ($data['izin_siswa'] as $d) : ?>
   <div class="modal fade" id="respon<?= $d->id_izin ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Respon Izin siswa</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/siswa/respon_izin">
               <div class="modal-body" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9em">

                  <input type="hidden" name="id_izin" value="<?= $d->id_izin ?>">
                  <input type="hidden" name="nis" value="<?= $d->nis_izin ?>">
                  <input type="hidden" name="mulai_izin" value="<?= $d->mulai_izin ?>">
                  <input type="hidden" name="sampai_izin" value="<?= $d->sampai_izin ?>">
                  <input type="hidden" name="kelas" value="<?= $d->kelas_izin ?>">
                  <input type="hidden" name="wali_kelas" value="<?= $d->wali_kelas_izin ?>">
                  <input type="hidden" name="semester_aktif" value="<?= $data['semester_aktif']->id_jadwal_setting ?>">

                  <?php
                  $tgl_hari_ini = new DateTime();
                  $tanggal_izin = new DateTime($d->sampai_izin);
                  $tgl_hari_ini->setTime(0, 0, 0);
                  $tanggal_izin->setTime(0, 0, 0);
                  if ($tgl_hari_ini->format('Y-m-d') > $tanggal_izin->format('Y-m-d')) { ?>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status Izin</label>
                        <div class="col-sm-5">
                           <select name="status_izin" class="form-control text1" required>
                              <option value="">~Pilih~</option>
                              <option value="Hapus">Hapus Data</option>
                           </select>
                        </div>
                     </div>
                  <?php } else { ?>
                     <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status Izin</label>
                        <div class="col-sm-5">
                           <select name="status_izin" class="form-control text1" required>
                              <option value="">~Pilih~</option>
                              <option value="Menunggu ACC" <?= ($d->status_izin == 'Menunggu ACC') ? 'selected' : '' ?>>Menunggu ACC</option>
                              <option value="Disetujui" <?= ($d->status_izin == 'Disetujui') ? 'selected' : '' ?>>Disetujui</option>
                              <option value="Ditolak" <?= ($d->status_izin == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
                              <option value="Hapus">Hapus Data</option>
                           </select>
                        </div>
                     </div>
                  <?php } ?>

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php endforeach; ?>

<style>
   .khusus td {
      padding: 5px 10px !important;
   }
</style>
<style>
   .lebar {
      width: auto !important;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
      padding-left: 10px !important;
      padding-right: 10px !important;
   }

   .lebar2 {
      width: auto !important;
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
</style>
<script>
   var originalTableBorder = $('#example').css('border');
   var originalTablePadding = $('#example').css('padding');

   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 20,
         "paging": true,
         "lengthChange": true,
         "ordering": false,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": " _MENU_ perhalaman",
            "zeroRecords": "Nothing found - sorry",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Cari disini :"
         }
      });
   });
</script>