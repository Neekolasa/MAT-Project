<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
  <title>Numeros criticos - APTIV</title>
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
                <button class="btn btn-success" id="uploadButton" onclick="$('#criticalModal').modal('show');" style="margin-left: 10px;"><i class="fa fa-upload"></i> Subir criticos desde archivo</button>
                </div>
                

              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="modal fade bs-example-modal-sm" id="criticalModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                              <div class="modal-content">

                                <div class="modal-header">
                                  <h4 class="modal-title" id="myModalLabel2">Cargar criticos desde paros potenciales</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                             
                                  <p>Para actualizar los criticos debe subir el archivo de Paros Potenciales</p>
                                  <form action="#" id="excel" accept=".xlsx" class="">
                                    <button class="btn btn-primary" id="newUpload-info" type="file" accept='.xlsx'><i class="fa fa-upload"></i> Cargar informacion</button>
                                    <!--<button class="btn btn-primary" id="upload-info" type="file" accept='.xlsx'><i class="fa fa-upload"></i> Cargar informacion</button>-->

                                    <input id="file-upload" accept='.xlsx' type="file"/>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  
                                </div>

                              </div>
                            </div>
                          </div>
                    <div>
                      
                      <div class="col-md-12">
                        
                        <img class="col-md-2" style="display: flex; margin-top: 2%; "  src="src/Aptiv_logo.png">
                        <div class="col-md-10">
                          <div class="col-md-1" style="margin-top: 1%;">
                            <img class="pull-right alert-icon" style="width: 41%;" src="src/alert.png">
                          </div>
                          <h1 class="col-md-7" style="color: black; text-align: center;" id="titleCriticos"></h1>
                          <div class="col-md-2" style="margin-top: 1%;">
                            <img class="pull-left alert-icon" style="width: 18%;" src="src/alert.png">
                          </div>
                          <div class="col-md-2">
                            <span id="time" class="pull-right" style="font-size: x-large; display: flex; margin-top: 13%; color:black;"></span>
                          </div>
                        </div>
                      
                        
                      </div>
                      <div class="col-md-12" style=" font-size: 21px;color: black; text-align: center;">Desarrollado por: Ing Joel Andrade Enriquez</div>
                      
                      <div class="col-md-3" style="text-align: center !important; "></div>
                      <div class="col-md-6" style="text-align: center !important; ">
                        <ul class="legend">
                          <li><span class="sinLlegada"></span> Sin llegada a planta </li>
                          <li><span class="sinLiberar"></span> Sin liberar en recibos</li>
                          <li><span class="ListoAlmacena"></span> Listo para almacenar</li>
                          <li><span class="MaterialPU"></span> Material en punto de uso / Sin surtir</li>
                          <li><span class="Surtido"></span> Surtido</li>
                        </ul>

                      </div>
                      <div class="col-md-3" style="text-align: center !important; "></div>
                   
                        
                    </div>
                   
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <table id="table_criticos" class="table table-sm table-bordered">
                        <thead>
                          <tr>
                            <th>Numero de parte</th>
                            <th>DOH</th>
                            <th>ETA</th>
                            <th>Mtype</th>
                            <th>Locacion</th>
                            <th>Estatus</th>
                            <th>Fecha Llegada</th>
                                      
                                          
                          </tr>
                        </thead>


                        <tbody style="font-size: 12px !important; font-weight: bold;" id="trTable">
                                        
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
<script src="build/js/relojTiempoReal_origin.js"></script>
<script src="build/js/getIP_origin.js"></script>

<style type="text/css">
  .legend { list-style: none; }
  .legend li { float: left; margin-right: 10px; }
  .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; }
  /* your colors */
  .legend .sinLlegada { background-color: #CA23B5; }
  .legend .sinLiberar { background-color: #F6384A; }
  .legend .ListoAlmacena { background-color: #F59533; }
  .legend .MaterialPU { background-color: #FAF667; }
  .legend .Surtido { background-color: #35E231; }
  @keyframes blink {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(3.1);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.blinking {
    animation: blink 1s infinite;
    color: #ff5722; /* Cambiar el color */
    text-shadow: 0 0 5px #ff5722; /* Agregar sombra */
}
</style>
