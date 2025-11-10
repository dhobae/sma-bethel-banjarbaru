<form method="POST" action="<?= URLROOT ?>/jadwal/simpan_isi_absen">

   <input type="hidden" name="tgl" value="<?= $data['tgl'] ?>">
   <input type="hidden" name="kelas" value="<?= $data['kelas'] ?>">
   <input type="hidden" name="ruang" value="<?= $data['ruang'] ?>">
   <input type="hidden" name="jam" value="<?= $data['jam'] ?>">
   <input type="hidden" name="nik" value="<?= $_SESSION['nik'] ?>">
   <input type="hidden" name="wali_kelas" value="<?= $data['wali_kelas'] ?>">
   <input type="hidden" name="id_pelajaran" value="<?= $data['id_pelajaran'] ?>">
   <input type="hidden" name="jumlah_siswa" value="<?= $data['jumlah_siswa'] ?>">

   <div class="row" style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
      <div class="col-lg-5">
         <div class="card card-outline card-success" style="margin-top:10px">
            <div class="card-header" style="font-size:20px">
               <b>Absen Kelas</b>
            </div>
            <div class="card-body">
               <div>
                  <table class="tabel_detail">
                     <tr>
                        <td>Hari/Tanggal</td>
                        <td>:</td>
                        <td><?= $data['hari'] ?> / <?= dateID($data['tgl']) ?></td>
                     </tr>
                     <tr>
                        <td>Mata Pelajaran</td>
                        <td>:</td>
                        <td>
                           <?php
                           $mp = $this->Mjadwal->mata_pelajaran_byid($data['id_pelajaran']);
                           echo $mp->mata_pelajaran;
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td><?= $data['kelas'] ?><?= $data['ruang'] ?></td>
                     </tr>
                     <tr>
                        <td>Jam Pelajaran Ke</td>
                        <td>:</td>
                        <td><?= $data['jam'] ?></td>
                     </tr>
                     <tr>
                        <td>Guru Pengajar</td>
                        <td>:</td>
                        <td><?php $niknya = $_SESSION['nik'] ?>
                           <?php
                           $gr = $this->Mjadwal->nama_guru_byid($niknya);
                           echo $gr->nama;
                           ?>
                        </td>
                     </tr>
                     <tr>
                        <td>Materi Pelajaran</td>
                        <td>:</td>
                        <td>
                           <input type="text" name="materi" placeholder="Isikan jurnal mengajar disini" class="text-pahdi" style="width:100%" required>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>


         <div class="card card-outline card-success">
   <div class="card-body" style="padding:15px; font-size:0.9em;">
      <div>
         <b>Siswa Izin Hari ini :</b>
      </div>

      <?php if (!$data['cek_izin']) { ?>
         <div class="text-center mt-2 mb-3">
            <span class="blink" style="color:green; font-weight:bold; font-size:1.2em">Tidak ada siswa izin</span>
         </div>
      <?php } else { ?>
         <ol style="margin-top:10px">
            <?php foreach ($data['cek_izin'] as $c) : ?>
               <li>
                  <b><?= $c->nama_siswa ?></b> &nbsp;|&nbsp; <?= $c->jenis_izin ?>
                  <?php if (!empty($c->file_izin)) : ?>
                     &nbsp;|&nbsp;
                     <?php
                     $ext = strtolower(pathinfo($c->file_izin, PATHINFO_EXTENSION));
                     $isPdf = ($ext === 'pdf');
                     ?>
                     <?php if ($isPdf) : ?>
                        <a href="<?= URLROOT ?>/smabethel/file_izin/<?= $c->file_izin ?>" target="_blank" class="btn btn-sm btn-info">
                           <i class="fas fa-file-pdf"></i> Lihat Bukti
                        </a>
                     <?php else : ?>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalBukti<?= $c->nis_izin ?>">
                           <i class="fas fa-image"></i> Lihat Bukti
                        </button>
                     <?php endif; ?>
                  <?php endif; ?>
               </li>
            <?php endforeach; ?>
         </ol>
      <?php } ?>

   </div>
</div>

