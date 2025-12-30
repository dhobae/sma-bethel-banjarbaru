<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/smabethel/img/icon.png" width="80px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Jadwal Pelajaran SMA Bethel Banjarbaru
      </div>

      <?php
      if (isset($_GET['kelas'])) {
         $kelas = $_GET['kelas'];
      } else {
         $kelas = 'XA';
      }
      ?>

      <div class="container1 mb-2" style="padding:0px">
         <div class="col" style="padding:0px">
            <a href="<?= URLROOT ?>/jadwal?kelas=XA" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XA') ? 'active' : '' ?>">XA</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XB" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XB') ? 'active' : '' ?>">XB</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XC" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XC') ? 'active' : '' ?>">XC</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XD" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XD') ? 'active' : '' ?>">XD</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XE" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XE') ? 'active' : '' ?>">XE</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XF" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XF') ? 'active' : '' ?>">XF</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XG" class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XG') ? 'active' : '' ?>">XG</a>

            <a href="<?= URLROOT ?>/jadwal?kelas=XIA" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIA') ? 'active' : '' ?>">XIA</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIB" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIB') ? 'active' : '' ?>">XIB</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIC" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIC') ? 'active' : '' ?>">XIC</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XID" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XID') ? 'active' : '' ?>">XID</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIE" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIE') ? 'active' : '' ?>">XIE</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIF" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIF') ? 'active' : '' ?>">XIF</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIG" class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIG') ? 'active' : '' ?>">XIG</a>

            <a href="<?= URLROOT ?>/jadwal?kelas=XIIA" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIA') ? 'active' : '' ?>">XIIA</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIB" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIB') ? 'active' : '' ?>">XIIB</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIC" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIC') ? 'active' : '' ?>">XIIC</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIID" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIID') ? 'active' : '' ?>">XIID</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIE" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIE') ? 'active' : '' ?>">XIIE</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIF" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIF') ? 'active' : '' ?>">XIIF</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIG" class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIG') ? 'active' : '' ?>">XIIG</a>

            <a href="<?= URLROOT ?>/jadwal?kelas=XA" class="btn btn-outline-dark btn-sm tombol3 lebar2">Ringkasan</a>

            <hr style="margin-top:0px">
         </div>
      </div>

      <div class="text-center" style="font-size:1.6em">
         <b>Kelas <?= $kelas ?></b>
      </div>
      <div class="text-center mb-3" style="font-size:0.95em">
         <b>Wali Kelas &nbsp;:&nbsp;
            <?php if ($data['wali_kelas']->wali_kelas) {
               echo $data['wali_kelas']->nama;
            } else {
               echo "<span style='color:red'>~Wali kelas belum dipilih~</span>";
            }
            ?>
         </b>
         <!--
         &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
         <a href="javascript:void(0)" data-toggle="modal" data-target="#wali_kelas<?= $data['wali_kelas']->id_jadwal_lengkap ?>"><i class="fa fa-edit" title="Edit wali kelas" style="font-size:12px"></i></a>
         -->
      </div>
      <table class="table tabel1">
         <thead class="text-center">
            <tr>
               <th rowspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Hari&nbsp;&nbsp;&nbsp;&nbsp;</th>
               <th colspan="10">Jam Ke</th>
            </tr>
            <tr>
               <th style="width:10%">1</th>
               <th style="width:10%">2</th>
               <th style="width:10%">3</th>
               <th style="width:10%">4</th>
               <th style="width:10%">5</th>
               <th style="width:10%">6</th>
               <th style="width:10%">7</th>
               <th style="width:10%">8</th>
               <th style="width:10%">9</th>
               <th style="width:10%">10</th>
            </tr>
         </thead>
         <tbody>
            <?php
            foreach ($data['jadwal'] as $d) :
            ?>
               <tr>
                  <td class="text-center" style="vertical-align:middle">
                     <b><?= $d->hari ?></b>
                     <br />

                     <?php
                     if (($_SESSION['role'] == 'admin') || (Middleware::admin('kurikulum')) || ($_SESSION['nik'] == $d->wali_kelas)) { ?>
                        <a href="<?= URLROOT ?>/jadwal/edit_jadwal_kelas?id=<?= $d->id_jadwal_lengkap ?>&kelas=<?= $kelas ?>" title="Edit jadwal hari ini"><i class="fa fa-edit"></i></a>
                     <?php } else { ?>
                        <a href="#" title="Edit jadwal hari ini" class="disabled"><i class="fa fa-edit"></i></a>
                     <?php } ?>

                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan1 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama1, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan2  ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama2, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan3 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama3, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan4 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama4, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan5 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama5, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan6 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama6, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan7 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama7, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan8 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama8, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan9 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama9, 0, 12) ?>..</span>
                  </td>
                  <td class="text-center">
                     <span style="font-weight:bold; font-size:18px"><?= $d->singkatan10 ?></span>
                     <br />
                     <span style="font-size:13px; color:orangered"><?= substr($d->nama10, 0, 12) ?>..</span>
                  </td>
               </tr>
            <?php
            endforeach;
            ?>
         </tbody>
      </table>
      <div class="mt-3">
         <?php if (($data['wali_kelas']->validasi) != '1') { ?>
            <span style="font-weight:bold; color:red" class="blink">Jadwal Belum di validasi</span>
            <br />
            <?php if (($d->wali_kelas == $_SESSION['nik']) || (Middleware::admin('kurikulum'))) { ?>
               <div class="mt-1">
                  <a href="javascript:void(0)" onclick="validasi('<?= $data['wali_kelas']->kode_kelas ?>')" class="btn btn-success btn-sm tombol3" title="Validasi jadwal"><i class="fa fa-check"></i> &nbsp;Validasi Jadwal</a>

                  <a href="javascript:void(0)" onclick="kosongkan('<?= $data['wali_kelas']->kode_kelas ?>')" class="btn btn-danger btn-sm tombol3" title="Hapus semua jadwal"><i class="fa fa-trash"></i> &nbsp;Kosongkan Jadwal</a>
               </div>
            <?php } ?>
         <?php } else { ?>
            <?php
            if ($data['wali_kelas']->validasi_oleh == 'admin') {
               $validator = 'Administrator';
            } else {
               $ambil = $this->Mjadwal->ambil_nama($data['wali_kelas']->validasi_oleh);
               $validator = $ambil->nama;
            }
            ?>
            <span style="font-weight:bold; color:green" class="blink">
               Jadwal Sudah di validasi oleh : <?= $validator ?><br />
               Divalidasi pada tanggal : <?= dateID($data['wali_kelas']->tanggal_validasi) ?>
               <br />
            </span>
            <?php if (($d->wali_kelas == $_SESSION['nik']) || (Middleware::admin('kurikulum'))) { ?>
               <div class="mt-2">
                  <a href="javascript:void(0)" onclick="kosongkan('<?= $data['wali_kelas']->kode_kelas ?>')" class="btn btn-danger btn-sm tombol3" title="Hapus semua jadwal"><i class="fa fa-trash"></i> &nbsp;Kosongkan Jadwal</a>
               </div>
            <?php } ?>
         <?php } ?>
      </div>
   </div>
