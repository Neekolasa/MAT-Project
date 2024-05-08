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
                <h3>Plain Page</h3>
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
                        <!--<div class="botones-container text-center">
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_ajuste').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

                           
                        </div>-->
                      <table id="table_pedidos"  style="width:100%;" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Numero de parte</th>
                              <th>Numero de serie</th>
                              <th>Locacion</th>
                              <th>Descripcion</th>
                              <th>Hora de pedido</th>
                              <th>Hora de surtido</th>
                              <th>Tiempo de accion</th>
                              <th>Fecha del pedido</th>
                            
                                        
                                            
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
