<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
  <title>APTIV - Descuento parcial</title>
 
  <style type="text/css">
  .left_col {
    background: #415f7c !important;
}
</style>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
             <?php 
              include 'templates/logo.php';
            ?>
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php 
              include 'templates/navbar.php';
            ?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <?php 

          include 'templates/topNavbar.php';
        ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Control de cantidades</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Descuento parcial</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                 
                  <div class="x_content col-md-12">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <button class="btn btn-danger pull-left col-md-1" id="salir" ><i class="fa fa-power-off"></i> </button>
                        <input type="text" class="form-control text-center  col-md-3"  id="user_logged" disabled>
                      </div>

                      <div class="col-sm-6 ">
                        <span id="time" class="pull-right" style="font-size: x-large;"></span>
                      </div>
                    </div>
                     <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div class="well text-center" style="overflow: auto" class="col-md-12">
                          <div class="col-md-12 text-center">
                            <div class="text-center">
                              <label class="col-form-label col-md-6 col-sm-6" for="material_discount">Cantidad a descontar</label>
                              <input id="material_discount" min="1" required value="1" type="number" class="form-control text-center col-md-6 col-sm-6" style="margin-bottom: 10px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc" placeholder="Cantidad a descontar">
                              </input>
                            </div>

                            <input id="material_sn" type="text" required class="form-control text-center col-md-12" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-bottom: 10px;" placeholder="Serie">
                            </input>
                            <div class="text-center">
                              <label class="col-form-label col-md-6 col-sm-6" for="material_discount">Cantidad actual</label>
                              <input id="qty_actual" readonly type="text" class="form-control text-center col-md-6 col-sm-6" style="margin-bottom: 10px; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc" disabled>
                              </input>
                            </div>
                           

                            <input id="material_pn" type="text" readonly  required class="form-control text-center col-md-12" style=" cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-bottom: 10px;" disabled placeholder="Numero de parte">
                            </input>



                            
                           
                            <!--<div class="col-md-12">
                              <br>
                              <button class="btn btn-success" id="dataSearch">Buscar</button>
                            </div>
                          </div>-->
                          

                      </div>

                      

                    </div>
                    <div>
                      <div class="well text-center">
                        <button class="btn btn-primary" id="qtyUpdateButton">Actualizar cantidad</button>
                      </div>
                    </div>
                     
                    <div class="modal fade bs-example-modal-sm" id="modalUpdate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Actualizar cantidad de una serie</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                            
                             	
                             
                                <label for="material_snQty">Numero de serie <span style="color: red;">*</span></label>
                                <input type="text"  id="material_snQty" class="form-control" required>
                                <label for="actual_qty">Cantidad actual <span style="color: red;"></span></label>
                                <input type="text"  disabled min="0" name="actual_qty" id="actual_qty" class="form-control">
                                <label for="partNumber">Numero de parte <span style="color: red;"></span></label>
                                <input type="text" disabled min="0" name="partNumber" id="partNumber" class="form-control">
                                <label for="new_qty">Nueva cantidad <span style="color: red;">*</span></label>
                                <input type="number" min="0" name="new_qty" id="new_qty" class="form-control" required>
                                <br>
                                <br>
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button id="updateQtySubmit" class="btn btn-primary">Actualizar</button>
                            </div>
                          
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="modal fade bs-example-modal-sm" id="modal_login" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Validar acceso</h4>
                              <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>-->
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form autocomplete="off">
                                <label for="badge">Numero de empleado <span style="color: red;">*</span></label>
                                <input type="text" min="0" name="badge" id="badge" class="form-control" required>
                                <br>
                                <br>
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>-->
                              <button type="submit" id="ingresar_button" class="btn btn-primary">Ingresar</button>
                            </div>
                            </form>
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
        <footer>
            <div class="pull-right">
                APTIV - Materials Admin Tool 
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

<script src="build/js/getIP.js"></script>
<script src="build/js/partial_discount.js"></script>



