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
<title>Picklist BTS - APTIV</title>
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
                <h3>Picklist BTS</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Picklist BTS</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                        <div style="text-align: center;">
                       
                        <div class="botones-container">
                              <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tablePicklist').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                              <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tablePicklist').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                              <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tablePicklist').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                      
                              <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tablePicklist').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

                              <!--<button class="btn btn-warning text-light boton-margen boton-responsivo" onclick="/*clean()*/">Limpiar obsoletos</button>-->
                                 <label>
                               
                            </label>
                          </div>
                        <table id="tablePicklist"  style="width:100%;" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>Numero de parte</th>
                                <th>Tipo</th>
                                <th>Series para servicio</th>
                                <th>Cantidad actual de series</th>
                                <th>Diferencia</th>
                                <th>Punto de uso</th>
                                <th>Comentario</th>       
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
<style type="text/css">
  dtr-title{
  color: black !important;
      
    }
    .dtr-data{
      color: black !important;

    }
    #tablePicklist_info{
      text-align:left !important;
    }
    #tablePicklist_length{
       text-align:left !important;
    }


       .boton-margen {
          margin-right: 10px !important; /* Puedes ajustar el valor del margen según tus preferencias */
      }

       @media (max-width: 767px) {
          .botones-container {
              display: flex;
              flex-wrap: wrap;
              justify-content: center;
          }
      }

      @media (max-width: 480px) {
          .botones-container {
              flex-direction: column;
          }
      }
    .x_title span
    {color: white;}
</style>
<script src="build/js/picklistModel.js"></script>