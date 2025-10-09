<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="SMK Telkom Banjarbar, presensi, presensi skatel, skatel banjarbaru">
    <meta name="Description" content="igracias, telkom university, academic information system, universitas telkom">
    <title>
        Presensi SMK Telkom Banjarbaru
    </title>
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/lib/pahdi.css">
    <link rel="shortcut icon" href="<?= URLROOT; ?>/skatel/img/ts_icon1.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php sflash2() ?>

    <input type="password" id="inputUsername" onchange="processInput(this.value)" class="transparan">
    <div style="margin-bottom:20px" class="text-center">
        <img src="<?= URLROOT; ?>/skatel/img/ts2.png" alt="Skatel" style="width: 250px;height: auto;" /></a>
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Presensi Pegawai SMK Telkom Banjarbaru ~</b>
    </div>
    <div style="font-family: 'courier new'; font-size:2.2em; margin-bottom:30px" class="blinking">
        <b>Tempelkan Kartu Presensi anda</b>
    </div>
</body>


<!-- Modal absen datang -->
<div class="modal fade" id="modal_absen">
    <div class="modal-dialog">
        <div class="modal-content warna_modal">
            <form method="post" action="<?= URLROOT ?>/dashboard/hadir_rfid">

                <div class="modal-body">
                    <div id="konten_absen">
                        <!-- ISI DARI file isi_form_absen -->
                        <?php $sudah = $absen_datang ?>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<?php
$jumlah_kolom = 4;
$jumlah_nama = count($data['pegawai_all']);
$jumlah_baris = ceil($jumlah_nama / $jumlah_kolom);
?>

<div style="text-align:center; color:white; margin-bottom:30px">
    <table class="depan">
        <?php
        for ($baris = 0; $baris < $jumlah_baris; $baris++) {
            echo "<tr>";
            for ($kolom = 0; $kolom < 4; $kolom++) {
                $index_nama = $baris * 4 + $kolom;

                echo "<td>";
                if ($index_nama < $jumlah_nama) {
                    $cek = $this->Mdashboard->cek_absen_rfid($data['pegawai_all'][$index_nama]->nik);
                    if ($cek) {
                        if ($cek->status_pulang == 'Pulang') {
                            $ada = '#aaaaaa; font-weight:bold';
                        } else if (($cek->status_masuk == 'Izin') || ($cek->status_masuk == 'Sakit') || ($cek->status_masuk == 'Cuti') || ($cek->status_masuk == 'TL')) {
                            $ada = 'orange; font-weight:bold';
                        } else {
                            $ada = 'white; font-weight:bold';
                        }
                    } else {
                        $ada = '';
                    }
                    echo "<span style='color:$ada'>";
                    echo $data['pegawai_all'][$index_nama]->nama;
                    echo "</span>";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>
<div class="mt-4" style="font-weight:bold">
    <span style="color:cyan">Keterangan Warna &nbsp;: &nbsp;</span>
    <span style="color:gray">Belum Absen</span> &nbsp; - &nbsp;
    <span style="color:white">Sudah Absen</span> &nbsp; - &nbsp;
    <span style="color:orange">Izin/Sakit/Cuti/TL</span> &nbsp; - &nbsp;
    <span style="color:#aaaaaa">Sudah Pulang</span>
</div>

<style>
    .depan {
        font-size: 16px;
        color: #777777;
        width: 90%;
        margin: auto;
    }

    .depan th {
        width: <?php echo (100 / count($data['kelompokkan'])); ?>px;
        padding: 3px 5px;
        text-align: center;
        color: white;
    }

    .depan td {
        width: <?php echo (100 / 4); ?>px;
        border: 0px solid gray;
        padding: 5px 5px;
        text-align: center;
    }
</style>



<script src="<?= URLROOT ?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function processInput(isinya) {
        $.ajax({
            url: '<?= URLROOT ?>/dashboard/ambil_pegawai_by_rfid',
            method: 'POST',
            data: {
                isi: isinya
            },
            success: function(response) {
                if (response.trim() == "error") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kartu Anda tidak terdaftar',
                        text: 'Maaf, kartu Anda tidak terdaftar dalam sistem.',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            refreshPage();
                        }
                    });
                } else {
                    $('#konten_absen').html(response);
                    $('#modal_absen').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function refreshPage() {
        location.reload(true);
    }
</script>





<script>
    window.onload = function() {
        document.getElementById("inputUsername").value = "";
        //document.getElementById("inputUsername").focus();
    };
</script>

<script>
    $(document).ready(function() {
        $('#inputUsername').focus();
    });

    document.addEventListener('click', function(event) {
        const nisInput = document.getElementById('inputUsername');
        if (event.target !== nisInput) {
            nisInput.focus();
        }
    });
</script>

<style>
    .transparan {
        background-color: transparent;
        border: none;
        outline: none;
    }

    body {
        background: url(skatel/img/skatel.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        color: #cccccc;
        text-align: center;
    }

    .full-page-wrapper.wrapper {
        background: url(skatel/img/skatel.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        color: #cccccc;
    }

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