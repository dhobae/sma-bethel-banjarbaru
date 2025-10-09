<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<?php
$tanggal2 = $data['tanggal'];

if ($tanggal2 > date('Y-m-d')) {
   echo '<script>';
   echo 'Swal.fire({
      title: "Tanggal dipilih salah",
      text: "Anda memilih tanggal melebihi tanggal hari ini.",
      icon: "warning",
      confirmButtonText: "OK"
   }).then(function() {
      window.location.href = "absen";
   })';
   echo '</script>';
   $tanggal2 = date('Y-m-d');
}
?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-header bg-primary" style="height:35px; padding:5px 10px;">
      <b>Presensi Harian</b>
   </div>
   <div class="card-body box-profile">

      <?php
      $hari = date('N', strtotime($tanggal2));
      if ($hari == 5) {
         $jam_kerja = $data['jam_kerja']->jam_kerja_jumat;
         $jam_istirahat = $data['jam_kerja']->jam_istirahat_jumat;
      } else {
         $jam_kerja = $data['jam_kerja']->jam_kerja;
         $jam_istirahat = $data['jam_kerja']->jam_istirahat;
      }
      ?>

      <div class="huruf1 tengah mb-1 mt-2" style="font-size:20px; font-weight:bold; margin-top:-6px">
         Daftar Absen Hari ini : <?php echo tanggal_indo($tanggal2); ?>
      </div>


      <div class="mb-1 mt-3" style="font-family:Trebuchet MS; font-size: 14px; font-weight:bold">
         <label for="date1"><b>Pilih Tanggal : </b>&nbsp;</label>
         <input type="date" id="tanggal" style="height: 25px;" onchange="submitForm()" value="<?= $tanggal2 ?>">
      </div>


      <table class="table tabel3 table-striped">
         <thead style="background-color: brown; color:white">
            <tr>
               <th style="width: 50px;" rowspan='2'>No</th>
               <th rowspan='2'>Nama Dosen / Karyawan</th>
               <th style="width: 90px;" rowspan='2'>Status</th>
               <th style="width: 80px;" rowspan='2'>Presensi</th>
               <th colspan='2'>Presensi Masuk</th>
               <th colspan='2'>Presensi Pulang</th>
               <th rowspan='2'>Beban<br />Kerja</th>
               <th rowspan='2'>Lama<br />Istirahat</th>
               <th style="width: 130px;" rowspan='2'>Lama<br />Hari ini</th>
               <th style="width: 65px;" rowspan='2'>Reset</th>
               <th style="width: 55px;" rowspan='2'>Aksi</th>
            </tr>
            <tr>
               <th style="width: 80px;">Jam</th>
               <th style="width: 80px;">Status</th>
               <th style="width: 80px;">Jam</th>
               <th style="width: 80px;">Status</th>
            </tr>
         </thead>

         <tbody>
            <?php
            //$tanggal2 = date("Y-m-d");
            $no = 1;
            if ($data['today']) :
               foreach ($data['today'] as $field) :
                  $niknya = $field->nik;
            ?>
                  <tr>
                     <td style='text-align:center;'> <?= $no ?> </td>
                     <td> <?= $field->nama ?></td>
                     <?php

                     $today_tanggal = $this->Mpresensi->today_by_tanggal($tanggal2);
                     $today_nik = $this->Mpresensi->today_by_nik($niknya, $tanggal2);

                     if ($today_tanggal) :
                        foreach ($today_tanggal as $field3) {
                           echo "<td colspan=9 class='text-center'>" . $field3->kenapa . "</td>";
                           //echo "<td><b><a href='" . URLROOT . "rekap_?data=" . $niknya . "'> Lihat </a></b></td>";
                        }
                     else :
                        if ($today_nik) :
                           foreach ($today_nik as $field2) {
                              $loc_masuk = '';
                              $loc_pulang = '';
                              if (($field2->loc_masuk == '-') || ($field2->loc_masuk == '')) {
                                 $loc_masuk = '<b>N/A</b>';
                              } else {
                                 $loc_masuk = '<button type="submit" name="submit" class="btn btn-warning tombollokasi" onClick="showLoc(\'' . preg_replace('/\s+/', '', $field2->loc_masuk) . '\')">Lokasi</button>';
                              }

                              if (($field2->loc_pulang == '-') || ($field2->loc_pulang == '')) {
                                 $loc_pulang = '<b>N/A</b>';
                              } else {
                                 $loc_pulang = '<button type="submit" name="submit" class="btn btn-warning tombollokasi" onClick="showLoc(\'' . preg_replace('/\s+/', '', $field2->loc_pulang) . '\')">Lokasi</button>';
                              }
                              if ($field2->jam_masuk > '08:00:00') {
                                 $statustelat = 'Telat';
                                 $warna = 'red';
                              } else {
                                 $statustelat = 'On Time';
                                 $warna = 'green';
                              }
                              echo "<td style='color:" . $warna . "; font-weight:bold; text-align:center'>" . $statustelat . "</td>";
                              echo "<td class='text-center'>" . $field2->status_masuk . "</td>";
                              echo "<td class='text-center'>" . $field2->jam_masuk . "</td>";
                              echo "<td class='text-center'>" . $field2->from_masuk . "</td>";
                              echo "<td class='text-center'>" . $field2->jam_pulang . "</td>";
                              echo "<td class='text-center'>" . $field2->from_pulang . "</td>";

                              echo "<td class='text-center'>" . $jam_kerja . "</td>";
                              echo "<td class='text-center'>" . $jam_istirahat . "</td>";

                              $timestamp1 = strtotime($data['tanggal']);
                              $dayOfWeek = date('N', $timestamp1);
                              if ($dayOfWeek == 5) {
                                 $istirahat = $data['jam_kerja']->jam_istirahat_jumat;
                              } else {
                                 $istirahat = $data['jam_kerja']->jam_istirahat;
                              }
                              $istirahatDetik = $istirahat * 3600;

                              $waktu_awal = strtotime($field2->jam_masuk);
                              $waktu_akhir = strtotime($field2->jam_pulang);

                              $diff_absen   = $waktu_akhir - $waktu_awal;
                              $diff_absen -= $istirahatDetik;
                              if ($diff_absen < 0) {
                                 $diff_absen = 0;
                              } else {
                                 $diff_absen = $diff_absen;
                              }

                              $jam    = floor($diff_absen / (60 * 60));
                              $menit  = $diff_absen - $jam * (60 * 60);
                              echo "<td>" . $jam .  ' jam, ' . floor($menit / 60) . " menit </td>";
                              if ($field2->status_masuk == 'Hadir') {
                                 echo "<td><a href='" . URLROOT . "/presensi/reset/" . $field2->id . "'><b>Reset</b></a></td>";
                              } else {
                                 echo "<td>-</td>";
                              }
                           }
                        else : {
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              echo "<td class='text-center'>-</td>";
                              //echo "<td>-</td>";
                              //echo "<td>-</td>";
                           }
                        endif; ?>
                        <td style='text-align:center;'>
                           <a href="<?= URLROOT ?>/rekap/rekap_admin?data=<?= $niknya ?>" class='btn btn-success btn-sm tombol1' title='Lihat selengkapnya'> <i class='fa fa-eye'></i> </a>
                        </td>
                     <?php
                     endif;
                     ?>
                  </tr>
               <?php
                  $no++;
               endforeach;
            else :
               ?>
               <tr>
                  <td colspan="7">
                     Data tidak ditemukan
                  </td>
               </tr>
            <?php
            endif;
            ?>
      </table>
   </div>
</div>
</body>


<script>
   function submitForm() {
      var tanggal = document.getElementById('tanggal').value;
      window.location.href = '<?= URLROOT ?>/presensi/today?tanggal=' + tanggal;
   }
</script>


<script>
   function showLoc(loc) {
      window.open("<?php echo URLROOT; ?>/presensi/showloc?data=" + loc, "_blank", "toolbar=no,scrollbars=yes,resizable=yes,'',left=500,width=400,height=400");
   }
</script>