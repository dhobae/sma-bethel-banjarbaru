<head>
    <title>Presensi Pegawai SMA Bethel Banjarbaru</title>
    <link rel="stylesheet" href="<?php echo URLROOT ?>/dist/lib/pahdi.css">
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/smabethel/img/icon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php sflash2() ?>

    <input type="password" id="inputRFID" onchange="prosesAbsen(this.value)" class="transparan">
    <input type="hidden" name="loc_masuk" id="loc_masuk" />
    <input type="hidden" value="" id="visitid" name="visitid">

    <div style="margin-bottom:20px" class="text-center">
        <img src="<?php echo URLROOT; ?>/smabethel/img/icon.png" alt="smabethel" style="width: 80px;height: auto;" />
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Presensi Pegawai SMA Bethel Banjarbaru ~</b>
    </div>
    <div style="font-family: 'courier new'; font-size:2.2em; margin-bottom:10px" class="blinking">
        <b>Tempelkan Kartu Presensi Anda</b>
    </div>
    <!-- <div style="font-family: 'courier new'; font-size:1.2em; color: #ffeb3b;" class="mb-3">
        <i class="fa fa-map-marker"></i> <span id="statusLokasi">Mendeteksi lokasi...</span>
    </div> -->
    <div class="d-flex justify-content-center align-items-center mt-3">
        <button class="btn btn-outline-danger btn-sm" id="logout-khusus">Logout</button>
    </div>

</body>

<script src="<?php echo URLROOT ?>/dist/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"></script>

<script type="text/javascript">
    let appState = {
        visitorId: null,
        latitude: null,
        longitude: null,
        coordinateLocation: null,
        rfidInput: null,
        isProcessing: false
    };

    function initializeVisitorId() {
        FingerprintJS.load().then(fp => {
            fp.get().then(result => {
                appState.visitorId = result.visitorId;
                console.log("✓ Visitor ID initialized: " + appState.visitorId);
            }).catch(error => {
                console.error("Error getting visitor ID:", error);
            });
        });
    }

    function getLocationCoordinates() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    appState.latitude = position.coords.latitude;
                    appState.longitude = position.coords.longitude;
                    appState.coordinateLocation = appState.latitude + ', ' + appState.longitude;
                    
                    console.log("✓ Lokasi diperoleh: " + appState.coordinateLocation);
                    console.log("  Akurasi: " + Math.round(position.coords.accuracy) + 'm');
                },
                function(error) {
                    console.error("Error geolocation:", error);
                    appState.latitude = null;
                    appState.longitude = null;
                    appState.coordinateLocation = null;
                }, 
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            console.warn("Browser tidak mendukung Geolocation");
        }
    }

    function setupLogoutHandler() {
        const logoutBtn = document.getElementById('logout-khusus');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: "Kamu akan keluar dari sistem",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?= URLROOT ?>/logout/logout";
                    }
                });
            });
        }
    }

    function prosesAbsen(rfidValue) {
        if (appState.isProcessing || !rfidValue.trim()) return;
        
        appState.isProcessing = true;

        const waitForVisitorId = setInterval(() => {
            if (appState.visitorId) {
                clearInterval(waitForVisitorId);
                sendAbsenRequest();
            }
        }, 100);

        function sendAbsenRequest() {
            $.ajax({
                url: '<?php echo URLROOT ?>/absen_pegawai/isi_absen_by_rfid',
                method: 'POST',
                data: {
                    isi: rfidValue,
                    id_pengunjung: appState.visitorId,
                    lokasi_koordinat: appState.coordinateLocation
                },
                dataType: 'json',
                success: function(response) {
                if (response.status === 'success') {
                    if (response.type === 'masuk') {
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
                    console.log(response);
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
            },
            complete: function() {
                appState.isProcessing = false;
            }
            });
        }
    }

    function refreshPage() {
        const rfidInput = document.getElementById("inputRFID");
        rfidInput.value = "";
        rfidInput.focus();
        setTimeout(function() {
            location.reload(true);
        }, 500);
    }

    function setupRFIDInput() {
        appState.rfidInput = document.getElementById("inputRFID");
        if (appState.rfidInput) {
            appState.rfidInput.focus();
        }
    }

    function setupEventListeners() {
        setupLogoutHandler();
        
        // Focus ke input RFID ketika klik di mana saja
        document.addEventListener('click', function(event) {
            if (event.target !== appState.rfidInput && appState.rfidInput) {
                appState.rfidInput.focus();
            }
        });

        // Focus otomatis saat page ready
        if (appState.rfidInput) {
            appState.rfidInput.focus();
        }
    }

    window.addEventListener('load', function() {
        setupRFIDInput();
        setupEventListeners();
        initializeVisitorId();
        getLocationCoordinates();
        // console.log("✓ Aplikasi siap digunakan");
    });

    $(document).ready(function() {
        const rfidInput = document.getElementById('inputRFID');
        if (rfidInput) {
            rfidInput.focus();
        }
    });
</script>

<style>
    :root {
        --bg-url: url('<?php echo URLROOT ?>/smabethel/img/gambarsmabethel2.jpg');
    }

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
        background-image: var(--bg-url);
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
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
</style>