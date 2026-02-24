<head>
    <title>Presensi Pegawai SMA Bethel Banjarbaru</title>
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

    <input type="password" id="inputRFID" onchange="prosesAbsen(this.value)" class="transparan">

    <div style="margin-bottom:20px" class="text-center">
        <img src="<?php echo URLROOT;?>/smabethel/img/icon.png" alt="smabethel" style="width: 80px;height: auto;" />
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Presensi Pegawai SMA Bethel Banjarbaru ~</b>
    </div>
    <div style="font-family: 'courier new'; font-size:2.2em; margin-bottom:10px" class="blinking">
        <b>Tempelkan Kartu Presensi Anda</b>
    </div>
    <div style="font-family: 'courier new'; font-size:1.2em; color: #ffeb3b;" class="mb-3">
        <i class="fa fa-map-marker"></i> <span id="statusLokasi">Mendeteksi lokasi...</span>
    </div>

</body>

<script src="<?php echo URLROOT?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<script>
// Variabel global untuk menyimpan koordinat
let userLatitude = null;
let userLongitude = null;

// Fungsi untuk mendapatkan lokasi GPS
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                userLatitude = position.coords.latitude;
                userLongitude = position.coords.longitude;
                $('#statusLokasi').html('<i class="fa fa-check-circle"></i> Lokasi terdeteksi');
                console.log('Koordinat: ' + userLatitude + ', ' + userLongitude);
            },
            function(error) {
                console.error('Error mendapatkan lokasi: ', error);
                $('#statusLokasi').html('<i class="fa fa-exclamation-triangle"></i> Lokasi tidak terdeteksi');
                // Tetap bisa absen meski tanpa koordinat
                userLatitude = null;
                userLongitude = null;
            }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            }
        );
    } else {
        $('#statusLokasi').html('<i class="fa fa-times-circle"></i> Browser tidak mendukung GPS');
        console.log("Geolocation tidak didukung oleh browser ini.");
    }
}

function prosesAbsen(rfidValue) {
    // Kirim data absen dengan koordinat
    $.ajax({
        url: '<?php echo URLROOT?>/absen_pegawai/isi_absen_by_rfid',
        method: 'POST',
        data: {
            isi: rfidValue,
            latitude: userLatitude,
            longitude: userLongitude
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
                                <p style="color: #666;">${response.nik} | ${response.jabatan}</p>
                                <hr style="margin: 15px 0;">
                                <p style="color: #28a745; font-size: 1.2em;"><b>⏰ ${response.waktu}</b></p>
                                <p style="color: #666; margin-top: 10px;">${response.message}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        timer: 1200,
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
                                <p style="color: #666;">${response.nik} | ${response.jabatan}</p>
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
                        timer: 1200,
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
                            <p style="color: #666;">${response.nik} | ${response.jabatan}</p>
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
                    timer: 1200,
                    timerProgressBar: true
                }).then(() => {
                    refreshPage();
                });
            } else if (response.status === 'info') {
                // SEDANG IZIN
                Swal.fire({
                    icon: 'info',
                    title: 'Presensi Gagal',
                    text: response.message,
                    confirmButtonText: 'OK',
                    timer: 1200,
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
                    timer: 1200,
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
                text: 'Gagal menghubungi server. Silakan coba lagi atau hubungi administrator.',
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
    document.getElementById("inputRFID").value = "";
    document.getElementById("inputRFID").focus();
    setTimeout(function() {
        location.reload(true);
    }, 500);
}

window.onload = function() {
    document.getElementById("inputRFID").value = "";
    document.getElementById("inputRFID").focus();
    getLocation(); 
};

$(document).ready(function() {
    $('#inputRFID').focus();
});

document.addEventListener('click', function(event) {
    const rfidInput = document.getElementById('inputRFID');
    if (event.target !== rfidInput) {
        rfidInput.focus();
    }
});
</script>

<style>

/* Force SweetAlert2 vertical layout */
.swal2-popup {
    display: block !important;
}

.swal2-title {
    display: block !important;
    margin: 0 0 1em 0 !important;
}

.swal2-html-container {
    display: block !important;
    margin: 1em auto !important;
    text-align: center !important;
}

.swal2-actions {
    display: block !important;
    margin-top: 1.5em !important;
}

.transparan {
    background-color: transparent;
    border: none;
    outline: none;
    position: absolute;
    left: -9999px;
}

body {
    background: url(<?php echo URLROOT?>/smabethel/img/gambarsmabethel2.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    color: #cccccc;
    text-align: center;
    padding-top: 2rem;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6); 
    z-index: -1;
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
</styl>