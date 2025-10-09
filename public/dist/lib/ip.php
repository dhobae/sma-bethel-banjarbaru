<?php

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP tidak dikenali';
    return $ipaddress;
}

function ip_in_range2($ip, $range)
{
    if (strpos($range, '/') == false) {
        $range .= '/32';
    }
    // $range is in IP/CIDR format eg 127.0.0.1/24
    list($range, $netmask) = explode('/', $range, 2);
    $range_decimal = ip2long($range);
    $ip_decimal = ip2long($ip);
    $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
    $netmask_decimal = ~$wildcard_decimal;
    return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
}


function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(1 =>    'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $bulan = array(1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $split       = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}


?>

<script type="text/javascript">
    <!--
    function showTime() {
        var a_p = "";
        var today = new Date();
        var curr_hour = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();
        curr_minute = checkTime(curr_minute);
        curr_second = checkTime(curr_second);
        document.getElementById('clock').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    setInterval(showTime, 500);
    //
    -->
</script>





<?php
$hari = date('l');
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

$tgl = date('d');
$bulan = date('F');
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
$tahun = date('Y');
?>