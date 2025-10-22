<div class="row">
   <div class="col text-center">
      <b>Jumlah Siswa</b>
      <br />
      <span class="jumlah"><?= $data['jumlah_siswa'] ?></span>
   </div>
</div>

<div class="row">
   <div class="col-lg-7">
      <div class="text-center">
         <b>Rekap Siswa SMA Bethel</b>
      </div>
      <div class="table-responsive">
         <table class="tabel3 table khusus">
            <tr>
               <td style="width:20%; background-color:aquamarine" rowspan="2">KELAS</td>
               <td style="width:60%; background-color:bisque" colspan="2">SMA BETHEL</td>
               <td style="width:20%; background-color:aquamarine;" rowspan="2">TOTAL</td>
            </tr>
            <tr>
               <td style="background-color:azure; width:30%">L</td>
               <td style="background-color:azure; width:30%">P</td>
            </tr>
            <tr>
               <td style="color:blue">X</td>
               <td><?= $data['rekap']->SMABETHEL_X_L ?? 0 ?></td>
               <td><?= $data['rekap']->SMABETHEL_X_P ?? 0 ?></td>
               <td style="background-color:azure">
                  <?= $data['rekap']->SMABETHEL_X ?? 0 ?>
               </td>
            </tr>
            <tr>
               <td style="color:red">XI</td>
               <td><?= $data['rekap']->SMABETHEL_XI_L ?? 0 ?></td>
               <td><?= $data['rekap']->SMABETHEL_XI_P ?? 0 ?></td>
               <td style="background-color:azure">
                  <?= $data['rekap']->SMABETHEL_XI ?? 0 ?>
               </td>
            </tr>
            <tr>
               <td style="color:green">XII</td>
               <td><?= $data['rekap']->SMABETHEL_XII_L ?? 0 ?></td>
               <td><?= $data['rekap']->SMABETHEL_XII_P ?? 0 ?></td>
               <td style="background-color:azure">
                  <?= $data['rekap']->SMABETHEL_XII ?? 0 ?>
               </td>
            </tr>
            <tr>
               <td style="background-color: aquamarine;">TOTAL</td>
               <td colspan="2" style="background-color: beige;"><?= ($data['rekap']->SMABETHEL_X ?? 0) + ($data['rekap']->SMABETHEL_XI ?? 0) + ($data['rekap']->SMABETHEL_XII ?? 0) ?></td>
               <td style="background-color:aquamarine">
                  <?= ($data['rekap']->SMABETHEL_X ?? 0) + ($data['rekap']->SMABETHEL_XI ?? 0) + ($data['rekap']->SMABETHEL_XII ?? 0) ?>
               </td>
            </tr>
         </table>
      </div>
   </div>

   <div class="col-lg-5">
      <div class="text-center">
         <b>Jumlah Siswa Perkelas</b>
      </div>
      <table class="tabel3 table perkelas">
         <tr>
            <td style="background-color:azure">Kelas</td>
            <td style="width:14%; background-color:azure">A</td>
            <td style="width:14%; background-color:azure">B</td>
            <td style="width:14%; background-color:azure">C</td>
            <td style="width:14%; background-color:azure">D</td>
            <td style="width:14%; background-color:azure">E</td>
            <td style="width:14%; background-color:azure">F</td>
            <td style="width:14%; background-color:azure">G</td>
         </tr>
         <?php
         $kelas = ['X', 'XI', 'XII'];
         $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
         $data_siswa = [];
         foreach ($kelas as $k) {
            $data_siswa[$k] = array_fill_keys($columns, 0);
         }
         foreach ($data['perkelas'] as $row) {
            $kelas_siswa = $row->kelas_siswa;
            $kelas_prefix = substr($kelas_siswa, 0, strlen($kelas_siswa) - 1);
            $kolom = substr($kelas_siswa, -1);
            $jumlah = $row->jumlah;
            if (isset($data_siswa[$kelas_prefix]) && isset($data_siswa[$kelas_prefix][$kolom])) {
               $data_siswa[$kelas_prefix][$kolom] = $jumlah;
            }
         }
         foreach ($data_siswa as $k => $data) {
            echo '<tr>';
            echo '<td>' . $k . '</td>';
            foreach ($columns as $col) {
               $kelasnya = $k . $col;
               $ambil_prodi = $this->Msiswa->ambil_prodi($kelasnya);
               
               echo '<td style="line-height:19px; padding-top:12px !important; padding-bottom:13px !important">' . $data[$col] . '<br/>';
               
               // Pengecekan apakah prodi ada
               if ($ambil_prodi && isset($ambil_prodi->kode_prodi)) {
                  echo "<span style='font-size:11px; font-weight:normal'>" . $ambil_prodi->kode_prodi . "</span>";
               } else {
                  echo "<span style='font-size:11px; font-weight:normal'>-</span>";
               }
               
               echo '</td>';
            }
            echo '</tr>';
         }
         ?>
      </table>
   </div>

</div>

<style>
   .jumlah {
      font-size: 40px;
      font-weight: bold;
      color: green;
   }

   .khusus {
      width: 98%;
      margin: auto;
      margin-top: 10px;
   }

   .khusus td {
      height: 40px;
      vertical-align: middle;
      text-align: center;
      font-weight: bold;
      font-size: 1.05em;
   }

   .perkelas {
      width: 98%;
      margin: auto;
      margin-top: 10px;
   }

   .perkelas td {
      height: 40px;
      vertical-align: middle;
      font-weight: bold;
      font-size: 1.05em;
      text-align: center;
   }
</style>