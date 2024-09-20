<!DOCTYPE html>
<html lang="es">
<title>APTIV - Tolvas por ruta</title>
  <?php 
    include 'templates/header.php';
  ?>
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
                <h3>Tolvas por ruta</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Grafico de tolvas por ruta</h2>
                    

                   


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     
                          
                          <!--<div id="weekGraphic"></div>
                          <div id="weekGraphicComparativo"></div>-->
                          <div class="modal fade bs-example-modal-sm" id="modalRegistroVisita" style="overflow-y: auto" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel">Registro de visita</h4>
                                  
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="num_material">Usuario que registra la visita </label>
                                    <select id="userConfirm" class="form-control">
                                        <option value="Ramon Martinez">Ramon Martinez</option>
                                        <option value="Gabriel Aldana">Gabriel Aldana</option>
                                    </select>

                                    <label for="num_material">Escaneo del numero de empleado </label>
                                    <input type="password" id="empNumScanned" class="form-control">
                                    

                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" id="saveVisitedUser">Guardar</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="modal fade bs-example-modal-sm" id="modalRouteOwner" style="overflow-y: auto" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel">Asignar dueños de ruta</h4>
                                  
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="num_material">Seleccione el turno </label>
                                    <select id="turno" class="form-control">
                                      
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                      

                                    </select>
                                    <label for="num_material">Ruta 1 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA1_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA1_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 2 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA2_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA2_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 3 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA3_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA3_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 4 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA4_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA4_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 5 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA5_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA5_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 10 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA10_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA10_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 11 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA11_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA11_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 12 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA12_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA12_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 13 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA13_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA13_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 14 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA14_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA14_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 15 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA15_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA15_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 16 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA16_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA16_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 17 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA17_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA17_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 18 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA18_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA18_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 19 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA19_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA19_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 20 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA20_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA20_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 21 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA21_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA21_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 22 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA22_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA22_PL" class="form-control" placeholder="Linea de produccion">
                                    <br>
                                    <label for="num_material">Ruta 23 <span style="color: red;">*</span></label>
                                    <input type="text" id="RUTA23_Name" class="form-control" placeholder="Dueno de ruta">
                                    <br>
                                    <input type="text" id="RUTA23_PL" class="form-control" placeholder="Linea de produccion">

                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" id="saveRoutes">Guardar</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="well">
                            <button class="btn btn-success" id="routeOwner"><i class="fa fa-shopping-cart"></i> Definir dueños de ruta</button>
                            
                            <button class="btn btn-primary pull-right" style="display: none;" id="checkLogin"><i class="fa fa-edit"></i> Revision diaria </button>
                          </div>
                          <div class="well">
                            <span id="review" style="font-weight: bold;"></span>
                            <ul id="review_list">
                              
                            </ul>
                          </div>
                          <div class="col-md-12 well" style="overflow:auto">
                            <fieldset class="col-md-4">
                              <div class="control-group">
                                <div class="controls">
                                  <div class="col-md-12 form-group has-feedback row xdisplay_inputx">
                                    <input aria-describedby="inputSuccess2Status" class="form-control has-feedback-left" id="single_cal1" placeholder=""> 
                                    <i class="fa fa-calendar form-control-feedback left" aria-hidden="true" style="color:#000"></i> 
                                    <span class="sr-only" id="inputSuccess2Status">(success)</span>
                                  </div>
                                </div>
                              </div>
                            </fieldset>
                            <div>
                              <div class="col-sm-2">
                                <select class="form-control" id="turnoSearch">
                                  <option value="A">A</option>
                                  <option value="B">B</option>
                                </select>
                              </div>
                              <span class="col-sm-2 col-md-2 control-label" style="color:#000;margin:10px auto">Turno</span>
                            </div>
                            <div class="col-sm-2 col-sm-2">
                              <button class="btn btn-success" id="searchTolvaButton"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                          </div>
                          <div class="well col-md-12">
                             <div id="tolvaGraphic" style="width: 100%;"></div>
                          </div>

                          <div class=" col-md-12">
                            <table id="tableTolvas" class="table table-striped table-bordered .progress" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>Ruta</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Numero de vuelta</th>
                                        <th>Tolvas enlazadas</th>
                                        <th>Dueno de ruta</th>
                                      </tr>
                                    </thead>


                                    <tbody style="font-size: 18px !important; ">
                                      
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

    <script src="build/js/tolvaGraphic.js"></script>
    <style type="text/css">
          g {
        font-size: 14px;
    }
    </style>
  </body>
</html>




