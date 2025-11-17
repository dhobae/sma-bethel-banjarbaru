<?php require APPROOT . '../../public/dist/lib/ip.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body">
      <div class="tengah mb-2">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px"> <br />
      </div>
      <div class="tengah judul1 mb-2">
         <b>SMA Bethel Banjarbaru<br />[Daftar Izin Meninggalkan sekolah pada jam kerja]</b>
      </div>

      <?php if ($_SESSION['role'] != 'admin') { ?>
         <div>
            <button type="button" data-toggle="modal" data-target="#tambah" class="btn btn-primary btn-sm tombol3"><i class="fa fa-plus-square"></i> &nbsp;<b> Ajukan Izin Keluar</b></a>
         </div>
      <?php } ?>

      <table class="tabeltiga table-bordered table-striped" id="example">
         <thead>
            <tr>
               <th style="height:38px; width:50px">No</th>
               <th>Nama Pegawai</th>
               <th style="width:7%">Hari</th>
               <th style="width:10%">Tanggal</th>
               <th style="width:10%">Dari Jam</th>
               <th style="width:10%">Sampai Jam</th>
               <th style="line-height:16px; width:10%">Durasi<br /><small>(jam : menit)</small></th>
               <th style="width:10%">Status</th>
               <th style="width:80px">#</th>
            </tr>
         </thead>
         <tbody>
            <?php $no = 1;
            foreach ($data['izin_jam_kerja'] as $d) :
               if ($d->status_izin_keluar == '0') {
                  $status = 'Menunggu ACC';
               } else if ($d->status_izin_keluar == '1') {
                  $status = 'Disetujui';
               } else {
                  $status = ' Ditolak';
               }
            ?>
               <tr>
                  <td class="text-center"><?= $no ?></td>
                  <td><?= $d->nama ?></td>
                  <td class="text-center"><?= dayID($d->tanggal) ?></td>
                  <td class="text-center"><?= date3ID($d->tanggal) ?></td>
                  <td class="text-center"><?= $d->dari_jam ?></td>
                  <td class="text-center"><?= $d->sampai_jam ?></td>
                  <?php
                  $dari_waktu = strtotime($d->dari_jam);
                  $sampai_waktu = strtotime($d->sampai_jam);
                  $selisih_detik = $sampai_waktu - $dari_waktu;
                  $jam = floor($selisih_detik / (60 * 60));
                  $sisa_detik = $selisih_detik % (60 * 60);
                  $menit = floor($sisa_detik / 60);
                  $detik = $sisa_detik % 60;

                  $jam_format = sprintf("%02d", $jam);
                  $menit_format = sprintf("%02d", $menit);
                  $detik_format = sprintf("%02d", $detik);
                  ?>
                  <td class="text-center"><?php echo $jam_format . " : " . $menit_format ?></td>
                  <td class="text-center">
                     <?php
                     if ($_SESSION['role'] != 'admin') {
                        if ($d->status_izin_keluar == '0') {
                           echo '<span class="bagde badge-warning badge1">Menunggu ACC</span>';
                        } else if ($d->status_izin_keluar == '1') {
                           echo '<span class="bagde badge-success badge1">Disetujui</span>';
                        } else {
                           echo '<span class="bagde badge-danger badge1">Ditolak</span>';
                        }
                     } else {
                        if ($d->status_izin_keluar == '0') {
                           echo '<a href="" data-toggle="modal" data-target="#respon' . $d->id_izin_keluar . '"><span class="bagde badge-warning badge1">Menunggu ACC</span></a>';
                        } else if ($d->status_izin_keluar == '1') {
                           echo '<a href="" data-toggle="modal" data-target="#respon' . $d->id_izin_keluar . '"><span class="bagde badge-success badge1">Disetujui</span></a>';
                        } else {
                           echo '<a href="" data-toggle="modal" data-target="#respon' . $d->id_izin_keluar . '"><span class="bagde badge-danger badge1">Ditolak</span></a>';
                        }
                     }
                     ?>
                  </td>
                  <td class="text-center">
                     <?php if ($_SESSION['role'] != 'admin') { ?>
                        <?php if ($d->nik == $_SESSION['nik']) { ?>
                           <?php if ($d->status_izin_keluar == '0') { ?>
                              <button type="button" data-toggle="modal" data-target="#edit<?= $d->id_izin_keluar ?>" class="btn btn-success btn-sm tombolsatu" title="Edit data"><i class="fa fa-edit"></i></button>
                              <button type="button" onclick="deleteData('<?= $d->id_izin_keluar ?>')" class="btn btn-danger btn-sm tombolsatu" title="Hapus data"><i class="fa fa-trash"></i></button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-success btn-sm tombolsatu disabled" title="Edit data" style="opacity: 0.3"><i class="fa fa-edit"></i></button>
                              <button type="button" class="btn btn-danger btn-sm tombolsatu disabled" title="Hapus data" style="opacity: 0.3"><i class="fa fa-trash"></i></button>
                           <?php } ?>
                        <?php } else { ?>
                           <button type="button" class="btn btn-success btn-sm tombolsatu disabled" title="Edit data" style="opacity: 0.3"><i class="fa fa-edit"></i></button>
                           <button type="button" class="btn btn-danger btn-sm tombolsatu disabled" title="Hapus data" style="opacity: 0.3"><i class="fa fa-trash"></i></button>
                        <?php } ?>
                        <!-- ADMIN ------- -->
                     <?php } else { ?>
                        <button type="button" data-toggle="modal" data-target="#edit<?= $d->id_izin_keluar ?>" class="btn btn-success btn-sm tombolsatu" title="Edit data"><i class="fa fa-edit"></i></button>
                        <button type="button" onclick="deleteData('<?= $d->id_izin_keluar ?>')" class="btn btn-danger btn-sm tombolsatu" title="Hapus data"><i class="fa fa-trash"></i></button>
                     <?php } ?>
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
   .badge1 {
      font-size: 11px;
      font-weight: bold;
      padding: 1px 7px;
      border-radius: 20px;
   }
