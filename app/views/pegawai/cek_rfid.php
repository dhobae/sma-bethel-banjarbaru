<div class="row">
   <div class="col">
      <div class="card card-outline card-primary" style="margin-top:15px">
         <div class="card-body tengah">
            <form method="POST" action="<?= URLROOT ?>/pegawai/cari_rfid" id="rfidForm">
               <div class="mb-4">
                  <b>Silahkan Scan RFID</b>
               </div>
               <div class="mb-4">
                  <input type="text" 
                     name="nomor_rfid" 
                     id="rfidInput"
                     class="text2" 
                     style="width:200px; text-align:center;"
                     autocomplete="off"
                     readonly
                     placeholder="TEMPELKAN KARTU RFID">
               </div>
               <div class="mb-4">
                  Halaman ini digunakan untuk mengetahui siapa pemilik kartu RFID<br />atau kartu RFID sudah terdaftar atau belum (KHUSUS PEGAWAI)
               </div>
            </form>
         </div>
      </div>
   </div>
</div>


<script>
$(document).ready(function() {

   const input = $('#rfidInput');
   const form  = $('#rfidForm');

   let buffer = '';
   let lastTime = new Date().getTime();
   let isProcessing = false;

   function focusInput() {
      input.focus();
   }
   focusInput();
   $(document).on('click', function() {
      focusInput();
   });

   $(document).on('keydown', function(e) {
      if (isProcessing) return;
      const currentTime = new Date().getTime();
      if (currentTime - lastTime > 100) {
         buffer = '';
      }
      lastTime = currentTime;
      if (e.key === 'Enter') {
         e.preventDefault();
         if (buffer.trim() === '') return;
         input.val(buffer);
         buffer = '';

         form.submit();
         return;
      }
      if (e.key.length === 1) {
         buffer += e.key;
      }
   });
   form.on('submit', function(event) {
      event.preventDefault();
      if (isProcessing) return;
      isProcessing = true;
      $.ajax({
         url: '<?= URLROOT ?>/pegawai/cari_rfid',
         method: 'POST',
         data: form.serialize(),

         success: function(response) {
         if (typeof response === 'string') {
            response = JSON.parse(response);
         }
         if (response.status === 'success') {
            let data = response.data;
            Swal.fire({
               title: 'Data Pegawai',
               html: `
                  <b>Nama:</b> ${data.nama}<br>
                  <b>NIK:</b> ${data.nik}<br>
                  <b>Jabatan:</b> ${data.jabatan}<br>
                  <b>Nomor RFID:</b> ${data.rfid}
               `,
               icon: 'success'
            });
         } else {
            Swal.fire({
               title: 'Tidak Ditemukan',
               text: response.message,
               icon: 'warning'
            });
         }

         input.val('');
         buffer = '';
         isProcessing = false;
         focusInput();
         },
         error: function() {
            Swal.fire({
               title: 'Error',
               text: 'Terjadi kesalahan, silahkan coba lagi.',
               icon: 'error',
               confirmButtonText: 'Tutup'
            }).then(() => {
               input.val('');
               buffer = '';
               isProcessing = false;
               focusInput();
            });

         }
      });
   });

});
</script>