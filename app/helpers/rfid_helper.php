<?php

function validasi_waktu_rfid($jamMasuk, $jamPulang)
{
    // gunakan timestamp biar akurat
    $now = strtotime(date('H:i:s'));

    $jamMasukTs = strtotime($jamMasuk);
    $jamPulangTs = strtotime($jamPulang);

    $bukaMasuk  = strtotime($jamMasuk . ' -30 minutes'); // 07:00
    $tutupMasuk = strtotime($jamMasuk . ' +15 minutes'); // 07:45

    $bukaPulang  = strtotime($jamPulang . ' -15 minutes'); // 16:45
    $tutupPulang = strtotime($jamPulang . ' +1 hour');     // 17:45

    // ======================
    // ABSEN MASUK
    // ======================
    if ($now >= $bukaMasuk && $now <= $jamMasukTs) {

        return [
            'status' => 'hadir'
        ];

    } elseif ($now > $jamMasukTs && $now <= $tutupMasuk) {

        return [
            'status' => 'terlambat'
        ];

    }

    // ======================
    // ABSEN PULANG
    // ======================
    elseif ($now >= $bukaPulang && $now <= $tutupPulang) {

        return [
            'status' => 'pulang'
        ];

    }

    // ======================
    // DI LUAR JAM
    // ======================
    else {

        return [
            'status' => 'ditutup'
        ];
    }
}