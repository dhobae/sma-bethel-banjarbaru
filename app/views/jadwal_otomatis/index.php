<?php
function toRomawi($angka)
{
    $map = [
        1 => 'I',
        2 => 'II',
    ];

    return $map[$angka] ?? $angka;
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white p-3">
                    <h4 class="mb-0"><i class="fas fa-cogs mr-2"></i> Generate Jadwal Otomatis</h4>
                </div>
                <div class="card-body">
                    <?php flash('jadwal_message'); ?>

                    <!-- Info Jadwal Aktif -->
                    <?php if (!empty($data['tahun_ajaran_aktif'])): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Jadwal Aktif Saat Ini:</strong>
                            Tahun Ajaran <?php echo $data['tahun_ajaran_aktif']; ?> -
                            Semester <?php echo $data['semester_aktif']; ?> -
                            Blok <?php echo $data['blok_aktif']; ?>
                            (Berlaku dari: <?php echo date('d/m/Y', strtotime($data['jadwal_aktif'])); ?>)
                        </div>
                    <?php endif; ?>

                    <?php if ($data['wali_kelas_tersedia']): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Wali Kelas:</strong> Sistem akan mempertahankan wali kelas lama jika sudah ada.
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Generate Jadwal Baru</h5>
                        </div>
                        <div class="card-body">
                            <form id="generateForm" action="<?= URLROOT; ?>/jadwal_otomatis/generateSchedule"
                                method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="semester">Semester</label>
                                            <select class="form-control" id="semester" name="semester">
                                                <option value="" disabled selected>-- Pilih --</option>
                                                <option value="Ganjil">Ganjil</option>
                                                <option value="Genap">Genap</option>
                                            </select>
                                            <small class="form-text text-muted">Gunakan Semester Ganjil jika Blok &#8544
                                                dan Sebaliknya.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="blok">Blok</label>
                                            <select class="form-control" id="blok" name="blok">
                                                <option value="" disabled selected>-- Pilih --</option>
                                                <option value="I">&#8544</option>
                                                <option value="II">&#8545</option>
                                            </select>
                                            <small class="form-text text-muted">Gunakan Blok &#8544 Jika Semester Ganjil
                                                dan Sebaliknya.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="berlaku_jadwal_dari">Tanggal Berlaku Jadwal <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="berlaku_jadwal_dari"
                                                name="berlaku_jadwal_dari" required>
                                            <small class="form-text text-muted">Tanggal mulai berlakunya jadwal baru
                                                (tahun ajar yaitu tahun sekarang + 1)</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <strong>Perhatian:</strong> Sistem akan otomatis membuat jadwal baru, dan
                                            mengaktifkan jadwal baru secara langsung.
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h6><strong>Pengaturan Mata Pelajaran Hanya Ada Pada Kelas Tertentu</strong>
                                            <small style="color:gray;"> [*kosongkan jika tidak perlu]</small>
                                        </h6>

                                        <!-- Mata pelajaran untuk kelas X -->
                                        <div class="row align-items-start mb-3">
                                            <div class="col-md-6">
                                                <label>Pilih Mata Pelajaran Hanya untuk Kelas X</label>
                                                <select name="mata_pelajaran_untuk_kelas_x[]" style="width:100%"
                                                    class="jadwal pilihjadwal" multiple="multiple">
                                                    <?php foreach ($data['mata_pelajaran'] as $mapel): ?>
                                                        <option value="<?= $mapel->id_pelajaran ?>">
                                                            <?= $mapel->mata_pelajaran ?> (<?= $mapel->singkatan ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="form-text text-muted">Mata pelajaran yang dipilih HANYA
                                                    akan ada di kelas X</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Kelas Target</label>
                                                <input type="text" value="X (Kelas 10)" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <!-- Mata pelajaran untuk kelas XI -->
                                        <div class="row align-items-start mb-3">
                                            <div class="col-md-6">
                                                <label>Pilih Mata Pelajaran Hanya untuk Kelas XI</label>
                                                <select name="mata_pelajaran_untuk_kelas_xi[]" style="width:100%"
                                                    class="jadwal pilihjadwal" multiple="multiple">
                                                    <?php foreach ($data['mata_pelajaran'] as $mapel): ?>
                                                        <option value="<?= $mapel->id_pelajaran ?>">
                                                            <?= $mapel->mata_pelajaran ?> (<?= $mapel->singkatan ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="form-text text-muted">Mata pelajaran yang dipilih HANYA
                                                    akan ada di kelas XI</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Kelas Target</label>
                                                <input type="text" value="XI (Kelas 11)" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <!-- Mata pelajaran untuk kelas XII -->
                                        <div class="row align-items-start mb-3">
                                            <div class="col-md-6">
                                                <label>Pilih Mata Pelajaran Hanya untuk Kelas XII</label>
                                                <select name="mata_pelajaran_untuk_kelas_xii[]" style="width:100%"
                                                    class="jadwal pilihjadwal" multiple="multiple">
                                                    <?php foreach ($data['mata_pelajaran'] as $mapel): ?>
                                                        <option value="<?= $mapel->id_pelajaran ?>">
                                                            <?= $mapel->mata_pelajaran ?> (<?= $mapel->singkatan ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="form-text text-muted">Mata pelajaran yang dipilih HANYA
                                                    akan ada di kelas XII</small>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Kelas Target</label>
                                                <input type="text" value="XII (Kelas 12)" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" name="generate_schedule" class="btn btn-primary">
                                            <i class="fas fa-play mr-2"></i>Generate Jadwal
                                        </button>
                                        <a href="<?php echo URLROOT; ?>/jadwal" class="btn btn-secondary">
                                            <i class="fas fa-list mr-2"></i>Lihat Jadwal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-4" id="progressCard" style="display: none;">
                        <div class="card-header">
                            <h5 class="mb-0">Proses Algoritma Genetika</h5>
                        </div>
                        <div class="card-body">
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    role="progressbar" style="width: 0%" id="progress-bar">0%</div>
                            </div>
                            <div id="status-message" class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>Memulai proses...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('generateForm');
        const progressCard = document.getElementById('progressCard');
        const progressBar = document.getElementById('progress-bar');
        const statusMessage = document.getElementById('status-message');
        const berlakuInput = document.getElementById('berlaku_jadwal_dari');
        // const tahunAjaranInput = document.getElementById('tahun_ajaran');
        const semesterInput = document.getElementById('semester');
        const blokInput = document.getElementById('blok');

        console.log(new FormData(form));

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Validasi tahun ajaran format jika diisi
                // const tahunAjaranVal = tahunAjaranInput.value.trim();
                // if (tahunAjaranVal && !/^\d{4}\/\d{4}$/.test(tahunAjaranVal)) {
                //     alert('Format tahun ajaran harus YYYY/YYYY (contoh: 2025/2026)');
                //     return;
                // }

                // Tampilkan card progress
                progressCard.style.display = 'block';
                form.style.display = 'none';

                // Scroll ke progress card
                progressCard.scrollIntoView({
                    behavior: 'smooth'
                });

                let progress = 0;
                const interval = setInterval(function () {
                    progress += Math.random() * 15;
                    if (progress > 90) progress = 90; // Berhenti di 90%, tunggu server

                    progressBar.style.width = progress + '%';
                    progressBar.textContent = Math.round(progress) + '%';

                    if (progress < 20) {
                        statusMessage.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Menyiapkan tahun ajaran dan jadwal setting...';
                    } else if (progress < 40) {
                        statusMessage.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Menginisialisasi populasi awal...';
                    } else if (progress < 65) {
                        statusMessage.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Melakukan evolusi dan optimasi...';
                    } else if (progress < 85) {
                        statusMessage.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Mengevaluasi jadwal terbaik...';
                    } else {
                        statusMessage.innerHTML =
                            '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan jadwal ke database...';
                    }
                }, 300);

                // Submit form asli ke server
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form)
                })
                    .then(response => response.json()) // Parse JSON response
                    .then(data => {
                        clearInterval(interval);
                        progressBar.style.width = '100%';
                        progressBar.textContent = '100%';

                        // Cek tipe response
                        if (data.type === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: data.title || 'Gagal',
                                text: data.message || 'Terjadi kesalahan saat membuat jadwal',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Kembalikan tampilan form
                                progressCard.style.display = 'none';
                                form.style.display = 'block';
                                statusMessage.className = 'alert alert-info';
                            });
                        } else if (data.type === 'success') {
                            statusMessage.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Jadwal berhasil dibuat!';
                            statusMessage.className = 'alert alert-success';

                            Swal.fire({
                                icon: 'success',
                                title: data.title || 'Berhasil',
                                text: data.message || 'Jadwal berhasil dibuat dan telah diaktifkan.',
                                confirmButtonText: 'Lihat Jadwal',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed && data.redirect) {
                                    window.location.href = data.redirect;
                                }
                            });
                        } else {
                            // Response tidak sesuai format
                            throw new Error('Format response tidak valid');
                        }
                    })
                    .catch(error => {
                        clearInterval(interval);
                        console.error('Error:', error);

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menghubungi server. Silakan coba lagi.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            progressCard.style.display = 'none';
                            form.style.display = 'block';
                            statusMessage.className = 'alert alert-info';
                        });
                    });
            });
        }
    });
</script>