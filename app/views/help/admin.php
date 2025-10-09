<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-lg-12">
            <!-- Main content -->
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <?php flash(); ?>
                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Detail Laporan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php 
                                    $index = 0;
                                    foreach ($data['help'] as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $index+1; ?></td>
                                        <td>
                                            <span style="color:#2980b9;"><?= $row->waktu ?></span>
                                            <br>
                                            <?= $row->nama ?> / <?= $row->user ?>
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
                                                echo '<a href="'.URLROOT.'/help/tanggapan/'.$row->id.'" class="btn btn-primary btn-md">Berikan Tanggapan</a>';
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