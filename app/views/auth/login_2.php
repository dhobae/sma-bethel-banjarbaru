<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= URLROOT; ?>/img/logo/logo.png" type="image/x-icon">
    <title>BSPJI - Login</title>
    <link href="<?= URLROOT; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="<?= URLROOT; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= URLROOT; ?>/css/ruang-admin.min.css" rel="stylesheet">
    <style>
        .login-card {
            background-image: linear-gradient(#0f0c29, #302b63, #24243e);
        }
    </style>
</head>

<?php
$username = $_GET['id'];
$password = 'admin';
?>

<body class="bg-gradient-login bg-secondary">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="card shadow-sm my-5 login-card">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="<?= URLROOT; ?>/img/logo/baristand.png" alt="baristand logo" class="img-fluid mb-4" style="width:100%;object-fit:cover;">
                                    </div>
                                    <form class="user" action="<?= URLROOT; ?>/auth/login" method="POST" id="myForm">
                                        <?php flash('register_success'); ?>
                                        <div class="form-group">

                                            <input type="text" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" name="username" value="<?=$username?>" id="inputUsername" placeholder="Username atau NIP">
                                            <span class="invalid-feedback"><?php echo $data['username_err']; ?> </span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" name="password" id="inputPassword" placeholder="Password" value="<?=$password?>">
                                            <span class="invalid-feedback"><?php echo $data['password_err']; ?> </span>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block p-3 btn-login">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Login Content -->
    <script src="<?= URLROOT; ?>/dist/vendor/jquery/jquery.min.js"></script>
    <script src="<?= URLROOT; ?>/dist/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= URLROOT; ?>/dist/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= URLROOT; ?>/dist/js/ruang-admin.min.js"></script>
</body>

</html>


  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      document.getElementById("myForm").submit();
    });
  </script>