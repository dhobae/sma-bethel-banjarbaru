<?php
$year = $data['tahun'];
$month = $data['bulan'];
$nik = $data['nik'];
?>

<div class="card" style="margin-top: 10px;">
    <div class="card-header" style="padding:7px 10px; background:orange">
        <b>Rekap data</b>
    </div>
    <div class="card-body">
        <div class="huruf1 mb-2">
            <label for="date1"><b>Pilih Bulan dan Tahun : </b>&nbsp;</label>
            <select class="" name="bulan" id="bulan" style="height:23px;" onchange="submitForm()">
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
            <select class="" name="tahun" id="tahun" style="height:23px;" onchange="submitForm()">
                <option value="2024" <?= ($year == '2024') ? 'selected' : '' ?>>2024</option>
                <option value="2025" <?= ($year == '2025') ? 'selected' : '' ?>>2025</option>
                <option value="2026" <?= ($year == '2026') ? 'selected' : '' ?>>2026</option>
            </select>
            &nbsp;
        </div>

        <input type="hidden" name="nik" id="nik" value="<?= $nik ?>">

        <div class="row">
            <div class="col-lg-3">
                <table class="tabeltiga table-bordered">
                    <thead style="background-color:brown; color:white">
                        <tr style="height:40px">
                            <th colspan="2">Pilih Karyawan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['pegawai'] as $d) :
                            if ($d->nik == $nik) {
                                $warna_back = 'red';
                                $warna_text = 'white !important';
                            } else {
                                $warna_back = 'none';
                                $warna_text = 'darkgreen';
                            }
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td style="background : <?= $warna_back ?>">
                                    <button type="button" onclick="submitFormWithNik('<?= $d->nik ?>')" class="namapilih" title="Klik nama" style="color:<?= $warna_text ?>">
                                        <?= $d->nama ?>
                                    </button>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        endforeach;
                        ?>
                </table>
            </div>
            </tbody>

            <div class="col-lg-9">
                <table class="tabeltiga table-bordered">
                    <thead style="background-color:brown; color:white">
                        <tr style="height:40px">
                            <th style="width: 40px;">No</th>
                            <th style="width: 80px;">Hari</th>
                            <th style="width: 120px">Tanggal</th>
                            <th>Uraian aktivitas hari ini</th>
                    </thead>
                    <tbody>
                        <?php
                        $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $days = ["Sunday" => "Minggu", "Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis", "Friday" => "Jum'at", "Saturday" => "Sabtu"];
                        $months = ["January" => "Januari", "February" => "Februari", "March" => "Maret", "April" => "April", "May" => "Mei", "June" => "Juni", "July" => "Juli", "August" => "Agustus", "September" => "September", "October" => "Oktober", "November" => "November", "December" => "Desember"];

                        for ($x = 1; $x <= $number_of_days; $x++) {
                            $dateStr = "$x-$month-$year";
                            $hari = $days[date("l", strtotime($dateStr))];
                            $bulan = $months[date("F", strtotime($dateStr))];
                            $tanggal3 = date("Y-m-d", strtotime($dateStr)); ?>
                            <tr>
                                <td class="tengah"> <?= $x ?> </td>
                                <td class="tengah"> <?= $hari ?> </td>
                                <?php if (($hari == "Sabtu") || ($hari == "Minggu")) { ?>
                                    <td class='tengah'><?= date3ID($tanggal3) ?></td>
                                    <td style='background:#c5c5c5'>Libur Akhir Pekan </td>
                                <?php } else { ?>
                                    <td class="tengah"> <?= date3ID($tanggal3) ?></td>
                                    <?php
                                    $ambil = $this->Mdar->dar_pertanggal_karyawan($tanggal3, $nik);
                                    ?>
                                    <td>
                                        <?php
                                        if ($ambil) { ?>
                                            <?= $ambil->isi_dar ?>
                                        <?php }  ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        var tahun = document.getElementById('tahun').value;
        var bulan = document.getElementById('bulan').value;
        var nik = document.getElementById('nik').value;
        window.location.href = '<?= URLROOT ?>/dar/admin?bulan=' + bulan + '&tahun=' + tahun + '&nik=' + nik;
    }

    function submitFormWithNik(nik) {
        var tahun = document.getElementById('tahun').value;
        var bulan = document.getElementById('bulan').value;
        window.location.href = '<?= URLROOT ?>/dar/admin?bulan=' + bulan + '&tahun=' + tahun + '&nik=' + nik;
    }
</script>

<style>
    .namapilih {
        background: none;
        border: none;
        color: darkgreen;
        cursor: pointer;
        text-align: left;
        font-weight: bold;
    }

    .namapilih:hover {
        color: red;
    }
</style>