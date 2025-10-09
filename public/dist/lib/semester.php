<?php
if (!function_exists('semester_'))   {
function semester_($nim)
{
    $nim = $nim;
    $angkatan = "20".substr($nim, 4, 2);
    $prodi = substr($nim, 6, 2);
    $tahun = date("Y");

    $bulan = date('n');
    if($bulan<=7){
        $smt = 2;
    }else{
        $smt = 1;
    }
    $semester = $tahun."".$smt;
    $angkatan = $angkatan;

    if ($semester %2 != 0){
        $a = (($semester + 10)-1)/10;
        $b = $a - $angkatan;
        $c = ($b*2)-1;
    }else{
        $a = (($semester + 10)-2)/10;
        $b = $a - $angkatan;
        $c = ($b * 2) - 2;
    }
    return $c;
}
}

if (!function_exists('prodi_'))   {
function prodi_($nim)
{
    $nim = $nim;
    $prodi = substr($nim, 6 , 2);
    if ($prodi == '01') {
        $prodi = 'Sistem Informasi';
    } else {
        $prodi = 'Teknik Informatika';
    }
    return $prodi;
}
}

if (!function_exists('angkatan_'))   {
function angkatan_($nim)
{
    $nim = $nim;
    $angkatan = substr($nim, 4 , 2);
    $angkatan = "20".$angkatan;
    return $angkatan;
}
}

if (!function_exists('ganjilgenap'))   {
    function ganjilgenap($nim)
{
    $nim = $nim;
    $angkatan = "20".substr($nim, 4, 2);
    $prodi = substr($nim, 6, 2);
    $tahun = date("Y");

    $bulan = date('n');
    if($bulan<=7){
        $smt = 2;
    }else{
        $smt = 3;
    }
    $semester = $tahun."".$smt;
    $angkatan = $angkatan;

    if ($semester %2 != 0){
        $a = 'Ganjil';
    }else{
        $a = 'Genap';
    }
    return $a;
}
}


if (!function_exists('nilai_'))   {
    function nilai_($nilai,$sks)
{
    $nilai = $nilai;
    $sks = $sks;
    if ($nilai == 'A')
        {
            $a = $sks * 4;
        }    
    else if ($nilai == 'A-')
        {
            $a = $sks * 3.75;
        }    
    else if ($nilai == 'B+')
        {
            $a = $sks * 3.5;
        }        
    else if ($nilai == 'C+')
        {
            $a = $sks * 2.5;
        }        
    else if ($nilai == 'AB')
        {
            $a = $sks * 3.5;
        }
    else if ($nilai == 'B')
        {
            $a = $sks * 3;
        }    
    else if ($nilai == 'BC')
        {
            $a = $sks * 2.5;
        }    
    else if ($nilai == 'C')
        {
            $a = $sks * 2;
        }    
    else if ($nilai == 'D')
        {
            $a = $sks * 1;
        }    
    else if ($nilai == 'E')
        {
            $a = $sks * 0;
        }    
    else
        {
            $a = 0;
        }    
    return $a;
}
}




?>