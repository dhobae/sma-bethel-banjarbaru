<div class="row">
   <div class="col">
      <div class="card card-outline card-primary" style="margin-top:15px">
         <div class="card-body tengah">
            <form method="POST" action="<?= URLROOT ?>/siswa/cari_rfid" id="rfidForm">
               <div class="mb-4">
                  <b>Silahkan Scan RFID</b>
               </div>
               <div class="mb-4">
                  <input type="text" name="nomor_rfid" class="text2" style="width:200px">
               </div>
               <div class="mb-4">
                  Halaman ini digunakan untuk mengetahui siapa pemilik kartu RFID<br />atau kartu RFID sudah terdaftar atau belum
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<script>
   $(document).ready(function() {
      $('#rfidForm').on('submit', function(event) {
         event.preventDefault();
         $.ajax({
            url: '<?= URLROOT ?>/siswa/cari_rfid',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
               Swal.fire({
                  title: 'Hasil Pencarian',
                  text: response,
                  icon: 'info',
                  confirmButtonText: 'Tutup'
               });
            },
            error: function() {
               Swal.fire({
                  title: 'Error',
                  text: 'Terjadi kesalahan, silahkan coba lagi.',
                  icon: 'error',
                  confirmButtonText: 'Tutup'
               });
            }
         });
      });
   });
</script>