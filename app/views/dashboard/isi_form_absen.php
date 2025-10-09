<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<?php if ($data['absen_datang'] == 'belum') { ?>
    <style>
        .warna_modal {
            background-color: #28a745;
        }
    </style>

    <div class="text-center" style="color:white; font-family:'Courier New', Courier, monospace; font-size:20px; padding:10px 10px 0px !important">
        <b>
            <div>
                Selamat Pagi
            </div>
            <div style="font-size:28px" class="mb-3 mt-2">
                <?= $data['ada_data']->nama ?>
            </div>
            <div>
                Anda akan melakukan Presensi Datang untuk Hari/Tanggal
            </div>
            <div class="mt-3 mb-2">
                <?php echo $hari . ", " . $tgl . " " . $bulan . " " . $tahun; ?>
            </div>
        </b>
        <input type="hidden" name="nik" value="<?= $data['ada_data']->nik ?>">
        <input type="hidden" name="absen_datang" value="belum">
    </div>

    <div style="text-align:left; height:20px" class="mt-4">
        <button type="submit" class="btn btn-danger btn-sm" name="hadirkan" onclick="window.navigator.vibrate(300);"> <i class="fa fa-save"></i> &nbsp;Ya, Absen Datang </button>
        <div class="float-right">
            <button type="button" class="btn btn-outline-light btn-sm" onclick="window.location.reload();" data-dismiss="modal"> <i class="fa fa-undo"></i> &nbsp;Batal </button>
        </div>
    </div>

<?php } else { ?>
    <style>
        .warna_modal {
            background-color: #dc3545;
            color: black;
        }
    </style>

    <div class="text-center" style="color:white; font-family:'Courier New', Courier, monospace; font-size:20px; padding:10px 10px 0px !important">
        <b>
            <div>
                Selamat Siang/Sore
            </div>
            <div style="font-size:28px" class="mb-3 mt-2">
                <?= $data['ada_data']->nama ?>
            </div>
            <div>
                Anda akan melakukan Presensi Pulang untuk Hari/Tanggal
            </div>
            <div class="mt-3 mb-2">
                <?php echo $hari . ", " . $tgl . " " . $bulan . " " . $tahun; ?>
            </div>
        </b>
        <input type="hidden" name="nik" value="<?= $data['ada_data']->nik ?>">
        <input type="hidden" name="absen_datang" value="sudah">
        <input type="hidden" name="id_absen" value="<?= $data['cek_absen']->id ?>">
    </div>

    <div style="text-align:left; height:20px" class="mt-4">
        <button type="submit" class="btn btn-success btn-sm" name="hadirkan" onclick="window.navigator.vibrate(300);"> <i class="fa fa-save"></i> &nbsp;Ya, Absen Pulang </button>
        <div class="float-right">
            <button type="button" class="btn btn-outline-light btn-sm" onclick="window.location.reload();" data-dismiss="modal"> <i class="fa fa-undo"></i> &nbsp;Batal </button>
        </div>
    </div>
<?php } ?>