<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="container-fluid mt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-graduation-cap"></i> 
                E-Rapor - <?= htmlspecialchars($data['siswa']->nama_siswa) ?>
            </h3>
            <div class="card-tools">
                <a href="<?= URLROOT ?>/siswa/rapor" class="btn btn-tool">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Info Siswa & Semester -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="120"><strong>NIS</strong></td>
                            <td>: <?= htmlspecialchars($data['siswa']->nis) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Nama</strong></td>
                            <td>: <?= htmlspecialchars($data['siswa']->nama_siswa) ?></td>
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
                            <td width="120"><strong>Tahun Ajaran</strong></td>
                            <td>: <?= htmlspecialchars($data['jadwal']->tahun_ajaran) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Semester</strong></td>
                            <td>: <?= htmlspecialchars($data['jadwal']->semester) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Blok</strong></td>
                            <td>: <?= htmlspecialchars($data['jadwal']->blok) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Filter Semester -->
            <div class="card card-secondary mb-3">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-calendar-alt"></i> Pilih Semester untuk Input Nilai</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="<?= URLROOT ?>/siswa/rapor_detail/<?= $data['siswa']->id_siswa ?>" class="form-inline">
                        <label class="mr-2"><strong>Ganti Semester:</strong></label>
                        <select name="semester" class="form-control mr-2" onchange="this.form.submit()" style="min-width: 400px;">
                            <?php foreach($data['semua_jadwal'] as $jadwal): ?>
                            <option value="<?= $jadwal->id_jadwal_setting ?>" 
                                    <?= (isset($data['semester_dipilih']) && $data['semester_dipilih'] == $jadwal->id_jadwal_setting) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jadwal->tahun_ajaran) ?> - 
                                Semester <?= htmlspecialchars($jadwal->semester) ?> - 
                                Blok <?= htmlspecialchars($jadwal->blok) ?>
                                <?= ($jadwal->status == 1) ? '⭐ (Aktif)' : '' ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <noscript>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                        </noscript>
                    </form>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle"></i> 
                        Anda sedang menginput nilai untuk semester: 
                        <strong><?= htmlspecialchars($data['jadwal']->tahun_ajaran) ?> - 
                        Semester <?= htmlspecialchars($data['jadwal']->semester) ?> - 
                        Blok <?= htmlspecialchars($data['jadwal']->blok) ?></strong>
                    </small>
                </div>
            </div>

            <hr>

            <!-- Form Rapor -->
            <form method="post" action="<?= URLROOT ?>/siswa/simpan_rapor" id="formRapor">
                <input type="hidden" name="id_siswa" value="<?= $data['siswa']->id_siswa ?>">
                <input type="hidden" name="id_jadwal_setting" value="<?= $data['jadwal']->id_jadwal_setting ?>">

                <!-- SECTION: NILAI PELAJARAN -->
                <div class="card card-outline card-info mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-book"></i> Nilai Mata Pelajaran</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Mata Pelajaran</th>
                                        <th width="10%">Nilai (0-100)</th>
                                        <th width="10%">Predikat</th>
                                        <th width="50%">Deskripsi Capaian Kompetensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    // Buat array nilai yang sudah ada untuk kemudahan akses
                                    $nilai_existing = [];
                                    foreach($data['nilai_pelajaran'] as $np) {
                                        $nilai_existing[$np->id_pelajaran] = $np;
                                    }
                                    
                                    foreach($data['pelajaran'] as $mp): 
                                        $nilai_data = isset($nilai_existing[$mp->id_pelajaran]) ? $nilai_existing[$mp->id_pelajaran] : null;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><strong><?= htmlspecialchars($mp->mata_pelajaran) ?></strong></td>
                                        <td>
                                            <input type="number" 
                                                   name="nilai[<?= $mp->id_pelajaran ?>]" 
                                                   class="form-control form-control-sm nilai-input" 
                                                   step="0.01" 
                                                   min="0" 
                                                   max="100"
                                                   value="<?= $nilai_data ? htmlspecialchars($nilai_data->nilai) : '' ?>"
                                                   placeholder="0-100"
                                                   data-mapel="<?= $mp->id_pelajaran ?>">
                                        </td>
                                        <td>
                                            <select name="predikat[<?= $mp->id_pelajaran ?>]" 
                                                    class="form-control form-control-sm predikat-<?= $mp->id_pelajaran ?>">
                                                <option value="">-</option>
                                                <option value="A" <?= ($nilai_data && $nilai_data->predikat == 'A') ? 'selected' : '' ?>>A</option>
                                                <option value="B" <?= ($nilai_data && $nilai_data->predikat == 'B') ? 'selected' : '' ?>>B</option>
                                                <option value="C" <?= ($nilai_data && $nilai_data->predikat == 'C') ? 'selected' : '' ?>>C</option>
                                                <option value="D" <?= ($nilai_data && $nilai_data->predikat == 'D') ? 'selected' : '' ?>>D</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea name="deskripsi[<?= $mp->id_pelajaran ?>]" 
                                                      class="form-control form-control-sm" 
                                                      rows="2"
                                                      placeholder="Deskripsi capaian kompetensi siswa..."><?= $nilai_data ? htmlspecialchars($nilai_data->deskripsi) : '' ?></textarea>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- SECTION: NILAI SIKAP -->
                <div class="card card-outline card-success mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-heart"></i> Penilaian Sikap</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Sikap Spiritual</strong></label>
                                    <select name="predikat_spiritual" class="form-control">
                                        <option value="">- Pilih Predikat -</option>
                                        <option value="SB" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'SB') ? 'selected' : '' ?>>SB - Sangat Baik</option>
                                        <option value="B" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'B') ? 'selected' : '' ?>>B - Baik</option>
                                        <option value="C" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'C') ? 'selected' : '' ?>>C - Cukup</option>
                                        <option value="K" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'K') ? 'selected' : '' ?>>K - Kurang</option>
                                    </select>
                                    <textarea name="deskripsi_spiritual" 
                                              class="form-control mt-2" 
                                              rows="3"
                                              placeholder="Deskripsi sikap spiritual (ketaatan beribadah, toleransi, dll)..."><?= $data['nilai_sikap'] ? htmlspecialchars($data['nilai_sikap']->deskripsi_spiritual) : '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Sikap Sosial</strong></label>
                                    <select name="predikat_sosial" class="form-control">
                                        <option value="">- Pilih Predikat -</option>
                                        <option value="SB" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'SB') ? 'selected' : '' ?>>SB - Sangat Baik</option>
                                        <option value="B" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'B') ? 'selected' : '' ?>>B - Baik</option>
                                        <option value="C" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'C') ? 'selected' : '' ?>>C - Cukup</option>
                                        <option value="K" <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'K') ? 'selected' : '' ?>>K - Kurang</option>
                                    </select>
                                    <textarea name="deskripsi_sosial" 
                                              class="form-control mt-2" 
                                              rows="3"
                                              placeholder="Deskripsi sikap sosial (kejujuran, disiplin, tanggung jawab, dll)..."><?= $data['nilai_sikap'] ? htmlspecialchars($data['nilai_sikap']->deskripsi_sosial) : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION: EKSTRAKURIKULER -->
                <div class="card card-outline card-warning mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-trophy"></i> Ekstrakurikuler</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahEkskul()">
                                <i class="fas fa-plus"></i> Tambah Ekskul
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="ekskulContainer">
                            <?php if(!empty($data['ekskul'])): ?>
                                <?php foreach($data['ekskul'] as $idx => $e): ?>
                                <div class="row mb-2 ekskul-row">
                                    <div class="col-md-3">
                                        <input type="text" 
                                               name="ekskul_nama[]" 
                                               placeholder="Nama Ekstrakurikuler"
                                               class="form-control form-control-sm"
                                               value="<?= htmlspecialchars($e->nama_ekstrakurikuler) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="ekskul_nilai[]" class="form-control form-control-sm">
                                            <option value="">- Nilai -</option>
                                            <option value="Baik" <?= $e->nilai == 'Baik' ? 'selected' : '' ?>>Baik</option>
                                            <option value="Cukup" <?= $e->nilai == 'Cukup' ? 'selected' : '' ?>>Cukup</option>
                                            <option value="Kurang" <?= $e->nilai == 'Kurang' ? 'selected' : '' ?>>Kurang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" 
                                               name="ekskul_ket[]" 
                                               placeholder="Keterangan"
                                               class="form-control form-control-sm"
                                               value="<?= htmlspecialchars($e->keterangan) ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="row mb-2 ekskul-row">
                                    <div class="col-md-3">
                                        <input type="text" name="ekskul_nama[]" placeholder="Nama Ekstrakurikuler" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="ekskul_nilai[]" class="form-control form-control-sm">
                                            <option value="">- Nilai -</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Cukup">Cukup</option>
                                            <option value="Kurang">Kurang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="ekskul_ket[]" placeholder="Keterangan" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- SECTION: PRESTASI -->
                <div class="card card-outline card-danger mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-medal"></i> Prestasi</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-success" onclick="tambahPrestasi()">
                                <i class="fas fa-plus"></i> Tambah Prestasi
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="prestasiContainer">
                            <?php if(!empty($data['prestasi'])): ?>
                                <?php foreach($data['prestasi'] as $idx => $p): ?>
                                <div class="row mb-2 prestasi-row">
                                    <div class="col-md-2">
                                        <select name="prestasi_jenis[]" class="form-control form-control-sm">
                                            <option value="">- Jenis -</option>
                                            <option value="Akademik" <?= $p->jenis_prestasi == 'Akademik' ? 'selected' : '' ?>>Akademik</option>
                                            <option value="Non-Akademik" <?= $p->jenis_prestasi == 'Non-Akademik' ? 'selected' : '' ?>>Non-Akademik</option>
                                            <option value="Olahraga" <?= $p->jenis_prestasi == 'Olahraga' ? 'selected' : '' ?>>Olahraga</option>
                                            <option value="Seni" <?= $p->jenis_prestasi == 'Seni' ? 'selected' : '' ?>>Seni</option>
                                            <option value="Lainnya" <?= $p->jenis_prestasi == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" 
                                               name="prestasi_nama[]" 
                                               placeholder="Nama Prestasi/Lomba"
                                               class="form-control form-control-sm"
                                               value="<?= htmlspecialchars($p->nama_prestasi) ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" 
                                               name="prestasi_ket[]" 
                                               placeholder="Keterangan (Juara 1 Tingkat Provinsi, dll)"
                                               class="form-control form-control-sm"
                                               value="<?= htmlspecialchars($p->keterangan) ?>">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="row mb-2 prestasi-row">
                                    <div class="col-md-2">
                                        <select name="prestasi_jenis[]" class="form-control form-control-sm">
                                            <option value="">- Jenis -</option>
                                            <option value="Akademik">Akademik</option>
                                            <option value="Non-Akademik">Non-Akademik</option>
                                            <option value="Olahraga">Olahraga</option>
                                            <option value="Seni">Seni</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="prestasi_nama[]" placeholder="Nama Prestasi/Lomba" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" name="prestasi_ket[]" placeholder="Keterangan (Juara 1 Tingkat Provinsi, dll)" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- SECTION: CATATAN WALI KELAS -->
                <div class="card card-outline card-secondary mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-sticky-note"></i> Catatan Wali Kelas</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="catatan" 
                                  class="form-control" 
                                  rows="4"
                                  placeholder="Catatan perkembangan siswa, saran, dan masukan dari wali kelas..."><?= $data['catatan'] ? htmlspecialchars($data['catatan']->catatan) : '' ?></textarea>
                        <small class="text-muted">Contoh: Siswa menunjukkan peningkatan dalam mata pelajaran Matematika. Perlu meningkatkan kedisiplinan kehadiran.</small>
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Simpan Semua Data Rapor
                        </button>
                        <a href="<?= URLROOT ?>/siswa/rapor" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-fill predikat berdasarkan nilai
