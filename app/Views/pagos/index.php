<?php //$this->extend('layout/master')?>
<?php $this->extend('layout/main')?>

<?php $this->section('content')?>

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Pagos /</span> Listado
</h4>

<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-end">
                <!--data-bs-toggle="modal" data-bs-target="#modalCenter"-->
                <a type="button" href="<?php echo base_url(route_to('importar')); ?>" class="btn btn-outline-primary"  title="Importar Pagos">
                    <span class="tf-icons bx bx-upload"></span>&nbsp; Importar
                </a>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline">
                            <span class="tf-icons bx bx-file-find h3 text-primary"></span>&nbsp;
                            <span class="card-title h3 text-primary">Filtro de Pagos</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" id="frmFiltrarDatos" name="frmFiltrarDatos"
                                action="<?php echo base_url("filtrarpagos"); ?>">
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <label for="cboAnioFiltro" class="form-label">Año</label>
                                        <select id="cboAnioFiltro" class="form-select" name="cboAnioFiltro">
                                            <option value="0">Seleccion</option>
                                            <?php $i=1; ?>
                                            <?php foreach ($anios as $anio) { ?>
                                                <option value="<?php echo $anio['cn_id'];?>" <?php echo ( ($i==1) ? ' selected ' :'') ?>><?php echo $anio['da_nombre'];?></option>
                                            <?php $i++; }?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <label for="cboQuincenaFiltro" class="form-label">Quincena</label>
                                        <select id="cboQuincenaFiltro" class="form-select" name="cboQuincenaFiltro">
                                            <?php foreach ($quincenas as $quincena) {?>
                                            <option value="<?php echo $quincena['cn_id'] ?>">
                                                <?php echo $quincena['da_nombre'] ?></option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <label for="cboTipoNominaFiltro" class="form-label">Tipo Nomina</label>
                                        <select id="cboTipoNominaFiltro" class="form-select" name="cboTipoNominaFiltro">
                                            <?php foreach ($nominas as $nomina) {?>
                                            <option value="<?php echo $nomina['cn_id'] ?>">
                                                <?php echo $nomina['da_nombre'] ?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="demo-inline-spacing">
                                            <button type="button" class="btn btn-outline-primary" id="btnFiltrar" title="Muestra Pagos según el Filtro">
                                                <span class="tf-icons bx bx-file-find"></span>&nbsp;Filtrar
                                            </button>
                                        </div>
                                        <div class="demo-inline-spacing">
                                            <a href="javascript:void(0);" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ModalReporte" title="Genera un reporte del año Seleccionado">
                                                <i class='bx bx-printer'></i>&nbsp;Reporte de Excel
                                            </a>
                                        </div>
                                        <div class="demo-inline-spacing">
                                            <a href="javascript:void(0);" class="btn btn-outline-danger" id="btnBorrar" title="Borrar Pagos del año Seleccionado">
                                                <i class='bx bx-trash'></i>&nbsp;Eliminar Pagos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--tabla-->
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline">
                            <span class='bx bxs-data h3 text-primary'></span>
                            <span class="card-title h3 text-primary">Resultdo de Filtro</span>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr class="table-dark">
                                            <th class="text-white">Año</th>
                                            <th class="text-white">Quincena</th>
                                            <th class="text-white">Plaza</th>
                                            <th class="text-white">N&oacute;mina</th>
                                            <th class="text-white">Tipo</th>
                                            <th class="text-white">Concepto</th>
                                            <th class="text-white">Descripción</th>
                                            <th class="text-white">Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ResultadoPagos">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between" id="ResultadoTotales">
                            <span>Card Footer</span>
                            <span>Card Footer</span>
                            <span>Card Footer</span>
                            <!--<button class="btn btn-light-primary">Read More</button>-->
                        </div>
                        <!-- table hover -->
                    </div>

                </div>
            </div>
        </div>
        <!--tabla-->
    </section>

</section>

<?php //echo $this->include('pagos/modal'); ?>
<?php echo $this->include('pagos/modalReporte'); ?>
<?php $this->endSection()?>