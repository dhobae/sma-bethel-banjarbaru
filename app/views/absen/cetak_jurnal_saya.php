<style>
   .cetak_body {
      font-family: 'calibri', 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
      line-height: 1.3;
      font-size: 14px;
   }

   table {
      border-collapse: collapse;
      border: 1px solid gray;
      font-size: 14px;
   }

   table th {
      border: 1px solid gray;
      padding: 3px 5px;
      text-align: center;
   }

   table td {
      border: 1px solid gray;
      padding: 3px 5px;
   }
</style>

<?php
$bulan_list = array(
   '01' => 'Januari',
   '02' => 'Februari',
   '03' => 'Maret',
   '04' => 'April',
   '05' => 'Mei',
   '06' => 'Juni',
   '07' => 'Juli',
   '08' => 'Agustus',
   '09' => 'September',
   '10' => 'Oktober',
   '11' => 'November',
   '12' => 'Desember'
);
$bl = $_GET['bulan'];
$bulan = isset($bulan_list[$bl]) ? $bulan_list[$bl] : '';

$nm = $this->Mabsen->ambil_nama($_SESSION['nik']);
?>

<body class="cetak_body">

   <div style="text-align:center; margin-bottom:10px">
      <img src="<?= URLROOT ?>/skatel/img/ts.png" width="140px">
   </div>

   <div style="text-align:center; margin-bottom:10px">
      Rekap Absen Mengajar Bulan <b><?= $bulan ?></b> Tahun <b><?= $_GET['tahun'] ?></b>
      <br />
      Nama Guru : <?= $nm->nama ?>
   </div>

   <table style="width:100%">
      <thead>
         <tr>
            <th>No</th>
            <th>Hari / tanggal</th>
            <th>Jam Ke</th>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
            <th>Jurnal Mengajar</th>
         </tr>
      </thead>
      <tbody>
         <?php
         if ($data['rekap_absen_saya']) {
            $no = 1;
            foreach ($data['rekap_absen_saya'] as $d) : ?>
               <tr>
                  <td style="width:25px; text-align:center"><?= $no++ ?></td>
                  <td style="width:125px; text-align:center">
                     <?= dayID($d->tgl_absen_kelas) ?>, <?= date4ID($d->tgl_absen_kelas) ?>
                  </td>
                  <td style="width:35px; text-align:center"><?= $d->jam_absen_kelas ?></td>
                  <td style="width:40px; text-align:center"><?= $d->kelas_absen_kelas . $d->ruang_absen_kelas ?></td>
                  <td style="width:180px;">
                     <?= substr($d->mata_pelajaran_lengkap, 0, 30) ?>
                  </td>
                  <td>
                     <?= $d->materi_pelajaran ?>
                  </td>
               </tr>
         <?php
            endforeach;
         } else {
            echo "<tr><td colspan='6' style='text-align:center'><b>Tidak ada data</b></td></tr>";
         }
         ?>
      </tbody>
   </table>
   <br />
   <table style="width:100%; border:0px">
      <tr>
         <td style="width:400px; border:0px"></td>
         <td style="text-align:center;  border:0px">
            Banjarbaru, <?= dateID(date('Y-m-d')) ?> <br />
            Ttd, <br /><br /><br />
            <b><?= $nm->nama ?></b>
         </td>
      </tr>
   </table>
</body>


<script>
   function backToPreviousPage() {
      window.history.back();
   }

   window.onafterprint = function() {
      backToPreviousPage();
   };

   window.onload = function() {
      window.print();
   };
</script>