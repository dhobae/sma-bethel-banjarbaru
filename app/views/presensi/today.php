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
               <th style="width: 50px;" rowspan=2>No</th>
               <th rowspan=2>Nama Dosen / Karyawan</th>
               <th style="width: 90px;" rowspan=2>Status</th>
               <th style="width: 80px;" rowspan=2>Presensi</th>
               <th colspan=2>Presensi Masuk</th>
               <th colspan=2>Presensi Pulang</th>
               <th style="width: 130px;" rowspan=2>Lama</th>
               <th style="width: 65px;" rowspan=2>Reset</th>
               <th style="width: 55px;" rowspan=2>Aksi</th>
            </tr>
            <tr>
               <th style="width: 80px;">Jam</th>
               <th style="width: 80px;">Status</th>
               <!--
               <th style="width: 75px;">Lokasi</th>
               -->
               <th style="width: 80px;">Jam</th>
               <th style="width: 80px;">Status</th>
               <!--
               <th style="width: 75px;">Lokasi</th>
               -->
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
                              if ($field2->jam_masuk > '08:30:00') {
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
                              //echo "<td style='text-align:center;'>" . $loc_masuk . "</td>";
                              echo "<td class='text-center'>" . $field2->jam_pulang . "</td>";
                              echo "<td class='text-center'>" . $field2->from_pulang . "</td>";
                              //echo "<td style='text-align:center;'>" . $loc_pulang . "</td>";

                              $waktu_awal = strtotime($field2->jam_masuk);
                              $waktu_akhir = strtotime($field2->jam_pulang);

                              $diff   = $waktu_akhir - $waktu_awal;
                              if ($diff < 0) {
                                 $diff = 0;
                              } else {
                                 $diff = $diff;
                              }

                              $jam    = floor($diff / (60 * 60));
                              $menit  = $diff - $jam * (60 * 60);
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
                              //echo "<td>-</td>";
                              //echo "<td>-</td>";
                           }
                        endif;
                        echo "<td style='text-align:center;'> 
                        <a href='" . URLROOT . "/rekap/rekap_admin?data=" . $niknya . "' class='btn btn-success btn-sm tombol1' title='Lihat selengkapnya'> <i class='fa fa-eye'></i> </a>
                        </td>";
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