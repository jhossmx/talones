 <!-- Vertically Centered Modal -->
 <div class="col-lg-4 col-md-6">
     <small class="text-light fw-semibold">Vertically centered</small>
     <div class="mt-3">
         
         <!-- Modal -->
         <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="modalCenterTitle">Importar Pagos</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <form class="form" method="POST" id="frmDatos" name="frmDatos" action="<?php echo base_url("procesarpagos"); ?>" enctype="multipart/form-data">
                            <div class="row g-2 mb-3">
                                 <div class="col mb-0">
                                    <label for="cboAnio" class="form-label">Año</label>
                                    <select id="cboAnio"  class="form-select" name="cboAnio">
                                        <option value="0">Seleccion</option>
                                        <?php foreach ($anios as $anio) {?>
                                            <option value="<?php echo $anio['cn_id'];?>"><?php echo $anio['da_nombre'];?></option>
                                        <?php }?>
                                    </select>
                                 </div>
                                 <div class="col mb-0">
                                    <label for="cboPeriodo" class="form-label">Quincena</label>
                                    <select id="cboQuincena" class="form-select" name="cboQuincena">
                                        <?php foreach ($quincenas as $quincena) {?>
                                            <option value="<?php echo $quincena['cn_id'] ?>"><?php echo $quincena['da_nombre'] ?></option>
                                        <?php }?>
                                    </select>
                                 </div>
                            </div>    
                            <div class="row">
                                <div class="form-group">
                                    <p>Archivo Xml</p>
                                    <div class="form-file" style="cursor: pointer">
                                        <input type="file" class="form-control myFile" id="file-xml" multiple="" data="xml" data2="1024" data3="1" name="file-xml[]">
                                    </div>
                                </div>
                            </div>
                        </form>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                             Cerrar
                         </button>
                         <button type="button" class="btn btn-primary" id="btnImportar">Importar</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>