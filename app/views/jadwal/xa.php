<div class="mb-1">
   <h5><b>Jadwal Kelas X-A</b></h5>
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
      foreach ($data['xa'] as $d) :
      ?>
         <tr>
            <td class="text-center" style="vertical-align:middle">
               <?= $d->hari ?>
               <br />
               <a href="<?= URLROOT ?>/jadwal/edit_xa?id=<?= $d->id_jadwal_lengkap ?>" title="Edit jadwal hari ini"><i class="fa fa-edit"></i>
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