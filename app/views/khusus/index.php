<head>
    <title>Presensi Pegawai SMA Bethel Banjarbaru</title>
    <link rel="stylesheet" href="<?=URLROOT?>/dist/lib/pahdi.css">
    <link rel="shortcut icon" href="<?=URLROOT;?>/smabethel/img/icon.png">
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
        <img src="<?=URLROOT;?>/smabethel/img/icon.png" alt="smabethel" style="width: 80px;height: auto;" />
    </div>
    <div style="font-family: 'courier new'; font-size:2em; margin-bottom:-10px">
        <b>~ Pilih Opsi Absen ~</b>
    </div>
    <div style="font-family: 'courier new'; gap:8px;" 
    class="d-flex justify-content-center align-items-center mt-5">
        <a style="font-size:1rem; font-weight: bold;" href="<?= URLROOT ?>/absen_pegawai" class="btn btn-primary ">Absen RFID Pegawai</a>
        <a style="font-size:1rem; font-weight: bold;" href="<?= URLROOT ?>/absen_siswa" class="btn btn-secondary">Absen RFID Siswa</a>
    </div>
</body>


<style>

.transparan {
    background-color: transparent;
    border: none;
    outline: none;
    position: absolute;
    left: -9999px;
}

body {
    background: url(<?=URLROOT?>/smabethel/img/gambarsmabethel2.jpg) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    color: #cccccc;
    text-align: center;
    padding-top: 2rem;
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