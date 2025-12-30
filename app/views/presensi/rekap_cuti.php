<?php
$tahun = date('Y');
?>

<div class="card" style="margin-top: 10px; background-color:azure">
    <div class="card-header bg-primary" style="height:35px; padding:5px 10px;">
        Rekap Cuti Pegawai
    </div>

    <div class="card-body box-profile">

        <div class="tengah">
            <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
        </div>
        <div class="huruf1 tengah" style="font-size:20px; font-weight:bold">
            SMA Bethel Banjarbaru
        </div>
        <div class="huruf1 tengah mb-3" style="font-size:18px; font-weight:bold; margin-top:-6px">
            Rekap Cuti Tahun <?= date('Y') ?>
        </div>

        <div class="col-lg-8 mx-auto">
            <table class="table tabel3 table-striped" id="example3">
                <thead style="background-color:brown; color:white">
                    <tr style="height:45px">
                        <th rowspan="2" style="width:50px">No</th>
                        <th rowspan="2" style="width:100px;">NIK/NIP</th>
                        <th rowspan="2">Nama Dosen / Karyawan</th>
                        <th>Total<br />Cuti</th>
                        <th style="width:70px !important">#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data['rekap_cuti'] as $d) : ?>
                        <tr>
                            <td class="text-center"><?= $no ?></td>
                            <td class="text-center"><?= $d->nik ?></td>
                            <td><?= $d->nama ?></td>
                            <?php
                            $ttl = $this->Mpresensi->hitung_cuti($d->nik, $tahun);
                            ?>
                            <td class="text-center"><?= $ttl->total ?></td>
                            <td class="text-center">
                                <?php if ($ttl->total > 0) { ?>
                                    <button type="button" data-toggle="modal" data-target="#lihat<?= $d->nik ?>" class="btn btn-primary btn-sm tombol1" title="Lihat detail">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal -->
<?php foreach ($data['rekap_cuti'] as $d) { ?>
    <div class="modal fade" id="lihat<?= $d->nik ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding:8px 15px !important">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php $detail = $this->Mpresensi->detail_cuti($d->nik, $tahun); ?>

                    <table class="table tabel3 table-striped">
                        <thead style="background-color:brown; color:white">
                            <tr style="height:40px">
                                <th style="width:50px">No</th>
                                <th style="width:140px">Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($detail as $r) : ?>
                                <tr>
                                    <td class="text-center"><?= $no ?></td>
                                    <td class="text-center"><?= date3ID($r->tanggal) ?></td>
                                    <td><?= $r->keterangan_izin ?></td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer" style="padding:8px 15px !important">
                    <button type="button" class="btn btn-danger tombol2" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Keluar</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>