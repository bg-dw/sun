<!DOCTYPE html>
<html lang="en">


<!-- chart-apexchart.html  21 Nov 2019 03:58:53 GMT -->

<head>
    <?= $this->include('_layout/admin/Header') ?>
</head>

<body>
    <div class="loader"></div>
    <div id="app d-print-none">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <?= $this->include('_layout/admin/Nav') ?>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <?= $this->include('_layout/admin/SideBar') ?>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-body">
                        <?php $this->renderSection('content'); ?>
                    </div>
                </section>
            </div>
            <footer class="main-footer  d-print-none">
                <?= $this->include('_layout/admin/Footer') ?>
            </footer>
            <?= $this->include('_layout/admin/Modal') ?>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="<?= base_url() ?>/public/assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <script src="<?= base_url() ?>/public/assets/bundles/apexcharts/apexcharts.min.js"></script>
    <!-- Page Specific JS File -->
    <!-- <script src="<?= base_url() ?>/public/assets/js/page/chart-apexcharts.js"></script> -->
    <!-- Template JS File -->
    <script src="<?= base_url() ?>/public/assets/bundles/datatables/datatables.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/bundles/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script
        src="<?= base_url() ?>/public/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="<?= base_url() ?>/public/assets/js/page/datatables.js"></script>
    <script src="<?= base_url() ?>/public/assets/bundles/izitoast/js/iziToast.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/bundles/sweetalert/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/bundles/select2/dist/js/select2.full.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="<?= base_url() ?>/public/assets/js/custom.js"></script>
    <?= $this->include('_layout/alert') ?>
    <script>
        $(function () {
            // $('.date-d').datepicker({
            //     changeMonth: true,
            //     changeYear: true,
            //     showButtonPanel: true,
            //     dateFormat: 'dd'
            // });
            // $(".datepicker-d").daterangepicker(
            //     {
            //         dateFormat: 'dd',
            //         singleDatePicker: true
            //     }
            // );
        });
    </script>
</body>


<!-- chart-apexchart.html  21 Nov 2019 03:58:55 GMT -->

</html>