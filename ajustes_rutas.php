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
<title>Ajuste de material - APTIV</title>
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
                <h3>Ajuste de material sin enlazar</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Material sin enlazar / Faltante de descuento parcial</h2>
                    <button class="btn btn-success pull-right" id="autoAdjustButton"><i class="fa fa-refresh"> </i> Iniciar ajustes automaticos</button>
                    <button class="btn btn-primary pull-right" id="stopAdjust"><i class="fa fa-bomb"></i> Detener ajustes automaticos</button>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
              
                      <div class="container">
                        <div class="botones-container text-center">
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

                           
                        </div>
                      <table id="table_ajuste"  style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Numero de parte</th>
                              <th>Punto de uso</th>
                              <th>Contenedor</th>
                              <th>Total sin descontar</th>
                              <th>UoM</th>
                              <th>SAPProcess</th>
                              <th>Fecha</th>
                            
                                        
                                            
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
                    <h2>Material disponible para el descuento</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                     
                  
                       <table id="table_disponible" style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Numero de parte</th>
                              <th>Numero de serie</th>
                              <th>StdPack</th>
                              <th>Cantidad actual</th>
                              <th>Cantidad sin descontar</th>
                            </tr>
                          </thead>


                          <tbody>
                                          
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
                    <h2>Material con diferencia de cantidades</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                     
                  
                       <table id="table_diferencia" style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Numero de parte</th>
                              <th>Numero de serie</th>
                              <th>StdPack</th>
                              <th>Cantidad actual</th>
                              <th>Cantidad sin descontar</th>
                              <th>Diferencia</th>
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

<script src="build/js/ajusteModel.js"></script>
