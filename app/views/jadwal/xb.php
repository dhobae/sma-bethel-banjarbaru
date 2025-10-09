<div class="mb-1">
    <h5><b>Jadwal Kelas X-B</h5>
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
        foreach ($data['xb'] as $d) :
        ?>
            <tr>
                <td class="text-center" style="vertical-align:middle"><?= $d->hari ?></td>
                <td class="text-center">
                    <?= $d->mp1 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru1 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp2 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru2 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp3 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru3 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp4 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru4 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp5 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru5 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp6 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru6 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp7 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru7 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp8 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru8 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp9 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru9 ?></span>
                </td>
                <td class="text-center">
                    <?= $d->mp10 ?><br /><span style="font-size:13px; color:orangered"><?= $d->guru10 ?></span>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>