document.querySelectorAll('.nilai-input').forEach(input => {
    input.addEventListener('input', function() {
        const nilai = parseFloat(this.value);
        const mapelId = this.getAttribute('data-mapel');
        const predikatSelect = document.querySelector(`.predikat-${mapelId}`);
        
        if (!isNaN(nilai)) {
            let predikat = '';
            if (nilai >= 90) predikat = 'A';
            else if (nilai >= 75) predikat = 'B';
            else if (nilai >= 60) predikat = 'C';
            else predikat = 'D';
            
            predikatSelect.value = predikat;
        }
    });
});

// Tambah baris ekstrakurikuler
function tambahEkskul() {
    const container = document.getElementById('ekskulContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 ekskul-row';
    newRow.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="ekskul_nama[]" placeholder="Nama Ekstrakurikuler" class="form-control form-control-sm">
        </div>
        <div class="col-md-2">
            <select name="ekskul_nilai[]" class="form-control form-control-sm">
                <option value="">- Nilai -</option>
                <option value="Baik">Baik</option>
                <option value="Cukup">Cukup</option>
                <option value="Kurang">Kurang</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" name="ekskul_ket[]" placeholder="Keterangan" class="form-control form-control-sm">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

// Tambah baris prestasi
function tambahPrestasi() {
    const container = document.getElementById('prestasiContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 prestasi-row';
    newRow.innerHTML = `
        <div class="col-md-2">
            <select name="prestasi_jenis[]" class="form-control form-control-sm">
                <option value="">- Jenis -</option>
                <option value="Akademik">Akademik</option>
                <option value="Non-Akademik">Non-Akademik</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Seni">Seni</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="prestasi_nama[]" placeholder="Nama Prestasi/Lomba" class="form-control form-control-sm">
        </div>
        <div class="col-md-5">
            <input type="text" name="prestasi_ket[]" placeholder="Keterangan (Juara 1 Tingkat Provinsi, dll)" class="form-control form-control-sm">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

// Hapus baris
function hapusRow(btn) {
    Swal.fire({
        title: 'Hapus baris ini?',
        text: "Data akan dihapus saat Anda menyimpan form",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            btn.closest('.row').remove();
        }
    });
}

// Validasi form sebelum submit
document.getElementById('formRapor').addEventListener('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Simpan Data Rapor?',
        text: "Pastikan semua data sudah benar sebelum disimpan",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Periksa Lagi'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>

<style>
.table td {
    vertical-align: middle;
}
.card-outline {
    border-top: 3px solid;
}
.ekskul-row, .prestasi-row {
    animation: fadeIn 0.3s;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>