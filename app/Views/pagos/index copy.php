<?php //$this->extend('layout/master')?>
<?php $this->extend('layout/main')?>

<?php $this->section('content')?>

<div class="page-title">
    <h3>Dashboard</h3>
    <p class="text-subtitle text-muted">A good dashboard to display your statistics</p>
</div>

<section class="section">
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Importación de Archivos de Pago xml</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="POST" id="frmDatos" name="frmDatos"
                                action="<?php echo base_url("procesarpagos"); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <label for="cboAnio" class="form-label">Año</label>
                                        <div class="selectWrapper">
                                            <select id="cboAnio" name="cboAnio">
                                                <option value="0">Seleccion</option>
                                                <option value="1">2019 </option>
                                                <option value="2" selected="">2020 </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <label for="cboPeriodo" class="form-label">Quincena</label>
                                        <div class="selectWrapper">
                                            <select id="cboQuincena" name="cboQuincena">
                                                <?php foreach ($quincenas as $quincena) {?>
                                                <option value="<?php echo $quincena['cn_id'] ?>">
                                                    <?php echo $quincena['da_nombre'] ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-12">
                                        <div class="form-group">
                                            <p>Archivo Xml</p>
                                            <div class="form-file" style="cursor: pointer">
                                                <input type="file" class="form-file-input myFile" id="file-xml" multiple
                                                    data="xml" data2="1024" data3="1" name="file-xml[]">
                                                <label class="form-file-label" for="customFile">
                                                    <span class="form-file-text">Seleccionar un Archivo...</span>
                                                    <span class="form-file-button">Buscar</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"
                                            id="btnImportar">Importar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Filtro de Archvivos Importados</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="POST" id="frmFiltrarDatos" name="frmFiltrarDatos"
                                    action="<?php echo base_url("filtrarpagos"); ?>">
                                    <div class="row">
                                        <div class="col-md-2 col-12">
                                            <label for="cboAnioFiltro" class="form-label">Año</label>
                                            <div class="selectWrapper">
                                                <select id="cboAnioFiltro" name="cboAnioFiltro">
                                                    <option value="0">Seleccion</option>
                                                    <option value="1">2019 </option>
                                                    <option value="2" selected="">2020 </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <label for="cboQuincenaFiltro" class="form-label">Quincena</label>
                                            <div class="selectWrapper">
                                                <select id="cboQuincenaFiltro" name="cboQuincenaFiltro">
                                                    <?php foreach ($quincenas as $quincena) {?>
                                                    <option value="<?php echo $quincena['cn_id'] ?>">
                                                        <?php echo $quincena['da_nombre'] ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 col-12 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary me-1 mb-1"
                                                id="btnFiltrar">Filtrar</button>
                                        </div>

                                        <div class="col-md-2 col-12 d-flex justify-content-end">
                                            <a href="<?=base_url('reporteExcel')?>"
                                                class="btn btn-info pull-right">Reporte de Excel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--tabla-->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Resultdo de Filtro</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Año</th>
                                                <th>Quincena</th>
                                                <th>Tipo</th>
                                                <th>Concepto</th>
                                                <th>Descripción</th>
                                                <th>Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ResultadoPagos">

                                            <tr>
                                                <td class="text-bold-500">Michael Right</td>
                                                <td>$15/hr</td>
                                                <td>$15/hr</td>
                                                <td class="text-bold-500">UI/UX</td>
                                                <td>Remote</td>
                                                <td>Austin,Taxes</td>
                                            </tr>
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

    <?php $this->endSection()?>