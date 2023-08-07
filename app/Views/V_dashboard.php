<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title>PRESENSI</title>
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/app.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/components.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/custom.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/shadow__btn.css">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/public/assets/img/favicon.ico">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/bundles/izitoast/css/iziToast.min.css">
	<style>
		.absen {
			height: 250px;
			overflow: hidden;
		}

		ul {
			list-style: none;
			position: relative;
		}

		li {
			height: 59px;
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
				<button class="btnFloat btn btn-icon btn-lg shadow__btn"
					onclick="location.href='<?= base_url('/' . bin2hex('login')) ?>'">
					<i class="my-float fas fa-fingerprint"> Login</i>
				</button>
			</div>
			<div class="row list m-2">
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - I</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="absen daftar-1">
								<ul id="kelas1" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header center">
							<h4>Kelas - II</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="absen daftar-2">
								<ul id="kelas2" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - III</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="absen daftar-3">
								<ul id="kelas3" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - IV</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="absen daftar-4">
								<ul id="kelas4" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - V</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="absen daftar-5">
								<ul id="kelas5" style="margin-left: -40px;">
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">
					<div class="card card-primary h-100">
						<div class="card-header">
							<h4>Kelas - VI</h4>
						</div>
						<div class="card-body" style="height: 250px;">
							<div class="absen daftar-6">
								<ul id="kelas6" style="margin-left: -40px;">
								</ul>
							</div>
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
	<script src="<?= base_url() ?>/public/assets/bundles/izitoast/js/iziToast.min.js"></script>
	<!-- tamplate JS File -->
	<script src="<?= base_url() ?>/public/assets/js/scripts.js"></script>
	<!-- Custom JS File -->
	<script src="<?= base_url() ?>/public/assets/js/custom.js"></script>
	<?= $this->include('_layout/alert') ?>
	<script>
		var input = document.getElementById("nomor");
		function tambah(rfid) {
			$.ajax({
				url: "<?= base_url('/inp'); ?>",
				type: 'post',
				data: { in_rfid: rfid },
				success: function (result) {
					let data = JSON.parse(result);
					if (data['status'] == 'success') {
						if (data['kelas'] == 'I') {
							reload_satu();
						} else if (data['kelas'] == 'II') {
							reload_dua();
						} else if (data['kelas'] == 'III') {
							reload_tiga();
						} else if (data['kelas'] == 'IV') {
							reload_empat();
						} else if (data['kelas'] == 'V') {
							reload_lima();
						} else if (data['kelas'] == 'VI') {
							reload_enam();
						}
					}
				}
			});
		}
		input.addEventListener("keypress", function (event) {
			// If the user presses the "Enter" key on the keyboard
			if (event.key === "Enter") {
				// Cancel the default action, if needed
				event.preventDefault();
				tambah(input.value);
				input.value = '';
			}
		});

		$(function () {
			input.focus();
			tampil_satu();
			tampil_dua();
			tampil_tiga();
			tampil_empat();
			tampil_lima();
			tampil_enam();
			setInterval(function () {
				cek_satu();
				cek_dua();
				cek_tiga();
				cek_empat();
				cek_lima();
				cek_enam();
			}, 1000);
		});

		//kelas1
		var tamp_satu = [];
		var last_satu = 0;

		function cek_satu() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'I' },
				success: function (result) {
					let data = JSON.parse(result);
					// console.log(data['total']);
					if (last_satu != data['total']) {
						last_satu = data['total']
						reload_satu();
					}
				}
			});
		}

		function tampil_satu() {
			tamp_satu = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'I' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp_satu.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat_satu();
				}
			});
		}

		function buat_satu() {
			let i = 0;
			for (let x in tamp_satu) {
				$("#kelas1").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_satu[i][0].substring(0, 5) + '</span> ' + tamp_satu[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop_satu();
			}
		}

		function loop_satu() {
			setTimeout(function () {
				let tickerLength = $('.daftar-1 ul li').length;
				let tickerHeight = $('.daftar-1 ul li').outerHeight();
				$('.daftar-1 ul li:last-child').prependTo('.daftar-1 ul');
				$('.daftar-1 ul').css('marginTop', -tickerHeight);

				function moveTop_satu() {
					$('.daftar-1 ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar-1 ul li:first-child').appendTo('.daftar-1 ul');
						$('.daftar-1 ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop_satu();
				}, 1500);
			}, 1000);
		}

		function reload_satu() {
			$('#kelas1').remove();
			$(".daftar-1").append('<ul id="kelas1" style="margin-left: -40px;"></ul>');
			tampil_satu();
		}

		//kelas 2
		var tamp_dua = [];
		var last_dua = 0;
		function cek_dua() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'II' },
				success: function (result) {
					let data = JSON.parse(result);
					if (last_dua != data['total']) {
						last_dua = data['total']
						reload_dua();
					}
				}
			});
		}

		function tampil_dua() {
			tamp_dua = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'II' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp_dua.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat_dua();
				}
			});
		}

		function buat_dua() {
			let i = 0;
			for (let x in tamp_dua) {
				$("#kelas2").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_dua[i][0].substring(0, 5) + '</span> ' + tamp_dua[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop_dua();
			}
		}

		function loop_dua() {
			setTimeout(function () {
				let tickerLength = $('.daftar-2 ul li').length;
				let tickerHeight = $('.daftar-2 ul li').outerHeight();
				$('.daftar-2 ul li:last-child').prependTo('.daftar-2 ul');
				$('.daftar-2 ul').css('marginTop', -tickerHeight);

				function moveTop_dua() {
					$('.daftar-2 ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar-2 ul li:first-child').appendTo('.daftar-2 ul');
						$('.daftar-2 ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop_dua();
				}, 1500);
			}, 1000);
		}

		function reload_dua() {
			$('#kelas2').remove();
			$(".daftar-2").append('<ul id="kelas2" style="margin-left: -40px;"></ul>');
			tampil_dua();
		}

		// kelas 3
		var tamp_tiga = [];
		var last_tiga = 0;

		function cek_tiga() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'III' },
				success: function (result) {
					let data = JSON.parse(result);
					if (last_tiga != data['total']) {
						last_tiga = data['total']
						reload_tiga();
					}
				}
			});
		}

		function tampil_tiga() {
			tamp_tiga = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'III' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp_tiga.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat_tiga();
				}
			});
		}

		function buat_tiga() {
			let i = 0;
			for (let x in tamp_tiga) {
				$("#kelas3").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_tiga[i][0].substring(0, 5) + '</span> ' + tamp_tiga[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop_tiga();
			}
		}

		function loop_tiga() {
			setTimeout(function () {
				let tickerLength = $('.daftar-3 ul li').length;
				let tickerHeight = $('.daftar-3 ul li').outerHeight();
				$('.daftar-3 ul li:last-child').prependTo('.daftar-3 ul');
				$('.daftar-3 ul').css('marginTop', -tickerHeight);

				function moveTop_tiga() {
					$('.daftar-3 ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar-3 ul li:first-child').appendTo('.daftar-3 ul');
						$('.daftar-3 ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop_tiga();
				}, 1500);
			}, 1000);
		}

		function reload_tiga() {
			$('#kelas3').remove();
			$(".daftar-3").append('<ul id="kelas3" style="margin-left: -40px;"></ul>');
			tampil_tiga();
		}

		//kelas 4
		var tamp_empat = [];
		var last_empat = 0;

		function cek_empat() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'IV' },
				success: function (result) {
					let data = JSON.parse(result);
					if (last_empat != data['total']) {
						last_empat = data['total']
						reload_empat();
					}
				}
			});
		}

		function tampil_empat() {
			tamp_empat = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'IV' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp_empat.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat_empat();
				}
			});
		}

		function buat_empat() {
			let i = 0;
			for (let x in tamp_empat) {
				$("#kelas4").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_empat[i][0].substring(0, 5) + '</span> ' + tamp_empat[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop_empat();
			}
		}

		function loop_empat() {
			setTimeout(function () {
				let tickerLength = $('.daftar-4 ul li').length;
				let tickerHeight = $('.daftar-4 ul li').outerHeight();
				$('.daftar-4 ul li:last-child').prependTo('.daftar-4 ul');
				$('.daftar-4 ul').css('marginTop', -tickerHeight);

				function moveTop_empat() {
					$('.daftar-4 ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar-4 ul li:first-child').appendTo('.daftar-4 ul');
						$('.daftar-4 ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop_empat();
				}, 1500);
			}, 1000);
		}

		function reload_empat() {
			$('#kelas4').remove();
			$(".daftar-4").append('<ul id="kelas4" style="margin-left: -40px;"></ul>');
			tampil_empat();
		}

		//kelas 5
		var tamp_lima = [];
		var last_lima = 0;

		function cek_lima() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'V' },
				success: function (result) {
					let data = JSON.parse(result);
					if (last_lima != data['total']) {
						last_lima = data['total']
						reload_lima();
					}
				}
			});
		}

		function tampil_lima() {
			tamp_lima = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'V' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp_lima.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat_lima();
				}
			});
		}

		function buat_lima() {
			let i = 0;
			for (let x in tamp_lima) {
				$("#kelas5").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_lima[i][0].substring(0, 5) + '</span> ' + tamp_lima[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop_lima();
			}
		}

		function loop_lima() {
			setTimeout(function () {
				let tickerLength = $('.daftar-5 ul li').length;
				let tickerHeight = $('.daftar-5 ul li').outerHeight();
				$('.daftar-5 ul li:last-child').prependTo('.daftar-5 ul');
				$('.daftar-5 ul').css('marginTop', -tickerHeight);

				function moveTop_lima() {
					$('.daftar-5 ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar-5 ul li:first-child').appendTo('.daftar-5 ul');
						$('.daftar-5 ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop_lima();
				}, 1500);
			}, 1000);
		}

		function reload_lima() {
			$('#kelas5').remove();
			$(".daftar-5").append('<ul id="kelas5" style="margin-left: -40px;"></ul>');
			tampil_lima();
		}

		//kelas 6
		var tamp_enam = [];
		var last_enam = 0;

		function cek_enam() {
			$.ajax({
				url: "<?= base_url('/get_last'); ?>",
				type: 'post',
				data: { d_kelas: 'VI' },
				success: function (result) {
					let data = JSON.parse(result);
					if (last_enam != data['total']) {
						last_enam = data['total']
						reload_enam();
					}
				}
			});
		}

		function tampil_enam() {
			tamp_enam = [];
			$.ajax({
				url: "<?= base_url('/show'); ?>",
				type: 'post',
				data: { d_kelas: 'VI' },
				success: function (result) {
					let data = JSON.parse(result);
					for (let x in data) {
						tamp_enam.push([data[x]['jam_absensi'], data[x]['nama']]
						);
					}
					buat_enam();
				}
			});
		}

		function buat_enam() {
			let i = 0;
			for (let x in tamp_enam) {
				$("#kelas6").append('<li><h3 style="margin-top:15px;"><span class="badge badge-secondary">' + tamp_enam[i][0].substring(0, 5) + '</span> ' + tamp_enam[i][1] + '</h3></li>');
				i++;
			}
			if (i > 4) {//lakukan scroll data jika data lebih dari 4
				loop_enam();
			}
		}

		function loop_enam() {
			setTimeout(function () {
				let tickerLength = $('.daftar-6 ul li').length;
				let tickerHeight = $('.daftar-6 ul li').outerHeight();
				$('.daftar-6 ul li:last-child').prependTo('.daftar-6 ul');
				$('.daftar-6 ul').css('marginTop', -tickerHeight);

				function moveTop_enam() {
					$('.daftar-6 ul').animate({
						top: -tickerHeight
					}, 2000, function () {
						$('.daftar-6 ul li:first-child').appendTo('.daftar-6 ul');
						$('.daftar-6 ul').css('top', '');
					});
				}
				setInterval(function () {
					moveTop_enam();
				}, 1500);
			}, 1000);
		}

		function reload_enam() {
			$('#kelas6').remove();
			$(".daftar-6").append('<ul id="kelas6" style="margin-left: -40px;"></ul>');
			tampil_enam();
		}
	</script>
</body>

</html>