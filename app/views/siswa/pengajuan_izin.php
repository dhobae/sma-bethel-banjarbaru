<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="row">
   <div class="col">
      <div class="card card-outline card-danger" style="margin-top: 15px" ;>
         <div class="card-header">
            <h5><b>Pengajuan Izin Tidak masuk sekolah</b></h5>
         </div>
         <div class="card-body">
            <div class="mb-3">
               <button type="button" class="btn btn-primary btn-sm tombol2" title="Buat pengajuan izin baru" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus-square"></i> &nbsp;Buat Pengajuan Izin baru</button>
            </div>
            <div class="table-responsive">
               <table class="tabel2 table table-bordered khusus">
                  <thead>
                     <tr style="height:40px; text-align:center">
                        <th style="width:45px">No</th>
                        <th style="width:13%">Tanggal Dibuat</th>
                        <th style="width:10%">Status Izin</th>
                        <th style="width:13%">Izin<br />Mulai Tanggal</th>
                        <th style="width:13%">Izin<br />Sampai Tanggal</th>
                        <th style="width:10%">Bukti</th>
                        <th>Keterangan</th>
                        <th style="width:11%">Status</th>
                        <th style="width:50px">#</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1;
                     if ($data['izin']) {
                        foreach ($data['izin'] as $d) : ?>
                           <tr>
                              <td class="text-center"><?= $no ?></td>
                              <td class="text-center"><?= date4ID($d->tgl_dibuat_izin) ?></td>
                              <td class="text-center"><?= $d->jenis_izin ?></td>
                              <td class="text-center"><?= date4ID($d->mulai_izin) ?></td>
                              <td class="text-center"><?= date4ID($d->sampai_izin) ?></td>
                              <td class="text-center d-flex justify-content-center">
                              <?php 
                                $ext = strtolower(pathinfo($d->file_izin, PATHINFO_EXTENSION));
                                $isPdf = ($ext === 'pdf');
                                $filePath = URLROOT . '/smabethel/file_izin/' . $d->file_izin;
                                ?>

                                <?php if ($isPdf) : ?>
                                <!-- Thumbnail PDF -->
                                <div style="width: 80px; height: 80px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; cursor: pointer; background: #f8f9fa;"
                                        data-toggle="modal"
                                        data-target="#modalBukti"
                                        data-file="<?= $filePath ?>"
                                        data-type="pdf"
                                        data-name="<?= $d->file_izin ?>">
                                    <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                </div>
                                <?php else : ?>
                                <!-- Thumbnail Gambar -->
                                <img src="<?= $filePath ?>"
                                        alt="Bukti"
                                        class="img-thumbnail"
                                        style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                        data-toggle="modal"
                                        data-target="#modalBukti"
                                        data-file="<?= $filePath ?>"
                                        data-type="image"
                                        data-name="<?= $d->file_izin ?>">
                                <?php endif; ?>
                              </td>
                              <td><?= $d->alasan_izin ?></td>
                              <td class="text-center">
                                 <?php if ($d->status_izin == 'Menunggu ACC') {
                                    echo "<span style='color:orange; font-weight:bold'>" . $d->status_izin . "</span>";
                                 } else if ($d->status_izin == 'Disetujui') {
                                    echo "<span style='color:green; font-weight:bold'>" . $d->status_izin . "</span>";
                                    echo "<div style='font-size:12px; line-height:18px' class='mt-1'>";
                                    echo "Ttd.<br/>";
                                    echo $d->wali_kelas_izin;
                                    echo "</div>";
                                 } else if ($d->status_izin == 'Ditolak') {
                                    echo "<span style='color:red; font-weight:bold'>" . $d->status_izin . "</span>";
                                    echo "<div style='font-size:12px; line-height:18px' class='mt-1'>";
                                    echo "Ttd.<br/>";
                                    echo $d->wali_kelas_izin;
                                    echo "</div>";
                                 }
                                 ?>
                              </td>
                              <td class="text-center" style="padding-left:0px !important; padding-right:0px !important;">
                                 <?php if ($d->status_izin == 'Menunggu ACC') { ?>
                                    <a href="javascript:void(0)" title="Edit permohonan" style="font-size:0.88em" data-toggle="modal" data-target="#edit<?= $d->id_izin ?>"><i class="fa fa-edit"></i></a>

                                    <a href="javascript:void(0)" onclick="hapus('<?= $d->id_izin ?>')" title="Hapus permohonan" style="font-size:0.88em"><i class="fa fa-trash"></i></a>
                                 <?php } else { ?>
                                    <a href="javascript:void(0)" title="Edit permohonan" class="disabled" style="font-size:0.88em"><i class="fa fa-edit"></i></a>
                                    <a href="#" title="Hapus permohonan" style="font-size:0.88em" class="disabled"><i class="fa fa-trash"></i></a>
                                 <?php } ?>
                              </td>
                           </tr>
                        <?php $no++;
                        endforeach;
                     } else { ?>
                        <tr>
                           <td colspan="8" style="height:100px; text-align:center; vertical-align:middle; font-weight:bold; font-size:1.5em">Anda belum pernah mengajukan izin</td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal edit -->
<?php foreach ($data['izin'] as $d) : ?>
   <div class="modal fade" id="edit<?= $d->id_izin ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Izin tidak masuk sekolah</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form method="POST" action="<?= URLROOT ?>/siswa/simpan_edit_izin_siswa" enctype="multipart/form-data">
               <div class="modal-body" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9em">

                  <input type="hidden" name="id_izin" value="<?= $d->id_izin ?>">

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Tanggal Dibuat</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" value="<?= $d->tgl_dibuat_izin ?>" readonly>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Mulai Izin</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" name="mulai_izin" value="<?= $d->mulai_izin ?>" required>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Sampai dengan</label>
                     <div class="col-sm-5">
                        <input type="date" class="form-control text1" name="sampai_izin" value="<?= $d->sampai_izin ?>" required>
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Jenis Izin</label>
                     <div class="col-sm-5">
                        <select name="jenis_izin" class="form-control text1" required>
                           <option value="">~Pilih~</option>
                           <option value="Izin" <?= ($d->jenis_izin == 'Izin') ? 'selected' : '' ?>>Izin</option>
                           <option value="Sakit" <?= ($d->jenis_izin == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                        </select>
                     </div>
                  </div>

                
                  <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Bukti Yang Telah Ada</label>
                        <div class="col-sm-5">
                            <?php 
                            $ext = strtolower(pathinfo($d->file_izin, PATHINFO_EXTENSION));
                            $isPdf = ($ext === 'pdf');
                            $filePath = URLROOT . '/smabethel/file_izin/' . $d->file_izin;
                            ?>
                            
                            <?php if ($isPdf) : ?>
                                <!-- Preview PDF dengan iframe -->
                                <div class="pdf-preview-container">
                                    <iframe src="<?= $filePath ?>" style="width: 100%; height: 200px; border: 1px solid #ddd;"></iframe>
                                </div>
                                <div class="mt-2">
                                    <a href="<?= $filePath ?>" target="_blank" class="btn btn-sm btn-primary mb-2">
                                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                                    </a>
                                    <a href="<?= $filePath ?>" download class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            <?php else : ?>
                                <!-- Preview Gambar -->
                                <img src="<?= $filePath ?>" alt="Bukti" style="width: 210px; border: 1px solid #ddd; padding: 5px;">
                            <?php endif; ?>
                        </div>
                    </div>


                  <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Bukti Baru
                     <small style="display:block;">(Jika Perlu)</small>
                  </label>
                     <div class="col-sm-9">
                        <input type="file" name="file_izin">
                     </div>
                  </div>

                  <div class="form-group row">
                     <label class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control text1" value="<?= $d->alasan_izin ?>" name="keterangan">
                     </div>
                  </div>

               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php endforeach; ?>

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Izin tidak masuk sekolah</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <form method="POST" action="<?= URLROOT ?>/siswa/simpan_izin_siswa" enctype="multipart/form-data">
            <div class="modal-body" style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9em">

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tanggal Dibuat</label>
                  <div class="col-sm-5">
                     <input type="date" class="form-control text1" value="<?= date('Y-m-d') ?>" readonly>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Mulai Izin</label>
                  <div class="col-sm-5">
                     <input type="date" class="form-control text1" name="mulai_izin" required>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Sampai dengan</label>
                  <div class="col-sm-5">
                     <input type="date" class="form-control text1" name="sampai_izin" required>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Jenis Izin</label>
                  <div class="col-sm-5">
                     <select name="jenis_izin" class="form-control text1" required>
                        <option value="">~Pilih~</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                     </select>
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Bukti</label>
                  <div class="col-sm-9">
                     <input type="file" name="file_izin">
                  </div>
               </div>

               <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Keterangan</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control text1" name="keterangan">
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-undo"></i> &nbsp;Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> &nbsp;Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Modal Detail Bukti Izin -->
<div class="modal fade" id="modalBukti" tabindex="-1" role="dialog" aria-labelledby="modalBuktiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">

      <!-- Header Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalBuktiLabel">Bukti - <span id="fileName"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Body Modal -->
      <div class="modal-body">
        <!-- Preview Gambar -->
        <div id="imagePreview" class="text-center" style="display: none;">
          <img src="" id="previewGambar" class="img-fluid rounded shadow" alt="Bukti" style="max-height: 70vh;">
        </div>

        <!-- Preview PDF -->
        <div id="pdfPreview" style="display: none;">
          <div class="text-center mb-3">
            <button class="btn btn-sm btn-secondary" onclick="prevPageModal()" id="prev-btn-modal">
              <i class="fas fa-chevron-left"></i> Sebelumnya
            </button>
            <span class="mx-3">
              Halaman: <span id="page-num-modal"></span> / <span id="page-count-modal"></span>
            </span>
            <button class="btn btn-sm btn-secondary" onclick="nextPageModal()" id="next-btn-modal">
              Selanjutnya <i class="fas fa-chevron-right"></i>
            </button>
          </div>
          <div id="pdf-container-modal" style="overflow: auto; max-height: 600px; text-align: center; background: #e9ecef; padding: 10px;">
            <canvas id="pdf-canvas-modal"></canvas>
          </div>
        </div>
      </div>

      <!-- Footer Modal -->
      <div class="modal-footer">
        <a href="" id="downloadLink" target="_blank" class="btn btn-primary">
          <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
        </a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>

<script>
// PDF.js configuration
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

let pdfDocModal = null;
let pageNumModal = 1;
let pageRenderingModal = false;
let pageNumPendingModal = null;
const scaleModal = 1.3;
let canvasModal = null;
let ctxModal = null;

// Handle modal open
$(document).on('click', '[data-target="#modalBukti"]', function(){
  var fileUrl = $(this).data('file');
  var fileType = $(this).data('type');
  var fileName = $(this).data('name');
  
  $('#fileName').text(fileName);
  $('#downloadLink').attr('href', fileUrl);
  
  if (fileType === 'pdf') {
    // Show PDF preview
    $('#imagePreview').hide();
    $('#pdfPreview').show();
    
    // Initialize canvas
    canvasModal = document.getElementById('pdf-canvas-modal');
    ctxModal = canvasModal.getContext('2d');
    
    // Load PDF
    loadPdfModal(fileUrl);
  } else {
    // Show image preview
    $('#pdfPreview').hide();
    $('#imagePreview').show();
    $('#previewGambar').attr('src', fileUrl);
  }
});

// Reset modal on close
$('#modalBukti').on('hidden.bs.modal', function () {
  pdfDocModal = null;
  pageNumModal = 1;
  $('#previewGambar').attr('src', '');
  if (canvasModal) {
    ctxModal.clearRect(0, 0, canvasModal.width, canvasModal.height);
  }
});

function loadPdfModal(url) {
  pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
    pdfDocModal = pdfDoc_;
    document.getElementById('page-count-modal').textContent = pdfDocModal.numPages;
    pageNumModal = 1;
    renderPageModal(pageNumModal);
    updateButtonStatesModal();
  }).catch(function(error) {
    console.error('Error loading PDF:', error);
    document.getElementById('pdf-container-modal').innerHTML = 
      '<div class="alert alert-danger">Gagal memuat PDF. Silakan buka di tab baru.</div>';
  });
}

