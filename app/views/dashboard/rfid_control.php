<?php
// Halaman Kontrol Jadwal RFID untuk Admin
$now = date('H:i:s');
$masuk_buka = $data['rfid_status']->rfid_masuk_buka;
$masuk_tutup = $data['rfid_status']->rfid_masuk_tutup;
$pulang_buka = $data['rfid_status']->rfid_pulang_buka;
$pulang_tutup = $data['rfid_status']->rfid_pulang_tutup;

$masuk_aktif = ($now >= $masuk_buka && $now <= $masuk_tutup);
$pulang_aktif = ($now >= $pulang_buka && $now <= $pulang_tutup);
?>
<!-- Status Saat Ini -->
<div class="row mb-2 mt-3">
   <div class="col-md-6">
      <div class="info-box <?= $masuk_aktif ? 'bg-success' : 'bg-danger' ?>">
         <span class="info-box-icon"><i class="fas fa-sign-in-alt"></i></span>
         <div class="info-box-content">
            <span class="info-box-text">RFID Masuk</span>
            <span class="info-box-number"><?= $masuk_aktif ? 'TERBUKA' : 'TERTUTUP' ?></span>
            <span class="info-box-text"><?= substr($masuk_buka, 0, 5) ?> - <?= substr($masuk_tutup, 0, 5) ?></span>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="info-box <?= $pulang_aktif ? 'bg-success' : 'bg-danger' ?>">
         <span class="info-box-icon"><i class="fas fa-sign-out-alt"></i></span>
         <div class="info-box-content">
            <span class="info-box-text">RFID Pulang</span>
            <span class="info-box-number"><?= $pulang_aktif ? 'TERBUKA' : 'TERTUTUP' ?></span>
            <span class="info-box-text"><?= substr($pulang_buka, 0, 5) ?> - <?= substr($pulang_tutup, 0, 5) ?></span>
         </div>
      </div>
   </div>
</div>

<!-- Form Pengaturan Jadwal -->
<div class="row">
   <div class="col-12">
      <div class="card card-primary card-outline">
         <div class="card-header">
            <h3 class="card-title"><i class="fas fa-clock"></i> Pengaturan Jadwal RFID</h3>
         </div>
         <form method="POST" action="<?= URLROOT ?>/dashboard/simpan_rfid_jadwal">
            <div class="card-body">
               <div class="row">
                  <!-- RFID Masuk -->
                  <div class="col-md-6">
                     <div class="card card-outline card-info">
                        <div class="card-header">
                           <h5 class="card-title"><i class="fas fa-sign-in-alt"></i> RFID Masuk</h5>
                        </div>
                        <div class="card-body">
                           <div class="form-group">
                              <label for="rfid_masuk_buka"><i class="fas fa-door-open text-success"></i> Jam Buka</label>
                              <input type="time" class="form-control" id="rfid_masuk_buka" name="rfid_masuk_buka" 
                                 value="<?= substr($masuk_buka, 0, 5) ?>" required>
                              <small class="text-muted">RFID mulai menerima tap kartu masuk</small>
                           </div>
                           <div class="form-group">
                              <label for="rfid_masuk_tutup"><i class="fas fa-door-closed text-danger"></i> Jam Tutup</label>
                              <input type="time" class="form-control" id="rfid_masuk_tutup" name="rfid_masuk_tutup" 
                                 value="<?= substr($masuk_tutup, 0, 5) ?>" required>
                              <small class="text-muted">RFID berhenti menerima tap kartu masuk</small>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- RFID Pulang -->
                  <div class="col-md-6">
                     <div class="card card-outline card-warning">
                        <div class="card-header">
                           <h5 class="card-title"><i class="fas fa-sign-out-alt"></i> RFID Pulang</h5>
                        </div>
                        <div class="card-body">
                           <div class="form-group">
                              <label for="rfid_pulang_buka"><i class="fas fa-door-open text-success"></i> Jam Buka</label>
                              <input type="time" class="form-control" id="rfid_pulang_buka" name="rfid_pulang_buka" 
                                 value="<?= substr($pulang_buka, 0, 5) ?>" required>
                              <small class="text-muted">RFID mulai menerima tap kartu pulang</small>
                           </div>
                           <div class="form-group">
                              <label for="rfid_pulang_tutup"><i class="fas fa-door-closed text-danger"></i> Jam Tutup</label>
                              <input type="time" class="form-control" id="rfid_pulang_tutup" name="rfid_pulang_tutup" 
                                 value="<?= substr($pulang_tutup, 0, 5) ?>" required>
                              <small class="text-muted">RFID berhenti menerima tap kartu pulang</small>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-footer text-right">
               <button type="submit" class="btn btn-primary btn-sm">
                  Simpan Jadwal RFID
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="callout callout-info">
         <h5><i class="fas fa-info-circle"></i> Informasi</h5>
         <ul class="mb-0">
            <li>RFID <strong>Masuk</strong> akan otomatis <strong>terbuka</strong> pada jam buka dan <strong>tertutup</strong> pada jam tutup yang diatur</li>
            <li>RFID <strong>Pulang</strong> akan otomatis <strong>terbuka</strong> pada jam buka dan <strong>tertutup</strong> pada jam tutup yang diatur</li>
            <li>Di luar jam yang diatur, tap kartu RFID akan <strong>ditolak</strong> secara otomatis</li>
            <li>Waktu server saat ini: <strong id="jam-server"></strong></li>
         </ul>
      </div>
   </div>
</div>

<script>
   function updateJam() {
      const now = new Date();
      let jam = String(now.getHours()).padStart(2, '0');
      let menit = String(now.getMinutes()).padStart(2, '0');
      let detik = String(now.getSeconds()).padStart(2, '0');
      document.getElementById('jam-server').textContent = jam + ':' + menit + ':' + detik;
   }
   updateJam();
   setInterval(updateJam, 1000);
</script>