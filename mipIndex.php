<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>

  <body class="col-md-12" background="">
    <div class="container body">
      <div class="main_container">
       

        <!--############-->
            <?php include 'templates/newNavbar.php' ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              
              </div>

            <title>MIP - Movers Interplantas</title>
            </div>

            <div class="clearfix"></div>
            

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Creacion y administracion de movers</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 " id="authorizedMovers" style="cursor: pointer;">
                          <div class="tile-stats">
                            <div class="icon"><i class="fa fa-plus-square" style="color: #40c1a6;"></i>
                            </div>
                            <div class="count" id="createdMovers"></div>

                            <h3>Movers autorizados</h3>
                            <p>Informacion de movers creados</p>
                          </div>
                        </div>

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 " id="queueMovers_container" style="cursor: pointer;">
                          <div class="tile-stats">
                            <div class="icon"><i class="fa fa-refresh" style="color: #40c1a6;"></i>
                            </div>
                            <div class="count" id="processingMovers"></div>

                            <h3>Movers en proceso</h3>
                            <p>Informacion de movers en proceso</p>
                          </div>
                        </div>

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6" id="finishedMovers_container" style="cursor: pointer;">
                          <div class="tile-stats">
                            <div class="icon"><i class="fa fa-check-square" style="color: #40c1a6;"></i>
                            </div>
                            <div class="count" id="finishedMovers"></div>

                            <h3>Movers finalizados</h3>
                            <p>Informacion de movers finalizados</p>
                          </div>
                        </div>

                        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 " id="shippedMovers_container" style="cursor: pointer;">
                          <div class="tile-stats">
                            <div class="icon"><i class="fa fa-truck" style="color: #40c1a6;"></i>
                            </div>
                            <div class="count" id="shippedMover"></div>

                            <h3>Movers enviados</h3>
                            <p>Informacion de movers enviados por embarques</p>
                          </div>
                        </div>


                        <div class="row col-md-12">
                          <div class="clearfix"></div>
                          <div class="modal fade bs-example-modal-sm" id="masiveMaterialModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel2">Agregar material desde archivo</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                             
                                  <p>Para agregar un mover desde un archivo debe descargar la plantilla y llenar los campos solicitados</p>
                                  <button class="btn btn-success" id="downloadTemplate"><i class="fa fa-download"></i> Descargar plantilla</button>
                                  <p>Llene la plantilla, seleccione el archivo y haga click en Cargar informacion</p>
                                  <form action="#" id="excel" accept=".xlsx" class="">
                                    <button class="btn btn-primary" id="newUpload-info" type="file" accept='.xlsx'><i class="fa fa-upload"></i> Cargar informacion</button>
                                    <!--<button class="btn btn-primary" id="upload-info" type="file" accept='.xlsx'><i class="fa fa-upload"></i> Cargar informacion</button>-->

                                    <input id="file-upload" accept='.xlsx' type="file"/>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="modal fade bs-example-modal-xl" id="modalCreatedMovers" style="overflow-y: auto" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel">Movers creados</h4>
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="input-group" id="moverSearchPN">
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-primary go-class" id="moverPNButton"><i class="fa fa-search"></i> Buscar mover por NP</button>
                                    </span>
                                    <input type="text" class="form-control col-md-3 col-sm-3" id="moverPNInput">
                                    <!--<input type="text" id="inputID" class="form-control col-md-3 col-sm-3">-->
                                  </div>
                                  <table id="tableMoverCreated" placeholder="Ingrese numero de parte" class="table table-striped table-bordered .progress" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>ID Mover</th>
                                        <th>Creador del mover</th>
                                        <th>Planta destino</th>
                                        <th>Instrucciones de envio</th>
                                        <th>Comentarios adicionales</th>
                                        <th>Estatus</th>
                                        <th>Fecha de creacion</th>
                                        <th>Acciones</th>
                                      </tr>
                                    </thead>


                                    <tbody style="font-size: 18px !important; ">
                                      
                                    </tbody>
                                </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="modal fade bs-example-modal-xl" id="modalMoverDetails" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel">Informacion del mover</h4>
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <table id="tableMoverItems" class="table table-striped table-bordered .progress" style="width:100%">
                                    <thead>
                                      <tr>

                                        <th>Numero de parte</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>TSA</th>
                                        <th>Item</th>
                                        <th>UoM</th>
                                        <!--<th>ID</th>-->
                                      </tr>
                                    </thead>


                                    <tbody style="font-size: 18px !important;">
                                      
                                    </tbody>
                                </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                               
                                </div>

                              </div>
                            </div>
                          </div>
                           <div class="modal fade bs-example-modal-lg" id="settingModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel2">Ajustes del mover</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div id="updateStatusForm">
                                    <h4>Actualizar estatus</h4>
                                    <input type="hidden" id="moverUniqueID">
                                    <input type="hidden" id="moverUserLogged">
                                    <select class="form-control" id="statusMover">
                                      <option value="Processing" id="moverPrepared">Preparando mover</option>
                                      <option value="Finished" id="moverSended">Mover enviado a embarques</option>
                                      <option value="Shipped" id="moverShipped">Mover salio de planta</option>
                                    </select>
                                    <br>
                                    <button class="btn btn-success"  id="updateStatus"><i class="fa fa-plus"></i> Actualizar estatus</button>
                                    <br>
                                    <br>
                                  </div>
                                  
                                  
                                   <div id="extraCommentsNonShipped">
                                  <h4>Agregar comentarios</h4>

                                  <textarea id="extraComments" class="form-group col-md-12 col-sm-12"></textarea>
                                  <br>
                                  <button class="btn btn-success" id="addExtraComment"><i class="fa fa-plus"></i> Agregar comentario</button>
                                   </div>
                                  <div id="shipmentForm">
                                    <h4>Formulario de envio</h4>
                                    <label for="shippedStatusMover">Actualizar estatus</label>
                                      <select class="form-control" id="shippedStatusMover">
                                        <option value="Shipped">Mover salio de planta</option>
                                      </select>

                                     <label for="shippedStatusMover">Numero de delivery</label>
                                     <input class="form-control" type="text" min="1" id="deliveryNumber">
                                       <div id="hideUOMShipped">
                                     <label for="shippedStatusMover">Cantidad</label>
                                     <input class="form-control" id="shippedQty">
                                  
                                      
                                   
                                     <label for="shippedStatusMover">Unidad de medida</label>
                                     <select class="form-control" id="shippedUom">
                                       <option value="FT">FT</option>
                                       <option value="PC">PC</option>
                                       <option value="M">M</option>
                                       <option value="KG">KG</option>
                                       <option value="G">G</option>
                                       <option value="LB">LB</option>
                                     </select>
                                      </div>
                                    
                                     <label for="shippedBox">Caja o placas</label>
                                     <input class="form-control"  id="shippedMoverBox">

                                     <label for="shippedBox">Comentarios adicionales</label>
                                     <textarea id="extraShippedComments" class="form-group col-md-12 col-sm-12"></textarea>
                                    

                                  </div>
                                  <button class="btn btn-success"  id="updateShippedStatus"><i class="fa fa-plus"></i> Enviar informacion</button>
                                  <br>
                                  <br>
                                   <table id="table_comments" class="table table-striped table-bordered .progress" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>Usuario</th>
                                          <th>Area</th>
                                          <th>Comentario</th>
                                          <th>Fecha</th>
                                      
                                          
                                        </tr>
                                      </thead>


                                      <tbody style="font-size: 18px !important;">
                                        
                                      </tbody>
                                    </table>
                                </div>

                               
                                

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                               
                                </div>

                              </div>
                            </div>
                  </div>
                          <div class="col-md-6" style="margin: 0 auto;" >
                          
                           <input type="hidden" id="fullname">
                          <div class="well" style="overflow: auto" class="col-md-12" id="moverMainForm">
                            <h2 class="text-center">Crear un nuevo Mover</h2>
                            <button class="btn btn-success" id="buttonMasiveMaterial"><i class="fa fa-upload"></i> Cargar desde archivo</button>
                            <p class="text-center" style="margin: 0 auto;"><span style="color: red; font-size: 17px;">*</span> Campos requeridos</p>
                                 <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Usuario logeado</label>
                                  <div class="col-md-3 col-sm-3 ">
                                    <input type="text" class="form-control" readonly id="userLogged">
                                  </div>
                                </div>
                                 
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Planta origen <span style="color: red; font-size: 17px;">*</span></label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id="planta_origen" readonly placeholder="Planta origen">
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Usuario que autoriza <span style="color: red; font-size: 17px;">*</span></label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id = 'usuario_autoriza' readonly placeholder="Usuario que autoriza">
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Telefono</label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id="telefono" placeholder="Telefono">
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Fecha de creacion <span style="color: red; font-size: 17px;">*</span></label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id='fecha_creacion' readonly placeholder="Fecha de creacion">
                                  </div>
                                </div>

                                <div class="x_title"></div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Planta destino <span style="color: red; font-size: 17px;">*</span></label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id = 'planta_destino' placeholder="Planta destino">
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Atencion <span style="color: red; font-size: 17px;">*</span></label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id ="atencion" placeholder="Atencion">
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Telefono atencion</label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id="telefono_atencion" placeholder="Telefono atencion">
                                  </div>
                                </div>
                                
                                 <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Instrucciones de envio</label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <input type="text" class="form-control" id="intrucciones_envio" placeholder="Instrucciones de envio">
                                  </div>
                                </div>
                                <div class="form-group row ">
                                  <label class="control-label col-md-3 col-sm-3 ">Comentarios adicionales</label>
                                  <div class="col-md-9 col-sm-9 ">
                                    <textarea type="textarea" class="form-control" id="comentarios_adicionales" placeholder="Comentarios adicionales"></textarea>
                                  </div>
                                </div>

                                <div class="x_title">Material a solicitar</div>
                                
                                <div id ="materialesContainer">
                                  <div class="element">
                                    <form id="materialsInfo">
                                      <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Numero de parte <span style="color: red; font-size: 17px;">*</span></label>
                                        <div class="col-md-9 col-sm-9 ">
                                          <input type="text" class="form-control numero_parte" name='numero_parte[]' id="numero_parte" placeholder="Numero de parte">
                                        </div>
                                      </div>

                                      <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Cantidad <span style="color: red; font-size: 17px;">*</span></label>
                                        <div class="col-md-9 col-sm-9 ">
                                          <input type="number" class="form-control qty" name='qty[]' id="qty"  readonly placeholder="Cantidad">
                                        </div>
                                      </div>

                                      <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Descripcion <span style="color: red; font-size: 17px;">*</span></label>
                                        <div class="col-md-9 col-sm-9 ">
                                          <input type="text" class="form-control descripcion" readonly name='description[]' id="description" placeholder="Descripcion">
                                        </div>
                                      </div>

                                      <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Unidad de medida <span style="color: red; font-size: 17px;">*</span></label>
                                        <div class="col-md-3 col-sm-3 ">
                                          <!--<input type="text" class="form-control uom" readonly name='uom[]' id="" placeholder="Unidad de medida">-->
                                          <select id="uom" class="form-control">
                                            <option value="PC">PC</option>
                                            <option value="M">M</option>
                                            <option value="FT">FT</option>
                                            <option value="KG">KG</option>
                                          </select>
                                        </div>
                                      </div>

                                      <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">TSA <span style="color: red; font-size: 17px;">*</span></label>
                                        <div class="col-md-3 col-sm-3 ">
                                          <input type="text" class="form-control mov_type" name='mov_type[]' id="mov_type" readonly placeholder="TSA">
                                        </div>
                                      </div>
                                      <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Item <span style="color: red; font-size: 17px;">*</span></label>
                                        <div class="col-md-3 col-sm-3 ">
                                          <input type="text" class="form-control sap_document" name='sap_document[]' readonly id="sap_document" placeholder="Item">
                                        </div>
                                      </div>
                                      <div class="x_title form-group"></div>
                                  </div>
                                   </div>
                                 </form>
                                
                                <div class="form-group row ">
                                  <div class="col-md-7 col-sm-7  ">
                                    <button class="btn btn-success" id="agregarMover"><i class="fa fa-plus"></i> Agregar material a mover</button>
                                  </div>
                                  <div class="col-md-5 col-sm-5">
                                    <!--<button class="btn btn-primary" id="buttonMasiveMaterial"><i class="fa fa-file-text-o"></i> Agregar material masivo a mover</button>-->
                                  </div>
                                   
                                </div>

                                <table id="table_mover" class="table table-striped table-bordered .progress" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Numero de parte</th>
                                        <th>Descripcion</th>
                                        <th>UoM</th>
                                        <th>Cantidad</th>
                                        <th>Acciones</th>
                                        
                                      </tr>
                                    </thead>


                                    <tbody >
                                      
                                    </tbody>
                                </table>


                                <div class="ln_solid"></div>
                                  <div class="form-group">
                                    <div class="col-md-9 col-sm-9  offset-md-3">
                                      <button  class="btn btn-primary" id="resetForm"><i class="fa fa-refresh"></i> Reiniciar formulario</button>
                                      <button  class="btn btn-success" id="sendMover"><i class="fa fa-pencil"></i> Crear mover</button>
                                    </div>
                                  </div>
                           
                          </div>


                        </div>
                      </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
       <footer style="margin-left: auto;">
            <div class="pull-right"> 
                MIP - Sistema de Movers Interplanta
            </div>
            <div class="pull-left"> 
                Desarrollado por: Ing Joel Andrade Enriquez 
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <?php include 'templates/footerLibs.php' ?>  
  </body>
</html>

<script src="build/js/mipForm.js"></script>
<script src="build/js/mipMoversModel.js"></script>
<script src="build/js/datatables-custom.js"></script>


