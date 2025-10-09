<?php
require APPROOT . '../../public/dist/lib/ip.php';
?>

<?php
$tanggal2 = $data['tanggal'];

if ($tanggal2 > date('Y-m-d')) {
    echo '<script>';
    echo 'Swal.fire({
        title: "Tanggal dipilih salah",
        text: "Anda memilih tanggal melebihi tanggal hari ini.",
        icon: "warning",
        confirmButtonText: "OK"
    }).then(function() {
        window.location.href = "absen";
    })';
    echo '</script>';
    $tanggal2 = date('Y-m-d');
}
?>

<div class="card card-primary card-outline" style="margin-top:10px;">
    <div class="card-header bg-primary" style="height:35px; padding:5px 10px;">
        <b>Presensi Harian</b>
    </div>
    <div class="card-body box-profile">


        <div class="huruf1 tengah mb-1 mt-2" style="font-size:20px; font-weight:bold; margin-top:-6px">
            Daftar Absen Hari ini : <?php echo tanggal_indo($tanggal2); ?>
        </div>


        <div class="mb-1 mt-3" style="font-family:Trebuchet MS; font-size: 14px; font-weight:bold">
            <label for="date1"><b>Pilih Tanggal : </b>&nbsp;</label>
            <input type="date" id="tanggal" style="height: 25px;" onchange="submitForm()" value="<?= $tanggal2 ?>">
        </div>





        <table class="table tabel3 table-striped">
            <thead style="background-color: brown; color:white">
                <tr>
                    <th style="width: 40px;" rowspan='2'>No</th>
                    <th rowspan='2'>Nama Dosen / Karyawan</th>
                    <th colspan="3">Presensi Datang</th>
                    <th colspan="3">Presensi Pulang</th>
                </tr>
                <tr>
                    <th style="width:70px">Datang</th>
                    <th style="width:21%">ID Device</th>
                    <th>Status</th>
                    <th style="width:70px">Pulang</th>
                    <th style="width:21%">ID Device</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $no = 1;
                if ($data['device']) :
                    // Ambil semua visitid hari ini untuk perbandingan
                    $today_tanggal = $this->Mpresensi->today_by_tanggal($tanggal2);
                    $visitid_list = [];
                    $visitid_pulang_list = [];

                    foreach ($data['device'] as $field) {
                        $niknya = $field->nik;
                        $today_nik = $this->Mpresensi->today_by_nik($niknya, $tanggal2);

                        // Kumpulkan visitid untuk pengecekan
                        if ($today_nik) {
                            foreach ($today_nik as $field2) {
                                $visitid_list[] = trim(strtolower($field2->visitid));
                                $visitid_pulang_list[] = trim(strtolower($field2->visitid_pulang));
                            }
                        }
                    }

                    // Hitung jumlah kemunculan visitid dan visitid_pulang
                    $visitid_count = array_count_values($visitid_list);
                    $visitid_pulang_count = array_count_values($visitid_pulang_list);

                    foreach ($data['device'] as $field) :
                        $niknya = $field->nik;
                ?>
                        <tr>
                            <td style='text-align:center;'><?= $no ?></td>
                            <td><?= $field->nama ?></td>
                            <?php
                            $today_nik = $this->Mpresensi->today_by_nik($niknya, $tanggal2);

                            if ($today_tanggal) :
                                foreach ($today_tanggal as $field3) {
                                    echo "<td colspan=6 class='text-center'>" . $field3->kenapa . "</td>";
                                }
                            else :
                                if ($today_nik) :
                                    foreach ($today_nik as $field2) {
                                        $visitid = trim(strtolower($field2->visitid));
                                        $visitid_pulang = trim(strtolower($field2->visitid_pulang));

                                        $status_masuk = (!empty($visitid) && isset($visitid_count[$visitid]) && $visitid_count[$visitid] > 1) ? "Sama" : "-";
                                        $status_pulang = (!empty($visitid_pulang) && isset($visitid_pulang_count[$visitid_pulang]) && $visitid_pulang_count[$visitid_pulang] > 1) ? "Sama" : "-";
                            ?>
                                        <td class='text-center'><?= $field2->jam_masuk ?></td>
                                        <td><?= $field2->visitid ?></td>
                                        <td><?= $status_masuk ?></td>
                                        <td class='text-center'><?= $field2->jam_pulang ?></td>
                                        <td><?= $field2->visitid_pulang ?></td>
                                        <td><?= $status_pulang ?></td>
                            <?php }
                                else :
                                    echo "<td class='text-center'>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td class='text-center'>-</td>";
                                    echo "<td>-</td>";
                                    echo "<td>-</td>";
                                endif;
                            endif;
                            ?>
                        </tr>
                    <?php
                        $no++;
                    endforeach;
                else :
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data tidak ditemukan
                        </td>
                    </tr>
                <?php
                endif;
                ?>
            </tbody>
        </table>











    </div>
</div>


<script>
    function submitForm() {
        var tanggal = document.getElementById('tanggal').value;
        window.location.href = '<?= URLROOT ?>/presensi/device?tanggal=' + tanggal;
    }
</script>


<script>
    function showLoc(loc) {
        window.open("<?php echo URLROOT; ?>/presensi/showloc?data=" + loc, "_blank", "toolbar=no,scrollbars=yes,resizable=yes,'',left=500,width=400,height=400");
    }
</script>