<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor - <?= htmlspecialchars($data['siswa']->nama_siswa) ?></title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18pt;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 11pt;
        }
        
        .logo {
            width: 80px;
            height: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table.info td {
            padding: 3px 5px;
            vertical-align: top;
        }
        
        table.nilai {
            border: 1px solid #000;
        }
        
        table.nilai th,
        table.nilai td {
            border: 1px solid #000;
            padding: 5px;
        }
        
        table.nilai th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            padding: 5px;
            background-color: #f0f0f0;
            border-left: 4px solid #333;
        }
        
        .ttd-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        
        .ttd-box {
            width: 45%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }
        
        .ttd-space {
            height: 70px;
        }
        
        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Tombol Print -->
    <div class="no-print" style="text-align: right; margin-bottom: 10px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">
            🖨️ Cetak Rapor
        </button>
    </div>

    <!-- Header -->
    <div class="header">
        <h1>SMA BETHEL BANJARBARU</h1>
        <p>Jl. [Alamat Sekolah]</p>
        <p>Telp: [Nomor Telepon] | Email: [Email Sekolah]</p>
        <p style="margin-top: 10px; font-size: 14pt;"><strong>LAPORAN HASIL BELAJAR SISWA</strong></p>
    </div>

    <!-- Identitas Siswa -->
    <table class="info">
        <tr>
            <td width="150">Nama Siswa</td>
            <td width="10">:</td>
            <td><strong><?= htmlspecialchars($data['siswa']->nama_siswa) ?></strong></td>
            <td width="150">Kelas</td>
            <td width="10">:</td>
            <td><strong><?= htmlspecialchars($data['siswa']->kelas_siswa) ?></strong></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['siswa']->nis) ?></td>
            <td>Wali Kelas</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['siswa']->nama_wali_kelas ?? '-') ?></td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['rapor']['jadwal']->tahun_ajaran) ?></td>
            <td>Semester</td>
            <td>:</td>
            <td><?= htmlspecialchars($data['rapor']['jadwal']->semester) ?> - Blok <?= htmlspecialchars($data['rapor']['jadwal']->blok) ?></td>
        </tr>
    </table>

    <!-- Nilai Pelajaran -->
    <div class="section-title">A. NILAI MATA PELAJARAN</div>
    <table class="nilai">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Mata Pelajaran</th>
                <th width="10%">Nilai</th>
                <th width="10%">Predikat</th>
                <th width="45%">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($data['rapor']['nilai_pelajaran'] as $nilai): 
            ?>
            <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td><?= htmlspecialchars($nilai->mata_pelajaran) ?></td>
                <td style="text-align: center;"><?= $nilai->nilai !== null ? number_format($nilai->nilai, 2) : '-' ?></td>
                <td style="text-align: center;"><strong><?= htmlspecialchars($nilai->predikat ?? '-') ?></strong></td>
                <td><?= htmlspecialchars($nilai->deskripsi ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Rata-rata</strong></td>
                <td style="text-align: center;"><strong><?= number_format($data['rata_rata'], 2) ?></strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <!-- Nilai Sikap -->
    <?php if ($data['rapor']['nilai_sikap']): ?>
    <div class="section-title">B. PENILAIAN SIKAP</div>
    <table class="nilai">
        <tr>
            <td width="30%"><strong>Sikap Spiritual</strong></td>
            <td width="15%" style="text-align: center;">
                <strong><?= htmlspecialchars($data['rapor']['nilai_sikap']->predikat_spiritual ?? '-') ?></strong>
            </td>
            <td><?= htmlspecialchars($data['rapor']['nilai_sikap']->deskripsi_spiritual ?? '-') ?></td>
        </tr>
        <tr>
            <td><strong>Sikap Sosial</strong></td>
            <td style="text-align: center;">
                <strong><?= htmlspecialchars($data['rapor']['nilai_sikap']->predikat_sosial ?? '-') ?></strong>
            </td>
            <td><?= htmlspecialchars($data['rapor']['nilai_sikap']->deskripsi_sosial ?? '-') ?></td>
        </tr>
    </table>
    <?php endif; ?>

    <!-- Ekstrakurikuler -->
    <?php if (!empty($data['rapor']['ekstrakurikuler'])): ?>
    <div class="section-title">C. EKSTRAKURIKULER</div>
    <table class="nilai">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Kegiatan</th>
                <th width="15%">Nilai</th>
                <th width="45%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($data['rapor']['ekstrakurikuler'] as $ekskul): 
            ?>
            <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td><?= htmlspecialchars($ekskul->nama_ekstrakurikuler) ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($ekskul->nilai ?? '-') ?></td>
                <td><?= htmlspecialchars($ekskul->keterangan ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Prestasi -->
    <?php if (!empty($data['rapor']['prestasi'])): ?>
    <div class="section-title">D. PRESTASI</div>
    <table class="nilai">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Jenis</th>
                <th width="35%">Nama Prestasi</th>
                <th width="40%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($data['rapor']['prestasi'] as $prestasi): 
            ?>
            <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td><?= htmlspecialchars($prestasi->jenis_prestasi) ?></td>
                <td><?= htmlspecialchars($prestasi->nama_prestasi) ?></td>
                <td><?= htmlspecialchars($prestasi->keterangan ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Catatan Wali Kelas -->
    <?php if ($data['rapor']['catatan']): ?>
    <div class="section-title">E. CATATAN WALI KELAS</div>
    <div style="border: 1px solid #000; padding: 10px; min-height: 80px; text-align: justify;">
        <?= nl2br(htmlspecialchars($data['rapor']['catatan']->catatan)) ?>
    </div>
    <?php endif; ?>

    <!-- Tanda Tangan -->
    <div class="ttd-section">
        <table width="100%">
            <tr>
                <td width="50%" style="text-align: center;">
                    <p>Orang Tua/Wali,</p>
                    <div class="ttd-space"></div>
                    <p>(__________________)</p>
                </td>
                <td width="50%" style="text-align: center;">
                    <p>Banjarbaru, <?= date('d F Y') ?></p>
                    <p>Wali Kelas,</p>
                    <div class="ttd-space"></div>
                    <p><strong><?= htmlspecialchars($data['siswa']->nama_wali_kelas ?? '________________') ?></strong></p>
                </td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 30px;">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="ttd-space"></div>
            <p><strong>(__________________)</strong></p>
        </div>
    </div>

</body>
</html>