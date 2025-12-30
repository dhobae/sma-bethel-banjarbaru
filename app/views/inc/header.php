<!DOCTYPE html>
<html>

<head lang="en">
    <title>Presensi SMA Bethel Banjarbaru</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Sistem Presensi SMA Bethel Banjarbaru">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="shortcut icon" href="<?= URLROOT; ?>/smabethel/img/icon.png">

    <link rel="stylesheet" href="<?= URLROOT ?>/dist/lib/pahdi.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/lib/tabelpahdi.css">


    <link rel="stylesheet" href="<?= URLROOT ?>/css/tombol.css">

    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>



    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= URLROOT ?>/dist/plugins/toastr/toastr.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">




    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!-- <li class="nav-item d-none d-sm-inline-block">
                <a href="https://www.smabethel.sch.id/web/" class="nav-link" target=_blank
                    title="Ke Web sma bethel Bjb">SMA Bethel Banjarbaru</a>
            </li> -->
            <!-- <li class="nav-item d-none d-sm-inline-block">
                <a href="https://igracias.telkomschools.sch.id/ts/login/" class="nav-link" target=_blank
                    title="Ke Elearning IGRACIAS">IGRACIAS</a>
            </li> -->
            <li class="nav-item d-none d-sm-inline-block">
                <a href="https://wiki.stekom.ac.id/sekolah/informasi-ppdb-sma-bethel-banjar-baru-2025/?q=INFORMASI+PPDB+SMA+BETHEL+BANJAR+BARU+2025#gsc.tab=0&gsc.q=INFORMASI%20PPDB%20SMA%20BETHEL%20BANJAR%20BARU%202025&gsc.page=1" class="nav-link" target=_blank
                    title="Ke PPDB SMA Bethel BJB">PPDB</a>
            </li>
        </ul>




        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <?php if (($_SESSION['role'] != 'admin') && ($_SESSION['role'] != 'siswa')) { ?>
            <li class="nav-item">
                <a type="button" data-toggle="modal" data-target="#wa" class="nav-link" href="#">
                    <b>Nomor WhatsApp</b>
                </a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= URLROOT ?>/logout">
                    <i class="fa fa-power-off"></i>
                </a>
            </li>
        </ul>
    </nav>




    <style>
    .coba {
        color: red !important;
        background-color: white !important;
    }
    </style>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="<?= URLROOT ?>" class="brand-link">
            <img src="<?= URLROOT; ?>/smabethel/img/icon.png" alt="AdminLTE Logo" class="brand-image"
                style="opacity: 1">
            <span class="brand-text" style="color:#6a1212; font-weight:bold">SMA BETHEL BJB</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <?php if ($_SESSION['avatar']) { ?>
                    <img src="<?= URLROOT ?>/smabethel/avatar/<?= $_SESSION['avatar'] ?>" class="img-circle elevation-1"
                        alt="User Image" style="height:37px !important">
                    <?php } else { ?>
                    <img src="<?= URLROOT ?>/dist/img/userumum.jpg" class="img-circle elevation-2" alt="User Image">
                    <?php } ?>

                </div>
                <div class="info" style="margin-top: -12px; margin-bottom: -13px;">
                    <a href="#" class="d-block"> <?= $_SESSION['nik'] ?> <br /> <?= $_SESSION['nama'] ?></a>
                </div>
            </div>


            <nav class="mt-2">
                <!-- <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">  -->
                <ul class="nav nav-compact nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">


                    <?php
                    require APPROOT . '/views/inc/sidebar.php';
                    ?>

                </ul>
            </nav>


        </div>
    </aside>


    <script>
    var url = window.location;
    const allLinks = document.querySelectorAll('.nav-item a');
    const currentLink = [...allLinks].filter(e => {
        return e.href == url;
    });

    currentLink[0].classList.add("active")
    currentLink[0].closest(".nav-treeview").style.display = "block";
    currentLink[0].closest(".has-treeview").classList.add("active");
    </script>



    <!-- Modal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php sflash() ?>
    <div class="modal fade" id="wa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-primary">
                <form method="POST" action="<?= URLROOT ?>/pegawai/simpan_nomor_hp">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ganti Nomor WA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mb-2 mt2">

                        <?php
                        $this->db = new Database;
                        $id_pegawai = $_SESSION['id_pegawai'];
                        $sql = "SELECT * from pegawai where id_pegawai=:id";
                        $this->db->query($sql);
                        $this->db->bind('id', $id_pegawai);
                        $no_hp = $this->db->single();
                        ?>

                        <input type="hidden" name="nik" value="<?= $_SESSION['nik'] ?>">
                        <label>Nomor WhatsApp :</label>
                        <input type="text" name="nomor_hp" value="<?= $no_hp->nomor_hp ?>" class="form-control text1"
                            required>
                        <small><i>*tuliskan nomor HP tanpa spasi dan dimulai dengan 0 (nol)</i></small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i
                                class="fa fa-undo"></i> &nbsp;Close</button>
                        <button type="submit" name="proses" value="simpan" class="btn btn-danger btn-sm"><i
                                class="fa fa-save"></i> &nbsp;Simpan</button>
                        <button type="submit" name="proses" value="tes_wa" class="btn btn-success btn-sm"><i
                                class="fa fa-paper-plane"></i> &nbsp;Tes WA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">