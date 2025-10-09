<div class="row">
   <div class="col-lg-9">
      <div class="card mt-2 card-primary card-outline">
         <div class="card-body">

            <div class="text-center mb-4" style="font-size: 20px; font-weight:bold;">
               Presensi Kehadiran Siswa Kelas Saya<br />
               <?= dayID($data['tanggal']) ?>, <?= dateID($data['tanggal']) ?>
            </div>
            <div class="mb-2" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:0.9em; font-weight:bold">
               Tanggal : <input type="date" id="tanggal" onchange="submitForm()" value="<?= $data['tanggal'] ?>">

               <a href="<?= URLROOT ?>/siswa/kelas_saya" class="btn btn-primary btn-sm tombol2" title="Kembali ke hari ini">
                  <i class="fa fa-undo" aria-hidden="true"></i> &nbsp;Hari ini
               </a>
               <button onclick="changeDate(-1)" class="btn btn-primary btn-sm tombol2" title="Mundur 1 hari">
                  <i class="fa fa-backward" aria-hidden="true"></i> &nbsp;Back
               </button>
               <button onclick="changeDate(1)" class="btn btn-primary btn-sm tombol2" title="Maju 1 hari">
                  <i class="fa fa-forward" aria-hidden="true"></i> &nbsp;Next
               </button>
            </div>

            <div class="table-responsive">
               <table class="table tabel4">
                  <thead>
                     <tr style="background-color: azure;">
                        <th style="width:40px" rowspan="2">No</th>
                        <th style="width:100px" rowspan="2">NIS</th>
                        <th rowspan="2">Nama Siswa</th>
                        <th class="text-center" colspan="11">Jam Pelajaran</th>
                     </tr>
                     <tr style="background-color: azure;">
                        <th style="width:4%">1</th>
                        <th style="width:4%">2</th>
                        <th style="width:4%">3</th>
                        <th style="width:4%">4</th>
                        <th style="width:4%">5</th>
                        <th style="width:4%">6</th>
                        <th style="width:4%">7</th>
                        <th style="width:4%">8</th>
                        <th style="width:4%">9</th>
                        <th style="width:4%">10</th>
                        <th style="width:4%">11</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1;
                     foreach ($data['kelas_saya'] as $d) { ?>
                        <tr>
                           <td class="text-center"><?= $no ?></td>
                           <td class="text-center"><?= $d->nis_aks ?></td>
                           <td><?= $d->nama_siswa ?></td>
                           <td class="text-center <?= $d->absen_jam1 == 'A' ? 'alpa' : ($d->absen_jam1 == 'S' || $d->absen_jam1 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam1 ?></td>
                           <td class="text-center <?= $d->absen_jam2 == 'A' ? 'alpa' : ($d->absen_jam2 == 'S' || $d->absen_jam2 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam2 ?></td>
                           <td class="text-center <?= $d->absen_jam3 == 'A' ? 'alpa' : ($d->absen_jam3 == 'S' || $d->absen_jam3 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam3 ?></td>
                           <td class="text-center <?= $d->absen_jam4 == 'A' ? 'alpa' : ($d->absen_jam4 == 'S' || $d->absen_jam4 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam4 ?></td>
                           <td class="text-center <?= $d->absen_jam5 == 'A' ? 'alpa' : ($d->absen_jam5 == 'S' || $d->absen_jam5 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam5 ?></td>
                           <td class="text-center <?= $d->absen_jam6 == 'A' ? 'alpa' : ($d->absen_jam6 == 'S' || $d->absen_jam6 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam6 ?></td>
                           <td class="text-center <?= $d->absen_jam7 == 'A' ? 'alpa' : ($d->absen_jam7 == 'S' || $d->absen_jam7 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam7 ?></td>
                           <td class="text-center <?= $d->absen_jam8 == 'A' ? 'alpa' : ($d->absen_jam8 == 'S' || $d->absen_jam8 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam8 ?></td>
                           <td class="text-center <?= $d->absen_jam9 == 'A' ? 'alpa' : ($d->absen_jam9 == 'S' || $d->absen_jam9 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam9 ?></td>
                           <td class="text-center <?= $d->absen_jam10 == 'A' ? 'alpa' : ($d->absen_jam10 == 'S' || $d->absen_jam10 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam10 ?></td>
                           <td class="text-center <?= $d->absen_jam11 == 'A' ? 'alpa' : ($d->absen_jam11 == 'S' || $d->absen_jam11 == 'I' ? 'izin' : 'hadir') ?>"><?= $d->absen_jam11 ?></td>
                        </tr>
                     <?php $no++;
                     } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>


</div>


<script>
   function changeDate(days) {
      let dateInput = document.getElementById('tanggal');
      let currentDate = new Date(dateInput.value);
      currentDate.setDate(currentDate.getDate() + days);
      while (currentDate.getDay() === 6 || currentDate.getDay() === 0) {
         currentDate.setDate(currentDate.getDate() + days);
      }
      dateInput.valueAsDate = currentDate;
      submitForm();
   }

   function validateDate() {
      let dateInput = document.getElementById('tanggal');
      let selectedDate = new Date(dateInput.value);
      let day = selectedDate.getDay();
      if (day === 6 || day === 0) {
         dateInput.classList.add('invalid');
         alert('Tanggal yang dipilih adalah hari Sabtu atau Minggu. Silakan pilih hari lain.');
         dateInput.value = '';
      } else {
         dateInput.classList.remove('invalid');
         submitForm();
      }
   }

   function submitForm() {
      var tanggal = document.getElementById('tanggal').value;
      window.location.href = '<?= URLROOT ?>/siswa/absen_kelas?tanggal=' + tanggal;
   }
</script>

<style>
   .alpa {
      color: red;
      background-color: bisque;
   }

   .izin {
      color: blue;
      background-color: blanchedalmond;
   }

   .hadir {
      color: black;
   }
</style>