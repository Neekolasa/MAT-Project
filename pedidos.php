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
  <title>Pedidos electronicos</title>
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
        <div class="modal fade bs-example-modal-sm" id="delModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Ingrese numero de empleado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
             
                <p>ID del pedido a borrar</p>
                <input type="text" id="delID" readonly class="form-control">
                   <p>Numero de empleado que borra el pedido</p>
                <input type="text" placeholder="Numero de empleado" id="delBadge" class="form-control">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-sign-out"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" id="delButton"><i class="fa fa-trash"></i> Eliminar</button>
              </div>

            </div>
          </div>
        </div>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Solicitar barril nuevo</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>
                  
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pedidos electronicos</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="container">
                          <div class="col-md-12" style="text-align: center;">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                               <input id="pn_pedido" type='text' class="form-control" placeholder="Numero de parte" style="text-align: center;" />

                            </div>
                            <button class="btn btn-primary pull-right" onclick="window.location.replace('http://10.215.156.203/materiales/rutas/pedidosMenu.php')"><i class="fa fa-paper-plane"></i> Atender pedidos</button>
                        
                             <div class="col-sm-12" style="margin-bottom: 10px;">
                              <br>
                              <button id="addPetition_button" class="btn btn-success"><i class="fa fa-exclamation-circle"></i> Solicitar</button>
                             
                            </div>

                          </div>


                      <table id="table_pedidos"  style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Numero de parte</th>
                              <th>Numero de serie</th>
                              <th>Locacion</th>
                              <th>Descripcion</th>
                              <th>Hora de pedido</th>
                              <th>Hora de surtido</th>
                              <th>Tiempo de accion</th>
                              <th>Fecha del pedido</th>
                              <th>Surtidor</th>
                              <th>Estatus</th>
                              <th>Acciones</th>
                            
                                        
                                            
                            </tr>
                          </thead>


                          <tbody>
                                          
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pedidos completados</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="container">
                         


                      <table id="tableCompletePedidos"  style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Numero de parte</th>
                              <th>Numero de serie</th>
                              <th>Locacion</th>
                              <th>Descripcion</th>
                              <th>Hora de pedido</th>
                              <th>Hora de surtido</th>
                              <th>Tiempo de accion (Min)</th>
                              <th>Fecha del pedido</th>
                              <th>Surtidor</th>
                              <th>Estatus</th>
                            
                                        
                                            
                            </tr>
                          </thead>


                          <tbody>
                                          
                          </tbody>
                      </table>
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
<script src="build/js/pedidosMain.js"></script>
