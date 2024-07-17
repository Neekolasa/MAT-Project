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
            <style>
              #spinner {
                display: none;
                width: 50px;
                height: 50px;
                border: 5px solid #f3f3f3;
                border-top: 5px solid #3498db;
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: auto;
              }

              @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
              }

              #loadingMessage {
                display: none;
                text-align: center;
                margin-top: 20px;
              }
            </style>
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
                <h3>Plain Page</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Plain Page</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <button class="btn btn-success" onclick="getData()">Obtener informacion</button>
                    
                    <div class="botones-container text-center">
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableAjusteCKT').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableAjusteCKT').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableAjusteCKT').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableAjusteCKT').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

                           
                        </div>

                      <table id="tableAjusteCKT"  style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Numero de parte</th>
                              <th>Cantidad</th>
                           
                            
                                        
                                            
                            </tr>
                          </thead>


                          <tbody>
                                          
                          </tbody>
                      </table>
                      <div id="spinner"></div>
                      <div id="loadingMessage">Cargando...</div>
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

<script src="build/js/adjustCKT_model.js"></script>
