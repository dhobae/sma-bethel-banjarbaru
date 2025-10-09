<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card-body bg-navy mt-2">
    <div class="row mb-2">
        <div>
            <a href="<?= URLROOT ?>/pegawai/master_jam" class="btn btn-warning btn-sm tomboldua" title="Tambah Master jam"><i class="fa fa-plus-square"></i> &nbsp;<b>Tambah Jam Baru</b></a>
        </div>
        <div style="text-align:center; width:100%; font-size:25px; font-weight:bold" class="mb-3">
            MASTER JAM KERJA
        </div>
        <table class="khusus">
            <thead style="background-color:brown;">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Berlaku Mulai</th>
                    <th colspan="4">Senin - Kamis</th>
                    <th colspan="4">Jumat</th>
                    <th rowspan="2">#</th>
                </tr>
                <tr>
                    <th style="line-height:17px"><small>Jam<br />Masuk</small></th>
                    <th style="line-height:17px"><small>Jam<br />Pulang</small></th>
                    <th style="line-height:17px"><small>Jam<br />Istirahat</small></th>
                    <th style="line-height:17px"><small>Jam<br />Kerja</small></th>
                    <th style="line-height:17px"><small>Jam<br />Masuk</small></th>
                    <th style="line-height:17px"><small>Jam<br />Pulang</small></th>
                    <th style="line-height:17px"><small>Jam<br />Istirahat</small></th>
                    <th style="line-height:17px"><small>Jam<br />Kerja</small></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data['jam'] as $d) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= date3ID($d->berlaku_mulai) ?></td>
                        <td><?= $d->masuk ?></td>
                        <td><?= $d->pulang ?></td>
                        <td><?= $d->jam_istirahat ?> Jam</td>
                        <td><?= $d->jam_kerja ?> Jam</td>
                        <td><?= $d->masuk_jumat ?></td>
                        <td><?= $d->pulang_jumat ?></td>
                        <td><?= $d->jam_istirahat_jumat ?> Jam</td>
                        <td><?= $d->jam_kerja_jumat ?> Jam</td>
                        <td>
                            <a href="<?= URLROOT ?>/pegawai/master_jam?id=<?= $d->id ?>" class="btn btn-warning btn-sm tombolsatu" title="Edit jam"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                <?php $no++;
                endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .khusus {
        width: 100%;
        border: 1px solid white;
    }

    .khusus th {
        border: 1px solid white;
        padding: 5px 5px;
        text-align: center;
    }

    .khusus td {
        border: 1px solid white;
        padding: 5px 5px;
        text-align: center;
    }
</style>