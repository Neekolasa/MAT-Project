<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
  <title>Numeros criticos - APTIV</title>  
  <body class="nav-md-12">
    <div class="container body">
      <div class="main_container"> 
      


        <!-- page content -->
        <div class="right_col" role="main"> 
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <div class="btn-group" style="position: absolute; z-index: 1;margin-left: 2%;">
                  <button class="btn btn-primary" onclick="window.location.replace('http://10.215.156.203/materiales/rutas/pedidos.php')"><i class="fa fa-home"></i> Volver al inicio</button>
                   
                  <button class="btn btn-danger" id="salir"><i class="fa fa-power-off"></i> Cerrar sesion</button>
            
                </div>

                

              </div>

      
            </div>

            <div class="clearfix"></div>
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

                      </div>
                    </div>
                  </div>
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Atender pedidos de barriles</h3>
                      
                  	
                        
                    </div>
                   <span id="user_logged"> </span>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <button class="btn btn-primary" onclick="getPedidoMobileList()"><i class="fa fa-reload"></i>Actualizar pedidos</button>
                     <table id="tableMobilePedidos" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                          	<th>ID</th>
                            
                            <th>Numero de serie</th>
                            <th>Numero de parte</th>
                            <th>Locacion</th>
                            <th>Descripcion</th>
                            <th>Hora de pedido</th>
                            <!--<th>Hora de surtido</th>-->
                            <!--<th>Tiempo de accion</th>-->
                            <!--<th>Fecha del pedido</th>-->
                            <th>Estatus</th>
                            <th>Acciones</th>
                                      
                                          
                          </tr>
                        </thead>


                        <tbody style="font-size: 12px !important; font-weight: bold;" id="trTable">
                                        
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer style="margin-left:auto;">
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
<script src="build/js/pedidosModel.js"></script>


