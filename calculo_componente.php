<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
  <title>Calculo de Tolvas</title>
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
                <h3>Calculo de componente</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tolva mas optima</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	 
                     <!--<div>
                     	<input type="text" class="form-control" id="numero_parte" name="" placeholder="Numero de parte">
	                    <br>
	                    <input type="text" class="form-control" id="requerimiento" name="" placeholder="Requerimiento diario">
	                    <br>
                      <input type="text" class="form-control" id="D" name="" placeholder="Diametro CM">
                      <br>
                      <input type="text" class="form-control" id="H" name="" placeholder="Altura">
                      <br>
	                    <input type="text" class="form-control" id="requerimiento_hora" name="" readonly placeholder="Requerimiento por hora">
	                    <br>
	                    <input type="text" class="form-control" id="requerimiento_tres" name="" readonly placeholder="Requerimiento por tres horas">
	                    <br>
	                    <input type="text" class="form-control" id="tolva" name="" readonly placeholder="Tolva">
	                    <br>
	                    <button class="btn btn-primary" id="btn_confirm">Calcular</button>
	                 </div>
                     <span id="MT"></span><br>
                     <span id="JT"></span><br>
                    
                     
                     <span id="2S"></span><br>
                     <span id="4S"></span><br>
                      <span id="8S"></span><br>-->
                     <div style="text-align: center;">
                      <button class="btn btn-primary" id="downloadTemplate"><i class="fa fa-download" ></i> Descargar plantilla</button>
                     	<form action="#" id="excel" accept=".xlsx" class="">
	                      <button class="btn btn-success" id="upload-info" type="file" accept='.xlsx'><i class="fa fa-upload"></i> Cargar desde archivo</button>
                        
	                      <input id="file-upload" accept='.xlsx' type="file"/>
	                    </form>
	                    <br><br>
                     	<div class="botones-container">
	                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableTolvas').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
	                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableTolvas').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
	                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableTolvas').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
	                
	                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#tableTolvas').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

	                        <!--<button class="btn btn-warning text-light boton-margen boton-responsivo" onclick="/*clean()*/">Limpiar obsoletos</button>-->
	                    </div>
	                     <table id="tableTolvas" class="table table-striped table-bordered .progress" style="width:100%">
	                      <thead>
	                        <tr>
	                          <th>Numero de parte</th>
	                          <th>Horas por cubrir</th>
	                          <th>Requerimiento diario</th>
	                          <th>Requerimiento Hora</th>
	                          <th>Requerimiento X horas</th>
	                          <th>Tolva optima</th>
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
  #tableTolvas_info{
    text-align:left !important;
  }
  #tableTolvas_length{
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
<script src="vendors/xlsx/xlsx.js"></script>
<script src="build/js/calculo_model.js"></script>
