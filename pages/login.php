<?php session_start();
if (isset($_SESSION['see'])){
    unset($_SESSION['see']);
}?>
<!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8"/>
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="./../vendor/materialize/css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="./../css/custom-css.css"  media="screen,projection"/>
        
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <title>MyNVENTORY</title>
        <link rel="icon" type="image/png" href="./../images/inventory_32.png">
    </head>
    <body class="light-green lighten-5">
        <header>
            <div class="navbar-fixed">
                <nav class="light-green">
                    <div class="nav-wrapper">
                        <a href="./../index.php" class="brand-logo waves-effect waves-light">
                            <img id="logo" class="left responsive-img hide-on-med-and-down" src="./../images/inventory_64.png">MyNVENTORY
                        </a>
                        <ul class="right hide-on-med-and-down">
                            <li>
                                <a href="./../index.php" class="waves-effect waves-light"><i class="mdi-action-home left"></i>INICIO</a>
                            </li>
                            <li>
                                <a href="inventarios.php" class="waves-effect waves-light"><i class="mdi-action-assignment left"></i>INVENTARIOS</a>
                            </li>
                            <li class="active">
                                <?php
                                if (isset($_SESSION['user'])){
                                    echo '<a href="#modal_disconnect" class="waves-effect waves-light modal-trigger user"><i class="mdi-action-account-circle left"></i>'.$_SESSION['user'].'&nbsp;<span class="uppercase">(logout)</span></a>';
                                }
                                else{
                                    echo '<a href="./login.php" class="waves-effect waves-light"><i class="mdi-action-https left"></i>LOGIN</a>';
                                }
                                ?>
                            </li>
                            <li>
                                <a href="contacto.php" class="waves-effect waves-light"><i class="mdi-content-mail left"></i>CONTACTO</a>
                            </li>
                        </ul>
                        <ul id="slide-out" class="side-nav">
                            <li class="brand">
                                <a href="./../index.php" class="waves-effect waves-light"><h5 class="myfont">MyNVENTORY</h5></a>
                            </li>
                            <li>
                                <a href="./../index.php" class="waves-effect waves-light"><i class="mdi-action-home left"></i>INICIO</a>
                            </li>
                            <li>
                                <a href="inventarios.php" class="waves-effect waves-light"><i class="mdi-action-assignment left"></i>INVENTARIOS</a>
                            </li>
                            <li class="active">
                                <?php
                                if (isset($_SESSION['user'])){
                                    echo '<a href="#modal_disconnect" class="waves-effect waves-light modal-trigger user"><i class="mdi-action-account-circle left"></i>'.$_SESSION['user'].'&nbsp;<span class="uppercase">(logout)</span></a>';
                                }
                                else{
                                    echo '<a href="./login.php" class="waves-effect waves-light"><i class="mdi-action-https left"></i>LOGIN</a>';
                                }
                                ?>
                            </li>
                            <li>
                                <a href="contacto.php" class="waves-effect waves-light"><i class="mdi-content-mail left"></i>CONTACTO</a>
                            </li>
                        </ul>
                        <a href="#!" data-activates="slide-out" class="button-collapse">
                            <i class="mdi-navigation-menu"></i>
                        </a>
                    </div>
                </nav>
            </div>
        </header>
        <main>
            <div class="container">
                <div class="row">
                    <div class="col l8 offset-l2 m8 offset-m2 s10 offset-s1">
                        <div class="row center-align">
                            <h4 class="margintop30">Log In</h4>
                        </div>
                        <div class="row">
                            <form id="login-form" action="./../functions/usersdb.php" method="POST">
                                <div class="input-field col l12 m12 s12">
                                    <i class="mdi-action-account-circle prefix"></i>
                                    <input id="user" name="user-log" type="text" class="" required>
                                    <label for="user" class="">Nombre de Usuario</label>
                                </div>
                                <div class="input-field col l12 m12 s12">
                                    <i class="mdi-action-lock prefix"></i>
                                    <input id="pass" name="pass-log" type="password" class="" required>
                                    <label for="pass" class="">Contraseña</label>
                                </div>
                                <div class="input-field col l12 m12 s12">
                                    <button id="submit" class="btn-large waves-effect waves-light light-green accent-4" type="submit" name="submit-log" value="submit">
                                        Entrar
                                        <i class="mdi-content-send right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="row center-align">
                            <br>
                            <p>¿Aún no tienes una cuenta de usuario? <a href="registro.php" class="waves-effect waves-green btn-flat light-green-text text-darken-2">Registrate</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal_disconnect" class="modal">
                <div class="modal-content">
                    <h4>¿Esta seguro que desea desconectarse?</h4>
                    <p>Si se desconecta tendra que volver a iniciar sesion para acceder a sus inventarios.</p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat left">Cancelar</a>
                    <a href="./../functions/usersdb.php?logout=logout" class=" modal-action modal-close waves-effect waves-green btn-flat right">Desconectar</a>

                </div>
            </div>
        </main>
        <footer class="page-footer light-green darken-2">
          <div class="container">
            <!--div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">MyNVENTORY</h5>
                <p class="grey-text text-lighten-4">Custom inventories for everyone.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Enlaces de interés:</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                </ul>
              </div>
            </div-->
          </div>
          <div class="footer-copyright">
            <div class="container center-align">
            MyNVENTORY &copy; 2015
                <!--a class="grey-text text-lighten-4 right" href="#!">Terminos Legales</a-->
            </div>
          </div>
        </footer>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="./../vendor/jquery/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="./../vendor/jquery.flip/js/jquery.flip.js"></script>
        <script type="text/javascript" src="./../vendor/materialize/js/materialize.js"></script>
        <script type="text/javascript" src="../js/custom-scripts-inventory.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                <?php if (!isset($_GET['fail'])){ echo "var success=".$_GET['success'].';'; } ?>
                var user="<?php if (isset($_GET['user'])){ echo $_GET['user']; }elseif(isset($_SESSION['user'])){ echo $_SESSION['user']; }else{ echo '';} ?>";
                var register=<?php if (isset($_GET['register'])){ echo $_GET['register']; }else{ echo "false"; } ?>;

                if (typeof success !== 'undefined' && typeof register !== 'undefined') {
                    if (register == true){
                        Materialize.toast('Usuario '+user+" registrado con exito.", 4000);
                        $('#user').val(user);
                    }
                    else{
                        if (success == true){
                            Materialize.toast('Conectado como: '+user, 4000);
                        }
                        else if(success == false){
                            Materialize.toast('Usuario o contraseña no validos.', 4000);
                            $('#user').val(user);
                        }
                    }
                }
            });
        </script>
    </body>
  </html>