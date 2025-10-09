<br />
<center>
    <?php
    $id = $data['id'];
    $tanggal = $data['tanggal'];
    ?>
    <h1>Reset Absen hari ini?</h1>
    <br>
    <h3>Apabila anda melakukan reset absen hari ini, maka jam masuk / pulang anda <br /> akan di reset (hapus)<br />Setelah di reset, anda akan bisa melakukan absen ulang</h3>
    <br>
    <a href="<?= URLROOT ?>/rekap/reset_jam?id=<?= $id ?>&tgl=<?= $tanggal ?>&status=datang" class="btn btn-primary btn-sm">Reset Jam Datang</a>
    <a href="<?= URLROOT ?>/rekap/reset_jam?id=<?= $id ?>&tgl=<?= $tanggal ?>&status=pulang" class="btn btn-success btn-sm">Reset Jam Pulang</a>
    <?php
    if ($_SESSION['role'] == 'dosen') {
        echo "<a href='" . URLROOT . "rekap_' class='btn btn-danger btn-sm'>Batal / Kembali</a>";
    } else {
        echo "<a href='" . URLROOT . "/rekap/rekap_admin?data={$id}' class='btn btn-danger btn-sm'>Batal / Kembali</a>";
    }
    ?>
</center>