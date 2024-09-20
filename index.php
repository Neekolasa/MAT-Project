<!DOCTYPE html>
<html lang="es">
   
  <?php

    include 'templates/header.php';

  ?>
  <title>APTIV - SUPERMERCADO</title>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="principal left_col scroll-view">
            <?php 
              include 'templates/logo.php';
            ?>

            <div class="clearfix"></div>
            <!--<script type="text/javascript">
              Swal.fire('Any fool can use a computer') 
            </script>-->

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
                <h3>Supermercado</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>


            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Seleccion por serie</h2>
                    <div class="x_content">
                      <form>

                        <div class="well" style="overflow: auto">
                          <div class="col-md-4">
                            <div id="reportrange_right" class="pull-left form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                              <i class="fa fa-calendar"></i>
                              <span style="color: black"></span> <b class="caret"></b>
                            </div>
                          </div>
                          <div>
                            
                            <div class="col-sm-2 ">
                              <select class="form-control" id="turno">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <!--<option value="C">C</option>-->
                                <option value="Comparativo">Comparativo</option>
                               
                              </select>
                            </div>
                            <span class="control-label col-md-2 col-sm-2 " style="color:black;margin: 10px auto;">Turno</span>

                          </div>
                          
                            <div class="col-sm-2 col-sm-2">
                              <button id="buscar_mercado" class="btn btn-success">Buscar</button>
                            </div>

                        </div>



                        
                         
                        
                      </form>

                    <div style="text-align: center;">
                      <div class="botones-container">
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#date-mercado').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#date-mercado').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#date-mercado').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#date-mercado').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>
                    </div>
                    <table id="date-mercado" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Recibos</th>
                          <th>Rackeo</th>
                          <th>Contingencia</th>
                          <th>Total Movimientos</th>
                          <th>Fecha</th>
                        </tr>
                      </thead>


                      <tbody id="table_mercado_body">
                        
                      </tbody>
                    </table>
                  </div>
                    <center>
                    <div class="container col-md-12 align-items-center center-block">
                      <div class="col-sm-6 col-md-6" id="grafico_a" style="display:block;"></div>
                      <div class="col-sm-6 col-md-6" id="grafico_b" style="display:none;"></div>
                    </div>
                     </center>

            </div>

                  

                    <!--*************ADD CONTENT HERE*****************-->



                    <div class="container col-md-12" style="margin-top: 4%"><h2>Seleccion a detalle</h2></div>
                  <div class="x_title">

                    
                    <form>

                        <div class="well col-md-12" style="overflow: auto">
                          <fieldset class="col-md-4">
                            <div class="control-group">
                              <div class="controls">
                                <div class="col-md-12 xdisplay_inputx form-group row has-feedback">
                                  <input type="text" class="form-control has-feedback-left" id="single_cal1" placeholder="" aria-describedby="inputSuccess2Status" >
                                  <i class="fa fa-calendar form-control-feedback left" aria-hidden="true" style="color: black;"></i>
                                  <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                </div>
                              </div>
                            </div>
                          </fieldset>
                          <div>
                            
                            <div class="col-sm-2 ">
                              <select class="form-control" id="turno_emp">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <!--<option value="C">C</option>-->
                               
                              </select>
                            </div>
                            <span class="control-label col-md-2 col-sm-2 " style="color:black;margin: 10px auto;">Turno</span>

                          </div>
                          
                            <div class="col-sm-2 col-sm-2">
                              <button id="buscar_empleado" class="btn btn-success">Buscar</button>
                            </div>
                      

                          
                        </div>

                        
                         
                        
                      </form>
                    
                    <div style="text-align: center;">
                      <div class="botones-container">
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_empleados').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_empleados').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_empleados').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                
                        <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_empleados').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>
                    </div>
                    <div class="col-sm-12 col-md-12" id="totales" style="text-align: center; display: none;">
                      <span id="total_rackeo" class="text text-justify" style="font-size: 15px !important; color: black;"></span> <br>
                      <span id="total_contingencia" class="text text-justify" style="font-size: 15px !important; color: black;"></span> <br>
                      <span id="total_movimientos" class="text text-justify" style="font-size: 15px !important; color: black;"></span> <br> <br>
                    </div>
                    <table id="table_empleados" class="table table-striped table-bordered .progress" style="width:100%">
                      <thead>
                        <tr>
                          <th>No Empleado</th>
                          <th>Nombre (s)</th>
                          <th>Apellidos</th>
                          <th>Rackeo</th>
                          <th>Contingencia</th>
                          <th>Total Movimientos</th>
                        </tr>
                      </thead>


                      <tbody>
                        
                      </tbody>
                  </table>
                </div>

                  <!--<table id="table_contingencia" class="table table-striped table-bordered .progress" style="width:100%">
                      <thead>
                        <tr>
                          <th>No Empleado</th>
                          <th>Nombre (s)</th>
                          <th>Apellidos</th>
                          <th>Rackeo</th>
                          <th>Contingencia</th>
                          <th>Total Movimientos</th>
                        </tr>
                      </thead>


                      <tbody>
                        
                      </tbody>
                  </table>

                   <div class="col-sm-12 col-md-12" id="grafico_emp" style="display: none;"></div>
                  </div>
                  </div>-->


                </div>
              </div>
            </div>
          </div>
        </div>
          <!-- /top tiles -->

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer style="margin-left: 0px;">
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
	 <button class="material-scrolltop" type="button"></button>
  </body>
</html>

<style type="text/css">
  .dtr-title{
color: black !important;
    
  }
  .dtr-data{
    color: black !important;

  }
  #date-mercado_info{
    text-align:left !important;
  }
  #date-mercado_length{
     text-align:left !important;
  }

  #table_empleados_info{
    text-align:left !important;
  }
  #table_empleados_length{
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

<script src="build/js/getIP_origin.js"></script>
<script src="build/js/buscar_mercado_origin.js"></script>
<script src="build/js/buscar_listaEmp_origin.js"></script>

  <script type="text/javascript">
        $('body').materialScrollTop();

    </script>

<script type="text/javascript">
  window.location.replace('conversiones.php');
</script>
