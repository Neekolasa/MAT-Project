<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>

  <body class="nav-md-12">
    <div class="container body">
      <div class="main_container">
      


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <div class="btn-group" style="position: fixed; z-index: 1;margin-left: 2%;">
                  <button class="btn btn-primary" onclick="window.location.replace('http://10.215.156.203/materiales/rutas/index.php')"><i class="fa fa-home"></i> Volver al inicio</button>
                <button class="btn btn-success" onclick="window.location.replace('http://10.215.156.203/materiales/rutas/index.php')" style="margin-left: 10px;"><i class="fa fa-upload"></i> Subir criticos desde archivo</button>
                </div>
                

              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <div>
                      
                      <div class="col-md-12">
                        <img  class="col-md-1" style="-moz-transform: scaleX(-1);
                                                                      -webkit-transform: scaleX(-1);
                                                                      -o-transform: scaleX(-1);
                                                                      transform: scaleX(-1);
                                                                      -ms-filter: fliph; /*IE*/
                                                                      filter: fliph; /*IE*/"  src="src/lol.png">
                        <div class="col-md-10"><h1 style="color: black; text-align: center;" id="titleCriticos"></h1></div>
                         <img class="col-md-1" style="display: flex; margin-top: 2%;" src="src/Aptiv_logo.png">
                      </div>
                      <div class="col-md-12" style=" font-size: 21px;color: black; text-align: center;">Desarrollado por: Ing Joel Andrade Enriquez</div>
                   
                        
                    </div>
                   
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <table id="table_criticos" class="table table-striped table-bordered .progress" style="width:100%">
                        <thead>
                          <tr>
                            <th>Numero de parte</th>
                            <th>Locacion</th>
                            <th>Estatus</th>
                            <th>Fecha</th>
                                      
                                          
                          </tr>
                        </thead>


                        <tbody style="font-size: 18px !important;">
                                        
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
<script src="build/js/realtime_criticos.js"></script>
