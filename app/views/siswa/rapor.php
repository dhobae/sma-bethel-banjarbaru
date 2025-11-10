<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
    <div class="card">
        <div class="card-body box-profile">

            <div class="mb-2 d-flex align-items-center">
                <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
                <div class="ml-3 pt-3 mb-0" style="font-family:calibri; font-size: 1.2rem; font-weight:bold;">SMA Bethel
                    Banjarbaru</div>
            </div>

            <div class="mb-3">
                <span style="font-family:calibri; font-size: 1.2rem; font-weight:bold;">
                    Daftar E Rapor Kelas Anda :
                    <?php foreach ($data['kelas'] as $row): ?>
                    <span class="badge bg-primary"><?= $row->kode_kelas ?></span>
                    <?php endforeach; ?>

                </span>
                <br>
            </div>
            <!-- cards siswa list siswa rapor -->
            <div class="row">
                <?php 
                $no = 0;
                foreach($data['siswa'] as $row) : ?>
                <div class="col-lg-2 col-6" style="padding: 0px 3px;">
                    <div class="small-box bg-primary">
                        <div class="inner" style="height: 80px; text-align:left;line-height:1.2;padding:10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <p><b><span style="font-family:calibri; font-size:1em;"><?= $row->nama_siswa ;?>
                                            (<?= $row->kelas_siswa ;?>)</span></b>
                                </p>
                                <p><?= $row->nis ;?></p>
                            </div>
                        </div>
                        <div class="icon"><i class="fas fa-user"></i></div>
                        <a href="<?= URLROOT ?>/siswa/rapor_detail/<?= $row->id_siswa;?>" class="small-box-footer">
                            Lihat Rapor
                        </a>
                    </div>
                </div>
                <?php $no++;
                endforeach; ?>
            </div>
            <!-- cards siswa list siswa rapor -->

        </div>
    </div>



</div>