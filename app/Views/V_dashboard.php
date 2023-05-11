<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Welcome to CodeIgniter 4!</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico" />

</head>

<body>
	<input type="text" id="nomor" />
	<input type="button" onclick="add();" value="add" id="mybtn" />
	<ul id="tampil"></ul>
</body>

</html>

<script type="text/javascript">
	var tampung_array = [];

	function add() {
		var masukan = document.getElementById('nomor');
		tampung_array.push(masukan.value);
		masukan.value = '';
		show();
	}

	function show() {
		var html = '';
		for (var i = 0; i < tampung_array.length; i++) {
			html += '<li>' + tampung_array[i] + '</li>';
		}
		var tampil = document.getElementById('tampil');
		tampil.innerHTML = html;
	}

	// Get the input field
	var input = document.getElementById("nomor");

	// Execute a function when the user presses a key on the keyboard
	input.addEventListener("keypress", function (event) {
		// If the user presses the "Enter" key on the keyboard
		if (event.key === "Enter") {
			// Cancel the default action, if needed
			event.preventDefault();
			// Trigger the button element with a click
			document.getElementById("mybtn").click();
		}
	});
</script>
</body>

</html>