<!DOCTYPE html>
<html lang="en">


<!-- auth-forgot-password.html  21 Nov 2019 04:05:02 GMT -->

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title>4 SEMAMBUNG</title>
	<!-- General CSS Files -->
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/app.min.css">
	<!-- tamplate CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/components.css">
	<!-- Custom style CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/custom.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/shadow__btn.css">
	<link rel='shortcut icon' type='image/x-icon' href='<?= base_url() ?>/public/assets/img/favicon.ico' />
	<style>
		.daftar {
			height: 250px;
			overflow: hidden;
		}

		ul {
			list-style: none;
			position: relative;
		}

		li {
			height: 59px;
			/* border-bottom: 1px solid #333; */
			overflow: hidden;
		}

		.btnFloat {
			position: fixed;
			bottom: 10%;
			right: 10px;
			z-index: 2;
		}
	</style>
</head>

<body>
	<div class="loader"></div>
	<div id="app">
		<section class="section" style="overflow: hidden;">
			<div class="row list m-2">
				<div class="col-md-4">
					<input type="number" name="rfid" class="form-control" id="nomor" name="id"
						style="margin-top:-500px;" />
				</div>
				<button class="btnFloat btn btn-icon btn-lg shadow__btn" onclick="login()">
					<i class="my-float fas fa-fingerprint"> Login</i>
				</button>
			</div>
			<div class="row list m-2">
				<div class="col-md-4 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - I</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="">
								<ul id="" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header center">
							<h4>Kelas - II</h4>
						</div>
						<div class="card-body" style="min-height: 200px; max-height: 200px;overflow-x: auto;">
							<table id="tb1">
								<tbody class="output"></tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - III</h4>
						</div>
						<div class="card-body">
						</div>
					</div>
				</div>

				<div class="col-md-4 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - IV</h4>
						</div>
						<div class="card-body" style="height: 250px;">
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - V</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="daftar">
								<ul id="kelas5" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - VI</h4>
						</div>
						<div class="card-body">
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row flogin" style="display:none;margin-top: 50px;">
					<div
						class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
						<div class="card card-primary">
							<div class="card-header">
								<h4>Login</h4>
							</div>
							<div class="card-body">
								<form method="POST" action="<?= base_url('auth') ?>" class="needs-validation"
									novalidate="">
									<div class="form-group">
										<label for="email">Email</label>
										<input id="email" type="text" class="form-control" name="email" tabindex="1"
											autofocus>
										<div class="invalid-feedback">
											Please fill in your email
										</div>
									</div>
									<div class="form-group">
										<div class="d-block">
											<label for="password" class="control-label">Password</label>
										</div>
										<input id="password" type="password" class="form-control" name="password"
											tabindex="2">
										<div class="invalid-feedback">
											please fill in your password
										</div>
									</div>
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" name="remember" class="custom-control-input"
												tabindex="3" id="remember-me">
											<label class="custom-control-label" for="remember-me">Remember Me</label>
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
											Login
										</button>
									</div>
								</form>
							</div>
						</div>
						<div class="mt-5 text-muted text-center">
							Batal login? <a href="#" onclick="batal()" id="btn-batal">Batal</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- General JS Scripts -->
	<script src="<?= base_url() ?>/public/assets/js/jquery-3.7.0.js"></script>
	<!-- JS Libraies -->
	<script src="<?= base_url() ?>/public/assets/js/app.min.js"></script>
	<!-- Page Specific JS File -->
	<!-- tamplate JS File -->
	<script src="<?= base_url() ?>/public/assets/js/scripts.js"></script>
	<!-- Custom JS File -->
	<script src="<?= base_url() ?>/public/assets/js/custom.js"></script>
	<script>
		var input = document.getElementById("nomor");
		// var tamp = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
		var tamp = [];
		var last = 0;

		$(function () {
			input.focus();
			setInterval(function () {
				cek();
			}, 1000);
			tampil();
		});

		function cek() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'V' },
				success: function (result) {
					let data = JSON.parse(result);
					if (last != data['total']) {
						last = data['total']
						reload();
					}
				}
			});
		}

		function tampil() {
			tamp = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'V' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat();
				}
			});
		}

		function tambah(rfid) {
			$.ajax({
				url: "<?= base_url('/inp'); ?>",
				type: 'post',
				data: { in_rfid: rfid },
				success: function (result) {
					let data = JSON.parse(result);
					tampil();
				}
			});
		}

		function buat() {
			let i = 0;
			for (let x in tamp) {
				// $("#kelas1").append("<li><h3 style='margin-bottom:1px;'>" + (tamp[x]) + "</h3><label>Jam" + (tamp[x]) + "</label></li>");
				$("#kelas5").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp[i][0].substring(0, 5) + '</span> ' + tamp[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop();
			}
		}

		function loop() {
			setTimeout(function () {
				var tickerLength = $('.daftar ul li').length;
				var tickerHeight = $('.daftar ul li').outerHeight();
				$('.daftar ul li:last-child').prependTo('.daftar ul');
				$('.daftar ul').css('marginTop', -tickerHeight);

				function moveTop() {
					$('.daftar ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar ul li:first-child').appendTo('.daftar ul');
						$('.daftar ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop();
				}, 1500);
			}, 1000);
		}

		// Execute a function when the user presses a key on the keyboard
		input.addEventListener("keypress", function (event) {
			// If the user presses the "Enter" key on the keyboard
			if (event.key === "Enter") {
				// Cancel the default action, if needed
				event.preventDefault();
				tambah(input.value);
				input.value = '';
				reload();
			}
		});

		function reload() {
			$('#kelas5').remove();
			$(".daftar").append('<ul id="kelas5"></ul>');
			tampil();
		}

		function login() {
			$(".list").hide("slow");
			$('.flogin').show("slow");
		}
		function batal() {
			$('.flogin').hide("slow");
			$(".list").show("slow");
		}
	</script>
</body>

</html>