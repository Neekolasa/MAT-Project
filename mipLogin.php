<!DOCTYPE html>
<html lang="es">
  <?php 
    include 'templates/header.php';
  ?>
<title>MIP - Movers Interplantas</title>
 <body class="login">
  
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form>
              <h1>MIP Movers Interplantas</h1>
              <h2>Sistema de Mover Interplantas</h2>
              <div>
                <input type="text" class="form-control" id="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" id="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-success submit" style="color: white;" id="loginButton">Iniciar sesion</a>
              </div>

              <div class="clearfix"></div>
             

              
            </form>
          </section>
        </div>


      </div>
    </div>
  </body>
</html>
<?php 
  include 'templates/footerLibs.php';
 ?>
<script src="build/js/moverPersonalAccess.js"></script>
