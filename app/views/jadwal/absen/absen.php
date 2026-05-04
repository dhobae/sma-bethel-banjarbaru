<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>


<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<?php
get_client_ip();
$ipnya = get_client_ip();
$i = 0;
$ada = 0;

foreach ($data['ip'] as $field_ip) {
   $i++;
   if (ip_in_range2($ipnya, $field_ip->ip_address)) {
      $status[$i] = 1;
   } else {
      $status[$i] = 0;
   }
   $ada = $ada + $status[$i];
}
?>


<?php
$tgl = $data['tanggal'];

if ($tgl > date('Y-m-d')) {
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
   $tgl = date('Y-m-d');
}
?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="100px">
      </div>
      <div class="tengah mb-1 huruf1" style="font-size:28px">
         <b>
            Hari :
            <?= dayID($tgl) ?>, <?= dateID($tgl) ?>
         </b>
      </div>
      <div class="tengah judul1" style="margin-top:-5px">
         <b>Presensi Mengajar hanya bisa di isi menggunakan WIFI Sekolah</b>
      </div>
      <div class="tengah mb-3" style="font-size:0.9em; color:#333; background-color:#ffffcc; padding:10px; border-radius:5px; line-height:1.6;">
         <b>Jadwal Jam Presensi Mengajar:</b><br>
         <span style="font-size:0.85em;">
         Jam 1: 07.30-08.15 | Jam 2: 08.15-09.00 | Jam 3: 09.00-09.45 | Jam 4: 09.45-10.30 | Jam 5: 11.00-11.45<br>
         Jam 6: 11.45-12.30 | Jam 7: 12.30-13.15 | Jam 8: 13.45-14.30 | Jam 9: 14.30-15.15 | Jam 10: 15.15-16.00
         </span>
      </div>

      <div class="mb-2">
         <div class="float-right">
            <a href="<?= URLROOT ?>/absen/rekap_saya" class="btn btn-primary btn-sm tombol2" title="Rekap presensi mengajar saya"><i class="fa fa-eye"></i> &nbsp;Rekap Presensi Mengajar Saya</a>
         </div>
         <b>Pilih Tanggal &nbsp;&nbsp;:&nbsp;&nbsp; </b>
         <input type="date" id="tanggal" style="height: 27px;" onchange="submitForm()" value="<?= $tgl ?>">
         &nbsp;&nbsp;
         <a href="<?= URLROOT ?>/jadwal/absen" class="btn btn-primary btn-sm tombol2" title="Kembali ke hari ini">
            <i class="fa fa-undo" aria-hidden="true"></i> &nbsp;Hari ini
         </a>
         <button onclick="changeDate(-1)" class="btn btn-primary btn-sm tombol2" title="Mundur 1 hari">
            <i class="fa fa-backward" aria-hidden="true"></i> &nbsp;Back
         </button>
         <button onclick="changeDate(1)" class="btn btn-primary btn-sm tombol2" title="Maju 1 hari">
            <i class="fa fa-forward" aria-hidden="true"></i> &nbsp;Next
         </button>

      </div>

      <hr style="margin-top:0px; margin-bottom:0px">

      <?php
      foreach ($data['kelas_data'] as $kelas => $absen_kelas) {
         if ($kelas == 'X') {
            $back = 'aliceblue';
            $warna2 = 'black';
         } else if ($kelas == 'XI') {
            $back = '#D6FFDE';
            $warna2 = 'black';
         } else {
            $back = '#FFF5D6';
            $warna2 = 'black';
         }
      ?>

         <div class="table-responsive">
            <table class="table tabeljadwal2">
               <thead style="background-color:<?= $back ?>; color:<?= $warna2 ?>">
                  <tr>
                     <th colspan="12" style="font-size:1.6em">Hari : <?= dayID($tgl) ?> | Presensi Kelas : <?= $kelas ?></th>
                  </tr>
                  <tr style="font-family:'calibri'">
                     <th style="background-color:red; color:white; font-weight:bold">Jam<br />&nbsp;&nbsp;Kelas&nbsp;&nbsp;</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>07.30-08.15</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>08.15-09.00</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>09.00-09.45</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>09.45-10.30</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>11.00-11.45</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>11.45-12.30</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>12.30-13.15</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>13.45-14.30</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>14.30-15.15</th>
                     <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>15.15-16.00</th>
                     <!-- <th style="width:10%; font-size:1.1em" class="text-nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam Ke 11&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>15.30-16.15</th> -->
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $no = 1;
                  foreach ($absen_kelas as $d) :
                  ?>
                     <tr>
                        <td style="background-color:<?= $back ?>; color:<?= $warna2 ?>; font-weight:bold;font-size:20px"><?= $d['kode_kelas'] ?></td>

                        <?php for ($i = 1; $i <= 10; $i++) : ?>

                           <?php
                           $cek_absen = $this->Mjadwal->cek_absen($tgl, $d['kelas'], $d['ruang'], $i);
                           if ($cek_absen) {
                              if ($cek_absen->materi_pelajaran === 'Izin') {
                                 $warna = '#dddddd';
                              } else {
                                 $warna = 'gray';
                              }
                           } else {
                              $warna = '';
                           }
                           ?>
                           <td style="background-color: <?= $warna ?>; color:<?= $warna2 ?>; position: relative;">

                              <?php if ($cek_absen) { ?>
                                 <!-- SUDAH ISI ABSEN --------------------------- -->
                                 <?php
                                 $guru_array = explode(',', $d['guru' . $i]);
                                 if (in_array($_SESSION['nik'], $guru_array)) {
                                    $cek_absen_nama = $this->Mjadwal->cek_absen_nama($_SESSION['nik'], $tgl, $d['kelas'], $d['ruang'], $i);
                                    if ($cek_absen_nama) { ?>
                                       <!-- RESET VERSI LAMA
                                       <a href="#" onclick="reset_absen('<?= $cek_absen->id_absen_kelas ?>')" style="text-decoration: none; color:black">
                                       -->

                                       <a href="<?= URLROOT ?>/jadwal/reset_absen?id_absen=<?= $cek_absen->id_absen_kelas ?>&tgl=<?= $tgl ?>" style="text-decoration: none; color:green">

                                          <span class="kode_pegawai">
                                             <?php
                                             if (strpos($d['guru' . $i], ',') !== false) {
                                                $nama_array[$i] = explode(",", $d['guru' . $i]);
                                                foreach ($nama_array[$i] as $nm) {
                                                   $nama[$i] = $this->Mjadwal->ambil_nama($nm);
                                                   $cek_absen_nama_warna = $this->Mjadwal->cek_absen_nama($nm, $tgl, $d['kelas'], $d['ruang'], $i);
                                                   if ($cek_absen_nama_warna) {
                                                      echo substr($nama[$i]->kode, 0, 5);
                                                   } else {
                                                      echo "<span style='color:#aaaaaa'>" . substr($nama[$i]->kode, 0, 5) . "</span>";
                                                   }
                                                   if ($nm !== end($nama_array[$i])) {
                                                      echo " - ";
                                                   }
                                                }
                                             } else {
                                                echo $d['kode_pegawai' . $i];
                                                echo "</span>";
                                                echo "<br />";
                                                echo "<span class='mata_pelajaran'>" . substr($d['mata_pelajaran' . $i], 0, 12) . "...</span>";
                                             }
                                             ?>
                                       </a>
                                    <?php
                                       //--JIKA SUDAH ADA YG ABSEN LBH DARI 1 GURU
                                    } else { ?>
                                       <!-- VERSI LAMA 
                                       <a href="#" onclick="absen('<?= $d['kelas'] ?>','<?= $d['ruang'] ?>','<?= $i ?>', '<?= $tgl ?>', '<?= $d['hari'] ?>','<?= $d['id_pelajaran' . $i] ?>','<?= $d['wali_kelas'] ?>')" style="text-decoration: none; color:green">
                                    -->

                                       <a href="<?= URLROOT ?>/jadwal/isi_absen?kelas=<?= $d['kelas'] ?>&ruang=<?= $d['ruang'] ?>&jam=<?= $i ?>&tgl=<?= $tgl ?>&hari=<?= $d['hari'] ?>&id_pelajaran=<?= $d['id_pelajaran' . $i] ?>&wali_kelas=<?= $d['wali_kelas'] ?>" onclick="return validateJamTime(<?= $i ?>, '<?= $tgl ?>')" style="text-decoration: none; color:green">

                                          <div style="background:white; position: absolute; top: 0; left: 0; width: 100%; height: 100%; padding-top:5px">
                                             <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                             <span class="guru">
                                                <?php
                                                if (strpos($d['guru' . $i], ',') !== false) {
                                                   $nama_array[$i] = explode(",", $d['guru' . $i]);
                                                   echo count($nama_array[$i]) . " Guru";
                                                } else {
                                                   echo substr($d['nama' . $i], 0, 15) . "..";
                                                }
                                                ?>
                                             </span>
                                          </div>;
                                       </a>
                                    <?php }
                                    ?>
                                 <?php
                                 } else {
                                 ?>
                                    <!-- SUDAH ABSEN salah satu guru DARI AKUN ORANG LAIN -->
                                    <a href="#" onclick="bukan()" style="text-decoration: none; color:black">
                                       <span class="kode_pegawai">
                                          <?php
                                          if (strpos($d['guru' . $i], ',') !== false) {
                                             $nama_array[$i] = explode(",", $d['guru' . $i]);
                                             foreach ($nama_array[$i] as $nm) {
                                                $nama[$i] = $this->Mjadwal->ambil_nama($nm);
                                                $cek_absen_nama_warna = $this->Mjadwal->cek_absen_nama($nm, $tgl, $d['kelas'], $d['ruang'], $i);
                                                if ($cek_absen_nama_warna) {
                                                   echo substr($nama[$i]->kode, 0, 5);
                                                } else {
                                                   echo "<span style='color:#aaaaaa'>" . substr($nama[$i]->kode, 0, 5) . "</span>";
                                                }
                                                if ($nm !== end($nama_array[$i])) {
                                                   echo " - ";
                                                }
                                             }
                                          } else {
                                             echo $d['kode_pegawai' . $i];
                                             echo "</span>";
                                             echo "<br />";
                                             echo "<span class='mata_pelajaran'>" . substr($d['mata_pelajaran' . $i], 0, 12) . "...</span>";
                                          }
                                          ?>
                                    </a>
                                 <?php } ?>
                                 <!-- BELUM ISI ABSEN ----------------- -->
                              <?php } else { ?>
                                 <!-- TANGGAL > VALIDASI VALIDASI----- -->
                                 <?php
                                 if ($tgl >= $d['berlaku_jadwal_dari']) {
                                 ?>
                                    <?php if ($d['validasi'] == '1') { ?>
                                       <!-- JIKA INI KELASNYA --------------- -->
                                       <?php
                                       $guru_array = explode(',', $d['guru' . $i]);
                                       if (in_array($_SESSION['nik'], $guru_array)) {
                                       ?>
                                          <!-- JIKA WFO ------------ -->
                                          <?php if ($ada) { ?>
                                             <!-- ISI ABSEN VERSI LAMA
                                             <a href="#" onclick="absen('<?= $d['kelas'] ?>','<?= $d['ruang'] ?>','<?= $i ?>', '<?= $tgl ?>', '<?= $d['hari'] ?>','<?= $d['id_pelajaran' . $i] ?>','<?= $d['wali_kelas'] ?>')" style="text-decoration: none; color:green"> 
                                             -->

                                             <a href="<?= URLROOT ?>/jadwal/isi_absen?kelas=<?= $d['kelas'] ?>&ruang=<?= $d['ruang'] ?>&jam=<?= $i ?>&tgl=<?= $tgl ?>&hari=<?= $d['hari'] ?>&id_pelajaran=<?= $d['id_pelajaran' . $i] ?>&wali_kelas=<?= $d['wali_kelas'] ?>" onclick="return validateJamTime(<?= $i ?>, '<?= $tgl ?>')" style="text-decoration: none; color:green">

                                                <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                                <span class="guru">
                                                   <?php
                                                   if (strpos($d['guru' . $i], ',') !== false) {
                                                      $nama_array[$i] = explode(",", $d['guru' . $i]);
                                                      echo count($nama_array[$i]) . " Guru";
                                                   } else {
                                                      echo substr($d['nama' . $i], 0, 15) . "..";
                                                   }
                                                   ?>
                                                </span>
                                             </a>
                                             <!-- JIKA WFH ---------------- -->
                                          <?php } else { ?>
                                             <a href="#" onclick="wfh('<?= $d['kelas'] ?>','<?= $d['ruang'] ?>','<?= $i ?>', '<?= $tgl ?>', '<?= $d['hari'] ?>','<?= rawurlencode($d['singkatan' . $i]) ?>','<?= $d['wali_kelas'] ?>')" style="text-decoration: none; color:green">
                                                <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                                <span class="guru">
                                                   <?php
                                                   if (strpos($d['guru' . $i], ',') !== false) {
                                                      $nama_array[$i] = explode(",", $d['guru' . $i]);
                                                      echo count($nama_array[$i]) . " Guru";
                                                   } else {
                                                      echo substr($d['nama' . $i], 0, 15) . "..";
                                                   }
                                                   ?>
                                                </span>
                                             </a>
                                          <?php } ?>
                                       <?php
                                       } else {
                                       ?>
                                          <!-- BUKAN KELASNYA ------------------ -->
                                          <?php if (!Middleware::admin('kurikulum')) { ?>
                                             <a href="#" onclick="bukan()" style="text-decoration: none; color:#bbbbbb">
                                                <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                                <span class="guru">
                                                   <?php
                                                   if (strpos($d['guru' . $i], ',') !== false) {
                                                      $nama_array[$i] = explode(",", $d['guru' . $i]);
                                                      echo "<span style='color:#bbbbbb'>" . count($nama_array[$i]) . " Guru</span>";
                                                   } else {
                                                      echo "<span style='color:#bbbbbb'>";
                                                      echo substr($d['nama' . $i], 0, 15) . "..";
                                                      echo "</span>";
                                                   }
                                                   ?>
                                                </span>
                                             </a>
                                          <?php } else { ?>
                                             <a href="<?= URLROOT ?>/jadwal/isi_absen_kurikulum?kelas=<?= $d['kelas'] ?>&ruang=<?= $d['ruang'] ?>&jam=<?= $i ?>&tgl=<?= $tgl ?>&hari=<?= $d['hari'] ?>&id_pelajaran=<?= $d['id_pelajaran' . $i] ?>&wali_kelas=<?= $d['wali_kelas'] ?>" style="text-decoration: none; color:#bbbbbb">
                                                <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                                <span class="guru">
                                                   <?php
                                                   if (strpos($d['guru' . $i], ',') !== false) {
                                                      $nama_array[$i] = explode(",", $d['guru' . $i]);
                                                      echo "<span style='color:#bbbbbb'>" . count($nama_array[$i]) . " Guru</span>";
                                                   } else {
                                                      echo "<span style='color:#bbbbbb'>";
                                                      echo substr($d['nama' . $i], 0, 15) . "..";
                                                      echo "</span>";
                                                   }
                                                   ?>
                                                </span>
                                             </a>
                                          <?php } ?>
                                       <?php
                                       } ?>
                                    <?php
                                    } ?>
                                 <?php } ?>
                                 <!-- JADWAL BELUM BERLAKU ---- -->
                                 <?php
                                 $lima_hari_sebelum = date('Y-m-d', strtotime('-6 days', strtotime($d['berlaku_jadwal_dari'])));
                                 if (strtotime($tgl) >= strtotime($lima_hari_sebelum) && strtotime($tgl) < strtotime($d['berlaku_jadwal_dari'])) {
                                 ?>
                                    <a href="#" onclick="bukan()" style="text-decoration: none; color:#bbbbbb">
                                       <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                       <span class="guru">
                                          <?php
                                          if (strpos($d['guru' . $i], ',') !== false) {
                                             $nama_array[$i] = explode(",", $d['guru' . $i]);
                                             echo "<span style='color:#bbbbbb'>" . count($nama_array[$i]) . " Guru</span>";
                                          } else {
                                             echo "<span style='color:#bbbbbb'>";
                                             echo substr($d['nama' . $i], 0, 15) . "..";
                                             echo "</span>";
                                          }
                                          ?>
                                       </span>
                                    </a>
                                 <?php } ?>
                              <?php } ?>
                           </td>
                        <?php endfor; ?>
                     </tr>
                  <?php $no++;
                  endforeach;
                  ?>
               </tbody>
            </table>
         </div>
      <?php
      }
      ?>
   </div>
