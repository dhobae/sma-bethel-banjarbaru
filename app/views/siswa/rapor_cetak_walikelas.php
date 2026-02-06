<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor - <?php echo htmlspecialchars($data['siswa']->nama_siswa) ?></title>
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

        .btn-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .btn {
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .btn-print {
            background-color: #007bff;
            color: white;
        }

        .btn-print:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background-color: #545b62;
        }

        @media print {
            body {
                margin: 0;
            }
            .no-print {
                display: none !important;
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
        <img src="<?php echo URLROOT ?>/smabethel/img/icon.png" alt="Logo" style="width:80px;">
        <h1>SMA BETHEL BANJARBARU</h1>
        <p>Jl. Kubis No.Ujung, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714</p>
        <p>Telp: 05114781106 | Email: smabethelbanjarbaru@gmail.com</p>
    </div>

    <!-- Identitas Siswa -->
    <table class="info">
        <p style="margin-top: 10px; font-size: 14pt; text-align: center;"><strong>LAPORAN HASIL BELAJAR SISWA</strong></p>
        <tr>
            <td width="150">Nama Siswa</td>
            <td width="10">:</td>
            <td><strong><?php echo htmlspecialchars($data['siswa']->nama_siswa) ?></strong></td>
            <td width="150">Kelas</td>
            <td width="10">:</td>
            <td><strong><?php echo htmlspecialchars($data['siswa']->kelas_siswa) ?></strong></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><?php echo htmlspecialchars($data['siswa']->nis) ?></td>
            <td>Wali Kelas</td>
            <td>:</td>
            <td><?php echo isset($data['wali_kelas']) ? htmlspecialchars($data['wali_kelas']->nama) : '-' ?></td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>:</td>
            <td><?php echo htmlspecialchars($data['jadwal']->tahun_ajaran) ?></td>
            <td>Semester</td>
            <td>:</td>
            <td><?php echo htmlspecialchars($data['jadwal']->semester) ?> - Blok <?php echo htmlspecialchars($data['jadwal']->blok) ?></td>
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
                $no             = 1;
                $nilai_existing = [];
                if (isset($data['nilai_pelajaran']) && ! empty($data['nilai_pelajaran'])) {
                    foreach ($data['nilai_pelajaran'] as $np) {
                        $nilai_existing[$np->id_pelajaran] = $np;
                    }
                }

                if (isset($data['pelajaran']) && ! empty($data['pelajaran'])):
                    foreach ($data['pelajaran'] as $mp):
                        $nilai_data = isset($nilai_existing[$mp->id_pelajaran]) ? $nilai_existing[$mp->id_pelajaran] : null;

                        // Hanya tampilkan jika ada nilai
                        if ($nilai_data):
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++ ?></td>
                <td><?php echo htmlspecialchars($mp->mata_pelajaran) ?></td>
                <td style="text-align: center;"><?php echo $nilai_data->nilai !== null ? number_format($nilai_data->nilai, 2) : '-' ?></td>
                <td style="text-align: center;"><strong><?php echo htmlspecialchars($nilai_data->predikat ?? '-') ?></strong></td>
                <td><?php echo htmlspecialchars($nilai_data->deskripsi ?? '-') ?></td>
            </tr>
            <?php
                        endif;
                endforeach;
                else:
            ?>
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data nilai</td>
            </tr>
            <?php endif; ?>

            <?php if (isset($data['rata_rata']) && $data['rata_rata'] > 0): ?>
            <tr>
                <td colspan="2" style="text-align: right;"><strong>Rata-rata</strong></td>
                <td style="text-align: center;"><strong><?php echo number_format($data['rata_rata'], 2) ?></strong></td>
                <td colspan="2"></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Nilai Sikap -->
    <?php if (isset($data['nilai_sikap']) && $data['nilai_sikap']): ?>
    <div class="section-title">B. PENILAIAN SIKAP</div>
    <table class="nilai">
        <tr>
            <td width="30%"><strong>Sikap Spiritual</strong></td>
            <td width="15%" style="text-align: center;">
                <strong><?php echo htmlspecialchars($data['nilai_sikap']->predikat_spiritual ?? '-') ?></strong>
            </td>
            <td><?php echo htmlspecialchars($data['nilai_sikap']->deskripsi_spiritual ?? '-') ?></td>
        </tr>
        <tr>
            <td><strong>Sikap Sosial</strong></td>
            <td style="text-align: center;">
                <strong><?php echo htmlspecialchars($data['nilai_sikap']->predikat_sosial ?? '-') ?></strong>
            </td>
            <td><?php echo htmlspecialchars($data['nilai_sikap']->deskripsi_sosial ?? '-') ?></td>
        </tr>
    </table>
    <?php endif; ?>

    <!-- Ekstrakurikuler -->
    <?php if (isset($data['ekskul']) && ! empty($data['ekskul'])): ?>
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
                foreach ($data['ekskul'] as $ekskul):
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++ ?></td>
                <td><?php echo htmlspecialchars($ekskul->nama_ekstrakurikuler) ?></td>
                <td style="text-align: center;"><?php echo htmlspecialchars($ekskul->nilai ?? '-') ?></td>
                <td><?php echo htmlspecialchars($ekskul->keterangan ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Prestasi -->
    <?php if (isset($data['prestasi']) && ! empty($data['prestasi'])): ?>
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
                foreach ($data['prestasi'] as $prestasi):
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++ ?></td>
                <td><?php echo htmlspecialchars($prestasi->jenis_prestasi) ?></td>
                <td><?php echo htmlspecialchars($prestasi->nama_prestasi) ?></td>
                <td><?php echo htmlspecialchars($prestasi->keterangan ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Catatan Wali Kelas -->
    <?php if (isset($data['catatan']) && $data['catatan']): ?>
    <div class="section-title">E. CATATAN WALI KELAS</div>
    <div style="border: 1px solid #000; padding: 10px; min-height: 80px; text-align: justify;">
        <?php echo nl2br(htmlspecialchars($data['catatan']->catatan)) ?>
    </div>
    <?php endif; ?>

    <!-- Tanda Tangan -->
    <div class="ttd-section">
        <table width="100%">
            <tr>
                <td width="50%" style="text-align: center;">
                    <p>Orang Tua/Wali,</p>
                    <div class="ttd-space"></div>
                    <p><strong style="text-decoration: underline;">__________________</strong></p>
                </td>
                <td width="50%" style="text-align: center;">
                    <p>Banjarbaru, <?php echo date('d F Y') ?></p>
                    <p>Wali Kelas,</p>
                    <div class="ttd-space"></div>
                    <p><strong style="text-decoration: underline;"><?php echo isset($data['wali_kelas']) ? htmlspecialchars($data['wali_kelas']->nama) : '________________' ?></strong></p>
                </td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 30px;">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="ttd-space"></div>
            <p><strong style="text-decoration: underline;"><?php echo isset($data['kepala_sekolah']) ? htmlspecialchars($data['kepala_sekolah']->nama) : 'Ichu Yulianty, S.Hut, M.Th' ?></strong></p>
        </div>
    </div>
    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>