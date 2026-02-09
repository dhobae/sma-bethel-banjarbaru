<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #000000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
        }
        th {
            background-color: #E0E0E0;
            font-weight: bold;
            font-size: 12px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding: 10px;
        }
        .info {
            text-align: center;
            font-size: 12px;
            padding: 5px;
        }
        .header-table {
            border: none;
            margin-bottom: 20px;
        }
        .header-table td {
            border: none;
        }
        .mapel {
            font-weight: bold;
            font-size: 14px;
        }
        .guru {
            font-size: 10px;
            color: #FF4500;
        }
    </style>
</head>
<body>
    <!-- Header Info -->
    <table class="header-table">
        <tr>
            <td colspan="11" class="title">JADWAL PELAJARAN SMA BETHEL BANJARBARU</td>
        </tr>
        <tr>
            <td colspan="11" class="info">
                Tahun Ajaran: <?= $data['tahun_ajaran']->tahun_ajaran ?> | 
                Semester: <?= $data['jadwal_setting']->semester ?> | 
                Blok: <?= $data['jadwal_setting']->blok ?>
            </td>
        </tr>
        <tr>
            <td colspan="11" class="info">
                <strong>Kelas: <?= $data['kelas'] ?></strong>
            </td>
        </tr>
        <tr>
            <td colspan="11" class="info">
                <strong>Wali Kelas: 
                    <?php 
                    if (isset($data['wali_kelas']->nama)) {
                        echo $data['wali_kelas']->nama;
                    } else {
                        echo "~Belum dipilih~";
                    }
                    ?>
                </strong>
            </td>
        </tr>
    </table>
    
    <!-- Tabel Jadwal -->
    <table border="1">
        <thead>
            <tr>
                <th style="width: 80px;">Hari</th>
                <th style="width: 100px;">Jam 1</th>
                <th style="width: 100px;">Jam 2</th>
                <th style="width: 100px;">Jam 3</th>
                <th style="width: 100px;">Jam 4</th>
                <th style="width: 100px;">Jam 5</th>
                <th style="width: 100px;">Jam 6</th>
                <th style="width: 100px;">Jam 7</th>
                <th style="width: 100px;">Jam 8</th>
                <th style="width: 100px;">Jam 9</th>
                <th style="width: 100px;">Jam 10</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['jadwal'] as $d): ?>
            <tr>
                <td><strong><?= $d->hari ?></strong></td>
                
                <?php for ($i = 1; $i <= 10; $i++): 
                    $singkatan = 'singkatan' . $i;
                    $guru = 'guru' . $i;
                    $nama = 'nama' . $i;
                ?>
                <td>
                    <?php 
                    // Khusus jam 1 untuk upacara/ibadah
                    if ($i == 1 && empty($d->$singkatan)) {
                        if (strtolower($d->hari) == 'senin') {
                            echo '<span class="mapel">UPACARA</span>';
                        } elseif (strtolower($d->hari) == 'jumat') {
                            echo '<span class="mapel">IBADAH</span>';
                        } else {
                            echo '-';
                        }
                    } 
                    // Mapel normal
                    elseif (!empty($d->$singkatan)) {
                        echo '<span class="mapel">' . $d->$singkatan . '</span><br>';
                        
                        // Nama guru
                        if (strpos($d->$guru, ',') !== false) {
                            // Banyak guru
                            $nama_array = explode(",", $d->$guru);
                            $names = [];
                            foreach ($nama_array as $nm) {
                                $nm = trim($nm);
                                $nama_obj = $this->Mjadwal->ambil_nama($nm);
                                if (isset($nama_obj->nama)) {
                                    $names[] = substr($nama_obj->nama, 0, 10);
                                }
                            }
                            echo '<span class="guru">' . implode(" | ", $names) . '</span>';
                        } else {
                            // Satu guru
                            echo '<span class="guru">' . substr($d->$nama, 0, 12) . '</span>';
                        }
                    }
                    ?>
                </td>
                <?php endfor; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <br>
    <table class="header-table">
        <tr>
            <td colspan="11" style="font-size: 10px; text-align: left;">
                Dicetak pada: <?= date('d-m-Y H:i:s') ?>
            </td>
        </tr>
    </table>
</body>
</html>
