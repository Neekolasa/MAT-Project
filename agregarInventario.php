<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
  <style type="text/css">
  .left_col {
    background: #415f7c !important;
}
</style>
<title>Agregar inventario</title>
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
                <h3>Agregar serie a inventario</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Agregar material a base de datos</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                   <div class="x_content">
                    <div class="col-md-12">
                        <div class="col-md-4"></div>
                        <div class="col-md-4" style="align-content: center;" align="center">
                          <span>Numero de serie</span>
                          <input class="form-control" type="text" name="num_serial" id="num_serial" placeholder="Numero de serie">
                          <span>Numero de serie</span>
                          <input class="form-control" type="text" name="lmSerial" readonly id="lmSerial" placeholder="Numero de serie">
                          <span>Numero de parte</span>
                          <input class="form-control" type="text" name="part_number" readonly id="part_number" placeholder="Numero de parte">
                          <span>Cantidad</span>
                          <input class="form-control" type="text" name="qty" readonly id="qty" placeholder="Cantidad">
                          <span>Unidad de medida</span>
                          <input class="form-control" type="text" name="uom" readonly id="uom" placeholder="Unidad de medida">
                          <br>
                          <button class="btn btn-success" id="btn_sendInventory">Agregar Inventario</button>
                          <button class="btn btn-secondary" id="btn_sendManual">Agregar Manual</button>
                        </div>
                        
                       <div class="col-md-4"></div>
                     </div>
                     <div class="modal fade bs-example-modal-sm" id="modalIdentity" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">

                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel2">Ingrese contrasena</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <span>Contrasena</span>
                            <input class="form-control" type="password" name="password" id="password" placeholder="Contrasena">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="loginPassword">Ingresar</button>
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
<script src="build/js/addInventoryModel.js"></script>