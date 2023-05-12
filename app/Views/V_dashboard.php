<!DOCTYPE html>
<html lang="en">


<!-- auth-forgot-password.html  21 Nov 2019 04:05:02 GMT -->

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<title>Otika - Admin Dashboard tamplate</title>
	<!-- General CSS Files -->
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/assets/css/app.min.css">
	<!-- tamplate CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/assets/css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/assets/css/components.css">
	<!-- Custom style CSS -->
	<link rel="stylesheet" href="<?= base_url() ?>/public/assets/assets/css/custom.css">
	<link rel='shortcut icon' type='image/x-icon' href='<?= base_url() ?>/public/assets/assets/img/favicon.ico' />
</head>

<body>
	<!-- <div class="loader"></div> -->
	<div id="app">
		<section class="section">
			<div class="container mt-5">
				<input type="number" id="nomor" name="id" />
				<div class="row">
					<div class="col-4 mb-2">
						<div class="card card-primary h-100">
							<div class="card-header">
								<h4>Forgot Password</h4>
							</div>
							<div class="card-body">
								<table id="tb1">
									<tbody class="output"></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-4 mb-2">
						<div class="card card-primary h-100">
							<div class="card-header">
								<h4>Forgot Password</h4>
							</div>
							<div class="card-body">
							</div>
						</div>
					</div>
					<div class="col-4 mb-2">
						<div class="card card-primary h-100">
							<div class="card-header">
								<h4>Forgot Password</h4>
							</div>
							<div class="card-body">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4 mb-2">
						<div class="card card-primary h-100">
							<div class="card-header">
								<h4>Forgot Password</h4>
							</div>
							<div class="card-body">
							</div>
						</div>
					</div>
					<div class="col-4 mb-2">
						<div class="card card-primary h-100">
							<div class="card-header">
								<h4>Forgot Password</h4>
							</div>
							<div class="card-body">
							</div>
						</div>
					</div>
					<div class="col-4 mb-2">
						<div class="card card-primary h-100">
							<div class="card-header">
								<h4>Forgot Password</h4>
							</div>
							<div class="card-body">
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<script src="https://code.jquery.com/jquery-3.7.0.js"
		integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
	<!-- General JS Scripts -->
	<script src="<?= base_url() ?>/public/assets/assets/js/app.min.js"></script>
	<!-- JS Libraies -->
	<!-- Page Specific JS File -->
	<!-- tamplate JS File -->
	<script src="<?= base_url() ?>/public/assets/assets/js/scripts.js"></script>
	<!-- Custom JS File -->
	<script src="<?= base_url() ?>/public/assets/assets/js/custom.js"></script>
	<script>
		var input = document.getElementById("nomor");
		var tamp = ['1', '2', '3', '4', '5'];
		var x = 0;
		var con = 0;
		window.onload = function () {
			input.focus();
			show();
		}
		// Execute a function when the user presses a key on the keyboard
		input.addEventListener("keypress", function (event) {
			// If the user presses the "Enter" key on the keyboard
			if (event.key === "Enter") {
				// Cancel the default action, if needed
				event.preventDefault();
				tamp.push(input.value);
				input.value = '';
				add();
				// ad();
				// show();
			}
		});

		//create data

		function add() {
			setTimeout(function () {
				$('.output').remove();
				$("#tb1").append('<tbody class="output"></tbody>');
				show();
			}, 1000);
			con = 1;
		}

		function show() {
			var q = 0;
			// while (x < tamp.length) {
			for (let x in tamp) {
				console.log(x + "aw");
				setTimeout(function () {
					$(".output").append("<tr class='odiv-" + tamp[x] + "'><td>TEST-" + (tamp[x]) + "</td></tr>");
					// x++;
					console.log("hasil=" + x + " - " + (tamp.length - 1));
					if (x == (tamp.length - 1)) {
						del();
					}
				}, 1000 * x);
			}
			x = 0;
			// q++;
			console.table(tamp);
		}
		// }
		// console.log(tamp);
		// while (con == 0) {
		function del() {
			var row = $('#tb1 tr:first');
			setTimeout(function () {
				row.remove();
				sho(row);
			}, 1000);
		}

		// function sho(row) {
		// 	// if (con === 1) {
		// 	// 	return show();
		// 	// }
		// 	setTimeout(function () {
		// 		$(".output").append("<tr class='" + row[0].className + "'><td>" + row[0].innerText + "</td></tr>");
		// 		del();
		// 	}, 1000);
		// }
		// 	if (i === 1) break;

		// }

		// function ad() {
		// 	var row = $('#tb1 tr:first');
		// 	var ind;
		// 	if (row) {
		// 		var lst = row[0].className.split("-");
		// 		ind = lst[1];
		// 	} else {
		// 		ind = 1;
		// 	}
		// 	if ((x - 1) == ind) {
		// 		$(".output").append("<tr class='odiv-" + (x + 1) + "'><td>TEST2-" + input.value + "</td></tr>");
		// 	}
		// 	input.value = '';
		// 	// console.log(tamp);
		// }
	</script>
</body>


<!-- auth-forgot-password.html  21 Nov 2019 04:05:02 GMT -->

</html>