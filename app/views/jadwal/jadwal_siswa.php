<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php sflash() ?>

<div class="card card-primary card-outline" style="margin-top:10px;">
   <div class="card-body box-profile">

      <div class="tengah mb-1">
         <img src="<?= URLROOT ?>/skatel/img/ts.png" width="120px">
      </div>
      <div class="huruf1 tengah mb-4" style="font-size:20px; font-weight:bold">
         Jadwal Pelajaran Skatel Banjarbaru
      </div>



      <div class="text-center" style="font-size:1.6em">
         <b>Kelas <?= $data['kelas'] ?></b>
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
      </div>

      <div class="table-responsive">
         <table class="table tabel1">
            <thead class="text-center">
               <tr>
                  <th rowspan="2">Hari</th>
                  <th colspan="11">Jam Ke</th>
               </tr>
               <tr>
                  <th style="width:9%; min-width:100px">1</th>
                  <th style="width:9%; min-width:100px">2</th>
                  <th style="width:9%; min-width:100px">3</th>
                  <th style="width:9%; min-width:100px">4</th>
                  <th style="width:9%; min-width:100px">5</th>
                  <th style="width:9%; min-width:100px">6</th>
                  <th style="width:9%; min-width:100px">7</th>
                  <th style="width:9%; min-width:100px">8</th>
                  <th style="width:9%; min-width:100px">9</th>
                  <th style="width:9%; min-width:100px">10</th>
                  <th style="width:9%; min-width:100px">11</th>
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
                     </td>
                     <td class="text-center">
                        <span style="font-weight:bold; font-size:18px"><?= $d->singkatan2  ?></span>
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
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
                     <td class="text-center">
                        <span style="font-weight:bold; font-size:18px"><?= $d->singkatan11 ?></span>
                        <br />
                        <span style="font-size:13px; color:orangered">
                           <?php
                           if (strpos($d->guru11, ',') !== false) {
                              $nama_array11 = explode(",", $d->guru11);
                              foreach ($nama_array11 as $nm11) {
                                 $nama11 = $this->Mjadwal->ambil_nama($nm11);
                                 echo substr($nama11->nama, 0, 5);
                                 if ($nm11 !== end($nama_array11)) {
                                    echo " | ";
                                 }
                              }
                           } else {
                              echo substr($d->nama11, 0, 12) . "..";
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