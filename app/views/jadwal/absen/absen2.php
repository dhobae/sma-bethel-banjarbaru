<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

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
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="140px">
      </div>
      <div class="tengah judul1">
         <b>SMK Telkom Banjarbaru</b>
      </div>
      <div class="tengah judul1">
         <b>Presensi kelas guru mata pelajaran</b>
      </div>


      <div class="tengah huruf1 mb-1">
         <b>
            Hari :
            <?= dayID($tgl) ?>, <?= dateID($tgl) ?>
         </b>
      </div>

      <div class="mb-2">
         <div class="float-right">
            <a href="<?= URLROOT ?>/absen/rekap_saya" class="btn btn-primary btn-sm tombol2" title="Rekap presensi mengajar saya"><i class="fa fa-eye"></i> &nbsp;Rekap Presensi Mengajar Saya</a>
         </div>
         <b>Pilih Tanggal &nbsp;&nbsp;:&nbsp;&nbsp; </b>
         <input type="date" id="tanggal" style="height: 25px;" onchange="submitForm()" value="<?= $tgl ?>">
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

         <br />
         <table class="table tabeljadwal2">
            <thead style="background-color:<?= $back ?>; color:<?= $warna2 ?>">
               <tr>
                  <th colspan="11" style="font-size:1.6em">Hari : <?= dayID($tgl) ?> | Presensi Kelas : <?= $kelas ?></th>
               </tr>
               <tr style="font-family:'calibri'">
                  <th style="background-color:red; color:white; font-weight:bold">Jam<br />&nbsp;&nbsp;&nbsp;Kelas&nbsp;&nbsp;&nbsp;</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 1</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 2</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 3</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 4</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 5</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 6</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 7</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 8</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 9</th>
                  <th style="width:10%; font-size:1.1em">Jam Ke 10</th>
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
                           $warna = 'gray';
                        } else {
                           $warna = '';
                        }
                        ?>
                        <td style="background-color: <?= $warna ?>; color:<?= $warna2 ?>">

                           <?php if ($cek_absen) { ?>

                              <?php if ($d['guru' . $i] == $_SESSION['nik']) { ?>
                                 <a href="#" onclick="reset_absen('<?= $cek_absen->id_absen_kelas ?>')" style="text-decoration: none; color:black">
                                    <span class="kode_pegawai"><?= $d['kode_pegawai' . $i] ?><br /></span>
                                    <span class="mata_pelajaran"><?= substr($d['mata_pelajaran' . $i], 0, 12) ?>...</span>
                                 </a>
                              <?php } else { ?>
                                 <a href="#" onclick="bukan()" style="text-decoration: none; color:black">
                                    <span class="kode_pegawai"><?= $d['kode_pegawai' . $i] ?><br /></span>
                                    <span class="mata_pelajaran"><?= substr($d['mata_pelajaran' . $i], 0, 12) ?>...</span>
                                 </a>
                              <?php } ?>


                           <?php } else { ?>

                              <?php if ($d['validasi'] == '1') { ?>
                                 <?php if ($d['guru' . $i] == $_SESSION['nik']) { ?>
                                    <a href="#" onclick="absen('<?= $d['kelas'] ?>','<?= $d['ruang'] ?>','<?= $i ?>', '<?= $tgl ?>', '<?= $d['hari'] ?>','<?= rawurlencode($d['singkatan' . $i]) ?>','<?= $d['wali_kelas'] ?>')" style="text-decoration: none; color:green">
                                       <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                       <span class="guru"><?= substr($d['nama' . $i], 0, 12) ?>...</span>
                                    </a>
                                 <?php } else { ?>
                                    <a href="#" onclick="bukan()" style="text-decoration: none; color:green">
                                       <span class="singkatan"><?= $d['singkatan' . $i] ?><br /></span>
                                       <span class="guru"><?= substr($d['nama' . $i], 0, 12) ?>...</span>
                                    </a>
                                 <?php } ?>
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
      font-size: 13px;
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
   function absen(kelas, ruang, jam, tanggal, hari, singkatan, wali_kelas) {
      console.log('URL: ' + '<?= URLROOT ?>/absen/isi_absen/' + kelas + '/' + ruang + '/' + jam + '/' + tanggal + '/' + encodeURIComponent(singkatan) + '/' + wali_kelas);
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
               url: '<?= URLROOT ?>/absen/isi_absen/' + kelas + '/' + ruang + '/' + jam + '/' + tanggal + '/' + encodeURIComponent(singkatan) + '/' + wali_kelas,
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