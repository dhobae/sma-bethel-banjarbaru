<?php

function timeFilter($time)
{
  $timenew = strtotime($time);
  return date('H:i', $timenew);
}

function dateID($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  // variabel pecahkan 0 = tahun
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tanggal
  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function date2ID($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $notime = explode('T', $tanggal);
  $pecahkan = explode('-', $notime[0]);

  // variabel pecahkan 0 = tahun
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tanggal
  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function date3ID($tanggal)
{
  $bulan = array(
    1 =>   'Jan',
    'Feb',
    'Mar',
    'Apr',
    'Mei',
    'Jun',
    'Jul',
    'Agt',
    'Sep',
    'Okt',
    'Nov',
    'Des'
  );
  $notime = explode('T', $tanggal);
  $pecahkan = explode('-', $notime[0]);

  // variabel pecahkan 0 = tahun
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tanggal
  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function date4ID($tanggal)
{
  $bulan = array(
    1 =>   'Jan',
    'Feb',
    'Mar',
    'Apr',
    'Mei',
    'Jun',
    'Jul',
    'Agt',
    'Sep',
    'Okt',
    'Nov',
    'Des'
  );
  $notime = explode('T', $tanggal);
  $pecahkan = explode('-', $notime[0]);

  // variabel pecahkan 0 = tahun
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tanggal
  return $pecahkan[2] . '-' . $bulan[(int)$pecahkan[1]] . '-' . $pecahkan[0];
}

function date5ID($tanggal)
{
  $bulan = array(
    1 =>   '01',
    '02',
    '03',
    '04',
    '05',
    '06',
    '07',
    '08',
    '09',
    '10',
    '11',
    '12'
  );
  $notime = explode('T', $tanggal);
  $pecahkan = explode('-', $notime[0]);

  // variabel pecahkan 0 = tahun
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tanggal
  return $pecahkan[2] . '-' . $bulan[(int)$pecahkan[1]] . '-' . $pecahkan[0];
}

function timeID($time)
{
  $timenew = strtotime($time);
  $waktu = date('H:i A', $timenew);
  $pecah = explode(' ', $waktu);
  if ($pecah[1] == 'AM') {
    $pecah[1] = 'Pagi';
  } else {
    $waktubaru = explode(':', $pecah[0]);
    $waktubaru[0] = $waktubaru[0] - 12;
    if ($waktubaru[0] > 3) {
      $pecah[1] = 'Sore';
    } else if ($waktubaru[0] > 6) {
      $pecah[1] = 'Malam';
    } else {
      $pecah[1] = 'Siang';
    }
    $pecah[0] = implode(':', $waktubaru);
  }
  $res = implode(' ', $pecah);
  return $res;
}

function dayID($tanggal)
{
  $day = date('D', strtotime($tanggal));
  $dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
  );
  return $dayList[$day];
}

function dateDiff($date1, $date2)
{
  $date1_ts = strtotime($date1);
  $date2_ts = strtotime($date2);
  $diff = $date2_ts - $date1_ts;
  return round($diff / 86400);
}