function renderPageModal(num) {
  pageRenderingModal = true;
  
  pdfDocModal.getPage(num).then(function(page) {
    const viewport = page.getViewport({scale: scaleModal});
    canvasModal.height = viewport.height;
    canvasModal.width = viewport.width;

    const renderContext = {
      canvasContext: ctxModal,
      viewport: viewport
    };
    
    const renderTask = page.render(renderContext);

    renderTask.promise.then(function() {
      pageRenderingModal = false;
      if (pageNumPendingModal !== null) {
        renderPageModal(pageNumPendingModal);
        pageNumPendingModal = null;
      }
    });
  });

  document.getElementById('page-num-modal').textContent = num;
}

function queueRenderPageModal(num) {
  if (pageRenderingModal) {
    pageNumPendingModal = num;
  } else {
    renderPageModal(num);
  }
}

function prevPageModal() {
  if (pageNumModal <= 1) return;
  pageNumModal--;
  queueRenderPageModal(pageNumModal);
  updateButtonStatesModal();
}

function nextPageModal() {
  if (pageNumModal >= pdfDocModal.numPages) return;
  pageNumModal++;
  queueRenderPageModal(pageNumModal);
  updateButtonStatesModal();
}

function updateButtonStatesModal() {
  document.getElementById('prev-btn-modal').disabled = (pageNumModal <= 1);
  document.getElementById('next-btn-modal').disabled = (pageNumModal >= pdfDocModal.numPages);
}
</script>


<script>
   function hapus(id) {
      console.log(id)
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Anda tidak bisa mengembalikan data yang dihapus!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/siswa/hapus_pengajuan_izin/' + id,
               type: 'GET',
               dataType: 'json',

               success: function(response) {
                  if (response.status == 'success') {
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        location.reload();
                     });
                  } else {
                     Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error'
                     });
                  }
               }
            });
         }
      });
   }
</script>

<style>
   .khusus td {
      padding: 7px !important;
   }
</style>