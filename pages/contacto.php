<?php session_start();
if (isset($_SESSION['see'])){
    unset($_SESSION['see']);
}
?>
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
                            <li>
                                <?php
                                if (isset($_SESSION['user'])){
                                    echo '<a href="#modal_disconnect" class="waves-effect waves-light modal-trigger user"><i class="mdi-action-account-circle left"></i>'.$_SESSION['user'].'&nbsp;<span class="uppercase">(logout)</span></a>';
                                }
                                else{
                                    echo '<a href="./login.php" class="waves-effect waves-light"><i class="mdi-action-https left"></i>LOGIN</a>';
                                }
                                ?>
                            </li>
                            <li class="active">
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
                            <li>
                                <?php
                                if (isset($_SESSION['user'])){
                                    echo '<a href="#modal_disconnect" class="waves-effect waves-light modal-trigger user"><i class="mdi-action-account-circle left"></i>'.$_SESSION['user'].'&nbsp;<span class="uppercase">(logout)</span></a>';
                                }
                                else{
                                    echo '<a href="./login.php" class="waves-effect waves-light"><i class="mdi-action-https left"></i>LOGIN</a>';
                                }
                                ?>
                            </li>
                            <li class="active">
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
                            <h4 class="margintop30">Contacto</h4>
                        </div>
                        <div class="row">
                            <form id="contact-form" action="" method="">
                                <div class="input-field col l12 m12 s12">
                                    <input id="name" name="name-cntct" type="text" class="" required>
                                    <label for="name" class="">Nombre Completo</label>
                                </div>
                                <div class="input-field col l12 m12 s12">
                                    <input id="email" name="email-cntct" type="email" class="" required>
                                    <label for="email" class="">Correo Electronico</label>
                                </div>
                                <div class="input-field col l12 m12 s12">
                                    <input id="subject" name="subject-cntct" type="text" class="" required>
                                    <label for="subject" class="">Asunto</label>
                                </div>
                                <div class="input-field col l12 m12 s12">
                                    <textarea id="message" name="message-cntct" class="materialize-textarea"></textarea>
                                    <label for="message">Mensaje</label>
                                </div>
                                <div class="input-field col l12 m12 s12">
                                    <button id="submit" class="btn-large waves-effect waves-light " disabled type="submit" name="submit-cntct" value="submit">
                                        Enviar
                                        <i class="mdi-content-send right"></i>
                                    </button>
                                </div>
                            </form>
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

                $('#message').bind('change paste keyup', function() {
                    if ( $('#message').val() != "" ){
                        $('#submit').addClass('light-green').addClass('accent-4').attr('disabled', false);
                    }
                    else{
                        $('#submit').removeClass('light-green').removeClass('accent-4').attr('disabled', true);
                    }
                });
            });
        </script>
    </body>
  </html>