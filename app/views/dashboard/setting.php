<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-info" style="margin-top:10px;">
   <div class="card-header">
      <h3 class="card-title">Pengaturan Informasi untuk halaman dashboard</h3>
   </div>

   <form class="form-horizontal" method="post" action="<?= URLROOT ?>/dashboard/simpan_setting">
      <div class="card-body">
         <div class="row">
            <div class="col-lg-8">
               <div class="mb-2">
                  <b>Informasi Aplikasi</b>
               </div>
               <textarea id="area3" style="width:100%; height:400px" name="home_dosen"><?= $data['setting']->home_dosen ?></textarea>
            </div>
            <div class="col-lg-4">
               <div class="mb-2">
                  <b>Kontak</b>
               </div>
               <textarea id="area4" style="width:90%; height:400px" name="kontak"><?= $data['setting']->kontak ?></textarea>
            </div>
         </div>
      </div>
      <div class="card-footer">
         <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
         <a href="<?= URLROOT ?>" class="btn btn-danger btn-sm float-right"><i class="fa fa-undo"></i> &nbsp;Cancel</a>
      </div>
   </form>
</div>





<script src="<?= URLROOT; ?>/js/nicEdit.js"></script>
<script type="text/javascript">
   var iconsPath = '<?= URLROOT ?>/js/nicEditorIcons.gif';
</script>
<script type="text/javascript">
   bkLib.onDomLoaded(function() {
      new nicEditor({
         iconsPath: iconsPath
      }).panelInstance('area3');

      function untuk_edit(modalId) {
         new nicEditor({
            iconsPath: iconsPath
         }).panelInstance('area3_' + modalId);
      }

      $('.modal').on('shown.bs.modal', function() {
         var modalId = $(this).attr('id').replace('edit', '');
         untuk_edit(modalId);
      });

      //--AREA 4
      new nicEditor({
         iconsPath: iconsPath
      }).panelInstance('area4');

      //--AREA 5
      new nicEditor({
         iconsPath: iconsPath
      }).panelInstance('area5');

      //--AREA kesimpulan
      new nicEditor({
         iconsPath: iconsPath
      }).panelInstance('area_kesimpulan');

   });
</script>