</div>

<style>
   .singkatan {
      font-weight: bold;
      font-size: 20px;
   }

   .guru {
      font-size: 12px;
      color: red;
   }

   .kode_pegawai {
      font-weight: bold;
      font-size: 20px;
      color: white;
   }

   .mata_pelajaran {
      font-size: 13px;
      color: white;
   }
</style>


<style>
   .button1 {
      border: none;
      background: none;
      padding: 0;
      margin: 0;
      cursor: pointer;
      text-decoration: none;
      color: green;
      font-weight: bold;
      line-height: 18px !important;
   }
</style>

<script>
   function submitForm() {
      var tanggal = document.getElementById('tanggal').value;
      window.location.href = '<?= URLROOT ?>/jadwal/absen?tanggal=' + tanggal;
   }
</script>

<script>
   /*
   function absen(kelas, ruang, jam, tanggal, hari, id_pelajaran, wali_kelas) {
      console.log('URL: ' + '<?= URLROOT ?>/absen/isi_absen/' + kelas + '/' + ruang + '/' + jam + '/' + tanggal + '/' + id_pelajaran + '/' + wali_kelas);
      Swal.fire({
         title: "Kelas : " + kelas + ruang + ", Hari : " + hari + ",  jam ke : " + jam,
         html: "Anda yakin ingin mengisi absen untuk kelas dan jam tersebut?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, absen!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/absen/isi_absen/' + kelas + '/' + ruang + '/' + jam + '/' + tanggal + '/' + id_pelajaran + '/' + wali_kelas,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  console.log(response)
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
               },
               error: function(xhr, status, error) {
                  console.error('AJAX Request Error:', status, error);
                  Swal.fire({
                     title: 'Error!',
                     text: 'Terjadi kesalahan..',
                     icon: 'error'
                  });
               }
            });
         }
      });
   }

   function reset_absen(id) {
      Swal.fire({
         title: "Reset Absen?",
         html: "Reset absen berarti menghapus absen anda pada jam dan kelas yang dipilih",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Reset!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/absen/reset_absen/' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  console.log(response)
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
               },
               error: function(xhr, status, error) {
                  console.error('AJAX Request Error:', status, error);
                  Swal.fire({
                     title: 'Error!',
                     text: 'Terjadi kesalahan.',
                     icon: 'error'
                  });
               }
            });
         }
      });
   }
   */

   function bukan() {
      Swal.fire({
         title: "Salah Jadwal / Kelas",
         html: "Yang anda klik bukanlah jadwal / kelas anda",
         icon: "error",
         showCancelButton: false,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ok",
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/absen/reset_absen/' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  console.log(response)
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
               },
               error: function(xhr, status, error) {
                  console.error('AJAX Request Error:', status, error);
                  Swal.fire({
                     title: 'Error!',
                     text: 'Terjadi kesalahan.',
                     icon: 'error'
                  });
               }
            });
         }
      });
   }

   function wfh() {
      Swal.fire({
         title: "Bukan WIFI Sekolah",
         html: "Presensi mengajar hanya bisa di isi menggunakan koneksi WIFI Sekolah",
         icon: "info",
         showCancelButton: false,
         confirmButtonColor: "#3085d6",
         confirmButtonText: "Ok",
      });
   }

   function validateJamTime(jam, tanggal) {
      var jamRanges = {
         1: ['07:30', '08:15'],
         2: ['08:15', '09:00'],
         3: ['09:00', '09:45'],
         4: ['09:45', '10:30'],
         5: ['11:00', '11:45'],
         6: ['11:45', '12:30'],
         7: ['12:30', '13:15'],
         8: ['13:45', '14:30'],
         9: ['14:30', '15:15'],
         10: ['15:15', '16:00']
      };

      if (!jamRanges[jam]) {
         return true;
      }

      var now = new Date();
      var selectedDate = new Date(tanggal + 'T00:00:00');
      var startTime = jamRanges[jam][0].split(':');
      var endTime = jamRanges[jam][1].split(':');
      var start = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(startTime[0]), parseInt(startTime[1]));
      var end = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(endTime[0]), parseInt(endTime[1]));

      // Format waktu dengan dot (.) untuk display
      var startDisplay = jamRanges[jam][0].replace(':', '.');
      var endDisplay = jamRanges[jam][1].replace(':', '.');

      if (now < start) {
         Swal.fire({
            title: 'Belum Waktunya',
            html: 'Jam ke ' + jam + ' hanya dapat diisi antara ' + startDisplay + ' - ' + endDisplay + '.',
            icon: 'warning',
            confirmButtonText: 'OK'
         });
         return false;
      }

      if (now > end) {
         Swal.fire({
            title: 'Sudah Lewat Waktu',
            html: 'Jam ke ' + jam + ' hanya dapat diisi antara ' + startDisplay + ' - ' + endDisplay + '.',
            icon: 'warning',
            confirmButtonText: 'OK'
         });
         return false;
      }

      return true;
   }
