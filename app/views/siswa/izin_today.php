<div class="row">
    <div class="col">
        <div class="card card-outline card-primary" style="margin-top:15px">
            <div class="card-body">

                <div class="text-center mb-3" style="font-size: 20px; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                    <b>DAFTAR IZIN SISWA</b><br />Hari ini
                </div>

                <div class="table-responsive">
                    <table class="table tabel2 khusus table-bordered table-hover" id="example">
                        <thead>
                            <tr style="text-align:center; height:50px">
                                <th style="width:30px">No</th>
                                <th style="width:35%">Nama Siswa</th>
                                <th style="width:100px">Kelas</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($data['izin_today'] as $d) : ?>
                                <tr>
                                    <td class="text-center"><?= $no ?></td>
                                    <!-- NAMA ------------------- -->
                                    <td>
                                        <?php
                                        $nm = $this->Msiswa->siswa_by_nis($d->nis_izin);
                                        $nm1 = strtolower($nm->nama_siswa);
                                        echo "<b>" . ucwords($nm1) . "</b>";
                                        ?>
                                    </td>
                                    <!-- KELAS ------------------- -->
                                    <td class="text-center">
                                        Kls : <b><?= $d->kelas_izin ?></b>
                                    </td>
                                    <!-- TANGGAL IZIN ------------------- -->
                                    <td>
                                        <b><?= $d->jenis_izin ?></b> : [<?= $d->alasan_izin ?>]
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .khusus td {
        padding: 5px 10px !important;
    }
</style>
<style>
    .lebar {
        width: auto !important;
        border-radius: 12px 12px 0px 0px !important;
        font-weight: bold;
        margin-left: -1px !important;
        margin-right: -1px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .lebar2 {
        width: auto !important;
        border-radius: 12px 12px 0px 0px !important;
        font-weight: bold;
        margin-left: -1px !important;
        margin-right: -1px !important;
        padding-left: 10px !important;
        padding-right: 10px !important;
    }

    .container1 {
        display: flex;
    }
</style>
<script>
    var originalTableBorder = $('#example').css('border');
    var originalTablePadding = $('#example').css('padding');

    $(document).ready(function() {
        $('#example').DataTable({
            "pageLength": 20,
            "paging": true,
            "lengthChange": true,
            "ordering": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "lengthMenu": " _MENU_ perhalaman",
                "zeroRecords": "Nothing found - sorry",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "sSearch": "Cari disini :"
            }
        });
    });
</script>