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
                    <h2>Plain Page</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="col-md-12">
                        <div class="col-md-4"></div>
                        <div class="col-md-4" style="align-content: center;" align="center">
                          <input class="form-control" type="text" name="scannedMaterial" id="scannedMaterial" placeholder="Numero de parte">
                          <br>
                          <span>Numero de parte</span>
                          <input class="form-control" type="text" name="getMaterial" readonly id="getMaterial" placeholder="Material">
                          <span>Locacion antigua</span>
                          <input class="form-control" type="text" name="oldLocation" readonly id="oldLocation" placeholder="Locacion antigua">
                          <span>Locacion nueva</span>
                          <input class="form-control" type="text" name="oldLocation" readonly id="newLocation" placeholder="Locacion nueva">
                          <br>
                          <button class="btn btn-success" id="btnSearch">Buscar locacion</button>
                        </div>
                        
                       <div class="col-md-4"></div>
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

<script src="build/js/locationModel.js"></script>