<!-- Modal untuk menampilkan gambar -->
<?php if ($data['cek_izin']) : ?>
   <?php foreach ($data['cek_izin'] as $c) : ?>
      <?php if (!empty($c->file_izin)) : ?>
         <?php
         $ext = strtolower(pathinfo($c->file_izin, PATHINFO_EXTENSION));
         $isPdf = ($ext === 'pdf');
         ?>
         <?php if (!$isPdf) : ?>
            <div class="modal fade" id="modalBukti<?= $c->nis_izin ?>" tabindex="-1" role="dialog" aria-labelledby="modalBuktiLabel<?= $c->nis_izin ?>" aria-hidden="true">
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="modalBuktiLabel<?= $c->nis_izin ?>">Bukti Izin - <?= $c->nama_siswa ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body text-center">
                        <img src="<?= URLROOT ?>/smabethel/file_izin/<?= $c->file_izin ?>" class="img-fluid" alt="Bukti Izin" style="max-height:500px;">
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                     </div>
                  </div>
               </div>
            </div>
         <?php endif; ?>
      <?php endif; ?>
   <?php endforeach; ?>
<?php endif; ?>


         <div class="card card-outline card-danger">
            <div class="card-body" style="padding:15px">
               <a href="<?= URLROOT ?>/jadwal/absen?tanggal=<?= $data['tgl'] ?>" class="btn btn-danger btn-sm tombol2" title="Kembali"><i class="fa fa-undo"></i> &nbsp;Kembali</a>
               <div class="float-right">
                  <button type="submit" class="btn btn-primary btn-sm tombol2" title="Simpan Absen"><i class="fa fa-save"></i> &nbsp;Simpan</button>
               </div>
            </div>
         </div>
      </div>

      <div class="col-lg-7">
         <div class="card card-outline card-success" style="margin-top:10px">
            <div class="card-body">
               <div class="table-responsive">
                  <table class="tabel4" style="width:100%">
                     <thead style="background-color: azure; font-weight:bold">
                        <tr>
                           <th style="width:40px; height:35px">No</th>
                           <th style="width:100px">NIS</th>
                           <th>Nama</th>
                           <th style="width:45px">H</th>
                           <th style="width:45px">A</th>
                           <th style="width:45px">I</th>
                           <th style="width:45px">S</th>
                        </tr>
                     </thead>
                     <tbody>
                     <?php 
                        $no = 1;
                        $a = 0;
                        foreach ($data['isi_kelas'] as $d) :

                           // Default status absen = 'H'
                           $status_absen = 'H';

                           // Cek apakah siswa ini ada di daftar izin
                           if (!empty($data['cek_izin'])) {
                              foreach ($data['cek_izin'] as $izin) {
                                 if ($izin->nis_izin == $d->nis) {
                                    // Jika jenis izin = Izin → I
                                    if ($izin->jenis_izin == 'Izin') {
                                       $status_absen = 'I';
                                    }
                                    // Jika jenis izin = Sakit → S
                                    elseif ($izin->jenis_izin == 'Sakit') {
                                       $status_absen = 'S';
                                    }
                                 }
                              }
                           }
                        ?>
                           <input type="hidden" name="nis[<?= $a ?>]" value="<?= $d->nis ?>">
                           <tr>
                              <td class="text-center"><?= $no ?></td>
                              <td class="text-center"><?= $d->nis ?></td>
                              <td><?= $d->nama_siswa ?></td>

                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-h" 
                                       name="absen[<?= $a ?>]" value="H"
                                       <?= $status_absen == 'H' ? 'checked' : '' ?>>
                              </td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-a" 
                                       name="absen[<?= $a ?>]" value="A"
                                       <?= $status_absen == 'A' ? 'checked' : '' ?>>
                              </td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-i" 
                                       name="absen[<?= $a ?>]" value="I"
                                       <?= $status_absen == 'I' ? 'checked' : '' ?>>
                              </td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-s" 
                                       name="absen[<?= $a ?>]" value="S"
                                       <?= $status_absen == 'S' ? 'checked' : '' ?>>
                              </td>
                           </tr>
                        <?php 
                           $no++;
                           $a++;
                        endforeach; 
                        ?>

                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>

<style>
   .tabel_detail {
      width: 100%;
      font-size: 0.90em;
   }

   .tabel_detail td {
      padding: 4px 2px;
   }

   .tabel_detail td:nth-child(1) {
      width: 120px;
      vertical-align: top;
   }

   .tabel_detail td:nth-child(2) {
      width: 20px;
      text-align: center;
      vertical-align: top;
   }

   .tabel_detail td:nth-child(3) {
      vertical-align: top;
      font-weight: bold;
   }

   .text-pahdi {
      border: 0px solid #aaaaaa;
      border-bottom: 1px solid #aaaaaa;
      font-weight: bold;
      color: blue;
   }
</style>
<style>
   @keyframes blink {
      0% {
         opacity: 1;
      }

      50% {
         opacity: 0.5;
      }

      100% {
         opacity: 1;
      }
   }

   .blinking {
      animation: blink 2s infinite;
   }
</style>