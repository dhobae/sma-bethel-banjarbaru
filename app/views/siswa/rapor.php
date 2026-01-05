<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
    <div class="card">
        <div class="card-body box-profile">

            <div class="mb-2 d-flex align-items-center">
                <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
                <div class="ml-3 pt-3 mb-0" style="font-family:calibri; font-size: 1.2rem; font-weight:bold;">
                    SMA Bethel Banjarbaru
                </div>
            </div>

            <!-- Filter Semester -->
            <div class="card card-secondary mb-3">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-filter"></i> Pilih Semester
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= URLROOT ?>/siswa/rapor" class="form-inline">
                        <label class="mr-2"><strong>Semester:</strong></label>
                        <select name="semester" class="form-control mr-2" onchange="this.form.submit()"
                            style="min-width: 400px;">
                            <?php if (empty($data['semua_jadwal'])): ?>
                                <option value="">Tidak ada semester tersedia</option>
                            <?php else: ?>
                                <?php foreach ($data['semua_jadwal'] as $jadwal): ?>
                                    <option value="<?= $jadwal->id_jadwal_setting ?>" <?= (isset($data['semester_dipilih']) && $data['semester_dipilih'] == $jadwal->id_jadwal_setting) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($jadwal->tahun_ajaran) ?> -
                                        Semester <?= htmlspecialchars($jadwal->semester) ?> -
                                        Blok <?= htmlspecialchars($jadwal->blok) ?>
                                        <?= ($jadwal->status == 1) ? '⭐ (Aktif)' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <noscript>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </noscript>
                    </form>

                    <?php if (isset($data['jadwal_terpilih'])): ?>
                        <div class="mt-2">
                            <span class="badge badge-info">
                                <i class="fas fa-info-circle"></i>
                                Menampilkan data untuk:
                                <strong>
                                    <?= htmlspecialchars($data['jadwal_terpilih']->tahun_ajaran) ?> -
                                    Semester <?= htmlspecialchars($data['jadwal_terpilih']->semester) ?> -
                                    Blok <?= htmlspecialchars($data['jadwal_terpilih']->blok) ?>
                                </strong>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info Kelas -->
            <div class="mb-3">
                <span style="font-family:calibri; font-size: 1.2rem; font-weight:bold;">
                    Daftar E-Rapor Kelas Anda:
                    <?php if (!empty($data['kelas'])): ?>
                        <?php foreach ($data['kelas'] as $row): ?>
                            <span class="badge bg-primary"><?= htmlspecialchars($row->kode_kelas) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="badge bg-warning">Tidak ada kelas</span>
                    <?php endif; ?>
                </span>
            </div>

            <!-- Filter & Search -->
            <div class="mb-3">
                <div class="input-group" style="max-width: 400px;">
                    <input type="text" id="searchSiswa" class="form-control" placeholder="Cari nama siswa...">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>

            <!-- Peringatan jika tidak ada semester dipilih -->
            <?php if (!isset($data['semester_dipilih']) || !$data['semester_dipilih']): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Tidak ada semester yang dipilih. Silakan pilih semester dari dropdown di
                    atas.
                </div>
            <?php endif; ?>

            <!-- Cards siswa list siswa rapor -->
            <div class="row" id="siswaContainer">
                <?php
                if (!empty($data['siswa']) && isset($data['semester_dipilih'])):
                    $no = 0;
                    foreach ($data['siswa'] as $row):
                        $kelengkapan = isset($row->kelengkapan) ? $row->kelengkapan : null;

                        // Tentukan warna card berdasarkan status kelengkapan
                        $card_color = 'bg-secondary'; // Default: belum ada data
                        $progress_pct = 0;
                        $status_text = 'Belum Ada Data';

                        if ($kelengkapan) {
                            $progress_pct = $kelengkapan['persentase_total'];
                            $status = $kelengkapan['status'];

                            if ($status == 'lengkap') {
                                $card_color = 'bg-success';
                                $status_text = 'Lengkap';
                            } elseif ($status == 'hampir_lengkap') {
                                $card_color = 'bg-info';
                                $status_text = 'Hampir Lengkap';
                            } elseif ($status == 'sebagian') {
                                $card_color = 'bg-warning';
                                $status_text = 'Sebagian';
                            } else {
                                $card_color = 'bg-danger';
                                $status_text = 'Minim';
                            }
                        }
                        ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6" style="padding: 0px 3px;"
                            data-siswa="<?= strtolower($row->nama_siswa) ?>">
                            <div class="small-box <?= $card_color ?>">
                                <div class="inner" style="height: 120px; text-align:left; line-height:1.2; padding:10px;">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <p class="mb-0"><b><span style="font-family:calibri; font-size:0.95em;">
                                                    <?= htmlspecialchars($row->nama_siswa) ?>
                                                </span></b></p>
                                    </div>
                                    <p class="mb-1" style="font-size: 0.85em;">
                                        <i class="fas fa-id-card"></i> <?= htmlspecialchars($row->nis) ?><br>
                                        <i class="fas fa-school"></i> <?= htmlspecialchars($row->kelas_siswa) ?>
                                    </p>

                                    <?php if ($kelengkapan): ?>
                                        <div class="progress" style="height: 8px; margin-top: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $progress_pct ?>%;"
                                                aria-valuenow="<?= $progress_pct ?>" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small style="font-size: 0.75em;">
                                            <i class="fas fa-check-circle"></i> <?= $status_text ?>: <?= $progress_pct ?>%
                                            <?php if (isset($kelengkapan['jumlah_nilai_mapel']) && isset($kelengkapan['total_mapel'])): ?>
                                                <br><i class="fas fa-book"></i> Nilai:
                                                <?= $kelengkapan['jumlah_nilai_mapel'] ?>/<?= $kelengkapan['total_mapel'] ?>
                                            <?php endif; ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                                <div class="icon"><i class="fas fa-user-graduate"></i></div>
                                <a href="<?= URLROOT ?>/siswa/rapor_detail/<?= $row->id_siswa ?>?semester=<?= $data['semester_dipilih'] ?>"
                                    class="small-box-footer">
                                    <i class="fas fa-edit"></i> Input/Edit Rapor
                                </a>
                            </div>
                        </div>
                        <?php
                        $no++;
                    endforeach;
                elseif (empty($data['siswa'])):
                    ?>
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            Tidak ada siswa yang terdaftar di kelas Anda.
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Silakan pilih semester terlebih dahulu untuk melihat daftar siswa.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- /cards siswa list siswa rapor -->

            <?php if (!empty($data['siswa']) && isset($data['semester_dipilih'])): ?>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-check-double"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Lengkap (100%)</span>
                                    <span class="info-box-number" id="count-lengkap">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-check"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Hampir Lengkap (≥80%)</span>
                                    <span class="info-box-number" id="count-hampir">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-spinner"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Sebagian (40-79%)</span>
                                    <span class="info-box-number" id="count-sebagian">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fas fa-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Minim (<40%)< /span>
                                            <span class="info-box-number" id="count-minim">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan informasi detail kelengkapan -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Kelengkapan Rapor</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Kriteria Kelengkapan Pengisian:</h5>
                                    <ul>
                                        <li>Nilai Mata Pelajaran: 20% (berdasarkan mata pelajaran yang berlaku untuk periode
                                            ini)</li>
                                        <li>Penilaian Sikap: 20%</li>
                                        <li>Ekstrakurikuler: 20%</li>
                                        <li>Prestasi: 20%</li>
                                        <li>Catatan Wali Kelas: 20%</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Status Kelengkapan:</h5>
                                    <ul>
                                        <li><span class="badge bg-success">Lengkap</span>: 100% (Lengkap)</li>
                                        <li><span class="badge bg-info">Hampir Lengkap</span>: ≥80% (Hampir Lengkap)</li>
                                        <li><span class="badge bg-warning">Sebagian</span>: 40-79% (sedang diproses)</li>
                                        <li><span class="badge bg-danger">Minim</span>: <40% (perlu segera diisi)</li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Catatan:</strong> Mata pelajaran yang ditampilkan adalah mata pelajaran yang
                                        berlaku untuk periode ini sesuai dengan kurikulum.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    // Search siswa
    document.getElementById('searchSiswa').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        const siswaCards = document.querySelectorAll('[data-siswa]');

        siswaCards.forEach(card => {
            const nama = card.getAttribute('data-siswa');
            if (nama.includes(keyword)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Hitung statistik kelengkapan
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.small-box');
        let lengkap = 0, hampir = 0, sebagian = 0, minim = 0;

        cards.forEach(card => {
            if (card.classList.contains('bg-success')) lengkap++;
            else if (card.classList.contains('bg-info')) hampir++;
            else if (card.classList.contains('bg-warning')) sebagian++;
            else if (card.classList.contains('bg-danger')) minim++;
        });

        if (document.getElementById('count-lengkap')) {
            document.getElementById('count-lengkap').textContent = lengkap;
            document.getElementById('count-hampir').textContent = hampir;
            document.getElementById('count-sebagian').textContent = sebagian;
            document.getElementById('count-minim').textContent = minim;
        }
    });
</script>

<style>
    .small-box {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .progress {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .progress-bar {
        background-color: rgba(255, 255, 255, 0.8);
    }
</style>