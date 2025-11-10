<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="container-fluid mt-3">
    <!-- Header Rapor -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px" alt="Logo SMA Bethel">
                </div>
                <div class="col-md-8 text-center">
                    <h3 class="mb-0" style="font-weight: bold;">SMA BETHEL BANJARBARU</h3>
                    <p class="mb-0">LAPORAN HASIL BELAJAR SISWA</p>
                    <p class="mb-0 text-muted">E-RAPOR</p>
                </div>
                <div class="col-md-2 text-right">
                    <?php if ($data['rapor']['ada_data']): ?>
                    <a href="<?= URLROOT ?>/siswa/cetak_rapor?semester=<?= $data['semester_dipilih'] ?>" 
                       class="btn btn-sm btn-success" target="_blank">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Data Siswa -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="150"><strong>Nama Siswa</strong></td>
                            <td>: <?= htmlspecialchars($data['siswa']->nama_siswa) ?></td>
                        </tr>
                        <tr>
                            <td><strong>NIS</strong></td>
                            <td>: <?= htmlspecialchars($data['siswa']->nis) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>: <?= htmlspecialchars($data['siswa']->kelas_siswa) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="150"><strong>Wali Kelas</strong></td>
                            <td>: <?= $data['siswa']->nama_wali_kelas ? htmlspecialchars($data['siswa']->nama_wali_kelas) : '-' ?></td>
                        </tr>
                        <tr>
                            <td><strong>Tahun Masuk</strong></td>
                            <td>: <?= htmlspecialchars($data['siswa']->tahun_masuk) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: <span class="badge badge-success"><?= htmlspecialchars($data['siswa']->status_siswa) ?></span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Filter Semester -->
            <div class="card card-secondary mb-3">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-filter"></i> Pilih Semester</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= URLROOT ?>/siswa/rapor_saya" class="form-inline">
                        <label class="mr-2">Semester:</label>
                        <select name="semester" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="">-- Pilih Semester --</option>
                            <?php foreach($data['semua_jadwal'] as $jadwal): ?>
                            <option value="<?= $jadwal->id_jadwal_setting ?>" 
                                    <?= ($data['semester_dipilih'] == $jadwal->id_jadwal_setting) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jadwal->tahun_ajaran) ?> - 
                                Semester <?= htmlspecialchars($jadwal->semester) ?> - 
                                Blok <?= htmlspecialchars($jadwal->blok) ?>
                                <?= ($jadwal->status == 1) ? '(Aktif)' : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <noscript>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </noscript>
                    </form>
                </div>
            </div>

            <?php if ($data['rapor']['ada_data']): ?>
                
                <!-- Info Semester -->
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Periode:</strong> 
                    <?= htmlspecialchars($data['rapor']['jadwal']->tahun_ajaran) ?> - 
                    Semester <?= htmlspecialchars($data['rapor']['jadwal']->semester) ?> - 
                    Blok <?= htmlspecialchars($data['rapor']['jadwal']->blok) ?>
                </div>

                <!-- Statistik Ringkas -->
                <div class="row mb-3">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?= count($data['rapor']['nilai_pelajaran']) ?></h3>
                                <p>Mata Pelajaran</p>
                            </div>
                            <div class="icon"><i class="fas fa-book"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?= number_format($data['rata_rata'], 2) ?></h3>
                                <p>Rata-rata Nilai</p>
                            </div>
                            <div class="icon"><i class="fas fa-chart-line"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?= count($data['rapor']['ekstrakurikuler']) ?></h3>
                                <p>Ekstrakurikuler</p>
                            </div>
                            <div class="icon"><i class="fas fa-trophy"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?= count($data['rapor']['prestasi']) ?></h3>
                                <p>Prestasi</p>
                            </div>
                            <div class="icon"><i class="fas fa-medal"></i></div>
                        </div>
                    </div>
                </div>

                <!-- NILAI PELAJARAN -->
                <div class="card card-primary card-outline mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-book-open"></i> Nilai Mata Pelajaran</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="35%">Mata Pelajaran</th>
                                        <th width="10%" class="text-center">Nilai</th>
                                        <th width="10%" class="text-center">Predikat</th>
                                        <th width="40%">Deskripsi Capaian Kompetensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    $total_nilai = 0;
                                    $jumlah_nilai = 0;
                                    foreach($data['rapor']['nilai_pelajaran'] as $nilai): 
                                        if ($nilai->nilai !== null) {
                                            $total_nilai += $nilai->nilai;
                                            $jumlah_nilai++;
                                        }
                                        
                                        // Tentukan warna predikat
                                        $badge_color = 'secondary';
                                        if ($nilai->predikat == 'A') $badge_color = 'success';
                                        elseif ($nilai->predikat == 'B') $badge_color = 'primary';
                                        elseif ($nilai->predikat == 'C') $badge_color = 'warning';
                                        elseif ($nilai->predikat == 'D') $badge_color = 'danger';
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($nilai->mata_pelajaran) ?></strong></td>
                                        <td class="text-center">
                                            <span class="badge badge-info"><?= $nilai->nilai !== null ? number_format($nilai->nilai, 2) : '-' ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-<?= $badge_color ?>"><?= htmlspecialchars($nilai->predikat ?? '-') ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($nilai->deskripsi ?? '-') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    
                                    <?php if ($jumlah_nilai > 0): ?>
                                    <tr class="bg-light font-weight-bold">
                                        <td colspan="2" class="text-right"><strong>Rata-rata</strong></td>
                                        <td class="text-center">
                                            <span class="badge badge-success"><?= number_format($total_nilai / $jumlah_nilai, 2) ?></span>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- NILAI SIKAP -->
                <?php if ($data['rapor']['nilai_sikap']): ?>
                <div class="card card-success card-outline mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-heart"></i> Penilaian Sikap</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>Sikap Spiritual</strong></h6>
                                <p class="mb-1">
                                    <span class="badge badge-success">
                                        <?= htmlspecialchars($data['rapor']['nilai_sikap']->predikat_spiritual ?? '-') ?>
                                    </span>
                                </p>
                                <p class="text-muted">
                                    <?= nl2br(htmlspecialchars($data['rapor']['nilai_sikap']->deskripsi_spiritual ?? 'Belum ada deskripsi')) ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>Sikap Sosial</strong></h6>
                                <p class="mb-1">
                                    <span class="badge badge-primary">
                                        <?= htmlspecialchars($data['rapor']['nilai_sikap']->predikat_sosial ?? '-') ?>
                                    </span>
                                </p>
                                <p class="text-muted">
                                    <?= nl2br(htmlspecialchars($data['rapor']['nilai_sikap']->deskripsi_sosial ?? 'Belum ada deskripsi')) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- EKSTRAKURIKULER -->
                <?php if (!empty($data['rapor']['ekstrakurikuler'])): ?>
                <div class="card card-warning card-outline mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-futbol"></i> Ekstrakurikuler</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="30%">Nama Kegiatan</th>
                                    <th width="15%">Nilai</th>
                                    <th width="50%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                foreach($data['rapor']['ekstrakurikuler'] as $ekskul): 
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($ekskul->nama_ekstrakurikuler) ?></td>
                                    <td>
                                        <span class="badge badge-info"><?= htmlspecialchars($ekskul->nilai ?? '-') ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($ekskul->keterangan ?? '-') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- PRESTASI -->
                <?php if (!empty($data['rapor']['prestasi'])): ?>
                <div class="card card-danger card-outline mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-award"></i> Prestasi</h5>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="bg-light">
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
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <span class="badge badge-secondary"><?= htmlspecialchars($prestasi->jenis_prestasi) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($prestasi->nama_prestasi) ?></td>
                                    <td><?= htmlspecialchars($prestasi->keterangan ?? '-') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- CATATAN WALI KELAS -->
                <?php if ($data['rapor']['catatan']): ?>
                <div class="card card-secondary card-outline mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-comment"></i> Catatan Wali Kelas</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="text-align: justify;">
                            <?= nl2br(htmlspecialchars($data['rapor']['catatan']->catatan)) ?>
                        </p>
                    </div>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Tidak Ada Data -->
                <div class="alert alert-warning text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h4><?= htmlspecialchars($data['rapor']['message']) ?></h4>
                    <p class="mb-0">Silakan pilih semester lain atau hubungi wali kelas Anda.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
@media print {
    .card-header .btn, 
    .card.card-secondary,
    .no-print {
        display: none !important;
    }
}
</style>