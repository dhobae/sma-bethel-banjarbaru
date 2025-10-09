<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-header bg-primary" style="height:35px; padding:5px 10px;">
      <b>DATA PENGAJUAN IZIN DARI DOSEN/KARYAWAN</b>
   </div>

   <div class="card-body box-profile">

      <div class="tengah">
         <h4><b>DAFTAR PENGAJUAN IZIN</b></h4>
      </div>
      <div class="tengah mb-3" style="font-size: 12px; line-height:20px !important">
         <b>
            Halaman ini adalah halaman yang berisi data Pengajuan Izin, Cuti, Sakit, atau Tugas Luar dari Dosen/Karyawan, Apabila Ajuan di ACC, maka data ajuan akan masuk ke daftar Izin Dosen/karyawan <br />
            Status = "Belum ACC" menandakan bahwa pengajuan izin belum di ACC Bagian Kepegawaian
         </b>
      </div>



      <table class="table tabel3 table-striped" id="example">
         <thead style="background-color: brown; color:white">
            <tr>
               <th style="width: 40px; height:35px;">No</th>
               <th style="width: 240px;">Nama Dosen/Karyawan</th>
               <th style="width: 150px;">Mulai dari</th>
               <th style="width: 150px;">Sampai dengan</th>
               <th style="width: 50px;">Jenis</th>
               <th>Keterangan Izin</th>
               <th style="width: 90px;">Status</th>
               <th style="width: 60px;">Aksi</th>
            </tr>
         </thead>

         <tbody>
            <?php
            $no = 1;
            if ($data['tmp_izin']) :
               foreach ($data['tmp_izin'] as $field) :
                  $hari = date("l", strtotime($field->tanggal_mulai));
                  if ($hari == "Sunday") {
                     $hari = "Minggu";
                  } elseif ($hari == "Monday") {
                     $hari = "Senin";
                  } elseif ($hari == "Tuesday") {
                     $hari = "Selasa";
                  } elseif ($hari == "Wednesday") {
                     $hari = "Rabu";
                  } elseif ($hari == "Thursday") {
                     $hari = "Kamis";
                  } elseif ($hari == "Friday") {
                     $hari = "Jum'at";
                  } elseif ($hari == "Saturday") {
                     $hari = "Sabtu";
                  }
                  $hari_akhir = date("l", strtotime($field->tanggal_akhir));
                  if ($hari_akhir == "Sunday") {
                     $hari_akhir = "Minggu";
                  } elseif ($hari_akhir == "Monday") {
                     $hari_akhir = "Senin";
                  } elseif ($hari_akhir == "Tuesday") {
                     $hari_akhir = "Selasa";
                  } elseif ($hari_akhir == "Wednesday") {
                     $hari_akhir = "Rabu";
                  } elseif ($hari_akhir == "Thursday") {
                     $hari_akhir = "Kamis";
                  } elseif ($hari_akhir == "Friday") {
                     $hari_akhir = "Jum'at";
                  } elseif ($hari_akhir == "Saturday") {
                     $hari_akhir = "Sabtu";
                  }
                  echo "<tr>";
                  echo "<td style='text-align:center;'>" . $no . "</td>";
                  echo "<td>" . $field->namadosen . "</td>";
                  echo "<td>" . dateID($field->tanggal_mulai) . "</td>";
                  echo "<td>" . dateID($field->tanggal_akhir) . "</td>";

                  if ($field->status_izin == 'Cuti2') {
                     echo "<td style='text-align:center;'>Cuti alasan penting</td>";
                  } else {
                     echo "<td style='text-align:center;'>" . $field->status_izin . "</td>";
                  }

                  echo "<td>" . $field->keterangan_izin . "</td>";
                  echo "<td>" . $field->status . "</td>";
            ?>
                  <td>
                     <a href="<?= URLROOT ?>/presensi/acc_permohonan/<?= $field->idtmpnya ?>" class="btn btn-success btn-sm tombol1 mb-1" title="Acc permohonan izin"><i class="fa fa-edit"></i></a>
                     <a href="#" onclick="hapus('<?= $field->idtmpnya ?>')" class="btn btn-danger btn-sm tombol1 mb-1" title="Hapus permohonan izin"><i class="fa fa-trash"></i></a>
                  </td>
                  </tr>
               <?php

                  $no++;
               endforeach;
            else :
               ?>
               <tr>
                  <td colspan="8">
                     Data tidak ditemukan
                  </td>
               </tr>
            <?php
            endif;
            ?>
         </tbody>
      </table>
   </div>
</div>

</body>


<script>
   $(document).ready(function() {
      $('#example').DataTable({
         "pageLength": 100,
         "paging": true, //Nomor halaman di bawah
         "lengthChange": true, //Jumlah ditampilkan berapa dulu
         "ordering": false,
         "autoWidth": false,
         "responsive": true,
         "language": {
            "lengthMenu": " _MENU_ perhalaman",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "sSearch": "Cari disini :"
         }
      });
   });
</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function hapus(id) {
      console.log('URL: ' + '<?= URLROOT ?>/presensi/hapus_permohonan_izin?id=' + id);
      Swal.fire({
         title: "Apakah anda yakin?",
         text: "Untuk menghapus permohonan izin yang anda pilih",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, hapus!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/presensi/hapus_permohonan_izin?id=' + id,
               type: 'POST',
               dataType: 'json',
               success: function(response) {
                  if (response.status == 'success') {
                     // Tampilkan SweetAlert untuk sukses
                     Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success'
                     }).then((result) => {
                        // Redirect atau lakukan tindakan lain setelah penghapusan
                        location.reload();
                     });
                  } else {
                     // Tampilkan SweetAlert untuk kesalahan
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