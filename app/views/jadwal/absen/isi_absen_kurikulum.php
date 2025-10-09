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
                           <input type="text" name="materi" placeholder="Izin" value="Izin" class="text-pahdi" style="width:100%" required readonly>
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
                        <li><b><?= $c->nama_siswa ?></b> &nbsp;|&nbsp; <?= $c->jenis_izin ?></li>
                     <?php endforeach; ?>
                  </ol>
               <?php } ?>

            </div>
         </div>

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
                        <?php $no = 1;
                        $a = 0;
                        foreach ($data['isi_kelas'] as $d) : ?>
                           <input type="hidden" name="nis[<?= $a ?>]" value="<?= $d->nis ?>">
                           <tr>
                              <td class="text-center"><?= $no ?></td>
                              <td class="text-center"><?= $d->nis ?></td>
                              <td><?= $d->nama_siswa ?></td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-h" name="absen[<?= $a ?>]" value="H" checked>
                              </td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-a" name="absen[<?= $a ?>]" value="A">
                              </td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-i" name="absen[<?= $a ?>]" value="I">
                              </td>
                              <td class="text-center">
                                 <input type="radio" id="absen-<?= $d->nis ?>-s" name="absen[<?= $a ?>]" value="S">
                              </td>
                           </tr>
                        <?php $no++;
                           $a++;
                        endforeach; ?>
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