<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
        <div class="table-responsive p-3">
            <?php flash(); ?>
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
            <thead class="thead-light">
                <tr>
                <th>No.</th>
                <th>Nama / NIP</th>
                <th>Waktu Login</th>
                <th>Waktu Logout</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($data['log_user'] as $row) {
                ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row->nama_user ?> / <?= $row->nip_user ?></td>
                        <td><?= $row->waktu_login ?></td>
                        <td><?= $row->waktu_logout ?></td>
                    </tr>
                    <?php 
                    $no++;
                }
                ?>
            </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>