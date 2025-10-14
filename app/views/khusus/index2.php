<head>
    <title>Presensi Pegawai SMK Telkom Banjarbaru</title>
    <link rel="stylesheet" href="<?=URLROOT?>/dist/lib/pahdi.css">
    <link rel="shortcut icon" href="<?=URLROOT;?>/skatel/img/ts_icon1.png">
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
        <img src="<?=URLROOT;?>/skatel/img/ts2.png" alt="Skatel" style="width: 250px;height: auto;" />
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Presensi Pegawai SMK Telkom Banjarbaru ~</b>
    </div>
    <div style="font-family: 'courier new'; font-size:2.2em; margin-bottom:10px" class="blinking">
        <b>Tempelkan Kartu Presensi Anda</b>
    </div>
    <div style="font-family: 'courier new'; font-size:1.2em; color: #ffeb3b;">
        <i class="fa fa-map-marker"></i> <span id="statusLokasi">Mendeteksi lokasi...</span>
    </div>
</body>

<script src="<?=URLROOT?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
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
        url: '<?=URLROOT?>/absen_pegawai/isi_absen_by_rfid',
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
                        title: 'PRESENSI MASUK',
                        html: `
                            <div style="font-size: 1.2em;">
                                <p style="font-size: 1.5em; margin: 15px 0; color: #28a745;"><b>${response.nama}</b></p>
                                <p style="color: #666; font-size: 0.95em;">${response.nik} | ${response.jabatan}</p>
                                <hr style="margin: 20px 0; border-top: 2px solid #e0e0e0;">
                                <p style="font-size: 1.8em; margin: 20px 0; color: #28a745;"><b>${response.waktu}</b></p>
                                <p style="color: #666; margin-top: 15px;">${response.message}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    }).then(() => {
                        refreshPage();
                    });
                } else if (response.type === 'pulang') {
                    // ABSEN PULANG
                    Swal.fire({
                        icon: 'info',
                        title: 'PRESENSI PULANG',
                        html: `
                            <div style="font-size: 1.2em;">
                                <p style="font-size: 1.5em; margin: 15px 0; color: #1976d2;"><b>${response.nama}</b></p>
                                <p style="color: #666; font-size: 0.95em;">${response.nik} | ${response.jabatan}</p>
                                <hr style="margin: 20px 0; border-top: 2px solid #e0e0e0;">
                                <div style="margin: 20px 0;">
                                    <p style="font-size: 1.1em; color: #555;">Masuk: <b>${response.jam_masuk}</b></p>
                                    <p style="font-size: 1.8em; margin: 15px 0; color: #1976d2;"><b>${response.waktu}</b></p>
                                    <p style="font-size: 1.1em; color: #1976d2;">Durasi: <b>${response.durasi}</b></p>
                                </div>
                                <p style="color: #666; margin-top: 15px;">${response.message}</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    }).then(() => {
                        refreshPage();
                    });
                }
            } else if (response.status === 'warning') {
                // SUDAH ABSEN LENGKAP
                Swal.fire({
                    icon: 'warning',
                    title: 'Sudah Presensi Lengkap',
                    html: `
                        <div style="font-size: 1.2em;">
                            <p style="font-size: 1.5em; margin: 15px 0; color: #ff9800;"><b>${response.nama}</b></p>
                            <p style="color: #666; font-size: 0.95em;">${response.nik} | ${response.jabatan}</p>
                            <hr style="margin: 20px 0; border-top: 2px solid #e0e0e0;">
                            <div style="margin: 20px 0;">
                                <p style="font-size: 1.1em; color: #555;">✓ Masuk: <b>${response.jam_masuk}</b></p>
                                <p style="font-size: 1.1em; color: #555; margin-top: 10px;">✓ Pulang: <b>${response.jam_pulang}</b></p>
                            </div>
                            <p style="color: #856404; margin-top: 15px;">${response.message}</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                }).then(() => {
                    refreshPage();
                });
            } else {
                // ERROR - KARTU TIDAK TERDAFTAR atau IP TIDAK TERDAFTAR
                let errorMessage = response.message;
                let additionalInfo = '';

                // Jika error karena IP tidak terdaftar
                if (response.ip_address) {
                    additionalInfo =
                        `<p style="color: #666; font-size: 0.9em; margin-top: 10px;">IP Address: ${response.ip_address}</p>`;
                }

                Swal.fire({
                    icon: 'error',
                    title: '✗ Akses Ditolak',
                    html: `
                        <div style="font-size: 1.1em;">
                            <p style="color: #dc3545; margin: 15px 0;">${errorMessage}</p>
                            ${additionalInfo}
                            <p style="color: #666; margin-top: 10px;">Silakan hubungi bagian administrasi kepegawaian.</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                }).then(() => {
                    refreshPage();
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
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
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

// Auto-focus dan get location saat halaman dimuat
window.onload = function() {
    document.getElementById("inputRFID").value = "";
    document.getElementById("inputRFID").focus();
    getLocation(); // Ambil lokasi GPS
};

// Maintain focus pada input field
$(document).ready(function() {
    $('#inputRFID').focus();
});

// Return focus saat klik di mana saja
document.addEventListener('click', function(event) {
    const rfidInput = document.getElementById('inputRFID');
    if (event.target !== rfidInput) {
        rfidInput.focus();
    }
});
</script>

<style>
.transparan {
    background-color: transparent;
    border: none;
    outline: none;
    position: absolute;
    left: -9999px;
}

body {
    background: url(skatel/img/skatel.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    color: #cccccc;
    text-align: center;
    padding-top: 50px;
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