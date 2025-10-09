<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-body">
            <div class="col-md-12">
                <?php flash(); ?>
              <form action="<?= URLROOT; ?>/help/add" method="POST" enctype="multipart/form-data">
              <div class="form-group row">
                  <label for="subjek" class="col-sm-2 col-form-label">Subjek</label>
                  <div class="col-sm-6">
                  <input type="text" class="form-control" id="subjek" name="subjek" >
                  </div>
              </div>
              <div class="form-group row">
                <label for="laporan" class="col-sm-2 col-form-label">Laporan</label>
                <div class="col-sm-6">
                  <textarea type="text" name="laporan" required class="form-control" id="laporan"></textarea>
                </div>
              </div>
              <div class="pb-4"></div>
              <div class="form-group row">
                  <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                  <a href="<?= URLROOT; ?>/help" class="btn btn-danger">Kembali</a>
                  </div>
              </div>
              </form>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>