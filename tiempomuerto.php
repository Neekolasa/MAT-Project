<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
<title>APTIV - Tiempo muerto</title>
 
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
                <h3>Rutas</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tiempo muerto</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix">
                      <div class="col-sm-12">
                     
                        <button class="btn btn-success pull-left col-md-3"  id="modalTiempo_button"><i class="fa fa-plus"></i> Registrar tiempo muerto </button>
                     
                      </div>
                    </div>
                  </div>
                  <div class="x_content col-md-12">
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
                              <button id="buscarTM" class="btn btn-success">Buscar</button>
                            </div>

                    </div>
                        
                      <div style="text-align: center;">
                        <div class="well col-md-12">

                        <div class="botones-container" hidden>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_criticos').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_criticos').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_criticos').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                          <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#table_criticos').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

                           
                        </div>
                        <table id="tableTM" class="table table-striped table-bordered .progress" style="width:100%">
                          <thead>
                            <tr>

                              <th>Codigo afectado</th>
                              <th>Minutos de tiempo muerto</th>
                              <th>Motivo</th>
                              <th>Personas afectadas</th>
                              <th>Comentarios</th>
                              <th>Fecha</th>
                            </tr>
                          </thead>


                          <tbody>
                            
                          </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="well col-md-12 align-items-center center-block">
                      <div class="col-sm-6 col-md-6" id="weekGraphic" style="display:block;"></div>
                      <div class="col-sm-6 col-md-6" id="weekGraphicComparativo" style="display:none;"></div>
                  </div>
                  <div class="well col-md-12">
                   
                      <!--<div id="weekGraphic"></div>
                      <div id="weekGraphicComparativo"></div>-->
                    
                    <div id="historicGraphic"></div>
                    <div id="historicYearGraphic"></div>
                  </div>
                    


                  </div>
                  <div class="modal fade bs-example-modal-lg" id="modalTiempo" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">Agregar tiempo muerto</h4>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="tiempoMinutos">Minutos de tiempo muerto <span class="required" style="color: red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="number" value="1" min="1" id="tiempoMinutos" required="required" class="form-control ">
                            </div>
                          </div>
                          <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="motivoTM">Motivo <span class="required" style="color: red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select class="form-control" id="motivoTM">
                                <option value="Falta_de_componente">Falta de componente - material</option>
                                <option value="No_se_surtio_a_tiempo">No se surtio a tiempo</option>
                                <!--<option value="Falta_de_material">Falta de material</option>-->
                                <option value="Otro">Otro...</option>
                              </select>
                             
                            </div>
                          </div>
                          <div class="item form-group otherMot">
                            <label class="col-form-label col-md-3 col-sm-3 label-align otherMot" for="motivoOther">Ingrese un motivo <span class="required" style="color: red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 otherMot">
                              <input type="text" id="motivoOther" required="required" class="form-control otherMot">
                             
                            </div>
                          </div>
                           <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="codigosTM">Codigo afectado <span class="required" style="color: red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select class="form-control" id="codigosTM">
                                <optgroup label="Cadena GM">
                                  <option value="AB007_L3B">AB007 L3B</option>
                                  <option value="AB010_LZ0">AB010 LZ0</option>
                                  <option value="AR007_LT4">AR007 LT4</option>
                                  <option value="AB012_L8T">AB012 L8T</option>
                                  <option value="AB013_L5P">AB013 L5P</option>
                                  <option value="AW004_BODY">AW004 BODY</option>
                                  <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;GM 610 Miscelaneos">
                                    <option value="AW021">&nbsp;&nbsp;&nbsp;&nbsp;AW021</option>
                                    <option value="AW022">&nbsp;&nbsp;&nbsp;&nbsp;AW022</option>
                                    <option value="AW042">&nbsp;&nbsp;&nbsp;&nbsp;AW042</option>
                                    <option value="AW031">&nbsp;&nbsp;&nbsp;&nbsp;AW031</option>
                                    <option value="AW032">&nbsp;&nbsp;&nbsp;&nbsp;AW032</option>
                                    <option value="AW104">&nbsp;&nbsp;&nbsp;&nbsp;AW104</option>
                                  </optgroup>
                                </optgroup>
                                <optgroup label="Cadena Honda">
                                  <option value="GCB070_(FLOOR)">GCB070 (FLOOR)</option>
                                </optgroup>
                                <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;Honda Miscelaneos">
                                  <option value="CB045">&nbsp;&nbsp;&nbsp;&nbsp;CB045</option>
                                  <option value="CB060">&nbsp;&nbsp;&nbsp;&nbsp;CB060</option>
                                  <option value="CB607">&nbsp;&nbsp;&nbsp;&nbsp;CB607</option>
                                  <option value="CB044">&nbsp;&nbsp;&nbsp;&nbsp;CB044</option>
                                  <option value="CB070">&nbsp;&nbsp;&nbsp;&nbsp;CB070</option>
                                  <option value="CB911">&nbsp;&nbsp;&nbsp;&nbsp;CB911</option>
                                  <option value="CB022">&nbsp;&nbsp;&nbsp;&nbsp;CB022</option>
                                  <option value="CB023">&nbsp;&nbsp;&nbsp;&nbsp;CB023</option>
                                  <option value="CB024">&nbsp;&nbsp;&nbsp;&nbsp;CB024</option>
                                  <option value="CB822">&nbsp;&nbsp;&nbsp;&nbsp;CB822</option>
                                </optgroup>
                                <optgroup label="Rear de Ridgeline">
                                  <option value="CB027">CB027</option>
                                </optgroup>
                                <optgroup label="Dash Stellantis">
                                  <option value="DZ187">DZ187</option>
                                </optgroup>
                               
                              </select>
                             
                            </div>

                            

                          </div>
                          <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="personasTM">Personas afectadas <span class="required" style="color: red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="number" min="1"  value="1" id="personasTM" required="required" class="form-control ">
                            </div>
                          </div>

                          <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="comentariosAdd">Comentarios
                            </label>
                            <div class="col-md-6 col-sm-6">
                              <textarea type="text" id="comentariosAdd" class="form-control"></textarea>
                            
                             
                            </div>
                          </div>
                           <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="turno">Turno afectado <span class="required" style="color: red;">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <select class="form-control" id="turno_add">
                                <option value="A">Turno A</option>
                                <option value="B">Turno B</option>
                              </select>
                             
                            </div>

                            

                          </div>
                          <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="dateCreated">Fecha de informe
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text" id="single_calendar" readonly style="cursor: pointer;" required="required" class="form-control has-feedback-left">
                              <i class="fa fa-calendar form-control-feedback left" aria-hidden="true" style="color: black;"></i>
                            </div>
                          </div>

                          <label class="col-form-label col-md-7 col-sm-7 label-align" for="codigosTM">Campos obligatorios <span class="required" style="color: red;">*</span></label>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button type="button" id="tiempoMuertoSubmit" class="btn btn-primary">Guardar cambios</button>
                        </div>

                      </div>
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
   #tableTM_length{
    text-align: left !important;
  }
  #tableTM_length{
    text-align: left !important;
  }
  #tableTM_info{
    text-align: left !important;
  }
</style>

<script src="build/js/tiempomuerto.js"></script>
<script src="build/js/tiempoMuertoGraphics.js"></script>
