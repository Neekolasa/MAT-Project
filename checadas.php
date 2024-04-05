<!DOCTYPE html>
<html lang="es">
  <?php
    header('Access-Control-Allow-Origin: *');
  
    include 'templates/header.php';
  ?>
<title>APTIV - Checadas</title>  
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
                <h3>Checadas</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Checadas de salidas</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-sm-12">
                      <div class="col-sm-6">
                        <button class="btn btn-info pull-left" id="config"><i class="fa fa-cog"></i> </button>
                      </div>

                      <div class="col-sm-6 ">
                        <span id="time" class="pull-right" style="font-size: x-large;"></span>
                      </div>
                    </div>
                    
                    



                    <div class="modal fade bs-example-modal-sm" id="modal_agregar" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Agregar Horario</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form autocomplete="off">
                                <label for="num_material">Numero de empleado <span style="color: red;">*</span></label>
                                <input type="text" min="0" name="num_empleado" id="add_num_empleado" class="form-control" required placeholder="Numero empleado">
                                
                                <label for="apw_material">Nombre <span style="color: red;">*</span></label>
                                <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" required placeholder="Nombre empleado">
                                
                                <label for="salida_almuerzo">Salida almuerzo <span style="color: red;">*</span></label>
                                <select id="salida_almuerzo" name="salida_almuerzo" class="form-control">
                                  
                                </select>
                                
                                
                                <label for="salida_comida">Salida comida <span style="color: red;">*</span></label>
                               <select id="salida_comida" name="salida_comida" class="form-control">
                                  
                                </select>
                                
                                <label for="area_emp">Area <span style="color: red;">*</span></label>
                                <select id="area_emp" name="area_emp" class="form-control">
                                  <option value="Ruta Interna">Ruta Interna</option>
                                  <option value="Ruta Externa">Ruta Externa</option>
                                  <option value="Barriles">Barriles</option>
                                  <option value="Supermercado">Supermercado</option>
                                </select>

                                <label for="turno_checada">Turno <span style="color: red;">*</span></label>
                                <select id="turno_checada" name="turno_checada" class="form-control">
                                  <option value="A">A</option>
                                  <option value="B">B</option>
                                
                                </select>
                                                                
                                

                                
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" id="insertar_horario" class="btn btn-primary">Guardar cambios</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>



                      <div style="text-align: center;">

                        <form autocomplete="off">
                          <div class="col-md-12" >
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                               <input id="num_empleado" type='password' class="form-control" placeholder="Numero de empleado" style="text-align: center;" />
                            </div>
                           
                             <div class="col-sm-12">
                              <br>
                              <button id="add_salida" type="submit" class="btn btn-success">Agregar</button>
                              <!--<button id="play" class="btn btn-primary">Play</button>-->
                            </div>   
                          </div>
                        </form>                        
                            
                        <!--<br>
                        <br>

                        <div class="botones-container">
                            <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#data_salidas').DataTable().button('.buttons-copy').trigger('click')">Copiar al portapapeles</button>
                            <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#data_salidas').DataTable().button('.buttons-excel').trigger('click')">Generar excel</button>
                            <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#data_salidas').DataTable().button('.buttons-pdf').trigger('click')">Generar PDF</button>
                    
                            <button class="btn btn-primary text-light boton-margen boton-responsivo" onclick="$('#data_salidas').DataTable().button('.buttons-print').trigger('click')">Imprimir documento</button>

                           
                        </div>-->
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="text-align: center !important; ">
                          <ul class="legend">
                            <li><span class="sinLlegada"></span> No checó </li>
                            <li><span class="sinLiberar"></span> Checó a tiempo</li>
                            <li><span class="ListoAlmacena"></span> Checó antes de su hora</li>
                            <li><span class="MaterialPU"></span> Checó despues de su hora</li>
                          </ul>
                        </div>
                        <div class="col-md-3"></div>
                        
                        <table id="data_salidas" class="table table-striped table-bordered" style="width:100%; margin-bottom: 10%;">
                        <thead>
                          <tr>
                            <th>No Empleado</th>
                            <th>Nombre</th>
                            <th>Salida Almuerzo</th>
                            <th>Entrada Almuerzo</th>
                            <th>Salida Comida</th>
                            <th>Entrada Comida</th>
                            <th>Area</th>
                            <th>Hora Escaneo</th>
                          </tr>
                        </thead>

                            

                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                    <!--******************************MODAL LOGIN**********************************-->
                    <div class="modal fade bs-example-modal-sm" id="modal_login" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Login</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form autocomplete="off">
                                <label for="username">Usuario <span style="color: red;">*</span></label>
                                <input type="text" min="0" name="username" id="username" class="form-control" required>
                                <label for="num_material">Contrasena <span style="color: red;">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <br>
                                <br>
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" id="ingresar_button" class="btn btn-primary">Ingresar</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                     <div class="modal fade bs-example-modal-sm" id="modal_administrator" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Nuevo admin</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form autocomplete="off">
                                <label for="username_admin">Usuario <span style="color: red;">*</span></label>
                                <input type="text" min="0" name="username_admin" id="username_admin" class="form-control" required>
                                <label for="num_material">Contrasena <span style="color: red;">*</span></label>
                                <input type="password" name="password_admin" id="password_admin" class="form-control" required>
                                <br>
                                <br>
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" id="reg_admin" class="btn btn-primary">Agregar</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  
                    <!--****************************FIN MODAL LOGIN**********************************-->

                    <!--****************************MODAL ACTIONS**********************************-->
                    <div class="modal fade bs-example-modal-sm" id="modal_actions" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Acciones</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                
                                <button class="btn btn-success col-md-12" id="reg_horario">Registrar nuevo horario</button>
                                
                                <br>
                                <button class="btn btn-success col-md-12" id="edit_horario">Editar horario existente</button>
                                <br>
                                <button class="btn btn-danger col-md-12" id="del_horario">Elminar horario</button>
                                <br>
                                <button class="btn btn-primary col-md-12" id="add_admin">Agregar administrador</button>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                             
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>


                    <!--***************************FIN MODAL ACTIONS*********************************-->

                    <!--***************************MODAL DELETE**************************************-->

                    <div class="modal fade bs-example-modal-sm" id="del_modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Eliminar horario</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form autocomplete="off">
                                <label for="username">Numero de empleado <span style="color: red;">*</span></label>
                                <input type="text" min="0" name="num_empleado_del" id="num_empleado_del" class="form-control" required>
                                
                                <br>
                                <br>
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" id="delete_button" class="btn btn-primary">Guardar cambios</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!--***************************FIN MODAL DELETE**********************************-->


                    <!--***************************MODAL EDIT****************************************-->

                    <div class="modal fade bs-example-modal-sm" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Editar horario</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form autocomplete="off">
                                <label for="username">Numero de empleado <span style="color: red;">*</span></label>
                                <input type="text" min="0" name="num_empleado_edit" id="num_empleado_edit" class="form-control" required placeholder="Numero de empleado">
                                <label for="nombre_empleado_edit">Nombre <span style="color: red;">*</span></label>
                                <input type="text" name="nombre_empleado_edit" id="nombre_empleado_edit" class="form-control" required placeholder="Nombre empleado">
                                
                                <label for="salida_almuerzo_edit">Salida almuerzo <span style="color: red;">*</span></label>
                                <select id="salida_almuerzo_edit" name="salida_almuerzo_edit" class="form-control">
                                  
                                  
                                </select>
                                
                                <label for="salida_comida_edit">Salida comida <span style="color: red;">*</span></label>
                               <select id="salida_comida_edit" name="salida_comida_edit" class="form-control">
                               
                                  
                                </select>
                                
                                <label for="area_emp_edit">Area <span style="color: red;">*</span></label>
                                <select id="area_emp_edit" name="area_emp_edit" class="form-control">
                                  <option value="Ruta Interna">Ruta Interna</option>
                                  <option value="Ruta Externa">Ruta Externa</option>
                                  <option value="Barriles">Barriles</option>
                                  <option value="Supermercado">Supermercado</option>
                                </select>

                                <label for="turno_checada_edit">Turno <span style="color: red;">*</span></label>
                                <select id="turno_checada_edit" name="turno_checada_edit" class="form-control">
                                  <option value="A">A</option>
                                  <option value="B">B</option>
                                
                                </select>
                                
                                
                                
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" id="edit_button" class="btn btn-primary">Guardar cambios</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!--***************************FIN MODAL EDIT************************************-->
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
    <button class="material-scrolltop" type="button"></button>   
  </body>
</html>
<script src="build/js/getIP_origin.js"></script>
<script src="build/js/relojTiempoReal_origin.js"></script>
<script src="build/js/add_checada_origin.js"></script>
<script src="build/js/checada_actions_origin.js"></script>
<script src="build/js/custom-time-picker.js"></script>
<script src="build/js/checada_opts_origin.js"></script>
<script src="build/js/table_checadas_origin.js"></script>

<style type="text/css">
  .legend { list-style: none; }
  .legend li { float: left; margin-right: 10px; }
  .legend span { border: 1px solid #ccc; float: left; width: 12px; height: 12px; margin: 2px; }
  /* your colors */
  .legend .sinLlegada { background-color: #ffffff; }
  .legend .sinLiberar { background-color: #008000; }
  .legend .ListoAlmacena { background-color: #af2ccb; }
  .legend .MaterialPU { background-color: #ff0000; }
  .legend .Surtido { background-color: #35E231; }
   #data_salidas_length{
    text-align: left !important;
  }
  #data_salidas_length{
    text-align: left !important;
  }
  #data_salidas_info{
    text-align: left !important;
  }
</style>
<script type="text/javascript">
  $('body').materialScrollTop();
</script>

