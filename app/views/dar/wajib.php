<div class="card" style="margin-top: 10px; background-color:aliceblue">
    <div class="card-header" style="padding:7px 10px; background:orange">
        <b>Pengaturan Karyawan pengisi DAR</b>
    </div>

    <div class="card-body">
        <div class="tengah judul1">
            <b>SMA Bethel Banjarbaru<br />Daily Activity Report (DAR)</b>
            <br /><br />
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="text-center mb-2 mt-2" style="font-size:20px; font-weight:bold">
                    Wajib Mengisi
                </div>
                <table class="tabeltiga table-bordered">
                    <thead style="background-color:brown; color:white">
                        <tr style="height:40px">
                            <th style="width:45px">No</th>
                            <th>Nama Karyawan</th>
                            <th style="width:45px">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['wajib'] as $d) : ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><?= $d->nama ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm tombol1" title="Edit data" data-toggle="modal" data-target="#hidupkan<?= $d->nik ?>"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6">
                <div class="text-center mb-2 mt-2" style="font-size:20px; font-weight:bold">
                    Tidak Wajib Mengisi
                </div>
                <table class="tabeltiga table-bordered">
                    <thead style="background-color:brown; color:white">
                        <tr style="height:40px">
                            <th style="width:45px">No</th>
                            <th>Nama Karyawan</th>
                            <th style="width:45px">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['tidak_wajib'] as $d) : ?>
                            <tr>
                                <td class="text-center"><?= $no ?></td>
                                <td><?= $d->nama ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm tombol1" title="Edit data" data-toggle="modal" data-target="#hidupkan<?= $d->nik ?>"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                        <?php $no++;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Hidupkan -->
<?php
foreach ($data['tidak_wajib'] as $d) { ?>
    <div class="modal fade" id="hidupkan<?= $d->nik ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?= URLROOT ?>/dar/hidupkan_dar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Jadikan Karyawa Wajib mengisi DAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <input type="hidden" name="nik" value="<?= $d->nik ?>">
                        <b>
                            Apakah anda yakin menjadikan karyawan ini menjadi yang wajib mengisi "Daily Activity Report"?
                        </b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm tombol2" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm tombol2"><i class="fa fa-save"></i> &nbsp;Ya, Aktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Matikan -->
<?php
foreach ($data['wajib'] as $d) { ?>
    <div class="modal fade" id="hidupkan<?= $d->nik ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?= URLROOT ?>/dar/matikan_dar">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Jadikan Karyawa Tidak Wajib mengisi DAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <input type="hidden" name="nik" value="<?= $d->nik ?>">
                        <b>
                            Apakah anda yakin menjadikan karyawan ini menjadi yang <span style="color:red;">TIDAK WAJIB MENGISI</span> "Daily Activity Report"?
                        </b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm tombol2" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm tombol2"><i class="fa fa-save"></i> &nbsp;Ya, Non Aktifkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>