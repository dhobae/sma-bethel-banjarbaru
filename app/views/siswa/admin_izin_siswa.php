<?php 
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
               <a href="<?= URLROOT ?>/siswa/admin_izin_siswa?status=Menunggu ACC" class="btn btn-outline-primary btn-sm tombol3 lebar2 <?= ($status == 'Menunggu ACC') ? 'active' : '' ?>">Menunggu ACC</a>
               <a href="<?= URLROOT ?>/siswa/admin_izin_siswa?status=Disetujui" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($status == 'Disetujui') ? 'active' : '' ?>">Sudah disetujui</a>
               <a href="<?= URLROOT ?>/siswa/admin_izin_siswa?status=Ditolak" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($status == 'Ditolak') ? 'active' : '' ?>">&nbsp;&nbsp;Izin ditolak&nbsp;&nbsp;</a>
               <a href="<?= URLROOT ?>/siswa/admin_izin_siswa?status=Expired" class="btn btn-outline-warning btn-sm tombol3 lebar <?= ($status == 'Expired') ? 'active' : '' ?>">&nbsp;&nbsp;Izin Expired&nbsp;&nbsp;</a>
            </div>
         </div>
            <hr style="margin-top:-9px">

            <div>
               <?php if($_SESSION['role'] == 'admin') { ?>
                  <button type="button" class="btn btn-primary btn-sm tombol2 mb-3" title="Buat pengajuan izin baru" data-toggle="modal" data-target="#tambahIzin"><i class="fa fa-plus-square"></i> &nbsp;Tambah data izin</button>
               <?php } else { ?>
               <button type="button" class="btn btn-primary btn-sm tombol2 mb-3 disabled" title="Tambah izin siswa"><i class="fa fa-plus-square"></i> &nbsp;Tambah data izin</button>
               <?php } ?>
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
                              <?php if($_SESSION['role'] == 'admin') { ?>
                                 <?php if ($status == 'Menunggu ACC') { ?>
                                    <button type="button" data-toggle="modal" data-target="#respon<?= $d->id_izin ?>" class="btn btn-success btn-sm tombol3 mt-1" title="Berikan respon">Respon</button>
                                 <?php } ?>
                                 <button type="button" data-toggle="modal" data-target="#editIzin<?= $d->id_izin ?>" class="btn btn-warning btn-sm tombol3 mt-1" title="Edit Data">Edit</button>
                                 <a href="javascript:void(0)" onclick="hapus('<?= $d->id_izin ?>')" class="btn btn-danger btn-sm tombol3 mt-1" title="Hapus Data">Hapus</a>
                              <?php } else { ?>
                                 <?php if ($status == 'Menunggu ACC') { ?>
                                    <button type="button" data-toggle="modal" data-target="#respon<?= $d->id_izin ?>" class="btn btn-success btn-sm tombol3 mt-1" title="Berikan respon">Respon</button>
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-success btn-sm tombol3 mt-1 disabled" title="Berikan respon">Respon</button>
                                 <?php } ?>
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
            <form method="POST" action="<?= URLROOT ?>/siswa/<?= ($_SESSION['role'] == 'admin') ? 'admin_respon_izin' : 'respon_izin' ?>">
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

   <?php if($_SESSION['role'] == 'admin'): ?>
   <div class="modal fade" id="editIzin<?= $d->id_izin ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Edit Izin Siswa</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/siswa/admin_simpan_edit_izin_siswa" enctype="multipart/form-data">
               <div class="modal-body" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9em">

                  <input type="hidden" name="id_izin" value="<?= $d->id_izin ?>">
                  <input type="hidden" name="status_kembali" value="<?= $status ?>">
                  
                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Siswa & NIS</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control text1" value="<?= $this->Msiswa->siswa_by_nis($d->nis_izin)->nama_siswa ?> (<?= $d->nis_izin ?>)" readonly>
                     </div>
                  </div>
                                                
                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Mulai Izin</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" name="mulai_izin" value="<?= $d->mulai_izin ?>" required>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Sampai dengan</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" name="sampai_izin" value="<?= $d->sampai_izin ?>" required>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Jenis Izin</label>
                     <div class="col-sm-5">
                        <select name="jenis_izin" class="form-control text1" required>
                           <option value="Izin" <?= ($d->jenis_izin == 'Izin') ? 'selected' : '' ?>>Izin</option>
                           <option value="Sakit" <?= ($d->jenis_izin == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                        </select>
                     </div>
                  </div>

                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bukti Yang Telah Ada</label>  
                        <div class="col-sm-5">
                            <?php if($d->file_izin): ?>
                               <?php 
                               $ext = strtolower(pathinfo($d->file_izin, PATHINFO_EXTENSION));
                               $isPdf = ($ext === 'pdf');
                               $filePath = URLROOT . '/smabethel/file_izin/' . $d->file_izin;
                               ?>
                               
                               <?php if ($isPdf) : ?>
                                   <!-- Preview PDF dengan iframe -->
                                   <div class="pdf-preview-container">
                                       <iframe src="<?= $filePath ?>" style="width: 100%; height: 200px; border: 1px solid #ddd;"></iframe>
                                   </div>
                                   <div class="mt-2">
                                       <a href="<?= $filePath ?>" target="_blank" class="btn btn-sm btn-primary mb-2">
                                       <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                                       </a>
                                       <a href="<?= $filePath ?>" download class="btn btn-sm btn-success">
                                       <i class="fas fa-download"></i> Download
                                       </a>
                                   </div>
                               <?php else : ?>
                                   <!-- Preview Gambar -->
                                   <img src="<?= $filePath ?>" alt="Bukti" style="width: 210px; border: 1px solid #ddd; padding: 5px;">
                               <?php endif; ?>
                            <?php else: ?>
                               <span class="text-muted">Tidak ada bukti yang diupload</span>
                            <?php endif; ?>
                        </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Bukti Baru
                        <small style="display:block;">(Jika Perlu)</small>
                     </label>
                     <div class="col-sm-9">
                        <input type="file" name="file_izin">
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control text1" name="keterangan" value="<?= $d->alasan_izin ?>">
                     </div>
                  </div>

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan Edit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <?php endif; ?>

<?php endforeach; ?>

<!-- Modal Tambah Izin ADMIN -->
<?php if($_SESSION['role'] == 'admin') { ?>
   <div class="modal fade" id="tambahIzin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Izin Siswa tidak masuk sekolah</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/siswa/admin_simpan_izin_siswa" enctype="multipart/form-data">
               <div class="modal-body" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9em">

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Tanggal Dibuat</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" value="<?= date('Y-m-d') ?>" readonly>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Nama Siswa & NIS</label>
                        <div class="col-sm-7">
                           <select name="nis_siswa" style="width:100%" class="pilihsiswaizin">
                              <?php foreach ($data['seluruh_siswa_aktif'] as $siswa): ?>
                                 <option value="<?= $siswa->nis ?>">
                                    <?= $siswa->nama_siswa ?> (<?= $siswa->nis ?>)
                                 </option>
                              <?php endforeach; ?>
                           </select>
                        </div>
                  </div>
                                                
                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Mulai Izin</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" name="mulai_izin" required>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Sampai dengan</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" name="sampai_izin" required>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Jenis Izin</label>
                     <div class="col-sm-5">
                        <select name="jenis_izin" class="form-control text1" required>
                           <option value="">~Pilih~</option>
                           <option value="Izin">Izin</option>
                           <option value="Sakit">Sakit</option>
                        </select>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Bukti</label>
                     <div class="col-sm-9">
                        <input type="file" name="file_izin">
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control text1" name="keterangan">
                     </div>
                  </div>

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php } ?>

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

   function hapus(id) {
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
               url: '<?= URLROOT ?>/siswa/hapus_pengajuan_izin/' + id,
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

   $(document).ready(function() {
      // Mencegat form respon admin untuk konfirmasi
      $('form[action*="admin_respon_izin"]').on('submit', function(e) {
         e.preventDefault();
         var form = this;
         var status = $(this).find('select[name="status_izin"]').val();
         
         var titleText = "Apakah anda yakin?";
         var textText = "Status pengajuan izin akan diubah menjadi: " + status;
         var confirmBtn = "Ya, lanjutkan!";

         if (status == 'Hapus') {
            textText = "Anda tidak bisa mengembalikan data yang dihapus!";
            confirmBtn = "Ya, hapus!";
         }
         
         if (status == "") {
            Swal.fire("Peringatan", "Pilih status respon terlebih dahulu", "warning");
            return;
         }

         Swal.fire({
            title: titleText,
            text: textText,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: confirmBtn,
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.isConfirmed) {
               form.submit();
            }
         });
      });
   });
</script>