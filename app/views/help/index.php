<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-12">
            <!-- Main content -->
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <a href="<?= URLROOT;?>/help/add" class="btn float-right btn-xs btn btn-primary"><i class="fa fa-plus-square"></i> Kirim Laporan Bantuan</a>
                        </div>
                        <div class="table-responsive p-3">
                            <?php flash(); ?>
                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Detail Laporan</th>
                                        <th>Tanggapan Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php 
                                    $index = 0;
                                    foreach ($data['help'] as $row) {
                                    ?>
                                    <tr >
                                        <td><?= $index+1; ?></td>
                                        <td>
                                            <span style="color:#2980b9;"><?= $row->waktu ?></span>
                                        </td>
                                        <td>
                                            <b><?= $row->subjek ?></b>
                                            <br><br>
                                            Laporan: <br>
                                            <?= $row->laporan ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if($row->tanggapan){
                                                echo '<span class="badge badge-success">Selesai</span><br><br>Tanggapan : <br>';
                                                echo $row->tanggapan;
                                            }else{
                                                echo '<span class="badge badge-danger">Belum ada tanggapan</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php 
                        $index++;
                    }
                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            <!-- /.content -->
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>