<?php

function validasi_waktu_rfid($jamMasuk, $jamPulang)
{
    $now = date('H:i:s');

    $bukaMasuk  = date('H:i:s', strtotime($jamMasuk . ' -30 minutes'));
    $tutupMasuk = date('H:i:s', strtotime($jamMasuk . ' +15 minutes'));

    $bukaPulang  = date('H:i:s', strtotime($jamPulang . ' -15 minutes'));
    $tutupPulang = date('H:i:s', strtotime($jamPulang . ' +1 hour'));

    if ($now >= $bukaMasuk && $now <= $jamMasuk) {

        return [
            'status' => 'hadir',
            // 'keterangan' => 'Absen masuk tepat waktu'
        ];

    } elseif ($now > $jamMasuk && $now <= $tutupMasuk) {

        return [
            'status' => 'terlambat',
            // 'keterangan' => 'Absen masuk terlambat'
        ];

    } elseif ($now >= $bukaPulang && $now <= $tutupPulang) {

        return [
            'status' => 'pulang',
            // 'keterangan' => 'Absen pulang berhasil'
        ];

    } else {

        return [
            'status' => 'ditutup',
            // 'keterangan' => 'Presensi tidak dapat dilakukan di luar jam kerja'
        ];
    }
}