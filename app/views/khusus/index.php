<head>
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

    <!--
    <input type="password" id="inputUsername" onchange="processInput(this.value)" class="transparan">
    -->
    <input type="password" id="inputUsername" onchange="isi(this.value)" class="transparan">

    <div style="margin-bottom:20px" class="text-center">
        <img src="<?= URLROOT; ?>/skatel/img/ts2.png" alt="Skatel" style="width: 250px;height: auto;" /></a>
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Presensi Siswa SMK Telkom Banjarbaru ~</b>
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


<script src="<?= URLROOT ?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function processInput(isinya) {
        $.ajax({
            url: '<?= URLROOT ?>/absen_siswa/isi_absen_by_rfid',
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


    function isi(isinya) {
        // Langsung menyimpan data tanpa mengecek kartu
        $.ajax({
            url: '<?= URLROOT ?>/absen_siswa/isi_absen_by_rfid',
            method: 'POST',
            data: {
                isi: isinya
            },
            success: function(saveResponse) {
                Swal.fire({
                    icon: 'success',
                    title: 'Data Berhasil Disimpan',
                    text: 'Data absen berhasil disimpan dalam sistem.',
                    showConfirmButton: false,
                    timer: 10
                }).then((result) => {
                    if (result.isConfirmed) {
                        refreshPage();
                    } else {
                        refreshPage();
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error saving data: ', error);
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