</script>

<style>
   .tabeljadwal2 {
      width: 100%;
      border: 2px solid #dddddd;
      font-family: 'calibri';
      font-size: 0.94rem;

   }

   .tabeljadwal2 td {
      border: 2px solid rgb(212, 212, 212);
      padding: 5px 5px !important;
      text-align: center;
      vertical-align: middle !important;
      height: 60px !important;
   }

   .tabeljadwal2 th {
      border: 2px solid rgb(212, 212, 212);
      /*background-color: rgb(158, 29, 29);*/
      /*color: white;*/
      padding: 0px !important;
      text-align: center;
      vertical-align: middle !important;
      height: 49px;
   }
</style>


<script>
   function changeDate(days) {
      let dateInput = document.getElementById('tanggal');
      let currentDate = new Date(dateInput.value);
      currentDate.setDate(currentDate.getDate() + days);
      while (currentDate.getDay() === 6 || currentDate.getDay() === 0) {
         currentDate.setDate(currentDate.getDate() + days);
      }
      dateInput.valueAsDate = currentDate;
      submitForm();
   }

   function validateDate() {
      let dateInput = document.getElementById('tanggal');
      let selectedDate = new Date(dateInput.value);
      let day = selectedDate.getDay();
      if (day === 6 || day === 0) {
         dateInput.classList.add('invalid');
         alert('Tanggal yang dipilih adalah hari Sabtu atau Minggu. Silakan pilih hari lain.');
         dateInput.value = '';
      } else {
         dateInput.classList.remove('invalid');
         submitForm();
      }
   }

   function submitForm() {
      var tanggal = document.getElementById('tanggal').value;
      window.location.href = '<?= URLROOT ?>/jadwal/absen?tanggal=' + tanggal;
   }
</script>