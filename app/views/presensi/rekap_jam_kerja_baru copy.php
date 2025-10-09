<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>


<?php
$jam_kerja = $data['jam_kerja']->jam_kerja;
$hari_kerja = $data['jam_kerja']->hari_kerja;

$tdetik = $jam_kerja * $hari_kerja * 3600;
$tjam = floor($tdetik / (60 * 60));
$tmenit = ($tdetik - $tjam * (60 * 60)) / 60;

if (isset($_GET['bulan'])) {
    $month = $_GET['bulan'];
} else {
    $month = date('m');
}

if (isset($_GET['tahun'])) {
    $year = $_GET['tahun'];
} else {
    $year = date('Y');
}

$bulan1 = array('01' => 'JANUARI', '02' => 'FEBRUARI', '03' => 'MARET', '04' => 'APRIL', '05' => 'MEI', '06' => 'JUNI', '07' => 'JULI', '08' => 'AGUSTUS', '09' => 'SEPTEMBER', '10' => 'OKTOBER', '11' => 'NOVEMBER', '12' => 'DESEMBER');
?>

<div class="card" style="margin-top: 10px; background-color:azure">
    <div class="card-header bg-primary" style="height:35px; padding:5px 10px;">
        <span style="font-family:Trebuchet MS; font-size: 13px;">
            <form method="GET" action="" class="form-inline">
                <label for="date1"><b>Pilih Bulan dan Tahun &nbsp; : </b> &nbsp;&nbsp; </label>
                <select name="bulan" style="height:20px;">
                    <option value="01" <?= ($month == '01') ? 'selected' : '' ?>>Januari</option>
                    <option value="02" <?= ($month == '02') ? 'selected' : '' ?>>Februari</option>
                    <option value="03" <?= ($month == '03') ? 'selected' : '' ?>>Maret</option>
                    <option value="04" <?= ($month == '04') ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= ($month == '05') ? 'selected' : '' ?>>Mei</option>
                    <option value="06" <?= ($month == '06') ? 'selected' : '' ?>>Juni</option>
                    <option value="07" <?= ($month == '07') ? 'selected' : '' ?>>Juli</option>
                    <option value="08" <?= ($month == '08') ? 'selected' : '' ?>>Agustus</option>
                    <option value="09" <?= ($month == '09') ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= ($month == '10') ? 'selected' : '' ?>>Oktober</option>
                    <option value="11" <?= ($month == '11') ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= ($month == '12') ? 'selected' : '' ?>>Desember</option>
                </select>
                &nbsp;
                <input type="number" name="tahun" value="<?= $year ?>" style="width: 70px; height:20px;">
                &nbsp;
                <button type="submit" name="submit" class="myButton6" style="height:20px; padding:0px 10px;">Tampilkan</button>
            </form>
        </span>
    </div>


    <div class="card-body box-profile">

        <?php
        $jam_k_normal = $data['jam_kerja']->jam_kerja * hari_normal($month, $year);
        $jam_k_jumat = $data['jam_kerja']->jam_kerja_jumat * hari_jumat($month, $year);
        $ttl_jam_kerja = $jam_k_normal + $jam_k_jumat;
        ?>

        <div style="margin-top:-13px; line-height:16px;">
            <small>
                <b>
                    Jumlah hari Senin-Kamis : <?= hari_normal($month, $year); ?>
                    <br />
                    Jumlah hari Jumat : <?= hari_jumat($month, $year); ?>
                </b>
            </small>
        </div>

        <div class="tengah">
            <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
        </div>
        <div class="huruf1 tengah" style="font-size:25px; font-weight:bold">
            SMK Telkom Banjarbaru
        </div>
        <div class="huruf1 tengah mb-3" style="font-size:18px; font-weight:bold; margin-top:-6px">
            Rekap Bulan <b><?php echo $bulan1[$month] ?> </b>, Tahun <b><?= $year ?></b>
        </div>

        <?php
        $diff_all = 0;
        if ($data['jumlah_libur']) {
            if ($data['jumlah_libur']->jumlah_libur) {
                $diff_all = $data['jumlah_libur']->jumlah_libur * $data['jam_kerja']->jam_kerja * 3600;
            } else {
                $diff_all = 0;
            };
        } else {
            $diff_all = 0;
        }
        ?>

        <?= $data['jumlah_libur']->jumlah_libur * $data['jam_kerja']->jam_kerja ?>

        <table class="table tabel3 table-striped" id="example3">
            <thead style="background-color:brown; color:white">
                <tr>
                    <th rowspan="2" style="width:50px">No</th>
                    <th rowspan="2" style="width:100px;">NIK/NIP</th>
                    <th rowspan="2">Nama Dosen / Karyawan</th>
                    <th colspan="4" style="text-align:center;">Beban Kerja</td>
                    <th rowspan="2">Total Jam Kerja</th>
                    <th rowspan="2">Kekurangan<br />(jam)</th>
                    <th rowspan="2">Kekurangan<br />(hari)</th>
                    <th rowspan="2">Detail</th>
                </tr>
                <tr>
                    <th style="width: 50px;text-align:center;">Hari</th>
                    <th style="width: 50px;text-align:center; line-height:15px"><small>Senin<br />Kamis</small></th>
                    <th style="width: 50px;text-align:center; line-height:15px"><small>Jumat</small></th>
                    <th style="width: 65px;text-align:center;">Ttl Jam</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $tanggal = date("Y-m-d");
                $no = 1;
                if ($data['rekap_jam_kerja']) :
                    foreach ($data['rekap_jam_kerja'] as $field) :
                        $niknya = $field->nik;

                        $jumlah_hari_libur = ($data['jumlah_libur']->jumlah_libur * $data['jam_kerja']->jam_istirahat) * 3600;
                        $jumlah_hari_absen = ($field->jumlah_absen * $data['jam_kerja']->jam_istirahat) * 3600;
                        $jumlah_jam_istirahat = $jumlah_hari_libur + $jumlah_hari_absen;

                        $diff   = $field->total_detik_selain_hadir;
                        $jam1    = floor($diff / (60 * 60));
                        $menit1  = ($diff - $jam1 * (60 * 60)) / 60;

                        $d_kurang = $tdetik - $diff;
                        $j_kurang    = floor($d_kurang / (60 * 60));
                        $m_kurang  = ($d_kurang - $j_kurang * (60 * 60)) / 60;



                ?>
                        <tr>
                            <td style="width:10px;text-align:center;"> <?= $no ?> </td>
                            <td class="tengah"> <?= $field->nik ?> </td>
                            <td> <?= $field->nama ?> </td>
                            <td style="text-align:center;"> <?= hari_normal($month, $year) + hari_jumat($month, $year) ?></td>
                            <td style="text-align:center;"> <?= $data['jam_kerja']->jam_kerja ?></td>
                            <td style="text-align:center;"> <?= $data['jam_kerja']->jam_kerja_jumat ?></td>
                            <td style="text-align:center;"> <?= $ttl_jam_kerja ?></td>
                            <td class="tengah"> <?= $jam1 ?> jam, <?= floor($menit1) ?> menit</td>
                            <?php
                            if ($d_kurang < 0) {
                                echo "<td class='tengah'> - </td>";
                            } else {
                                echo "<td class='tengah'>" . $j_kurang . " jam, " . floor($m_kurang) . " mnt </td>";
                            }
                            ?>
                            <?php
                            if ($d_kurang < 0) {
                                echo "<td class='tengah'> - </td>";
                            } else {
                                $total_hours = $j_kurang;
                                $hours_per_day = 7.5;
                                $total_days = floor($total_hours / $hours_per_day);
                                $remaining_hours = $total_hours - ($total_days * $hours_per_day);
                                echo "<td class='tengah'>" . $total_days  . " Hari, " . $remaining_hours . " Jam</td>";
                            }
                            ?>
                            <td class="text-center" style="font-weight:bold">
                                <a href="<?= URLROOT ?>/presensi/lihat_detail?id=<?= $field->nik ?>&bulan=<?= $month ?>&tahun=<?= $year ?>" title="lihat detail">Lihat</a>
                            </td>

                        </tr>
                    <?php
                        $no++;
                    endforeach;
                else :
                    ?>
                    <tr>
                        <td colspan="11">
                            Data tidak ditemukan
                        </td>
                    </tr>
                <?php
                endif;
                ?>
        </table>

    </div>
</div>
</body>


<script>
    $(function() {
        $("#example3").DataTable({
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, 100, 150, 200, -1],
                [10, 25, 50, 100, 150, 200, "All"]
            ],
            "responsive": true,
            "autoWidth": false,
            "pageLength": 80,
            "searching": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
    });
</script>


<style>
    .dataTables_wrapper .dt-buttons button {
        background-color: #A1A1A1;
        color: white;
        border: none;
        border-radius: 0px;
        padding: 2px 8px;
        margin-right: -2px;
        cursor: pointer;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-size: 0.75em;
    }

    .dataTables_wrapper .dt-buttons button:hover {
        background-color: #45a049;
    }

    .dataTables_wrapper .dt-buttons button:active {
        background-color: #3e8e41;
    }
</style>