<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4 mb-5">
    <div class="rapor-container">
        <!-- Header Section -->
        <div class="header-section">
            <img src="<?= URLROOT ?>/smabethel/img/icon.png" alt="" class="school-logo">
            <div class="school-name">SMA Bethel Banjarbaru</div>
            <div class="school-address"> Jl. Kubis No.Ujung, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar
                Baru, Kalimantan Selatan 70714</div>
            <div class="rapor-title">LAPORAN HASIL BELAJAR SISWA</div>
        </div>

        <!-- Student Information -->
        <div class="student-info">
            <div class="info-table">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Nama Siswa:</strong> <?= htmlspecialchars($data['siswa']->nama_siswa) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>NIS:</strong> <?= htmlspecialchars($data['siswa']->nis) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Kelas:</strong> <?= htmlspecialchars($data['siswa']->kelas_siswa) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Tahun Ajaran:</strong> <?= htmlspecialchars($data['jadwal']->tahun_ajaran) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <strong>Semester:</strong> <?= htmlspecialchars($data['jadwal']->semester) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Blok:</strong> <?= htmlspecialchars($data['jadwal']->blok) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Rapor -->
        <form method="post" action="<?= URLROOT ?>/siswa/simpan_rapor" id="formRapor">
            <input type="hidden" name="id_siswa" value="<?= $data['siswa']->id_siswa ?>">
            <input type="hidden" name="id_jadwal_setting" value="<?= $data['jadwal']->id_jadwal_setting ?>">

            <!-- Nilai Pelajaran Section -->
            <div class="section-title">A. Nilai Mata Pelajaran</div>
            <div class="table-responsive">
                <table class="nilai-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Mata Pelajaran</th>
                            <th width="15%">Nilai (0-100)</th>
                            <th width="15%">Predikat</th>
                            <th width="30%">Deskripsi Capaian Kompetensi</th>
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
                            <td><?= $no++ ?></td>
                            <td style="text-align: left; font-weight: bold;">
                                <?= htmlspecialchars($mp->mata_pelajaran) ?></td>
                            <td>
                                <input type="number" name="nilai[<?= $mp->id_pelajaran ?>]"
                                    class="form-control form-control-sm nilai-input" step="0.01" min="0" max="100"
                                    value="<?= $nilai_data ? htmlspecialchars($nilai_data->nilai) : '' ?>"
                                    placeholder="0-100" data-mapel="<?= $mp->id_pelajaran ?>">
                            </td>
                            <td>
                                <select name="predikat[<?= $mp->id_pelajaran ?>]"
                                    class="form-control form-control-sm predikat-<?= $mp->id_pelajaran ?>">
                                    <option value="">-</option>
                                    <option value="A"
                                        <?= ($nilai_data && $nilai_data->predikat == 'A') ? 'selected' : '' ?>>A
                                    </option>
                                    <option value="B"
                                        <?= ($nilai_data && $nilai_data->predikat == 'B') ? 'selected' : '' ?>>B
                                    </option>
                                    <option value="C"
                                        <?= ($nilai_data && $nilai_data->predikat == 'C') ? 'selected' : '' ?>>C
                                    </option>
                                    <option value="D"
                                        <?= ($nilai_data && $nilai_data->predikat == 'D') ? 'selected' : '' ?>>D
                                    </option>
                                </select>
                            </td>
                            <td style="text-align: left;">
                                <textarea name="deskripsi[<?= $mp->id_pelajaran ?>]"
                                    class="form-control form-control-sm" rows="2"
                                    placeholder="Deskripsi capaian kompetensi siswa..."><?= $nilai_data ? htmlspecialchars($nilai_data->deskripsi) : '' ?></textarea>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Sikap Section -->
            <div class="section-title">B. Penilaian Sikap</div>
            <div class="sikap-section">
                <table class="sikap-table">
                    <tr>
                        <td>Sikap Spiritual</td>
                        <td>
                            <select name="predikat_spiritual" class="form-control form-control-sm">
                                <option value="">- Pilih Predikat -</option>
                                <option value="SB"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'SB') ? 'selected' : '' ?>>
                                    SB - Sangat Baik</option>
                                <option value="B"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'B') ? 'selected' : '' ?>>
                                    B - Baik</option>
                                <option value="C"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'C') ? 'selected' : '' ?>>
                                    C - Cukup</option>
                                <option value="K"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_spiritual == 'K') ? 'selected' : '' ?>>
                                    K - Kurang</option>
                            </select>
                            <textarea name="deskripsi_spiritual" class="form-control form-control-sm mt-2" rows="3"
                                placeholder="Deskripsi sikap spiritual (ketaatan beribadah, toleransi, dll)..."><?= $data['nilai_sikap'] ? htmlspecialchars($data['nilai_sikap']->deskripsi_spiritual) : '' ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Sikap Sosial</td>
                        <td>
                            <select name="predikat_sosial" class="form-control form-control-sm">
                                <option value="">- Pilih Predikat -</option>
                                <option value="SB"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'SB') ? 'selected' : '' ?>>
                                    SB - Sangat Baik</option>
                                <option value="B"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'B') ? 'selected' : '' ?>>
                                    B - Baik</option>
                                <option value="C"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'C') ? 'selected' : '' ?>>
                                    C - Cukup</option>
                                <option value="K"
                                    <?= ($data['nilai_sikap'] && $data['nilai_sikap']->predikat_sosial == 'K') ? 'selected' : '' ?>>
                                    K - Kurang</option>
                            </select>
                            <textarea name="deskripsi_sosial" class="form-control form-control-sm mt-2" rows="3"
                                placeholder="Deskripsi sikap sosial (kejujuran, disiplin, tanggung jawab, dll)..."><?= $data['nilai_sikap'] ? htmlspecialchars($data['nilai_sikap']->deskripsi_sosial) : '' ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Ekstrakurikuler Section -->
            <div class="section-title">C. Kegiatan Ekstrakurikuler</div>
            <div class="no-print mb-2">
                <button type="button" class="btn btn-sm btn-success" onclick="tambahEkskul()">
                    <i class="fas fa-plus"></i> Tambah Ekskul
                </button>
            </div>
            <table class="ekskul-table">
                <thead>
                    <tr>
                        <th width="30%">Nama Kegiatan</th>
                        <th width="15%">Nilai</th>
                        <th width="45%">Keterangan</th>
                        <th width="10%" class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ekskulContainer">
                    <?php if(!empty($data['ekskul'])): ?>
                    <?php foreach($data['ekskul'] as $idx => $e): ?>
                    <tr class="ekskul-row fade-in">
                        <td>
                            <input type="text" name="ekskul_nama[]" placeholder="Nama Ekstrakurikuler"
                                class="form-control form-control-sm"
                                value="<?= htmlspecialchars($e->nama_ekstrakurikuler) ?>">
                        </td>
                        <td>
                            <select name="ekskul_nilai[]" class="form-control form-control-sm">
                                <option value="">- Nilai -</option>
                                <option value="Baik" <?= $e->nilai == 'Baik' ? 'selected' : '' ?>>Baik</option>
                                <option value="Cukup" <?= $e->nilai == 'Cukup' ? 'selected' : '' ?>>Cukup</option>
                                <option value="Kurang" <?= $e->nilai == 'Kurang' ? 'selected' : '' ?>>Kurang
                                </option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="ekskul_ket[]" placeholder="Keterangan"
                                class="form-control form-control-sm" value="<?= htmlspecialchars($e->keterangan) ?>">
                        </td>
                        <td class="no-print text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr class="ekskul-row fade-in">
                        <td>
                            <input type="text" name="ekskul_nama[]" placeholder="Nama Ekstrakurikuler"
                                class="form-control form-control-sm">
                        </td>
                        <td>
                            <select name="ekskul_nilai[]" class="form-control form-control-sm">
                                <option value="">- Nilai -</option>
                                <option value="Baik">Baik</option>
                                <option value="Cukup">Cukup</option>
                                <option value="Kurang">Kurang</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="ekskul_ket[]" placeholder="Keterangan"
                                class="form-control form-control-sm">
                        </td>
                        <td class="no-print text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Prestasi Section -->
            <div class="section-title">D. Prestasi</div>
            <div class="no-print mb-2">
                <button type="button" class="btn btn-sm btn-success" onclick="tambahPrestasi()">
                    <i class="fas fa-plus"></i> Tambah Prestasi
                </button>
            </div>
            <table class="prestasi-table">
                <thead>
                    <tr>
                        <th width="15%">Jenis</th>
                        <th width="35%">Nama Prestasi/Lomba</th>
                        <th width="40%">Keterangan</th>
                        <th width="10%" class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody id="prestasiContainer">
                    <?php if(!empty($data['prestasi'])): ?>
                    <?php foreach($data['prestasi'] as $idx => $p): ?>
                    <tr class="prestasi-row fade-in">
                        <td>
                            <select name="prestasi_jenis[]" class="form-control form-control-sm">
                                <option value="">- Jenis -</option>
                                <option value="Akademik" <?= $p->jenis_prestasi == 'Akademik' ? 'selected' : '' ?>>
                                    Akademik</option>
                                <option value="Non-Akademik"
                                    <?= $p->jenis_prestasi == 'Non-Akademik' ? 'selected' : '' ?>>Non-Akademik
                                </option>
                                <option value="Olahraga" <?= $p->jenis_prestasi == 'Olahraga' ? 'selected' : '' ?>>
                                    Olahraga</option>
                                <option value="Seni" <?= $p->jenis_prestasi == 'Seni' ? 'selected' : '' ?>>Seni
                                </option>
                                <option value="Lainnya" <?= $p->jenis_prestasi == 'Lainnya' ? 'selected' : '' ?>>
                                    Lainnya</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="prestasi_nama[]" placeholder="Nama Prestasi/Lomba"
                                class="form-control form-control-sm" value="<?= htmlspecialchars($p->nama_prestasi) ?>">
                        </td>
                        <td>
                            <input type="text" name="prestasi_ket[]"
                                placeholder="Keterangan (Juara 1 Tingkat Provinsi, dll)"
                                class="form-control form-control-sm" value="<?= htmlspecialchars($p->keterangan) ?>">
                        </td>
                        <td class="no-print text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr class="prestasi-row fade-in">
                        <td>
                            <select name="prestasi_jenis[]" class="form-control form-control-sm">
                                <option value="">- Jenis -</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Non-Akademik">Non-Akademik</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Seni">Seni</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="prestasi_nama[]" placeholder="Nama Prestasi/Lomba"
                                class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="text" name="prestasi_ket[]"
                                placeholder="Keterangan (Juara 1 Tingkat Provinsi, dll)"
                                class="form-control form-control-sm">
                        </td>
                        <td class="no-print text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Catatan Section -->
            <div class="section-title">E. Catatan Wali Kelas</div>
            <div class="catatan-section">
                <div class="catatan-box">
                    <textarea name="catatan" class="form-control" rows="4"
                        placeholder="Catatan perkembangan siswa, saran, dan masukan dari wali kelas..."><?= $data['catatan'] ? htmlspecialchars($data['catatan']->catatan) : '' ?></textarea>
                </div>
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div>Orang Tua/Wali</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div>Wali Kelas, <?= date('d F Y') ?></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center no-print mt-5">
                <button type="submit" class="btn btn-success btn-sm btn-action">
                    <i class="fas fa-save"></i> Simpan Semua Data Rapor
                </button>
                <button type="button" class="btn btn-primary btn-sm btn-action" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Rapor
                </button>
                <a href="<?= URLROOT ?>/siswa/rapor" class="btn btn-secondary btn-sm btn-action">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
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
    const newRow = document.createElement('tr');
    newRow.className = 'ekskul-row fade-in';
    newRow.innerHTML = `
                <td>
                    <input type="text" name="ekskul_nama[]" placeholder="Nama Ekstrakurikuler" class="form-control form-control-sm">
                </td>
                <td>
                    <select name="ekskul_nilai[]" class="form-control form-control-sm">
                        <option value="">- Nilai -</option>
                        <option value="Baik">Baik</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Kurang">Kurang</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="ekskul_ket[]" placeholder="Keterangan" class="form-control form-control-sm">
                </td>
                <td class="no-print text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
    container.appendChild(newRow);
}

// Tambah baris prestasi
function tambahPrestasi() {
    const container = document.getElementById('prestasiContainer');
    const newRow = document.createElement('tr');
    newRow.className = 'prestasi-row fade-in';
    newRow.innerHTML = `
                <td>
                    <select name="prestasi_jenis[]" class="form-control form-control-sm">
                        <option value="">- Jenis -</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Non-Akademik">Non-Akademik</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Seni">Seni</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="prestasi_nama[]" placeholder="Nama Prestasi/Lomba" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="prestasi_ket[]" placeholder="Keterangan (Juara 1 Tingkat Provinsi, dll)" class="form-control form-control-sm">
                </td>
                <td class="no-print text-center">
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
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
            btn.closest('tr').remove();
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
@media print {
    .no-print {
        display: none !important;
    }

    body {
        background: white !important;
        color: black !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
}

body {
    background-color: #f5f5f5;
    font-family: 'Times New Roman', serif;
    color: #333;
}

.rapor-container {
    max-width: 900px;
    margin: 0 auto;
    background: white;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    border-radius: 5px;
}

.header-section {
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 3px double #333;
    /* padding-bottom: 20px; */
}

.school-logo {
    width: 80px;
    height: 80px;
    margin: 0 auto 10px;
    display: block;
    padding: 10px;
}

.school-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.school-address {
    font-size: 14px;
    margin-bottom: 45px;
}

.rapor-title {
    font-size: 20px;
    font-weight: bold;
    margin: 15px 0;
    text-transform: uppercase;
}

.student-info {
    margin-bottom: 25px;
}

.info-table .row {
    display: flex;
    border-bottom: 1px solid #ddd;
    padding: 4px 0;
}

.info-table .col-md-6 {
    flex: 1;
    padding: 6px 12px;
    border-right: 1px solid #ddd;
}

.info-table .col-md-6:last-child {
    border-right: none;
}

strong {
    display: inline-block;
    width: 120px;
}

.section-title {
    font-size: 18px;
    font-weight: bold;
    margin: 25px 0 15px;
    text-transform: uppercase;
    border-bottom: 2px solid #333;
    padding-bottom: 5px;
}

.nilai-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
}

.nilai-table th,
.nilai-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

.nilai-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.nilai-table td:nth-child(2) {
    text-align: left;
}

.sikap-section {
    margin-bottom: 25px;
}

.sikap-table {
    width: 100%;
    border-collapse: collapse;
}

.sikap-table td {
    border: 1px solid #ddd;
    padding: 10px;
}

.sikap-table td:first-child {
    width: 30%;
    font-weight: bold;
    background-color: #f9f9f9;
}

.ekskul-table,
.prestasi-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
}

.ekskul-table th,
.ekskul-table td,
.prestasi-table th,
.prestasi-table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.ekskul-table th,
.prestasi-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.catatan-section {
    margin: 25px 0;
}

.catatan-box {
    border: 1px solid #ddd;
    padding: 15px;
    min-height: 100px;
}

.signature-section {
    margin-top: 40px;
    display: flex;
    justify-content: space-between;
}

.signature-box {
    width: 45%;
    text-align: center;
}

.signature-line {
    border-bottom: 1px solid #333;
    height: 40px;
    margin-bottom: 5px;
}

.btn-action {
    margin: 20px 5px;
}

.form-control-sm {
    border: 1px solid #ddd;
    border-radius: 3px;
}

.fade-in {
    animation: fadeIn 0.5s;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>