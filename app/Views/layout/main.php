<?php helper('html');?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo 'Lector de Pagos ' . ((isset($titulo)) ? ' - '.$titulo:''); ?></title>
    <meta name="description" content="" />

    <!-- Page CSS -->
    <?php echo $this->include('layout/partials/header_css'); ?>

    
    <!-- Helpers -->
    <script src="<?php echo base_url('assets/vendor/js/helpers.js')?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?php echo base_url('assets/js/config.js')?>"></script>

    <?php echo $this->renderSection('css') ?>

    <script>
        const base_url = '<?php echo base_url() . '/' ?>';
        const rutaLogin = '<?php echo 'logout'; ?>'
    </script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="<?php echo base_url(route_to('principal')); ?>" class="app-brand-link">
                <?php echo $this->include('layout/partials/logo'); ?>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <?php echo $this->include('layout/partials/menu'); ?>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center"></div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <!--<li class="nav-item lh-1 me-3">
                  <a
                    class="github-button"
                    href="https://github.com/themeselection/sneat-html-admin-template-free"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  >
                </li>-->

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?php echo base_url('assets/img/avatars/1.png') ?>" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <?php $session = \Config\Services::session(); ?>  
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo $session->get('correo'); ?></span>
                            <?php $tipo = (($session->get('tipo') == '1') ? 'Administrador' : 'Usuario'); ?>
                            <small class="text-muted"><?php echo $tipo ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" id="btnSalir" title="Salir del Sistema">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Salir</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <?php //contenido principal ?>
                <?php $this->renderSection('content')?>
            </div>    
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url('assets/vendor/libs/jquery/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>

    <script src="<?php echo base_url('assets/vendor/js/menu.js')?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo base_url('assets/vendor/libs/apex-charts/apexcharts.js')?>"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url('assets/js/main.js')?>"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url('assets/js/dashboards-analytics.js')?>"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    
    <script src="<?php echo base_url('assets/js/sweetalert2.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.validate.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/additional-methods.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/genericas.js')?>"></script>
    <script src="<?php echo base_url('assets/js/salir.js')?>"></script>


    <?php
    $jsFileArray = [];
    //agrego los extras
    if (isset($js)) {
        $data_js = $js;
        foreach ($data_js as &$jsFile) {
            array_push($jsFileArray, ('assets/js/' . $jsFile . ".js"));
        }
    }
    //js opcionales que le pado del controlador
    foreach ($jsFileArray as $js) {
        echo script_tag($js);
    }
?>

    <?php echo $this->renderSection('js') ?>
  </body>
</html>
