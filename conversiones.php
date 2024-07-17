<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>

  <title>APTIV - Conversiones</title>

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
                <h3>Conversion</h3>
              </div>

      
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Convertir peso a longitud</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <button class="btn btn-success" hidden data-toggle="modal" data-target="#modal_agregar">Agregar material</button>
                      
                      <div class="modal fade bs-example-modal-sm" id="modal_agregar" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel2">Agregar Material</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group">
                                <form>
                                <label for="num_material">Numero de parte <span style="color: red;">*</span></label>
                                <input type="text" name="num_material" id="num_material" class="form-control" required placeholder="Numero de parte">
                                <br>
                                <label for="apw_material">APW <span style="color: red;">*</span></label>
                                <input type="number" min="0" name="apw_material" id="apw_material" class="form-control" required placeholder="APW">
                                <br>
                                <label for="descripcion_material">Descripcion</label>
                                <input type="text" id="descripcion_material" name="descripcion_material" class="form-control" placeholder="Descripcion">
                                <br>
                                <label for="medida_material">UoM (Unidad de medida)</label>
                                <select id="medida_material" name="medida_material" class="form-control">
                                  <option value="FT">FT (Pies)</option>
                                  <option value="M">M (Metros)</option>
                                  <option value="KG">KG (Kilogramos)</option>
                                  <option value="LB">LB (Libras)</option>
                                </select>
                                <br>
                                <label for="std_pack">STD Pack</label>
                                <input type="number" min="1" name="std_pack" id="std_pack" class="form-control" placeholder="STD Pack">
                                <br>
                                <label for="mtype_material">Mtype</label>
                                <select class="form-control" id="mtype_material" name="mtype_material">
                                  <option value="CABLE">CABLE</option>
                                  <option value="BATTERY CABLE">BATTERY CABLE</option>
                                  <option value="TAPE">TAPE</option>
                                  <option value="SEAL">SEAL</option>
                                  <option value="TERMINAL">TERMINAL</option>
                                  <option value="CONDUIT">CONDUIT</option>
                                  <option value="COMPONENT">COMPONENT</option>
                                </select>
                                
                                

                                <br>
                                <label><span style="color: red;">*</span> Campos obligatorios</label>

                              </div>
                              
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                              <button type="submit" id="insertar_material" class="btn btn-primary">Guardar cambios</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <br><br>
                      <div style="text-align: center;">
                        <table id="table_conversion" class="table table-striped table-bordered table_conversion" style="width:100%">
                            <thead>
                              <tr>
                                <th>Numero de parte</th>
                                <th>Peso completo</th>
                                <th>Tara</th>
                                <th>Descripcion</th>
                                <th>APW</th>
                                <th>Peso tara</th>
                                <th>Metro</th>
                                <th>Feet</th>
                              </tr>
                            </thead>


                            <tbody>
                                <tr>
                                  <td>
                                    <input id="material_nombre" class="form-control col-md-12" placeholder="Numero de parte" list="productos">
                                    <datalist id="productos" class=""></datalist>

                                  </td>
                                  <td>
                                    <input id="material_peso" type="number" class="form-control col-md-12" placeholder="Peso">
                                  </td>
                                  <td>
                                    <select id="material_tara" class="form-control col-md-12">
                                      <option value="NPS">NPS</option>
                                      <option value="BP_NEGRO">BP NEGRO</option>
                                      <option value="BP_GRIS">BP GRIS</option>
                                      <option value="POLIDUCTO">POLIDUCTO</option>
                                      <option value="CARRETE_MADERA_GDE">CARRETE MADERA GRANDE</option>
                                    </select>
                                  </td>

                                  <td id="descripcion"></td>
                                  <td id="apw"></td>
                                  <td id="peso_tara"></td>
                                  <td id="metro"></td>
                                  <td id="feet"></td>
                                </tr>                            
                            </tbody>

                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Convertir longitud a peso</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     
                      <br><br>
                      <div style="text-align: center;">
                        <table id="table_conversion" class="table table-striped table-bordered table_conversion" style="width:100%">
                            <thead>
                              <tr>
                                <th>Numero de parte</th>
                                <th>Metros</th>
                                <th>Tara</th>
                                <th>Descripcion</th>
                                <th>APW</th>
                                <th>Peso tara</th>
                                <th>Peso completo</th>
                                <th>Feet</th>
                              </tr>
                            </thead>


                            <tbody>
                                <tr>
                                  <td>
                                    <input id="material_nombre_two" class="form-control col-md-12" placeholder="Numero de parte" list="productos_two">
                                    <datalist id="productos_two" class=""></datalist>

                                  </td>
                                  <td>
                                    <input id="material_metros_two" type="number" class="form-control col-md-12" placeholder="Metros">
                                  </td>
                                  <td>
                                    <select id="material_tara_two" class="form-control col-md-12">
                                      <option value="NPS">NPS</option>
                                      <option value="BP_NEGRO">BP NEGRO</option>
                                      <option value="BP_GRIS">BP GRIS</option>
                                      <option value="POLIDUCTO">POLIDUCTO</option>
                                      <option value="CARRETE_MADERA_GDE">CARRETE MADERA GRANDE</option>
                                    </select>
                                  </td>

                                  <td id="descripcion_two"></td>
                                  <td id="apw_two"></td>
                                  <td id="peso_tara_two"></td>
                                  <td id="material_peso_two"></td>
                                  <td id="feet_two"></td>
                                </tr>                            
                            </tbody>
                            
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Conversor</h2>
                    

                    <!--*************ADD CONTENT HERE*****************-->


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     
                      <br><br>
                      <div style="position:relative;width:100%;">
						  <iframe src="https://convertlive.com/es/w/convertir/pies/a/metros" 
						          frameBorder="0" 
						          width="100%" 
						          height="280px" 
						          style="border:medium none;overflow-x:hidden;overflow-y:hidden;margin-bottom:-5px;">
						    <p>Su navegador no soporta iframes. <a href="https://convertlive.com/es/convertir">convertlive</a>.</p>
						  </iframe>
						  <a target="_blank" 
						     rel="noopener" 
						     style="position:absolute;bottom:7px;right:15px;font-family:monospace;color:#68808F;font-size:12px;font-weight:700;" 
						     href="https://convertlive.com/es/convertir">
						    convertlive
						  </a>
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
<script src="build/js/getIP.js"></script>
<script src="build/js/conversiones_origin.js"></script>
<script src="build/js/add_material.js"></script>
