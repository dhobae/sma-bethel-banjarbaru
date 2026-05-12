<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Keywords" content="igracias, telkom university, academic information system, universitas telkom">
	<meta name="Description" content="igracias, telkom university, academic information system, universitas telkom">
	<title>
		Presensi SMA Bethel Banjarbaru</title>
	<link rel="shortcut icon" href="<?= URLROOT; ?>/smabethel/img/icon.png">

	<style>
		.full-page-wrapper.wrapper {
			background: url(<?=URLROOT?>/smabethel/img/gambarsmabethel2.jpg) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
	</style>
</head>

<body>
	<!DOCTYPE html>
	<html lang="en" class="no-js">

	<head>
		<link href="<?= URLROOT; ?>/smabethel/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="<?= URLROOT; ?>/smabethel/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<?php
	require APPROOT . '../../public/dist/lib/ip.php';
	require_once APPROOT . '/helpers/location_helper.php';
	get_client_ip();
	$ipnya = get_client_ip();

	$i = 0;
	$ada = 0;

	foreach ($data['ip'] as $field_ip) :
		$i++;
		if (ip_in_range2($ipnya, $field_ip->ip_address)) {
			$status[$i] = 1;
		} else {
			$status[$i] = 0;
		}
		$ada = $ada + $status[$i];
	endforeach;


	//-- SEMENTARA -------------------------------
	if (!$ada) {
		//$this->userModel->simpan_ip_address_sementara($ipnya);
	}
	//-- BATAS SEMENTARA -------------------------------
	?>

	<body>
		<div class="wrapper full-page-wrapper page-auth page-login text-center" style="min-height:100%">
			<div class="inner-page">
				<div class="login-box center-block">

					<div class="text-center" style="margin-bottom:15px">
						<a href="index.html"><img src="<?= URLROOT; ?>/smabethel/img/icon.png" alt="Smabethel" style="width: 90px;height: auto;" /></a>
					</div>

					<div class="text-center" style="font-family: 'calibri'; font-size:18px; line-height:20px; margin-bottom:10px">
						<b>~ Presensi Pegawai & Siswa ~<br />SMA Bethel Banjarbaru</b>
					</div>

					<form class="form-horizontal" role="form" method="post" action="<?= URLROOT; ?>/auth/login" id="pahdi">

						<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

						<div class="text-center" style="font-family: 'calibri'; margin-bottom:10px" id="wfo-status-container" data-ip-wfo="<?= ($ada > 0) ? '1' : '0' ?>">
							<span style="font-size:14px; font-weight:bold" id="wfo-status-header">Status Posisi Anda<br />
								<?php if ($ada > 0) { ?>
									<span id="wfo-status-text">Anda sedang berada di lingkungan Sekolah (IP)</span><br/>
									<span id="wfo-status-label" style='font-size:30px; color:green'>WFO</span>
									<input type='hidden' name='dari' id='inputDari' value='WFO'>
								<?php } else { ?>
									<span id="wfo-status-text">Mengecek lokasi (GPS)...</span><br/>
									<span id="wfo-status-label" style='font-size:30px; color:orange'>Memuat</span>
									<input type='hidden' name='dari' id='inputDari' value='WFH'>
								<?php } ?>
							</span>
						</div>

						<?php flash('register_success'); ?>

						<div class="form-group">
							<label for="username" class="control-label sr-only">Username</label>
							<div class="col-sm-12">
								<div class="input-group">
									<input type="text" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" name="username" value="<?php echo $data['username']; ?>" id="inputUsername" placeholder="Username atau NIP">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
								</div>
								<span class="invalid-feedback" style="color:red"><?php echo $data['username_err']; ?> </span>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="control-label sr-only">Password</label>
							<div class="col-sm-12">
								<div class="input-group">
									<input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" name="password" id="inputPassword" placeholder="Password">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
								</div>
								<span class="invalid-feedback" style="color:red"><?php echo $data['password_err']; ?> </span>
							</div>
						</div>
						<button class="btn btn-custom-primary btn-lg btn-block btn-auth" name="submit" value="submit"><i class="fa fa-arrow-circle-o-right"></i> Login</button>
					</form>
					<br />
				</div>
			</div>
		</div>
		<script src="<?= URLROOT; ?>/smabethel/js/jquery-2.1.0.min.js"></script>
		<script src="<?= URLROOT; ?>/smabethel/js/bootstrap.js"></script>
		<script src="<?= URLROOT; ?>/smabethel/js/modernizr.js"></script>
		
		<script type="text/javascript">
			const SCHOOL_LAT = <?= SCHOOL_LAT ?>;
			const SCHOOL_LNG = <?= SCHOOL_LNG ?>;
			const WFO_RADIUS = <?= WFO_RADIUS ?>;

			function calculateDistance(lat1, lon1, lat2, lon2) {
				const R = 6371000;
				const dLat = (lat2 - lat1) * Math.PI / 180;
				const dLon = (lon2 - lon1) * Math.PI / 180;
				const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
						Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
						Math.sin(dLon / 2) * Math.sin(dLon / 2);
				const c = 2 * Math.asin(Math.sqrt(a));
				return R * c;
			}

			function updateStatusDisplay(isWFO, method) {
				const wfoText = document.getElementById('wfo-status-text');
				const wfoLabel = document.getElementById('wfo-status-label');
				const inputDari = document.getElementById('inputDari');
				
				if (isWFO) {
					wfoText.innerHTML = 'Anda sedang berada di lingkungan Sekolah (' + method + ')';
					wfoLabel.innerHTML = 'WFO';
					wfoLabel.style.color = 'green';
					inputDari.value = 'WFO';
				} else {
					wfoText.innerHTML = 'Anda berada di luar lingkungan Sekolah';
					wfoLabel.innerHTML = 'WFH';
					wfoLabel.style.color = 'red';
					inputDari.value = 'WFH';
				}
			}

			function getLocation() {
				const container = document.getElementById('wfo-status-container');
				if (container.getAttribute('data-ip-wfo') === '1') {
					// Sudah WFO karena IP
					return;
				}

				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(
						function(position) {
							const distance = calculateDistance(position.coords.latitude, position.coords.longitude, SCHOOL_LAT, SCHOOL_LNG);
							updateStatusDisplay(distance <= WFO_RADIUS, 'GPS');
						},
						function(error) {
							console.log("Geolocation error: " + error.message);
							updateStatusDisplay(false, 'Error');
						}
					);
				} else {
					updateStatusDisplay(false, 'No GPS');
				}
			}

			$(function() {
				getLocation();
			});
		</script>
	</body>