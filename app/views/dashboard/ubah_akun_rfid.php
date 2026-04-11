<?php sflash() ?>

<div class="container">
    <div class="card card-info" style="margin-top:10px;">
        <div class="card-header">
            <h3 class="card-title">Ubah Password/Sandi Akun RFID</h3>
        </div>
        <form method="POST" action="<?= URLROOT ?>/dashboard/simpan_akun_rfid">
            <div class="card-body">
                <?php if (empty($data['akun_rfid'])) : ?>
                    <div class="alert alert-warning">Data akun RFID tidak ditemukan.</div>
                <?php else : ?>
                    <div class="row">   
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK User</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data['akun_rfid']->nik_user, ENT_QUOTES) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data['akun_rfid']->username, ENT_QUOTES) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama User</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data['akun_rfid']->nama_user, ENT_QUOTES) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data['akun_rfid']->role, ENT_QUOTES) ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" class="form-control" name="password_baru" required minlength="6" placeholder="Masukkan password baru">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="konfirmasi_password" required minlength="6" placeholder="Ulangi password baru">
                            </div>
                        </div>
                        <div class="col">
                            <b>*hanya password yang dapat diganti</b>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= URLROOT ?>/dashboard" class="btn btn-danger btn-sm float-right"><i class="fa fa-undo"></i> Batal</a>
            </div>
        </form>
    </div>
</div>

