<?php
require APPROOT . '../../public/dist/lib/ip.php';

$id = $data['tmp_izin']->id;
$nik = $data['tmp_izin']->npk;
$mulai = $data['tmp_izin']->tanggal_mulai;
$sampai = $data['tmp_izin']->tanggal_akhir;
$status = $data['tmp_izin']->status_izin;
$keterangan = $data['tmp_izin']->keterangan_izin;
$nama = $data['tmp_izin']->nama;
?>

<form method="POST" action="<?= URLROOT ?>/presensi/simpan_acc_permohonan">
   <div class="card card-primary card-outline" style="margin-top:10px">
      <div class="card-body box-profile">
         <h4><b>ACC Izin</b></h4>
         <h5>Apakah anda yakin akan menyetujui permohonan : ?</h5>

         <h5> Status &nbsp;:&nbsp; <b>
               <?php if ($status == 'Cuti2') {
                  echo "Cuti alasan penting";
               } else {
                  echo $status;
               } ?></b>
         </h5>

         <h5> Nama &nbsp;:&nbsp; <b><?= $nama; ?></b> </h5>
         <h5> Tanggal &nbsp;:&nbsp; <b><?= tanggal_indo($mulai) ?> s/d <?= tanggal_indo($sampai) ?></b> <br />

            <input type="hidden" name="nik" value="<?= $nik ?>">
            <input type="hidden" name="id_tmp" value="<?= $id ?>">
            <input type="hidden" name="mulai" value="<?= $mulai ?>">
            <input type="hidden" name="sampai" value="<?= $sampai ?>">
            <input type="hidden" name="status" value="<?= $status ?>">
            <input type="hidden" name="keterangan" value="<?= $keterangan ?>">

            <br />
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> &nbsp;Ya, ACC</button>
            <a class="btn btn-danger btn-sm" href="<?= URLROOT ?>/presensi/permohonan_izin"><i class="fa fa-times"></i> &nbsp;Batal</a>
      </div>
   </div>
</form>