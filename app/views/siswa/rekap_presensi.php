<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Rekap Ketidakhadiran Siswa Skatel Banjarbaru
      </div>

      <?php
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'dash';
      }

      if (isset($_GET['mulai'])) {
         $mulai = $_GET['mulai'];
      } else {
         $mulai = '2024-07-01';
      }

      if (isset($_GET['sampai'])) {
         $sampai = $_GET['sampai'];
      } else {
         $sampai = date('Y-m-d');
      }
      ?>

      <div class="container1" style="padding:0px">
         <div class="col" style="padding:0px">
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=dash&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-info btn-sm tombol3 lebar3 <?= ($kelas == 'dash') ? 'active' : '' ?>">Dashboard</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XA&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XA') ? 'active' : '' ?>">XA</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XB&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XB') ? 'active' : '' ?>">XB</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XC&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XC') ? 'active' : '' ?>">XC</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XD&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XD') ? 'active' : '' ?>">XD</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XE&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XE') ? 'active' : '' ?>">XE</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XF&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XF') ? 'active' : '' ?>">XF</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XG&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XG') ? 'active' : '' ?>">XG</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIA&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIA') ? 'active' : '' ?>">XIA</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIB&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIB') ? 'active' : '' ?>">XIB</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIC&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIC') ? 'active' : '' ?>">XIC</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XID&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XID') ? 'active' : '' ?>">XID</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIE&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIE') ? 'active' : '' ?>">XIE</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIF&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIF') ? 'active' : '' ?>">XIF</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIG&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIG') ? 'active' : '' ?>">XIG</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIIA&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIA') ? 'active' : '' ?>">XIIA</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIIB&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIB') ? 'active' : '' ?>">XIIB</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIIC&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIC') ? 'active' : '' ?>">XIIC</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIID&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIID') ? 'active' : '' ?>">XIID</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIIE&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIE') ? 'active' : '' ?>">XIIE</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIIF&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIF') ? 'active' : '' ?>">XIIF</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=XIIG&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIG') ? 'active' : '' ?>">XIIG</a>
            <a href="<?= URLROOT ?>/siswa/rekap_presensi?kelas=tanpa_kelas&mulai=<?= $mulai ?>&sampai=<?= $sampai ?>" class="btn btn-outline-dark btn-sm tombol3 lebar3 <?= ($kelas == 'tanpa_kelas') ? 'active' : '' ?>">Tanpa Kelas</a>
            <hr style="margin-top:0px">
         </div>
      </div>


      <div style="margin-top:0px !important; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.8em; font-weight:bold" class="mb-2">
         Dari tanggal :
         <input type="date" class="textini" value="<?= $mulai ?>" id="mulai" onchange="submitForm()">
         s/d
         <input type="date" class="textini" value="<?= $sampai ?>" id="sampai" onchange="submitForm()">
         &nbsp;
         <a href="<?= URLROOT ?>/siswa/rekap_presensi" class="btn btn-danger btn-sm tombol2 khusus"><i class="fa fa-undo"></i> &nbsp;Reset</a>
      </div>

      <script>
         var kelas = '<?= $kelas ?>';

         function submitForm() {
            var mulai = document.getElementById('mulai').value;
            var sampai = document.getElementById('sampai').value;
            window.location.href = '<?= URLROOT ?>/siswa/rekap_presensi?kelas=' + kelas + '&mulai=' + mulai + '&sampai=' + sampai;
         }
      </script>


      <?php if ($kelas == 'dash') { ?>
         <?php
         $this->view('siswa/dash_rekap', $data);
         ?>
      <?php } else { ?>
         <?php if (($kelas <> 'all') and ($kelas <> 'tanpa_kelas')) { ?>
            <div class="text-center mb-1" style="font-size:0.95em">
               <b>Wali Kelas &nbsp;:&nbsp;
                  <?php if ($data['wali_kelas']->wali_kelas) {
                     echo $data['wali_kelas']->nama;
                  } else {
                     echo "<span style='color:red'>~Wali kelas belum dipilih~</span>";
                  }
                  ?>
               </b>
            </div>
         <?php } ?>

         <table class="table tabel3" id="example">
            <thead style="background-color: azure;">
               <tr class="text-center">
                  <th style="height:35px; width:50px;">No</th>
                  <th style="width:10%">NIS</th>
                  <th>Nama Siswa</th>
                  <th style="width:7%">Alpa<br />(JP)</th>
                  <th style="width:7%">Izin<br />(JP)</th>
                  <th style="width:7%">Sakit<br />(JP)</th>
                  <th style="width:8%">Telat<br />(Hari)</th>
                  <th style="width:8%">Prodi</th>
                  <th style="width:8%">Kelas</th>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1;
               foreach ($data['siswa_aktif'] as $d) :
                  $nis = $d->nis;

                  $mulai = isset($_GET['mulai']) ? $_GET['mulai'] : null;
                  $sampai = isset($_GET['sampai']) ? $_GET['sampai'] : null;
                  $alpa = $this->Msiswa->rekap_presensi($nis, $mulai, $sampai); ?>
                  <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td class="text-center"><?= $d->nis ?></td>
                     <td><?= $d->nama_siswa ?></td>
                     <td class="text-center">
                        <?php if ($alpa) {
                           echo $alpa->alpa;
                        } else {
                           echo "-";
                        }
                        ?>
                     </td>
                     <td class="text-center">
                        <?php if ($alpa) {
                           echo $alpa->izin;
                        } else {
                           echo "-";
                        }
                        ?>
                     </td>
                     <td class="text-center">
                        <?php if ($alpa) {
                           echo $alpa->sakit;
                        } else {
                           echo "-";
                        }
                        ?>
                     </td>
                     <td class="text-center"></td>
                     <td class="text-center"><?= $d->kode_prodi ?></td>
                     <td class="text-center"><?= $d->kelas_siswa ?></td>
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

   .textini {
      border: 1px solid #aaaaaa;
      background-color: bisque;
   }

   .khusus {
      font-size: 10px !important;
      margin-top: -2px;
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