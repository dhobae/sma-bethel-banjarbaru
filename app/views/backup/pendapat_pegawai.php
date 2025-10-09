<div class="card" style="margin-top: 10px; background:azure">
    <div class="card-header bg-danger" style="padding:2px 10px;">
    </div>

    <div class="card-body">
        <div class="tengah mb-2">
            <img src="<?= URLROOT ?>/skatel/img/ts.png" width="160px">
            <br />
        </div>
        <div class="tengah judul1 mb-4">
            <b>Pendapat Pegawai tentang aplikasi Presensi ini</b>
        </div>

        <div>
            <table class="table tabel3">
                <thead style="background-color: brown;color:white">
                    <tr style="height:40px">
                        <td class="tengah tengah2" style="width:70px">No</td>
                        <td class="tengah tengah2" style="width:20%">Digunakan/Tidak</td>
                        <td class="tengah tengah2">Saran dan masukan</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data['pendapat'] as $d) :
                    ?>
                        <tr>
                            <td class="tengah"><?= $no ?></td>
                            <td class="tengah">
                                <?php if ($d->pendapat == 'Ya') {
                                    echo "Ya, Gunakan presensi ini";
                                } else {
                                    echo "Tidak Setuju";
                                } ?>
                            </td>
                            <td><?= $d->saran ?></td>
                        </tr>
                    <?php $no++;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>