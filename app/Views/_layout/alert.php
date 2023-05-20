<?php if (session()->has('success')): ?>
    ?>
    <script>
        iziToast.success({
            title: 'Success!',
            message: '<?= session()->getFlashdata('success') ?>',
            position: 'topCenter'
        });
    </script>
    <?php
endif; ?>
<?php if (session()->has('warning')):
    ?>
    <script>
        iziToast.error({
            title: 'error!',
            message: '<?= session()->getFlashdata('warning') ?>',
            position: 'topCenter'
        });
    </script>
    <?php
endif; ?>

<?php if (session()->has('error')):
    ?>
    <script>swal('Error', "<?= session()->getFlashdata('error') ?>", 'error');</script>
    <?php
endif; ?>