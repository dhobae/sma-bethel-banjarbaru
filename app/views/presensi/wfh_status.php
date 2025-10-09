<?php

require_once 'lib/Mobile_Detect.php';
$detect = new Mobile_Detect;



function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(1 =>    'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $bulan = array(1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}

$tanggal = date("Y-m-d");

$hari   = date('l', microtime($tanggal));
$hari_indonesia = array(
    'Monday'  => 'Senin',
    'Tuesday'  => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu'
);


if (isset($_params[0]) && $_params[0] == 'izin') {
    $tanggal = date("Y-m-d");
    $query = mysqli_query($koneksi, "UPDATE absen set keterangan='ACC' where nik='{$_params[1]}' and tanggal='{$tanggal}' and from_masuk='WFH'");
    if ($query) {
        echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Anda sudah berhasil memberi izin WFH',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}presensi/daftar-hadir'; }, 0);
		</script>";
    } else {
        echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Anda gagal absen',
		    type: 'alert'
		});</script>";
    }
}
if (isset($_params[0]) && $_params[0] == 'batal') {
    $tanggal = date("Y-m-d");
    $query = mysqli_query($koneksi, "UPDATE absen set keterangan='-' where nik='{$_params[1]}' and tanggal='{$tanggal}' and from_masuk='WFH'");
    if ($query) {
        echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Anda sudah berhasil memberi izin WFH',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}presensi/daftar-hadir'; }, 0);
		</script>";
    } else {
        echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Anda gagal absen',
		    type: 'alert'
		});</script>";
    }
}

?>
<?php

$sql = "SELECT * from dosen where npk='{$_id}'";
$query = mysqli_query($koneksi, $sql);
while ($field = mysqli_fetch_array($query)) {
    $npk = $field['npk'];
    $nama = $field['nama'];
}
?>

<center>
    <h1><u>Status WFH</u></h1>
    <br />
    <b>Apakah Status Work From Home (WFH) mendapatkan Izin, atas nama :</b>
    <h4>Nama Karyawan : <?= $nama ?> </h4>
    <b>Hari/Tanggal : <?= $hari_indonesia[$hari] ?>, <?= tanggal_indo($tanggal) ?> </b>

    <br /><br /><br />

    <a href="<?= $_url ?>presensi/wfh-status/izin/<?= $npk ?>/" class="button success">Sudah Izin WFH</a>
    <a href="<?= $_url ?>presensi/wfh-status/batal/<?= $npk ?>/" class="button danger">Batal Izin WFH</a>

    <?php
    if ($detect->isMobile()) {
    ?>
        <a href="<?= $_url ?>presensi/daftar-hadir-HP" class="button primary"> &nbsp; &nbsp; &nbsp; Kembali &nbsp; &nbsp; &nbsp; </a>
    <?php
    } else {
    ?>
        <a href="<?= $_url ?>presensi/daftar-hadir" class="button primary"> &nbsp; &nbsp; &nbsp; Kembali &nbsp; &nbsp; &nbsp; </a>
    <?php
    }
    ?>

</center>