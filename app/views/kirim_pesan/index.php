<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="col-md-12">
                <?php flash(); ?>
              <form action="<?= URLROOT; ?>/kirimpesan" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                  <label for="nomor" class="col-sm-2 col-form-label">Nomor WhatsApp (Hanya 1 Saja)</label>
                  <div class="col-sm-6">
                  <input type="text" class="form-control" id="nomor" name="nomor" >
                  </div>
              </div>
              <div class="form-group row">
                <label for="pesan" class="col-sm-2 col-form-label">Pesan</label>
                <div class="col-sm-6">
                  <textarea type="text" name="pesan" required class="form-control" id="pesan"></textarea>
                </div>
              </div>
              <div class="pb-4"></div>
              <div class="form-group row">
                  <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                  </div>
              </div>
              </form>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>