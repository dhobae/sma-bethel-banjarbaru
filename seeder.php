<?php

$host = 'localhost';
$dbname = 'smabethel';
$user = 'root';
$pass = '';

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $pass
);

$pegawai = $pdo->query("
    SELECT nik
    FROM pegawai
    WHERE absen = 'Aktif'
")->fetchAll(PDO::FETCH_ASSOC);

// $awal = new DateTime('2026-05-01');
// $akhir = new DateTime('2026-05-31');

$awal = new DateTime('2026-06-01');
$akhir = new DateTime('2026-06-10');

$lokasi = '-3.434881956908593, 114.83546697903968';

// Tanggal yang dikecualikan (tidak ada absensi)
// $tanggalDikecualikan = [1, 14, 15, 27, 28, 31];
$tanggalDikecualikan = [1];

$total = 0;

for ($tanggal = clone $awal; $tanggal <= $akhir; $tanggal->modify('+1 day')) {

    $tgl = $tanggal->format('Y-m-d');
    $hari = (int)$tanggal->format('w'); // 0=Minggu, 6=Sabtu
    $tglBulan = (int)$tanggal->format('d'); // Tanggal dalam bulan (1-31)
    
    // Skip Sabtu (6) dan Minggu (0)
    if ($hari === 0 || $hari === 6) {
        continue;
    }
    
    // Skip tanggal yang dikecualikan
    if (in_array($tglBulan, $tanggalDikecualikan)) {
        continue;
    }

    foreach ($pegawai as $p) {

        $stmt = $pdo->prepare("
            SELECT id
            FROM absen
            WHERE nik = ?
            AND tanggal = ?
            LIMIT 1
        ");

        $stmt->execute([$p['nik'], $tgl]);

        if (!$stmt->fetch()) {

            $jamMasuk = sprintf(
                '08:%02d:%02d',
                rand(0, 50),
                rand(0, 59)
            );

            if (rand(0, 1)) {
                $jamPulang = sprintf(
                    '14:%02d:%02d',
                    rand(50, 59),
                    rand(0, 59)
                );
            } else {
                $jamPulang = sprintf(
                    '15:%02d:%02d',
                    rand(0, 30),
                    rand(0, 59)
                );
            }

            $insert = $pdo->prepare("
                INSERT INTO absen (
                    nik,
                    tanggal,
                    jam_masuk,
                    status_masuk,
                    from_masuk,
                    jam_pulang,
                    status_pulang,
                    from_pulang,
                    keterangan,
                    loc_masuk,
                    loc_pulang,
                    created_at,
                    updated_at
                )
                VALUES (
                    ?, ?, ?, 'Hadir', 'WFO',
                    ?, 'Pulang', 'WFO',
                    '-', ?, ?,
                    NOW(), NOW()
                )
            ");

            $insert->execute([
                $p['nik'],
                $tgl,
                $jamMasuk,
                $jamPulang,
                $lokasi,
                $lokasi
            ]);

            $total++;
            echo "Insert {$p['nik']} {$tgl} - Lokasi: {$lokasi}\n";
        }
    }
}

echo "\nSelesai. Total insert: {$total}\n";