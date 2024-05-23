<?php helper('html');?>
<!DOCTYPE html>
<html lang="es" >
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo 'Lector de Pagos ' . ((isset($titulo)) ? ' - '.$titulo:''); ?></title>
    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/img/favicon/favicon.ico')?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"  rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fonts/boxicons.css')?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/core.css')?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/theme-default.css')?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo.css')?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/pages/page-auth.css')?>" />
    <!-- Helpers -->
    <script src="<?php echo base_url('assets/vendor/js/helpers.js')?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo base_url('assets/js/config.js')?>"></script>

    <?php echo $this->renderSection('css') ?>
    <?php
        //archivos css requeridos por el template
        $cssFileArray = [];
        //agrego los extras
        if (isset($css)) {
            $data_ccs = $css;
            foreach ($data_ccs as &$cssFile) {
                array_push($cssFileArray, ('css/' . $cssFile . ".css"));
            }
        }

        //css opcionales que le pado del controlador
        foreach ($cssFileArray as $css) {
            echo link_tag($css);
        }
    ?>
    <script>
        var base_url = '<?php echo base_url() ?>/';
    </script>
  </head>

  <body>
    <?php $session = \Config\Services::session(); ?>
    <!-- Content -->
    <div class="container-xxl">
        <?php //contenido principal ?>
        <?php $this->renderSection('content') ?>

      
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url('assets/vendor/libs/jquery/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>

    <script src="<?php echo base_url('assets/vendor/js/menu.js')?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?php echo base_url('assets/js/main.js')?>"></script>

    <!-- Page JS -->
    <?php echo $this->renderSection('js') ?>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
