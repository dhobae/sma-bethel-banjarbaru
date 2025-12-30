<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>
<?php
$year = date('Y');
$month = date('m');

if (isset($_GET['submit'])) {
    $year = date('Y');
    $month = date('m');

    $bln = date($_GET['bulan']);
    $thn = date($_GET['tahun']);

    if (!empty($bln)) {
        $year = $thn;
        $month = $bln;
    }
}
?>


<div class="card" style="margin-top: 10px; background-color:cornsilk">
    <div class="card-header" style="padding:7px 10px; background:orange">
        <b>Catatan Rekap Absen &nbsp; : &nbsp; <?= $_SESSION['nama'] ?> </b>
    </div>

    <div class="card-body">
        <div class="tengah mb-2">
            <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="90px"> <br />
        </div>
        <div class="tengah judul1">
            <b>SMA Bethel Banjarbaru<br />[Rekap Absen]</b>
            <br /><br />
        </div>

        <div class="huruf1 mb-2">
            <form method="GET" action="" class="form-inline">
                <label for="date1"><b>Pilih Bulan dan Tahun : </b>&nbsp;</label>
                <select class="" name="bulan" style="height:23px;">
                    <option value="">-</option>
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
                <input type="number" name="tahun" value="<?= $year ?>" style="width: 70px;height:23px;">
                &nbsp;
                <button type="submit" name="submit" class="btn btn-primary btn-sm tombol2" style="height:23px;padding:0px 10px;">Tampilkan</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="tabeltiga table-bordered table-striped">
                <thead style="background-color:brown; color:white">
                    <tr>
                        <th style="width: 45px;" rowspan=2>No</th>
                        <th style="width: 100px;" rowspan=2>Hari</th>
                        <th rowspan=2>Tanggal</th>
                        <th style="width: 8%;" rowspan=2>Presensi</th>
                        <th colspan=2>Presensi Masuk</th>
                        <th colspan=2>Presensi Pulang</th>
                        <th rowspan=2 style="width: 9%;">Jam<br />Istirahat</th>
                        <th rowspan=2 style="width: 9%;">Beban<br /><small>Perhari</small></th>
                        <th rowspan=2 style="width: 9%;">Total Jam<br />hari ini</th>
                    </tr>
                    <tr>
                        <th style="width: 9%;">Jam</th>
                        <th style="width: 7%;">Status</th>
                        <th style="width: 9%;">Jam</th>
                        <th style="width: 7%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $totallibur = 0;
                    $ttllbur = 0;
                    $totallibur_all = 0;

                    $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    for ($x = 1; $x <= $number_of_days; $x++) {
                        //membuat nama hari
                        $hari = date("l", strtotime($x . "-" . $month . "-" . $year));
                        if ($hari == "Sunday") {
                            $hari = "Minggu";
                        } elseif ($hari == "Monday") {
                            $hari = "Senin";
                        } elseif ($hari == "Tuesday") {
                            $hari = "Selasa";
                        } elseif ($hari == "Wednesday") {
                            $hari = "Rabu";
                        } elseif ($hari == "Thursday") {
                            $hari = "Kamis";
                        } elseif ($hari == "Friday") {
                            $hari = "Jum'at";
                        } elseif ($hari == "Saturday") {
                            $hari = "Sabtu";
                        }

                        $bulan = date("F", strtotime($x . "-" . $month . "-" . $year));
                        if ($bulan == "January") {
                            $bulan = " Januari ";
                        } elseif ($bulan == "February") {
                            $bulan = " Februari ";
                        } elseif ($bulan == "March") {
                            $bulan = " Maret ";
                        } elseif ($bulan == "April") {
                            $bulan = " April ";
                        } elseif ($bulan == "May") {
                            $bulan = " Mei ";
                        } elseif ($bulan == "June") {
                            $bulan = " Juni ";
                        } elseif ($bulan == "July") {
                            $bulan = " Juli ";
                        } elseif ($bulan == "August") {
                            $bulan = " Agustus ";
                        } elseif ($bulan == "September") {
                            $bulan = " September ";
                        } elseif ($bulan == "October") {
                            $bulan = " Oktober ";
                        } elseif ($bulan == "November") {
                            $bulan = " November ";
                        } elseif ($bulan == "December") {
                            $bulan = " Desember ";
                        }

                        $bulan2 = date("m", strtotime($x . "-" . $month . "-" . $year));
                        $tanggal2 = str_pad($x, 2, "0", STR_PAD_LEFT);
                        $tanggal3 = $year . "-" . $bulan2 . "-" . $tanggal2;

                    ?>


                        <tr>
                            <td style="width: 50px;" class="tengah"> <?= $x ?> </td>
                            <td style="width: 80px;" class="tengah"> <?= $hari ?> </td>
                            <td style="width: 160px;" class="tengah"> <?= tanggal_indo($tanggal3) ?> </td>
                            <?php
                            $nik = $_SESSION['username'];
                            $rekap_bulanan = $this->Mrekap->rekap_bulanan($nik, $tanggal3);

                            if ($rekap_bulanan) :
                                foreach ($rekap_bulanan as $field2) {
                                    if ($field2->nik == "all") {
                                        echo "<td colspan='9' style='text-align:center;background:#A7A7A7;'>" . $field2->keterangan_libur . "</td>";

                                        $jam_libur_all = $data['jam_kerja']->jam_kerja;

                                        $detiklibur_all = $jam_libur_all * 3600;
                                        $ttllbur_all = $detiklibur_all;
                                        $totallibur_all = $totallibur_all + $ttllbur_all;
                                    } else {
                                        //-- Jika normal ------------------------------------------- --                                     

                                        $timestamp1 = strtotime($tanggal3);
                                        $dayOfWeek = date('N', $timestamp1);
                                        if ($dayOfWeek == 5) {
                                            $beban = $data['jam_kerja']->jam_kerja_jumat;
                                            $istirahat = $data['jam_kerja']->jam_istirahat_jumat;
                                        } else {
                                            $beban = $data['jam_kerja']->jam_kerja;
                                            $istirahat = $data['jam_kerja']->jam_istirahat;
                                        }

                                        $istirahatDetik = $istirahat * 3600;

                                        echo "<td  class='text-center'>" . $field2->status_masuk . "</td>";
                                        if (($field2->status_masuk == 'Izin') or ($field2->status_masuk == 'Cuti') or ($field2->status_masuk == 'TL') or ($field2->status_masuk == 'Sakit') or ($field2->status_masuk == 'Libur')) {
                                            echo "<td colspan='8'> - </td>";

                                            $jam_libur = $data['jam_kerja']->jam_kerja;

                                            $detiklibur = $jam_libur * 3600;
                                            $ttllbur = $detiklibur;
                                            $totallibur = $totallibur + $ttllbur;
                                        } else {
                                            echo "<td class='text-center'>" . $field2->jam_masuk . "</td>";
                                            echo "<td class='text-center'>" . $field2->from_masuk . "</td>";
                                            echo "<td class='text-center'>" . $field2->jam_pulang . "</td>";
                                            echo "<td class='text-center'>" . $field2->from_pulang . "</td>";
                                            echo "<td class='text-center'>" . $istirahat . " Jam </td>";
                                            echo "<td class='text-center'>" . $beban . " Jam </td>";

                                            $waktu_awal = strtotime($field2->jam_masuk);
                                            $waktu_akhir = strtotime($field2->jam_pulang);
                                            $diff   = $waktu_akhir - $waktu_awal;
                                            // Kurangi waktu istirahat
                                            $diff -= $istirahatDetik;

                                            if ($diff < 0) {
                                                $diff = 0;
                                            } else {
                                                $diff = $diff;
                                            }

                                            $jam    = floor($diff / (60 * 60));
                                            $menit  = $diff - $jam * (60 * 60);
                                            if ($diff < 0) {
                                                echo "<td class='text-center'>0</td>";
                                            } else {
                                                echo "<td class='text-center'->" . $jam .  '.' . floor($menit / 60) . " jam</td>";
                                            }
                                            $total = $total + $diff;
                                        }
                                    }
                                }
                            else : {
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                }
                            endif;
                            ?>
                        </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>

        <?php
        $jam_k_normal = $data['jam_kerja']->jam_kerja * hari_normal($month, $year);
        $jam_k_jumat = $data['jam_kerja']->jam_kerja_jumat * hari_jumat($month, $year);
        $ttl_jam_kerja = $jam_k_normal + $jam_k_jumat;

        //Total Jam kerja sebulan
        $detikkerja = $ttl_jam_kerja * 3600;
        $jamkerja = floor($detikkerja / (60 * 60));
        $menitkerja = ($detikkerja - $jamkerja * (60 * 60)) / 60;

        //Total jam Kerja sebulan
        $detik1  = $total;
        $jam1    = floor($total / (60 * 60));
        $menit1  = ($total - $jam1 * (60 * 60)) / 60;

        //Jam Izin atau Sakit atau Cuti atau Libur
        $ttllibur = $totallibur + $totallibur_all;
        $jamlbr    = floor($ttllibur / (60 * 60));
        $menitlbr  = ($ttllibur - $jamlbr * (60 * 60)) / 60;

        //Total jam kerja anda sebulan
        $total_jam_sebulan = $jam1 + $jamlbr;
        $total_jam_sebulan += $menit1 / 60;
        $total_jam_sebulan += $menitlbr / 60;
        $jam_total = floor($total_jam_sebulan);
        $menit_total = ($total_jam_sebulan - $jam_total) * 60;

        //Kurang jam 
        $detik2 = $detikkerja - ($detik1 + $ttllibur);
        $jamkurang = floor($detik2 / (60 * 60));
        $menitkurang  = ($detik2 - $jamkurang * (60 * 60)) / 60;
        ?>


        <style>
            .tabelbawah {
                font-family: Trebuchet MS;
                font-weight: Bold;
                font-size: 12px;
            }
        </style>

        <span class="tabelbawah"><u>Keterangan :</u></span>
        <p>
        <table>
            <tr>
                <td class="tabelbawah">Total Jam Kerja Perbulan</td>
                <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
                <td class="tabelbawah"><?= $jamkerja ?> Jam, <?= floor($menitkerja) ?> Menit</td>
            </tr>
            <tr>
                <td class="tabelbawah">Jam Kerja Anda</td>
                <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
                <td class="tabelbawah"><?= $jam1 ?> jam, <?= floor($menit1) ?> Menit</td>
            </tr>
            <tr>
                <td class="tabelbawah">Jam Libur/Izin/Sakit/Cuti/TL</td>
                <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
                <td class="tabelbawah"><?= $jamlbr ?> jam, <?= floor($menitlbr) ?> Menit</td>
            </tr>
            <tr>
                <td class="tabelbawah">Total Jam Kerja Bulan ini </td>
                <td class="tabelbawah" style="width:20px; text-align:center;">:</td>
                <td class="tabelbawah" style="font-weight:bold; color:red">
                    <?= $jam_total ?> jam, <?= floor($menit_total) ?> Menit
                </td>
            </tr>
            <tr>
                <td colspan="3">-----------------------------------------------------------</td>
            </tr>
            <tr>
                <td class="tabelbawah">Kekurangan Jam Kerja Anda</td>
                <td class="tabelbawah" style="width:20px; text-align:center;">:</td>

                <?php
                if ($jamkurang < 0)
                    $jamkurangnya = '+' . abs($jamkurang);
                else
                    $jamkurangnya = $jamkurang;
                ?>

                <?php if ($jamkurang < 0) { ?>
                    <td class="tabelbawah">Tidak ada</td>
                <?php } else { ?>
                    <td class="tabelbawah"><?= $jamkurangnya ?> jam, <?= floor($menitkurang) ?> Menit</td>
                <?php } ?>
            </tr>
            <tr>
                <td colspan="3">-----------------------------------------------------------</td>
            </tr>

        </table>
    </div>
</div>