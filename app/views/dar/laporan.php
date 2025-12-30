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

<div class="card" style="margin-top: 10px; background-color:aliceblue">
    <div class="card-header" style="padding:7px 10px; background:orange">
        <b>Daily Activity Report &nbsp; : &nbsp; <?= $_SESSION['nama'] ?> </b>
    </div>

    <div class="card-body">
        <div class="tengah mb-2">
            <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="120px"> <br />
        </div>
        <div class="tengah judul1">
            <b>SMA Bethel Banjarbaru<br />Daily Activity Report (DAR)</b>
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
            <table class="tabeltiga table-bordered">
                <thead style="background-color:brown; color:white">
                    <tr style="height:40px">
                        <th style="width: 45px;">No</th>
                        <th style="width: 90px;">Hari</th>
                        <th>Tanggal</th>
                        <th>Uraian aktivitas hari ini</th>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $totallibur = 0;
                    $ttllbur = 0;
                    $totallibur_all = 0;

                    $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $days = ["Sunday" => "Minggu", "Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis", "Friday" => "Jum'at", "Saturday" => "Sabtu"];
                    $months = ["January" => "Januari", "February" => "Februari", "March" => "Maret", "April" => "April", "May" => "Mei", "June" => "Juni", "July" => "Juli", "August" => "Agustus", "September" => "September", "October" => "Oktober", "November" => "November", "December" => "Desember"];

                    for ($x = 1; $x <= $number_of_days; $x++) {
                        $dateStr = "$x-$month-$year";
                        $hari = $days[date("l", strtotime($dateStr))];
                        $bulan = $months[date("F", strtotime($dateStr))];
                        $tanggal3 = date("Y-m-d", strtotime($dateStr)); ?>
                        <tr>
                            <td style="width: 50px;" class="tengah"> <?= $x ?> </td>
                            <td style="width: 80px;" class="tengah"> <?= $hari ?> </td>
                            <?php if (($hari == "Sabtu") || ($hari == "Minggu")) { ?>
                                <td class='tengah'><?= tanggal_indo($tanggal3) ?></td>
                                <td style='background:#c5c5c5'>Libur Akhir Pekan </td>
                            <?php } else { ?>
                                <td style="width: 160px;" class="tengah"> <?= tanggal_indo($tanggal3) ?></td>
                                <?php
                                $ambil = $this->Mdar->dar_pertanggal_saya($tanggal3);
                                ?>
                                <td style="padding:0px; margin:0px">

                                    <?php
                                    $tanggal_hari_ini = date("Y-m-d");
                                    $tanggal_kemarin = date("Y-m-d", strtotime("-1 day", strtotime($tanggal_hari_ini)));

                                    if ($ambil) { ?>
                                        <input type="hidden" name="nik[]" value="<?= $_SESSION['nik'] ?>">
                                        <input type="hidden" name="tanggal[]" value="<?= $tanggal3 ?>">
                                        <input type="text" class="dar" value="<?= $ambil->isi_dar ?>" id="edit_isi_<?= $x ?>" <?php if ($tanggal3 != $tanggal_hari_ini && $tanggal3 != $tanggal_kemarin) echo 'disabled'; ?>>
                                    <?php } else { ?>
                                        <input type="hidden" name="nik[]" value="<?= $_SESSION['nik'] ?>">
                                        <input type="hidden" name="tanggal[]" value="<?= $tanggal3 ?>">
                                        <input type="text" class="dar" id="tambah_isi_<?= $x ?>" <?php if ($tanggal3 != $tanggal_hari_ini && $tanggal3 != $tanggal_kemarin) echo 'disabled'; ?>>
                                    <?php } ?>


                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<style>
    .dar {
        width: 100%;
        padding: 0px;
        margin: 0px;
        border: 0px;
        padding-left: 8px;
    }
</style>
<script>
    $(document).ready(function() {
        $('.dar').on('input', function() {
            var dataField = $(this).val();
            var nik = $(this).closest('tr').find('input[name="nik[]"]').val();
            var tanggal = $(this).closest('tr').find('input[name="tanggal[]"]').val();
            console.log(nik);
            $.ajax({
                url: '<?= URLROOT ?>/dar/simpan_isi',
                type: 'POST',
                data: {
                    dataField: dataField,
                    nik: nik,
                    tanggal: tanggal
                },
                success: function(response) {
                    console.log('Data tersimpan:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>