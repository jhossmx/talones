<!-- Modal Reporte-->
<div class="modal fade" id="ModalReporte" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Par&aacute;metros del Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="FrmReporte" name="FrmReporte" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="cboAnioReporte" class="form-label">Año del Reporte</label>
                            <select id="cboAnioReporte" class="form-select" name="cboAnioReporte">
                                <option value="0">Seleccion</option>
                                <?php $i=1; ?>
                                <?php foreach ($anios as $anio) { ?>
                                    <option value="<?php echo $anio['cn_id'];?>" <?php echo ( ($i==1) ? ' selected ' :'') ?>><?php echo $anio['da_nombre'];?></option>
                                <?php $i++; }?>
                            </select>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="mb-2">
                            <label for="txt_monto" class="col-12 col-form-label">Monto Compensac&oacute;n:</label>
                            <div class="col-12">
                                <input class="form-control" type="number" value="0.00" id="txt_monto" name="txt_monto" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2">
                            <label for="txt_monto_Compe_Ant" class="col-12 col-form-label">Monto Segunda Parte Aguinaldo Compesación (Año Anterior)</label>
                            <div class="col-12">
                                <input class="form-control" type="number" value="0.00" id="txt_monto_Compe_Ant" name="txt_monto_Compe_Ant" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-2">
                            <label for="txt_monto_Compe_Act" class="col-12 col-form-label">Monto Primera Parte Aguinaldo Compesación (Año Actual)</label>
                            <div class="col-12">
                                <input class="form-control" type="number" value="0.00" id="txt_monto_Compe_Act" name="txt_monto_Compe_Act" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="btnCerrar" title="Cerrar Ventana" onclick="hide_modal();">
                        <i class='bx bx-x-circle'></i>&nbsp;Cerrar
                    </button>
                    <button type="button" id="btnReporte" class="btn btn-outline-primary" title="Genera Reporte Excel">
                        <i class='bx bx-printer'></i>&nbsp;Reporte de Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Reporte-->