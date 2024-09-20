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
                <h3>Inventario</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Validar Masters</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div style="text-align: center;">
                          <div class="col-md-12" >
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                               <input id="num_master" type='text' class="form-control" placeholder="Serie master" style="text-align: center;" />
                            </div>
                           
                             <div class="col-sm-12">
                              <br>
                              <button id="search_button" class="btn btn-success">Buscar</button>
                              <!--<button id="play" class="btn btn-primary">Play</button>-->
                            </div>   
                          </div>
                          <br>
                          <span id="totalSeries" style="color:black;font-size: 20px;"></span>
                          <br>
                        </div>
                          <table id="dataMaster" class="table table-striped table-bordered" style="width:100%; margin-bottom: 10%;">
                        <thead>
                          <tr>
                            <th>Serie enlazada</th>
                            <th>Serie Master</th>
                            <th>Numero de parte</th>
                            <th>Cantidad</th>
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
<script src="build/js/masterModel.js"></script>
<script type="text/javascript">
  window.location.replace('conversiones.php');
</script>