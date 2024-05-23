<?php $this->extend('layout/main') ?>

<?php $this->section('content') ?>

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Pagos /</span> Importar
</h4>
<section class="section">
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Importación de Archivos de Pago</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" id="frmDatos" name="frmDatos" action="<?php echo base_url("procesararchivos"); ?>" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label for="cboAnio" class="form-label">Año</label>
                                        <select id="cboAnio" class="form-select" name="cboAnio">
                                            <?php foreach ($anios as $anio) { ?>
                                                <option value="<?php echo $anio['cn_id']; ?>"><?php echo $anio['da_nombre']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!--<div class="col-6">
                                        <label for="cboPeriodo" class="form-label">Quincena</label>
                                        <select id="cboQuincena" class="form-select" name="cboQuincena">
                                            <?php //foreach ($quincenas as $quincena) { ?>
                                                <option value="<?php //echo $quincena['cn_id'] ?>"><?php //echo $quincena['da_nombre'] ?></option>
                                            <?php //} ?>
                                        </select>
                                    </div>-->
                                </div>
                                

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p>Archivo(s) Zip a Importar</p>
                                            <div class="form-file" style="cursor: pointer">
                                                <input type="file" class="form-file-input myFile" id="file-rar" multiple data="zip" data2="1024" data3="1" name="file-rar[]">
                                                <label class="form-file-label" for="customFile">
                                                    <span class="form-file-text">Seleccionar Archivo(s)...</span>
                                                    <span class="form-file-button">Buscar</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>   
                                </div>

                                <!--<div class="row mb-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <p>Archivo Xml</p>
                                            <div class="form-file" style="cursor: pointer">
                                                <input type="file" class="form-file-input myFile" id="file-xml" multiple data="xml" data2="1024" data3="1" name="file-xml[]">
                                                <label class="form-file-label" for="customFile">
                                                    <span class="form-file-text">Seleccionar un Archivo...</span>
                                                    <span class="form-file-button">Buscar</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>   
                                </div>-->

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="<?php echo base_url('pagos'); ?>" class="btn btn-outline-secondary me-1" title="Regresar al Listado">
                                        <span class="tf-icons bx bx-left-arrow-circle"></span>&nbsp;Regresart
                                        </a>&nbsp;&nbsp;
                                        <button  type="submit" class="btn btn-outline-primary me-1" id="btnImportar" title="Importar los Pagos">
                                        <span class="tf-icons bx bx-upload"></span>&nbsp;Importar
                                            </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <?php $this->endSection() ?>