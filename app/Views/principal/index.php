<?php //$this->extend('layout/master')
?>
<?php $this->extend('layout/main') ?>

<?php $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Inicio /</span> Bienvenida
</h4>

<div class="row">
    <div class="col-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <?php $session = \Config\Services::session(); ?>
                        <h5 class="card-title text-primary">Bienvenido <?php echo $session->get('nombre') . ' ' . $session->get('ap1') . ' ' .  $session->get('ap2');  ?>! 🎉</h5>
                        <p class="mb-4">
                            Al sistema que le ficilita la importación de los pagos realizados por el FONE
                        </p>

                        <a href="https://miportal.fone.sep.gob.mx" target="_blank" class="btn btn-sm btn-outline-primary">Portal FONE</a>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="<?php echo base_url('assets/img/illustrations/man-with-laptop-light.png') ?>" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="col-lg">
            <div class="card mb-4">
                <h5 class="card-header">Aviso</h5>
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="align-middle"><small class="text-light fw-semibold"></small></td>
                            <td class="py-3">
                                <p class="mb-3" style="font-size:1.2rem; text-align: justify;">
                                    El presente sistema se pone a disposición de manera <b>Gratuita</b>. Como una herramienta que facilita la lectura de los pagos realizados por el <b>FONE</b> y gnerar un archivo <b>Excel </b> para la declaración anual.
                                </p>
                                <p class="mb-3" style="font-size:1.2rem; text-align: justify;">
                                    El sistema no prender recabar ninguna información de dichos pagos. Solo se almacenan para la generación del reporte de Excel. En el sistema se brinda la funcionalidad de eliminar los pagos importados.  
                                </p>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>