</div>

<style>
   .lebar {
      width: 47px !important;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
   }

   .lebar2 {
      width: 90px !important;
      border-radius: 12px 12px 0px 0px !important;
      font-weight: bold;
      margin-left: -1px !important;
      margin-right: -1px !important;
   }

   .container1 {
      display: flex;
   }
</style>


<script>
   function validasi(id) {
      //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
      Swal.fire({
         title: "Validasi Jadwal?",
         text: "Apakah anda yakin untuk memvalidasi jadwal diatas!",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Validasi!",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/jadwal/validasi_jadwal?id=' + id,
               type: 'POST',
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


   function kosongkan(id) {
      //console.log('URL: ' + '<?= URLROOT ?>/presensi/karyawan_hapus/' + id);
      Swal.fire({
         title: "Kosongkan Jadwal?",
         text: "Apakah anda yakin untuk menghapus semua jadwal kelas : " + id,
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Ya, Hapus",
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: '<?= URLROOT ?>/jadwal/kosongkan_jadwal?id=' + id,
               type: 'POST',
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


<div class="modal fade" id="wali_kelas<?= $data['wali_kelas']->id_jadwal_lengkap ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content p-4">
         <form method="POST" action="<?= URLROOT ?>/jadwal/simpan_wali_kelas">
            <input type="hidden" name="id_jadwal_lengkap" value="<?= $data['wali_kelas']->id_jadwal_lengkap ?>">
            <input type="hidden" name="kelasnya" value="<?= $data['wali_kelas']->kode_kelas ?>">
            <div class="modal-body text-center">
               <b>Wali Kelas &nbsp;:&nbsp; <?= $data['wali_kelas']->kode_kelas ?> </b>
               <br />
               <select name="wali_kelas" class="text-pahdi" style="width:300px">
                  <option value="">Pilih</option>
                  <?php
                  foreach ($data['guru'] as $g) :
                  ?>
                     <option value="<?= $g->nik ?>" <?= ($g->nik === $data['wali_kelas']->wali_kelas) ? 'selected' : '' ?>>
                        <?= $g->nama ?>
                     </option>
                  <?php
                  endforeach;
                  ?>
               </select>
            </div>
            <div style="text-align:right">
               <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i class="fa fa-undo"></i> Close</button>
               <button type="submit" class="btn btn-success  btn-sm tombol3"><i class="fa fa-save"></i> Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>