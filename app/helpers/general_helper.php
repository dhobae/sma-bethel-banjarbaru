<?php

function rupiah($price)
{
  $res = "Rp. " . number_format($price, 0, ",", ".");
  return $res;
}

function rupiah2($price)
{
  $res = number_format($price, 0, ",", ".");
  return $res;
}

function notifWA($data)
{
  $apikey = API_WA;
  $tujuan = $data['no_telp'];
  $pesan = $data['isi_pesan'];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://starsender.online/api/sendText?message=' . rawurlencode($pesan) . '&tujuan=' . rawurlencode($tujuan . '@s.whatsapp.net'),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
      'apikey: ' . $apikey
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  if ($response) {
    return true;
  } else {
    return false;
  }
}

function qrcode($size, $content)
{
  // CHart Type
  $cht = "qr";

  // CHart Size
  $chs = $size . "x" . $size;

  // CHart Link
  // the url-encoded string you want to change into a QR code
  $chl = urlencode($content);

  // CHart Output Encoding (optional)
  // default: UTF-8
  $choe = "UTF-8";

  $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;

  return $qrcode;
}




function penyebut($nilai)
{
  $nilai = abs($nilai);
  $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($nilai < 12) {
    $temp = " " . $huruf[$nilai];
  } else if ($nilai < 20) {
    $temp = penyebut($nilai - 10) . " belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
  }
  return $temp;
}

function terbilang($nilai)
{
  if ($nilai == 0) {
    $hasil = 'nol';
  } else if ($nilai < 0) {
    $hasil = "minus " . trim(penyebut($nilai));
  } else {
    $hasil = trim(penyebut($nilai));
  }
  return $hasil;
}



function encrypt($string)
{
  $output = false;
  $security       = parse_ini_file("security.ini");
  $secret_key     = $security["encryption_key"];
  $secret_iv      = $security["iv"];
  $encrypt_method = $security["encryption_mechanism"];
  $key    = hash("sha256", $secret_key);
  $iv     = substr(hash("sha256", $secret_iv), 0, 16);
  $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
  $output = base64_encode($result);
  return $output;
}
function decrypt($string)
{
  $output = false;
  $security       = parse_ini_file("security.ini");
  $secret_key     = $security["encryption_key"];
  $secret_iv      = $security["iv"];
  $encrypt_method = $security["encryption_mechanism"];
  $key    = hash("sha256", $secret_key);
  $iv = substr(hash("sha256", $secret_iv), 0, 16);
  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  return $output;
}


function hari_jumat($month, $year)
{
  $totalDays = date('t', mktime(0, 0, 0, $month, 1, $year));
  $fridayCount = 0;

  for ($day = 1; $day <= $totalDays; $day++) {
    if (date('N', mktime(0, 0, 0, $month, $day, $year)) == 5) {
      $fridayCount++;
    }
  }
  return $fridayCount;
}

function hari_sabtu($month, $year)
{
  $totalDays = date('t', mktime(0, 0, 0, $month, 1, $year));
  $fridayCount = 0;

  for ($day = 1; $day <= $totalDays; $day++) {
    if (date('N', mktime(0, 0, 0, $month, $day, $year)) == 6) {
      $fridayCount++;
    }
  }
  return $fridayCount;
}

function hari_minggu($month, $year)
{
  $totalDays = date('t', mktime(0, 0, 0, $month, 1, $year));
  $fridayCount = 0;

  for ($day = 1; $day <= $totalDays; $day++) {
    if (date('N', mktime(0, 0, 0, $month, $day, $year)) == 6) {
      $fridayCount++;
    }
  }
  return $fridayCount;
}

function hari_normal($month, $year)
{
  $totalDays = date('t', mktime(0, 0, 0, $month, 1, $year));
  $weekdayCount = 0;

  for ($day = 1; $day <= $totalDays; $day++) {
    $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
    if ($dayOfWeek != 5 && $dayOfWeek != 6 && $dayOfWeek != 7) {
      $weekdayCount++;
    }
  }

  return $weekdayCount;
}

function semua_hari($month, $year)
{
  return date('t', mktime(0, 0, 0, $month, 1, $year));
}
