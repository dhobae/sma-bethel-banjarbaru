<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Presensi Harian Siswa
      </div>

      <?php
      $bulan = [
         1 => 'Januari',
         2 => 'Februari',
         3 => 'Maret',
         4 => 'April',
         5 => 'Mei',
         6 => 'Juni',
         7 => 'Juli',
         8 => 'Agustus',
         9 => 'September',
         10 => 'Oktober',
         11 => 'November',
         12 => 'Desember'
      ];
      ?>

      <?php
      $bulan_sekarang = date('n');
      ?>

      <div class="container1 mb-2" style="padding:0px">
         <div class="col" style="padding:0px">

            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XA&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XA') ? 'active' : '' ?>">XA</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XB&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class=" btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XB') ? 'active' : '' ?>">XB</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XC&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XC') ? 'active' : '' ?>">XC</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XD&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XD') ? 'active' : '' ?>">XD</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XE&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XE') ? 'active' : '' ?>">XE</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XF&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XF') ? 'active' : '' ?>">XF</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XG&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($data['kelas'] == 'XG') ? 'active' : '' ?>">XG</a>

            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIA&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIA') ? 'active' : '' ?>">XIA</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIB&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIB') ? 'active' : '' ?>">XIB</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIC&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIC') ? 'active' : '' ?>">XIC</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XID&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XID') ? 'active' : '' ?>">XID</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIE&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIE') ? 'active' : '' ?>">XIE</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIF&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIF') ? 'active' : '' ?>">XIF</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIG&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIG') ? 'active' : '' ?>">XIG</a>

            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIIA&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIIA') ? 'active' : '' ?>">XIIA</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIIB&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIIB') ? 'active' : '' ?>">XIIB</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIIC&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIIC') ? 'active' : '' ?>">XIIC</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIID&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIID') ? 'active' : '' ?>">XIID</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIIE&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIIE') ? 'active' : '' ?>">XIIE</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIIF&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIIF') ? 'active' : '' ?>">XIIF</a>
            <a href="<?= URLROOT ?>/siswa/presensi_harian?kelas=XIIG&bulan=<?= $data['bulan'] ?>&tahun=<?= $data['tahun'] ?>" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($data['kelas'] == 'XIIG') ? 'active' : '' ?>">XIIG</a>

            <hr style="margin-top:0px">
         </div>
      </div>

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

      <div class="mb-1">
         <select name="bulan" class="textini" id="bulan" onchange="submitForm()">
            <?php foreach ($bulan as $num => $nama_bulan) : ?>
               <option value="<?php echo $num; ?>" <?php if ($num == $data['bulan']) echo 'selected'; ?>>
                  <?php echo $nama_bulan; ?>
               </option>
            <?php endforeach; ?>
         </select>

         <select name="tahun" class="textini" id="tahun" onchange="submitForm()">
            <option value="2024" <?= ($data['tahun'] == '2024') ? 'selected' : '' ?>>2024</option>
            <option value="2025" <?= ($data['tahun'] == '2025') ? 'selected' : '' ?>>2025</option>
            <option value="2026" <?= ($data['tahun'] == '2026') ? 'selected' : '' ?>>2026</option>
         </select>
      </div>

      <div class="table-responsive">
         <table class="table tabel3 tabelkhusus">
            <thead style="background-color: azure;">
               <tr class="text-center">
                  <th style="height:35px; width:40px;" rowspan="2">No</th>
                  <th rowspan="2">Nama Siswa</th>
                  <th colspan="31">Tanggal</th>
               </tr>
               <tr>
                  <?php
                  for ($i = 1; $i <= 31; $i++) {
                     $tanggal = mktime(0, 0, 0, $data['bulan'], $i, $data['tahun']);
                     $englishDay = date('l', $tanggal);
                     $isWeekend = ($englishDay == 'Saturday' || $englishDay == 'Sunday');
                  ?>
                     <th style="width:2.3%; <?= $isWeekend ? 'background-color:#eeeeee;' : '' ?>" class="text-center"><?= $i ?></th>
                  <?php } ?>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1;
               foreach ($data['siswa_aktif'] as $d) : ?>
                  <tr>
                     <td class="text-center"><?= $no ?></td>
                     <td><?= $d->nama_siswa ?></td>
                     <?php
                     for ($i = 1; $i <= 31; $i++) {

                        $ambil_isi_absen = $this->Msiswa->ambil_isi_absen($i, $data['bulan'], $data['tahun'], $d->nis);
                        $tanggal = mktime(0, 0, 0, $data['bulan'], $i, $data['tahun']);
                        $englishDay = date('l', $tanggal);
                        $isWeekend = ($englishDay == 'Saturday' || $englishDay == 'Sunday');
                     ?>
                        <td class="text-center" style="<?= $isWeekend ? 'background-color:#eeeeee;' : '' ?>">
                           <?php
                           if ($ambil_isi_absen) {
                              if ($ambil_isi_absen->status_ahs == 'Hadir') {
                                 echo "H";
                              } else if ($ambil_isi_absen->status_ahs == 'Izin') {
                                 echo "I";
                              } else if ($ambil_isi_absen->status_ahs == 'Sakit') {
                                 echo "S";
                              } else {
                                 echo "-";
                              }
                           } else {
                              echo "";
                           };
                           ?>
                        </td>
                     <?php } ?>
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
   var kelas = '<?= $data['kelas'] ?>';

   function submitForm() {
      var bulan = document.getElementById('bulan').value;
      var tahun = document.getElementById('tahun').value;
      window.location.href = '<?= URLROOT ?>/siswa/presensi_harian?kelas=' + kelas + '&bulan=' + bulan + '&tahun=' + tahun;
   }
</script>

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

   .tabelkhusus td {
      padding-left: 6px !important;
      padding-right: 6px !important;
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
      font-size: 12px;
      font-weight: bold;
   }
</style>