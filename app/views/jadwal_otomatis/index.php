<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-cogs me-2"></i>Generate Jadwal Otomatis</h4>
                </div>
                <div class="card-body">
                    <?php flash('jadwal_message'); ?>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Batasan (Hard Constraint)</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex align-items-start">
                                            <i class="fas fa-user-clock text-danger me-2 mt-1"></i>
                                            <div>
                                                <strong>Guru tidak boleh mengajar di 2 waktu yang sama</strong>
                                                <p class="mb-0 text-muted small">Seorang guru hanya dapat mengajar satu
                                                    kelas pada satu waktu tertentu.</p>
                                            </div>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start">
                                            <i class="fas fa-chalkboard-teacher text-danger me-2 mt-1"></i>
                                            <div>
                                                <strong>Kelas tidak boleh memiliki 2 pelajaran di waktu yang
                                                    sama</strong>
                                                <p class="mb-0 text-muted small">Satu kelas hanya dapat memiliki satu
                                                    mata pelajaran pada satu waktu tertentu.</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Parameter Algoritma Genetika</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Ukuran Populasi
                                            <span class="badge bg-primary rounded-pill">50</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Generasi Maksimal
                                            <span class="badge bg-primary rounded-pill">100</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tingkat Mutasi
                                            <span class="badge bg-primary rounded-pill">10%</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Tingkat Crossover
                                            <span class="badge bg-primary rounded-pill">80%</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Ukuran Elitisme
                                            <span class="badge bg-primary rounded-pill">5</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Generate Jadwal Baru</h5>
                        </div>
                        <div class="card-body">
                            <form id="generateForm" action="<?php echo URLROOT; ?>/jadwal_otomatis/generateSchedule"
                                method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="berlaku_jadwal_dari">Tanggal Berlaku Jadwal</label>
                                            <input type="date" class="form-control" id="berlaku_jadwal_dari"
                                                name="berlaku_jadwal_dari" value="<?php echo date('Y-m-d'); ?>"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" name="generate_schedule" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Generate Jadwal
                                        </button>
                                        <a href="<?php echo URLROOT; ?>/jadwal" class="btn btn-secondary">
                                            <i class="fas fa-list me-2"></i>Lihat Jadwal
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
                                <i class="fas fa-info-circle me-2"></i>Memulai proses...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('generateForm');
    const progressCard = document.getElementById('progressCard');
    const progressBar = document.getElementById('progress-bar');
    const statusMessage = document.getElementById('status-message');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Tampilkan card progress
            progressCard.style.display = 'block';
            form.style.display = 'none';

            // Scroll ke progress card
            progressCard.scrollIntoView({
                behavior: 'smooth'
            });

            let progress = 0;
            const interval = setInterval(function() {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90; // Berhenti di 90%, tunggu server

                progressBar.style.width = progress + '%';
                progressBar.textContent = Math.round(progress) + '%';

                if (progress < 30) {
                    statusMessage.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-2"></i>Menginisialisasi populasi awal...';
                } else if (progress < 60) {
                    statusMessage.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-2"></i>Melakukan evolusi dan optimasi...';
                } else if (progress < 90) {
                    statusMessage.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-2"></i>Mengevaluasi jadwal terbaik...';
                } else {
                    statusMessage.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan jadwal ke database...';
                }
            }, 300);

            // Submit form asli ke server
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            }).then(response => {
                clearInterval(interval);
                progressBar.style.width = '100%';
                progressBar.textContent = '100%';
                statusMessage.innerHTML =
                    '<i class="fas fa-check-circle me-2"></i>Jadwal berhasil dibuat!';
                statusMessage.className = 'alert alert-success';

                // Redirect setelah jeda singkat
                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 1000);
            }).catch(error => {
                clearInterval(interval);
                statusMessage.innerHTML =
                    '<i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan. Silakan coba lagi.';
                statusMessage.className = 'alert alert-danger';
                form.style.display = 'block';
            });
        });
    }
});
</script>