<?php
if (isset($_GET['mulai'])) {
    $mulai = $_GET['mulai'];
} else {
    $mulai = '2024-07-01';
}

if (isset($_GET['sampai'])) {
    $sampai = $_GET['sampai'];
} else {
    $sampai = date('Y-m-d');
}
?>

<div class="row mt-4">
    <div class="col-lg-6">
        <div class="text-center mb-3">
            <?php $alpa1 = $this->Msiswa->alpa_terbanyak($mulai, $sampai); ?>
            <b>10 Siswa Dengan <span style="color:red">Alpa</span> terbanyak</b>
        </div>
        <table class="table tabel3">
            <thead>
                <tr style="background-color: azure;">
                    <th style="width:40px">No</th>
                    <th>Nama Siswa</th>
                    <th style="width:13%">Kelas</th>
                    <th style="width:13%">Jumlah<br />(JP)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($alpa1 as $a) : ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $a->nama_siswa ?></td>
                        <td class="text-center"><?= $a->kelas_aks ?></td>
                        <td class="text-center"><?= $a->alpa ?></td>
                    </tr>
                <?php $no++;
                endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="col-lg-6">
        <div class="text-center mb-3">
            <?php $alpa1 = $this->Msiswa->izin_terbanyak($mulai, $sampai); ?>
            <b>10 Siswa Dengan <span style="color:red">Izin</span> terbanyak</b>
        </div>
        <table class="table tabel3">
            <thead>
                <tr style="background-color: azure;">
                    <th style="width:40px">No</th>
                    <th>Nama Siswa</th>
                    <th style="width:9%">Kelas</th>
                    <th style="width:9%">Izin<br />(JP)</th>
                    <th style="width:9%">Sakit<br />(JP)</th>
                    <th style="width:9%">Total<br />Izin</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($alpa1 as $a) : ?>
                    <tr>
                        <td class="text-center"><?= $no ?></td>
                        <td><?= $a->nama_siswa ?></td>
                        <td class="text-center"><?= $a->kelas_aks ?></td>
                        <td class="text-center"><?= $a->izin ?></td>
                        <td class="text-center"><?= $a->sakit ?></td>
                        <td class="text-center"><?= $a->total_izin ?></td>
                    </tr>
                <?php $no++;
                endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<style>

</style>