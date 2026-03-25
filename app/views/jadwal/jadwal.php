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
         $kelas = 'ringkasan';
      }
      ?>

      <div class="container1 mb-2" style="padding:0px">
         <div class="col" style="padding:0px">
            <a href="<?= URLROOT ?>/jadwal?kelas=ringkasan"
               class="btn btn-outline-dark btn-sm tombol3 lebar2 <?= ($kelas == 'ringkasan') ? 'active' : '' ?>">Ringkasan</a>

            <a href="<?= URLROOT ?>/jadwal?kelas=XA"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XA') ? 'active' : '' ?>">XA</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XB"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XB') ? 'active' : '' ?>">XB</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XC"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XC') ? 'active' : '' ?>">XC</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XD"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XD') ? 'active' : '' ?>">XD</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XE"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XE') ? 'active' : '' ?>">XE</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XF"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XF') ? 'active' : '' ?>">XF</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XG"
               class="btn btn-outline-primary btn-sm tombol3 lebar <?= ($kelas == 'XG') ? 'active' : '' ?>">XG</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIA"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIA') ? 'active' : '' ?>">XIA</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIB"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIB') ? 'active' : '' ?>">XIB</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIC"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIC') ? 'active' : '' ?>">XIC</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XID"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XID') ? 'active' : '' ?>">XID</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIE"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIE') ? 'active' : '' ?>">XIE</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIF"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIF') ? 'active' : '' ?>">XIF</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIG"
               class="btn btn-outline-danger btn-sm tombol3 lebar <?= ($kelas == 'XIG') ? 'active' : '' ?>">XIG</a>

            <a href="<?= URLROOT ?>/jadwal?kelas=XIIA"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIA') ? 'active' : '' ?>">XIIA</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIB"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIB') ? 'active' : '' ?>">XIIB</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIC"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIC') ? 'active' : '' ?>">XIIC</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIID"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIID') ? 'active' : '' ?>">XIID</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIE"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIE') ? 'active' : '' ?>">XIIE</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIF"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIF') ? 'active' : '' ?>">XIIF</a>
            <a href="<?= URLROOT ?>/jadwal?kelas=XIIG"
               class="btn btn-outline-success btn-sm tombol3 lebar <?= ($kelas == 'XIIG') ? 'active' : '' ?>">XIIG</a>

            <hr style="margin-top:0px">
         </div>
      </div>

      <?php if ($kelas != 'ringkasan') { ?>
         <div style="margin-top: -10px; font-size:0.75em; font-weight:bold;">
            <?php $th = $this->Mjadwal->tahun_ajaran_byid($data['jadwal_setting']->id_tahun_ajaran); ?>
            Tahun Ajaran : <?= $th->tahun_ajaran ?>
            &nbsp;|&nbsp;
            Semester : <?= $data['jadwal_setting']->semester ?>
            &nbsp;|&nbsp;
            Blok : <?= $data['jadwal_setting']->blok ?>
            &nbsp;|&nbsp;
            Mulai dari : <?= date3ID($data['jadwal_setting']->berlaku_dari) ?>
         </div>
           <!-- Tombol Print dan Download Excel -->
         <div class="text-right mb-2 no-print">
            <button onclick="printJadwal()" class="btn btn-info btn-sm tombol3">
               <i class="fa fa-print"></i> Print
            </button>
            <a href="<?= URLROOT ?>/jadwal/export_excel?kelas=<?= $kelas ?>" class="btn btn-success btn-sm tombol3">
                  <i class="fa fa-file-excel"></i> Download Excel
            </a>
         </div>
         <div class="text-center" style="font-size:1.6em">
            <b>Kelas <?= $kelas ?></b>
         </div>
         <div class="text-center mb-3" style="font-size:0.95em">
            <b>Wali Kelas &nbsp;:&nbsp;
               <?php if (isset($data['wali_kelas']->wali_kelas)) {
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

         <div class="table-responsive">
            <table class="table tabel1">
               <thead class="text-center">
                  <tr>
                     <th rowspan="2">&nbsp;&nbsp;&nbsp;&nbsp;Hari&nbsp;&nbsp;&nbsp;&nbsp;</th>
                     <th colspan="10">Jam Ke</th>
                  </tr>
                  <tr>
                     <th style="width:9%">1</th>
                     <th style="width:9%">2</th>
                     <th style="width:9%">3</th>
                     <th style="width:9%">4</th>
                     <th style="width:9%">5</th>
                     <th style="width:9%">6</th>
                     <th style="width:9%">7</th>
                     <th style="width:9%">8</th>
                     <th style="width:9%">9</th>
                     <th style="width:9%">10</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ($data['jadwal'] as $d):
                     ?>
                     <tr>
                        <td class="text-center" style="vertical-align:middle">
                           <b><?= $d->hari ?></b>
                           <br />

                           <?php
                           if (($_SESSION['role'] == 'admin') || (Middleware::admin('kurikulum')) || ($_SESSION['nik'] == $d->wali_kelas)) { ?>
                              <a href="<?= URLROOT ?>/jadwal/edit_jadwal_kelas?id=<?= $d->id_jadwal_lengkap ?>&kelas=<?= $kelas ?>"
                                 title="Edit jadwal hari ini"><i class="fa fa-edit"></i></a>
                           <?php } else { ?>
                              <a href="#" title="Edit jadwal hari ini" class="disabled"><i class="fa fa-edit"></i></a>
                           <?php } ?>

                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <?php
                           if (empty($d->singkatan1)) {
                              if (strtolower($d->hari) == 'senin') {
                                 echo '<span style="font-weight:bold; font-size:18px;">UPACARA</span>';
                              }
                              elseif (strtolower($d->hari) == 'jumat') {
                                 echo '<span style="font-weight:bold; font-size:18px;">IBADAH</span>';
                              }
                              else {
                                 echo '<span style="font-weight:bold; font-size:18px">-</span>';
                              }
                           } else {
                              ?>
                              <span style="font-weight:bold; font-size:18px">
                                 <?= $d->singkatan1 ?>
                              </span>
                              <br />
                              <span style="font-size:13px; color:orangered">
                                 <?php
                                 if (strpos($d->guru1, ',') !== false) {
                                    $nama_array1 = explode(",", $d->guru1);
                                    foreach ($nama_array1 as $nm1) {
                                       $nama1 = $this->Mjadwal->ambil_nama($nm1);
                                       echo substr($nama1->nama, 0, 5);
                                       if ($nm1 !== end($nama_array1)) {
                                          echo " | ";
                                       }
                                    }
                                 } else {
                                    echo substr($d->nama1, 0, 12) . "..";
                                 }
                                 ?>
                              </span>
                           <?php } ?>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan2 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru2, ',') !== false) {
                                 $nama_array2 = explode(",", $d->guru2);
                                 foreach ($nama_array2 as $nm2) {
                                    $nama2 = $this->Mjadwal->ambil_nama($nm2);
                                    echo substr($nama2->nama, 0, 5);
                                    if ($nm2 !== end($nama_array2)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama2, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan3 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru3, ',') !== false) {
                                 $nama_array3 = explode(",", $d->guru3);
                                 foreach ($nama_array3 as $nm3) {
                                    $nama3 = $this->Mjadwal->ambil_nama($nm3);
                                    echo substr($nama3->nama, 0, 5);
                                    if ($nm3 !== end($nama_array3)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama3, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan4 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru4, ',') !== false) {
                                 $nama_array4 = explode(",", $d->guru4);
                                 foreach ($nama_array4 as $nm4) {
                                    $nama4 = $this->Mjadwal->ambil_nama($nm4);
                                    echo substr($nama4->nama, 0, 5);
                                    if ($nm4 !== end($nama_array4)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama4, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan5 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru5, ',') !== false) {
                                 $nama_array5 = explode(",", $d->guru5);
                                 foreach ($nama_array5 as $nm5) {
                                    $nama5 = $this->Mjadwal->ambil_nama($nm5);
                                    echo substr($nama5->nama, 0, 5);
                                    if ($nm5 !== end($nama_array5)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama5, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan6 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru6, ',') !== false) {
                                 $nama_array6 = explode(",", $d->guru6);
                                 foreach ($nama_array6 as $nm6) {
                                    $nama6 = $this->Mjadwal->ambil_nama($nm6);
                                    echo substr($nama6->nama, 0, 5);
                                    if ($nm6 !== end($nama_array6)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama6, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan7 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru7, ',') !== false) {
                                 $nama_array7 = explode(",", $d->guru7);
                                 foreach ($nama_array7 as $nm7) {
                                    $nama7 = $this->Mjadwal->ambil_nama($nm7);
                                    echo substr($nama7->nama, 0, 5);
                                    if ($nm7 !== end($nama_array7)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama7, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan8 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru8, ',') !== false) {
                                 $nama_array8 = explode(",", $d->guru8);
                                 foreach ($nama_array8 as $nm8) {
                                    $nama8 = $this->Mjadwal->ambil_nama($nm8);
                                    echo substr($nama8->nama, 0, 5);
                                    if ($nm8 !== end($nama_array8)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama8, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan9 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru9, ',') !== false) {
                                 $nama_array9 = explode(",", $d->guru9);
                                 foreach ($nama_array9 as $nm9) {
                                    $nama9 = $this->Mjadwal->ambil_nama($nm9);
                                    echo substr($nama9->nama, 0, 5);
                                    if ($nm9 !== end($nama_array9)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama9, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                           <span style="font-weight:bold; font-size:18px"><?= $d->singkatan10 ?></span>
                           <br />
                           <span style="font-size:13px; color:orangered">
                              <?php
                              if (strpos($d->guru10, ',') !== false) {
                                 $nama_array10 = explode(",", $d->guru10);
                                 foreach ($nama_array10 as $nm10) {
                                    $nama10 = $this->Mjadwal->ambil_nama($nm10);
                                    echo substr($nama10->nama, 0, 5);
                                    if ($nm10 !== end($nama_array10)) {
                                       echo " | ";
                                    }
                                 }
                              } else {
                                 echo substr($d->nama10, 0, 12) . "..";
                              }
                              ?>
                           </span>
                        </td>

                     </tr>
                     <?php
                  endforeach;
                  ?>
               </tbody>
            </table>
         </div>
         <div class="mt-3 no-print">
            <?php
            if (isset($data['wali_kelas']) && is_object($data['wali_kelas']) && $data['wali_kelas']->validasi != '1') {
               ?>
               <span style="font-weight:bold; color:red" class="blink no-print">Jadwal Belum di validasi</span>
               <br />
               <?php
               if ((isset($d) && isset($d->wali_kelas) && $d->wali_kelas == $_SESSION['nik']) || (Middleware::admin('kurikulum'))) {
                  ?>
                  <div class="mt-1">
                     <a href="javascript:void(0)" onclick="validasi('<?= $data['wali_kelas']->kode_kelas ?>')"
                        class="btn btn-success btn-sm tombol3" title="Validasi jadwal"><i class="fa fa-check"></i> &nbsp;Validasi
                        Jadwal</a>
                     <a href="javascript:void(0)" onclick="kosongkan('<?= $data['wali_kelas']->kode_kelas ?>')"
                        class="btn btn-danger btn-sm tombol3" title="Hapus semua jadwal"><i class="fa fa-trash"></i>
                        &nbsp;Kosongkan Jadwal</a>
                  </div>
               <?php } ?>
            <?php } else { ?>
               <?php
               if (isset($data['wali_kelas']) && is_object($data['wali_kelas'])) {
                  if ($data['wali_kelas']->validasi_oleh == 'admin') {
                     $validator = 'Administrator';
                  } else {
                     $ambil = $this->Mjadwal->ambil_nama($data['wali_kelas']->validasi_oleh);
                     $validator = isset($ambil->nama) ? $ambil->nama : 'Tidak Diketahui';
                  }
                  ?>
                  <span style="font-weight:bold; color:green" class="blink no-print">
                     Jadwal Sudah di validasi oleh : <?= $validator ?><br />
                     Divalidasi pada tanggal : <?= dateID($data['wali_kelas']->tanggal_validasi) ?>
                     <br />
                  </span>
                  <?php
                  if ((isset($d) && isset($d->wali_kelas) && $d->wali_kelas == $_SESSION['nik']) || (Middleware::admin('kurikulum'))) {
                     ?>
                     <div class="mt-2">
                        <a href="javascript:void(0)" onclick="kosongkan('<?= $data['wali_kelas']->kode_kelas ?>')"
                           class="btn btn-danger btn-sm tombol3" title="Hapus semua jadwal"><i class="fa fa-trash"></i>
                           &nbsp;Kosongkan Jadwal</a>
                     </div>
                  <?php } ?>
               <?php } ?>
            <?php } ?>
         </div>
      <?php } else {
         $this->view('jadwal/ringkasan', $data);
      } ?>
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
   
   /* Print Styles */
   @media print {
      .no-print {
         display: none !important;
      }
      
      .main-header,
      .main-sidebar,
      .main-footer,
      .content-header,
      nav.navbar,
      aside {
         display: none !important;
      }

      .content-wrapper {
         margin-left: 0 !important;
         padding-top: 0 !important;
         background: white !important;
      }

      .wrapper {
         overflow: visible !important;
      }

      .card {
         box-shadow: none !important;
         border: none !important;
      }
      
      .container1, .btn, .fa-edit, a[href*="edit"] {
         display: none !important;
      }
      
      table {
         page-break-inside: avoid;
         width: 100%;
      }
      
      thead {
         display: table-header-group;
      }
      
      tr {
         page-break-inside: avoid;
      }
      
      body {
         margin: 0;
         padding: 0px;
      }
      
      @page {
         size: landscape;
         margin: 1cm;
      }
   }
</style>


<script>
   function printJadwal() { window.print();}

   // function downloadExcel() {
   //    var kelas = '<?= $kelas ?>';
   //    window.location.href = '<?= URLROOT ?>/jadwal/download_excel?kelas=' + kelas;
   // }

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
               success: function (response) {
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
               success: function (response) {
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


<div class="modal fade no-print" id="wali_kelas<?= $data['wali_kelas']->id_jadwal_lengkap ?>" tabindex="-1"
   aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  foreach ($data['guru'] as $g):
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
               <button type="button" class="btn btn-danger btn-sm tombol3" data-dismiss="modal"><i
                     class="fa fa-undo"></i> Close</button>
               <button type="submit" class="btn btn-success  btn-sm tombol3"><i class="fa fa-save"></i> Simpan</button>
            </div>
         </form>
      </div>
   </div>
</div>