</style>

<script>
   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 20,
         "paging": false, //Nomor halaman di bawah
         "lengthChange": true, //Jumlah ditampilkan berapa dulu
         "ordering": false,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": "Menampilkan _MENU_ data perhalaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Pencarian disini :"
         }
      });
   });
</script>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Izin meninggalkan sekolah pada jam kerja</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="POST" action="<?= URLROOT ?>/presensi/simpan_izin_jam_kerja">
            <div class="modal-body">
               <table style="width:100%">
                  <tr>
                     <td style="width:100px">Tanggal</td>
                     <td>:</td>
                     <td>
                        <input type="text" value="<?= dateID(date('Y-m-d')) ?>" readonly>
                     </td>
                  </tr>
                  <tr>
                     <td>Dari Jam</td>
                     <td>:</td>
                     <td>
                        <input type="time" name="dari_jam" min="07:30" max="16:00" onchange="validateTime(this)" required>
                     </td>
                  </tr>
                  <tr>
                     <td>Sampai Jam</td>
                     <td>:</td>
                     <td>
                        <input type="time" name="sampai_jam" min="07:30" max="16:00" onchange="validateTime(this)" required>
                     </td>
                  </tr>
                  <tr>
                     <td>Keperluan</td>
                     <td>:</td>
                     <td>
                        <input type="text" name="keperluan" required style="width:100%">
                     </td>
                  </tr>
               </table>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp; Close</button>
               <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   function validateTime(input) {
      var minTime = "07:30";
      var maxTime = "16:00";

      var selectedTime = input.value;
      var currentTime = new Date();
      var selectedDateTime = new Date("2000-01-01T" + selectedTime + ":00");
      var minDateTime = new Date("2000-01-01T" + minTime + ":00");
      var maxDateTime = new Date("2000-01-01T" + maxTime + ":00");

      if (selectedDateTime < minDateTime || selectedDateTime > maxDateTime) {
         alert("Jam dipilih harus berada di antara 07:30 dan 16:00.");
         input.value = "";
      }
   }
</script>


<?php
foreach ($data['izin_jam_kerja'] as $d) :
?>
   <div class="modal fade" id="edit<?= $d->id_izin_keluar ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><b>Izin meninggalkan sekolah pada jam kerja</b></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/presensi/edit_izin_jam_kerja">
               <input type="hidden" name="id_izin_keluar" value="<?= $d->id_izin_keluar ?>">
               <div class="modal-body">
                  <table style="width:100%">
                     <tr>
                        <td style="width:100px">Tanggal</td>
                        <td>:</td>
                        <td>
                           <input type="text" value="<?= dateID($d->tanggal) ?>" readonly>
                        </td>
                     </tr>
                     <tr>
                        <td>Dari Jam</td>
                        <td>:</td>
                        <td>
                           <input type="time" name="dari_jam" min="07:30" max="16:00" onchange="validateTime(this)" value="<?= $d->dari_jam ?>" required>
                        </td>
                     </tr>
                     <tr>
                        <td>Sampai Jam</td>
                        <td>:</td>
                        <td>
                           <input type="time" name="sampai_jam" min="07:30" max="16:00" onchange="validateTime(this)" value="<?= $d->sampai_jam ?>" required>
                        </td>
                     </tr>
                     <tr>
                        <td>Keperluan</td>
                        <td>:</td>
                        <td>
                           <input type="text" name="keperluan" required style="width:100%" value="<?= $d->keperluan ?>">
                        </td>
                     </tr>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp; Close</button>
                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan Data</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php
endforeach;
?>

<?php
foreach ($data['izin_jam_kerja'] as $d) :
?>
   <div class="modal fade" id="respon<?= $d->id_izin_keluar ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><b>Respon Admin terhadap Izin di jam kerja</b></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/presensi/status_izin_jam_kerja">
               <input type="hidden" name="id_izin_keluar" value="<?= $d->id_izin_keluar ?>">
               <div class="modal-body text-center">
                  <div class="mb-2">
                     <b>Respon</b>
                  </div>
                  <div class="mb-2">
                     <select name="status_izin_keluar" required style="width:200px">
                        <option value="">~ Pilih ~</option>
                        <option value="0" <?= ($d->status_izin_keluar == '0') ? 'selected' : '' ?>>Menunggu ACC</option>
                        <option value="1" <?= ($d->status_izin_keluar == '1') ? 'selected' : '' ?>>Disetujui</option>
                        <option value="2" <?= ($d->status_izin_keluar == '2') ? 'selected' : '' ?>>Ditolak</option>
                     </select>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp; Close</button>
                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php
endforeach;
?>

<script>
   function deleteData(id) {
      console.log('URL: ' + '<?= URLROOT ?>/presensi/hapus_pengajuan_izin/' + id);
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
               url: '<?= URLROOT ?>/presensi/hapus_izin_jam_kerja/' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  if (response.status == 'success') {
                     // Tampilkan SweetAlert untuk sukses
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        // Redirect atau lakukan tindakan lain setelah penghapusan
                        location.reload();
                     });
                  } else {
                     // Tampilkan SweetAlert untuk kesalahan
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