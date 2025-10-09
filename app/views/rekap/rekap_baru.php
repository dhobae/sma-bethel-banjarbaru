<?php
require APPROOT . '../../public/dist/lib/ip.php';
$bulanindo = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
?>

<div class="card card-primary card-outline" style="margin-top:10px; background:aliceblue">
    <div class="card-body box-profile">
        <?php
        if ($_SESSION['role'] == 'admin') {
            echo "<div style='margin-top:-15px'>";
            echo "<a href='" . $_url . "presensi/today' class='myButton11'> Kembali </a> ";
            echo "</div>";
        }
        ?>

        <div class="text-center mb-1">
            <img src="<?= URLROOT ?>/skatel/img/ts.png" width="160px"> <br />
        </div>

        <div class="text-center huruf1 mb-3" style="font-size:20px; font-weight:bold; line-height:25px">
            SMK Telkom Banjarbaru <br />
            Presensi :
            <?php
            if ($_SESSION['role'] == 'pegawai') {
                echo $_SESSION['nama'];
            } else {
                echo $data['rekap']->nama;
            } ?>
            <br />
            [<?= $bulanindo[$month = date('m')] . "-" . $year = date('Y') ?>]
        </div>

        <div class="table-responsive">
            <table class="table tabel4 table-striped">
                <thead style="background-color:brown !important; color:white">
                    <tr>
                        <th style="width: 45px;" rowspan=2>No</th>
                        <th style="width: 100px;" rowspan=2>Hari</th>
                        <th rowspan=2>Tanggal</th>
                        <th style="width: 8%;" rowspan=2>Presensi</th>
                        <th style="width: 8%;" rowspan=2>Status</th>
                        <th colspan=2>Presensi Masuk</th>
                        <th colspan=2>Presensi Pulang</th>
                        <th rowspan=2 style="width: 8%;">Jam<br />Istirahat</th>
                        <th rowspan=2 style="width: 8%;">Beban<br /><small>Perhari</small></th>
                        <th rowspan=2 style="width: 8%;">Total Jam<br />hari ini</th>
                        <th rowspan=2 style="width: 80px;">Aksi</th>
                    </tr>
                    <tr>
                        <th style="width: 8%;">Jam</th>
                        <th style="width: 6%;">Status</th>
                        <th style="width: 8%;">Jam</th>
                        <th style="width: 6%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $year = date('Y'); //Mengambil tahun saat ini
                    $month = date('m'); //Mengambil bulan saat ini
                    $total = 0;
                    $totallibur = 0;
                    $ttllbur = 0;
                    $totallibur_all = 0;
                    $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    for ($x = 1; $x <= $number_of_days; $x++) {
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
                            <td style="text-align:center;"> <?= $x ?> </td>
                            <td class="tengah"><?= $hari ?></td>

                            <?php
                            //-- Jika sabtu dan minggu ---------------------------------------------------- --
                            if (($hari == "Sabtu") || ($hari == "Minggu")) {
                                echo "<td class='tengah'>" . tanggal_indo($tanggal3) . "</td>";
                                echo "<td style='background:#bbbbbb '></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                                echo "<td style='background:#bbbbbb;'></td>";
                            } else {
                            ?>
                                <td class="no-wrap tengah"> <?= tanggal_indo($tanggal3) ?> </td>
                                <?php
                                $nik = $_SESSION['username'];
                                $rekap_byid_tanggal = $this->Mrekap->rekap_byid_tanggal($nik, $tanggal3);

                                if ($rekap_byid_tanggal) :
                                    foreach ($rekap_byid_tanggal as $field2) {
                                        if ($field2->nik == "all") {
                                            //-- JIka hari libur ---------------------------------------------------------
                                            echo "<td colspan=10 style='text-align:center;background:#F7EE5A;'>" . $field2->keterangan_libur . "</td>";

                                            $jam_libur_all = $data['jam_kerja']->jam_kerja;

                                            $detiklibur_all = $jam_libur_all * 3600;
                                            $ttllbur_all = $detiklibur_all;
                                            $totallibur_all = $totallibur_all + $ttllbur_all;
                                        } else {
                                            //-- JIka izin dll ---------------------------------------------------------
                                            echo "<td class='text-center'>" . $field2->status_masuk . "</td>";
                                            if (($field2->status_masuk == 'Izin') or ($field2->status_masuk == 'Cuti') or ($field2->status_masuk == 'TL') or ($field2->status_masuk == 'Sakit') or ($field2->status_masuk == 'Libur')) {
                                                echo "<td colspan='9'>  </td>";

                                                $jam_libur = $data['jam_kerja']->jam_kerja;

                                                $detiklibur = $jam_libur * 3600;
                                                $ttllbur = $detiklibur;
                                                $totallibur = $totallibur + $ttllbur;
                                            } else {
                                                //-- Jika normal ------------------------------------------- --
                                                if ($field2->jam_masuk > '08:00:00') {
                                                    $statustelat = 'Telat';
                                                } else {
                                                    $statustelat = 'On Time';
                                                }

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

                                                echo "<td class='text-center'>" . $statustelat . "</td>";
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

                                                $jam    = floor($diff / 3600);
                                                $sisa_detik = $diff % 3600;
                                                $menit  = floor($sisa_detik / 60);
                                                $menit_format = sprintf('%02d', $menit);

                                                if ($diff < 0) {
                                                    echo "<td class='text-center'>0</td>";
                                                } else {
                                                    echo "<td class='text-center'->" . $jam .  ':' . $menit_format . " jam</td>";
                                                }
                                                $total = $total + $diff;
                                ?>
                                                <td>
                                                    <?php if ($tanggal3 === date("Y-m-d")) { ?>
                                                        <?php if ($field2->status_pulang != '-') { ?>
                                                            <a href="javascript:void(0)" onclick="deletePulang('<?= $field2->id_absen ?>')" class="btn btn-primary btn-sm tombol3" title="Reset absen hari ini"><i class="fa fa-edit"></i> &nbsp;Reset</a>
                                                        <?php } else { ?>
                                                            <a href="javascript:void(0)" onclick="deleteData('<?= $field2->id_absen ?>')" class="btn btn-success btn-sm tombol3" title="Reset absen hari ini"><i class="fa fa-edit"></i> &nbsp;Reset</a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                            <?php
                                            }
                                        }
                                    }
                                else : {
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                        echo "<td class='text-center'>-</td>";
                                    }
                                endif;
                            }
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

                <td class="tabelbawah"><?= $jamkurangnya ?> jam, <?= floor($menitkurang) ?> Menit</td>
            </tr>
            <tr>
                <td colspan="3">-----------------------------------------------------------</td>
            </tr>

        </table>

    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteData(id) {
        //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Reset sama dengan menghapus absen datang anda hari ini, dan anda harus melakukan presensi kembali",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ye, reset!",
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= URLROOT ?>/presensi/reset_absen?id=' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.message,
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    }
</script>

<script>
    function deletePulang(id) {
        //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Reset sama dengan menghapus absen pulang anda hari ini, dan anda harus melakukan presensi pulang kembali",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ye, reset!",
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= URLROOT ?>/presensi/reset_absen_pulang?id=' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Sukses!',
                                text: response.message,
                                icon: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });
    }
</script>