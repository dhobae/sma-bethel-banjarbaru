<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<?php
$tgl = date('Y-m-d');

if (isset($_GET['submit'])) {
   $tgl = date($_GET['tanggal']);

   if (!empty($bln)) {
      $tgl = $tgl;
   }
}
?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="0px">
      </div>
      <div class="tengah judul1">
         <b>SMA Bethel Banjarbaru</b>
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


      <form method="GET" action="" class="form-inline">
         <div class="mb-2">
            <b>Pilih Tanggal &nbsp;:&nbsp; <input type="date" style="height:25px;" name="tanggal" value="<?= $tgl ?>"></b>
            &nbsp;
            <button type=" submit" name="submit" class="btn btn-primary btn-sm tombol2" style="height:25px;padding:2px 10px !important; margin-top:-5px">Tampilkan</button>
         </div>
      </form>


      <hr style="margin:2px !important">
      <div class="mb-2">
         <b>Catatan :</b><br />
         <small><b>Apabila anda salah Absen, anda dapat mereset absen dengan cara mengclik nama anda</b></small>
         <div class="float-right">
            <a href="<?= URLROOT ?>/absen/rekap_saya" class="btn btn-primary btn-sm tombol2" title="Rekap presensi mengajar saya"><i class="fa fa-eye"></i> &nbsp;Rekap Presensi Mengajar Saya</a>
         </div>
      </div>

      <?php
      $currentKelas = ''; // Menyimpan kelas saat ini
      foreach ($data['jadwal'] as $kelas) :
         if ($kelas->kelas != $currentKelas) :
            if ($currentKelas != '') :
               echo '</table>';
            endif;
            $currentKelas = $kelas->kelas; ?>

            <table class="table tabeljadwal mb-4">
               <tr>
                  <th style="background-color:red; color:white; font-weight:bold">Jam<br />&nbsp;&nbsp;&nbsp;Kelas&nbsp;&nbsp;&nbsp;</th>
                  <?php for ($i = 1; $i <= 10; $i++) : ?>
                     <th style="width:10%">Jam Ke <?php echo $i; ?></th>
                  <?php endfor; ?>
               </tr>
            <?php endif; ?>
            <tr>
               <td style="background-color:brown; color:white; font-weight:bold;font-size:20px"><?= $kelas->kelas; ?><?= $kelas->ruang; ?></td>
               <?php for ($i = 1; $i <= 10; $i++) : ?>

                  <?php
                  $cek_absen = $this->Mabsen->cek_absen($tgl, $kelas->kelas, $kelas->ruang, $i);
                  if ($cek_absen) {
                     $warna = 'darkgray';
                  } else {
                     $warna = '';
                  }
                  ?>

                  <td style="background-color: <?= $warna ?>;">
                     <form action="#" method="post">
                        <input type="hidden" name="kelas" value="<?php echo $kelas->kelas; ?>">
                        <input type="hidden" name="jam" value="<?php echo $i; ?>">
                        <input type="hidden" name="data" required>
                        <input type="hidden" name="tanggal" value="<?= $tgl ?>">
                        <?php if ($cek_absen) { ?>
                           <?php if ($cek_absen->nik_absen_kelas == $_SESSION['nik']) { ?>
                              <button type="button" class="button1" onclick="reset_absen('<?= $cek_absen->id_absen_kelas ?>')" style="color:black !important">
                                 <b><?= $cek_absen->nama_pendek ?></b>
                              </button>
                           <?php } else { ?>
                              <b><?= $cek_absen->nama_pendek ?></b>
                           <?php } ?>
                        <?php } else { ?>
                           <button type="button" class="button1" onclick="absen('<?= $kelas->kelas ?>','<?= $kelas->ruang ?>','<?= $i ?>', '<?= $tgl ?>')">Isi Absen<br />Klik disini</button>
                        <?php } ?>
                     </form>
                  </td>
               <?php endfor; ?>
            </tr>
         <?php endforeach; ?>

         <?php
         // Tutup tabel terakhir jika diperlukan
         if ($currentKelas != '') :
            echo '</table>';
         endif;
         ?>
   </div>
</div>


<style>
   /*
   button[type="submit"] {
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
*/

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
   function absen(kelas, ruang, jam, tanggal) {
      //console.log('URL: ' + '<?= URLROOT ?>/absen/isi_absen/' + kelas + '-' + ruang + '-' + jam);
      Swal.fire({
         title: "Kelas : " + kelas + ruang + ", jam ke : " + jam,
         html: "Anda yakin ingin mengisi absen untuk kelas dan jam tersebut?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, absen!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/absen/isi_absen/' + kelas + '/' + ruang + '/' + jam + '/' + tanggal,
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
         title: "Anda Yakin?",
         html: "Reset absen berarti menghapus absen anda pada jam dan kelas yang dipilih",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ye, Reset!",
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
</script>