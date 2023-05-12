<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>/public/assets/login/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= base_url() ?>/public/assets/login/img/favicon.png">
    <title>
        SUN
    </title>
    <!--     Fonts and icons     -->
    <link href="<?= base_url() ?>/public/assets/login/css/css.css" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="<?= base_url() ?>/public/assets/login/css/nucleo-icons.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="<?= base_url() ?>/public/assets/login/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>/public/assets/login/css/soft-ui-dashboard.css?v=1.0.3"
        rel="stylesheet" />
    <style>
        .papan {
            height: 200px;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- Navbar -->
    <nav
        class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent mt-4">
        <div class="container">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="../pages/dashboards/default.html">
                Soft UI Dashboard
            </a>
            <Button class="btn bg-gradient-dark btn-outline-light pull-right">Login</Button>
        </div>
    </nav>
    <!-- End Navbar -->
    <section class="">
        <div class="page-header align-items-start min-vh-20 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('<?= base_url() ?>/public/assets/login/img/curved-images/curved14.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <input type="number" id="nomor" name="id" />
        </div>
        <div class="container">
            <div class="row mt-lg-n15 mt-md-n11 mt-n15">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto mb-2">
                    <div class="card z-index-0 papan">
                        <h2 class="text-center" style="margin-bottom: -10px;">Kelas I</h2>
                        <div class="card-body">
                            <table id="tb1">
                                <tbody class="output"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto mb-2">
                    <div class="card z-index-0 papan">
                        <h2 class="text-center" style="margin-bottom: -10px;">Kelas II</h2>
                        <div class="card-body">
                            <table id="tb2">
                                <tbody class="output"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto mb-2">
                    <div class="card z-index-0 papan">
                        <h2 class="text-center" style="margin-bottom: -10px;">Kelas II</h2>
                        <div class="card-body">
                            <table id="tb3">
                                <tbody class="output"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto mb-2">
                    <div class="card z-index-0 papan">
                        <h2 class="text-center" style="margin-bottom: -10px;">Kelas I</h2>
                        <div class="card-body">
                            <table id="tb1">
                                <tbody class="output"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <footer class="footer py-10">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto text-center">
                    <p class="mb-0 text-secondary">
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> Soft by Creative Tim.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    <!--   Core JS Files   -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/login/js/core/popper.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/login/js/core/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/login/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/login/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url() ?>/public/assets/login/js/soft-ui-dashboard.min.js?v=1.0.3"></script>

    <script>
        var input = document.getElementById("nomor");

        //create data
        var tampung_arr = [];
        window.onload = function () {
            input.focus();
        }

        function add() {
            tampung_arr.push(input.value);
            input.value = '';
            show();
        }

        function show() {
            var x = 0;
            for (var q = 0; q < tampung_arr; q++) {
                setTimeout(function () {
                    $(".output").append("<tr class='odiv-" + x + "'><td>TEST-" + (x) + "</td></tr>");
                    x++;
                    if (x == (tampung_arr - 1)) { del(); }
                }, 1000 * q);
            }
        }

        function del() {
            var row = $('#tb1 tr:first');
            setTimeout(function () {
                row.remove();
                sho(row);
            }, 1000);
        }

        function sho(row) {
            setTimeout(function () {
                $(".output").append("<tr class='" + row[0].className + "'><td>" + row[0].innerText + "</td></tr>");
                del();
            }, 1000);
        }

        function ad() {
            var row = $('#tb1 tr:first');
            var lst = row[0].className.split("-");
            if ((x - 1) == lst[1]) {
                $(".output").append("<tr class='odiv-" + (x + 1) + "'><td>TEST-" + input.value + "</td></tr>");
            }
        }

        // Execute a function when the user presses a key on the keyboard
        input.addEventListener("keypress", function (event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                add(); ad();
            }
        });
    </script>
</body>

</html>