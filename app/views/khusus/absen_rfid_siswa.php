<head>
    <title>
        Presensi Siswa SMA Bethel Banjarbaru
    </title>
    <link rel="stylesheet" href="<?php echo URLROOT?>/dist/lib/pahdi.css">
    <link rel="shortcut icon" href="<?php echo URLROOT;?>/smabethel/img/icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php sflash2()?>

    <!--
    <input type="password" id="inputUsername" onchange="processInput(this.value)" class="transparan">
    -->
    <input type="password" id="inputUsername" onchange="isi(this.value)" class="transparan">

    <div style="margin-bottom:20px" class="text-center">
        <img src="<?php echo URLROOT;?>/smabethel/img/icon.png" alt="smabethel" style="width: 80px;height: auto;" /></a>
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Presensi Siswa SMA Bethel Banjarbaru ~</b>
    </div>
    <div style="font-family: 'courier new'; font-size:2.2em; margin-bottom:30px" class="blinking">
        <b>Tempelkan Kartu Presensi anda</b>
    </div>
</body>


<!-- Modal absen datang -->
<div class="modal fade" id="modal_absen">
    <div class="modal-dialog">
        <div class="modal-content warna_modal">
            <form method="post" action="<?php echo URLROOT?>/dashboard/hadir_rfid">

                <div class="modal-body">
                    <div id="konten_absen">
                        <!-- ISI DARI file isi_form_absen -->
                        <?php $sudah = $absen_datang?>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- End Modal -->


<script src="<?php echo URLROOT?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// function processInput(isinya) {
//     $.ajax({
//         url: '<?php echo URLROOT?>/absen_siswa/isi_absen_by_rfid',
//         method: 'POST',
//         data: {
//             isi: isinya
//         },
//         success: function(response) {
//             if (response.trim() == "error") {
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Kartu Anda tidak terdaftar',
//                     text: 'Maaf, kartu Anda tidak terdaftar dalam sistem.',
//                     confirmButtonText: 'OK',
//                 }).then((result) => {
//                     if (result.isConfirmed) {
//                         refreshPage();
//                     }
//                 });
//             } else {
//                 $('#konten_absen').html(response);
//                 $('#modal_absen').modal('show');
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// }

function isi(isinya) {
    $.ajax({
        url: '<?php echo URLROOT?>/absen_siswa/isi_absen_by_rfid',
        method: 'POST',
        data: {
            isi: isinya
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                if (response.type === 'masuk') {
                    // ABSEN MASUK
                    Swal.fire({
                        icon: 'success',
                        title: '✓ PRESENSI MASUK',
                        html: `
                            <div style="font-size: 1.1em;">
                                <p style="font-size: 1.3em; margin: 10px 0;"><b>${response.nama}</b></p>
                                <p style="color: #666;">NIS: ${response.nis} | Kelas: ${response.kelas}</p>
                                <hr style="margin: 15px 0;">
                                <p style="color: #28a745; font-size: 1.2em;"><b>⏰ ${response.waktu}</b></p>
                                <p style="color: #666; margin-top: 10px;">${response.message}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        timer: 7000,
                        timerProgressBar: true
                    }).then(() => {
                        refreshPage();
                    });
                } else if (response.type === 'pulang') {
                    // ABSEN PULANG
                    Swal.fire({
                        icon: 'info',
                        title: '✓ PRESENSI PULANG',
                        html: `
                            <div style="font-size: 1.1em;">
                                <p style="font-size: 1.3em; margin: 10px 0;"><b>${response.nama}</b></p>
                                <p style="color: #666;">NIS: ${response.nis} | Kelas: ${response.kelas}</p>
                                <hr style="margin: 15px 0;">
                                <div style="background: #f0f8ff; padding: 10px; border-radius: 5px; margin: 10px 0;">
                                    <p style="margin: 5px 0;">Masuk: <b>${response.jam_masuk}</b></p>
                                    <p style="margin: 5px 0;">Pulang: <b>${response.waktu}</b></p>
                                    <p style="margin: 5px 0; color: #007bff;">Durasi: <b>${response.durasi}</b></p>
                                </div>
                                <p style="color: #666; margin-top: 10px;">${response.message}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        timer: 7000,
                        timerProgressBar: true
                    }).then(() => {
                        refreshPage();
                    });
                }
            } else if (response.status === 'warning') {
                // SUDAH ABSEN LENGKAP
                Swal.fire({
                    icon: 'warning',
                    title: '⚠ Sudah Presensi Lengkap',
                    html: `
                        <div style="font-size: 1.1em;">
                            <p style="font-size: 1.3em; margin: 10px 0;"><b>${response.nama}</b></p>
                            <p style="color: #666;">NIS: ${response.nis} | Kelas: ${response.kelas}</p>
                            <hr style="margin: 15px 0;">
                            <div style="background: #fff3cd; padding: 10px; border-radius: 5px; margin: 10px 0;">
                                <p style="margin: 5px 0;">✓ Masuk: <b>${response.jam_masuk}</b></p>
                                <p style="margin: 5px 0;">✓ Pulang: <b>${response.jam_pulang}</b></p>
                            </div>
                            <p style="color: #856404; margin-top: 10px;">${response.message}</p>
                        </div>
                    `,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107',
                    timer: 5000,
                    timerProgressBar: true
                }).then(() => {
                    refreshPage();
                });
            } else if (response.status === 'info') {
                Swal.fire({
                    icon: 'info',
                    title: 'Presensi Gagal',
                    text: response.message,
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        refreshPage();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: response.message,
                    confirmButtonText: 'OK',
                    timer: 5000,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        refreshPage();
                    }
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ', error);
            console.error('Response: ', xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal menghubungi server. Silakan coba lagi atau hubungi admin.',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            }).then(() => {
                refreshPage();
            });
        }
    });
}

function refreshPage() {
    // Clear input
    document.getElementById("inputUsername").value = "";
    // Focus kembali ke input
    document.getElementById("inputUsername").focus();
    // Reload page setelah delay singkat
    setTimeout(function() {
        location.reload(true);
    }, 500);
}

// Auto-focus on page load
window.onload = function() {
    document.getElementById("inputUsername").value = "";
    document.getElementById("inputUsername").focus();
};

// Maintain focus on input field
$(document).ready(function() {
    $('#inputUsername').focus();
});

// Return focus when clicking anywhere
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
    background: url(<?php echo URLROOT?>/smabethel/img/gambarsmabethel2.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    color: #cccccc;
    text-align: center;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: -1;
}

.full-page-wrapper.wrapper {
    background: url(<?php echo URLROOT?>/smabethel/img/gambarsmabethel2.jpg) no-repeat center center fixed;
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