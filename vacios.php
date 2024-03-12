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
                <h3>Control del material vacio</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bajas del dia</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
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
                            <select class="form-control" id="turno">
                              <option value="A">A</option>
                              <option value="B">B</option>
                            </select>
                          </div>
                          <span class="col-sm-2 col-md-2 control-label" style="color:#000;margin:10px auto">Turno</span>
                        </div>
                        <div class="col-sm-2 col-sm-2">
                          <button class="btn btn-success" id="searchEmpty_Button">Buscar</button>
                        </div>
                      </div>
                      <table id="tableBajas" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Numero de parte</th>
                            <th>Numero de serie</th>
                            <th>No Empleado</th>
                            <th>Nombre</th>
                            <th>Accion</th>
                            <th>Fecha</th>
                         
                                      
                                          
                          </tr>
                        </thead>


                        <tbody style="font-size: 12px !important;">
                                        
                        </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bajas por usuario</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="emptyUsers" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>No Empleado</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Series dadas de baja</th>
                            <th>Fecha</th>
                         
                                         
                          </tr>
                        </thead>


                        <tbody style="font-size: 12px !important;">
                                        
                        </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bajas por numero de parte</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <table id="emptyNumbers" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Numero de parte</th>
                            <th>Series vaciadas</th>
                            <th>No Empleado</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                         
                                         
                          </tr>
                        </thead>


                        <tbody style="font-size: 12px !important;">
                                        
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
<script src="build/js/emptyModel.js"></script>
