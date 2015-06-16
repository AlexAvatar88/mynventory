<?php session_start();
if (isset($_SESSION['see'])){
    unset($_SESSION['see']);
}?>
<!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8"/>
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="vendor/materialize/css/materialize.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/custom-css.css"  media="screen,projection"/>
        
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        
        <title>MyNVENTORY</title>
        <link rel="icon" type="image/png" href="./images/inventory_32.png">
    </head>
    <body class="light-green lighten-5">
        <header>
            <div class="navbar-fixed">
                <nav class="light-green">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo waves-effect waves-light">
                            <img id="logo" class="left responsive-img hide-on-med-and-down" src="./images/inventory_64.png">MyNVENTORY
                        </a>
                        <ul class="right hide-on-med-and-down">
                            <li class="active">
                                <a href="#" class="waves-effect waves-light"><i class="mdi-action-home left"></i>INICIO</a>
                            </li>
                            <li>
                                <a href="./pages/inventarios.php" class="waves-effect waves-light"><i class="mdi-action-assignment left"></i>INVENTARIOS</a>
                            </li>
                            <li>
                                <?php
                                    if (isset($_SESSION['user'])){
                                        echo '<a href="#modal_disconnect" class="waves-effect waves-light modal-trigger user"><i class="mdi-action-account-circle left"></i>'.$_SESSION['user'].'&nbsp;<span class="uppercase">(logout)</span></a>';
                                    }
                                    else{
                                        echo '<a href="./pages/login.php" class="waves-effect waves-light"><i class="mdi-action-https left"></i>LOGIN</a>';
                                    }
                                ?>
                            </li>
                            <li>
                                <a href="./pages/contacto.php" class="waves-effect waves-light"><i class="mdi-content-mail left"></i>CONTACTO</a>
                            </li>
                        </ul>
                        <ul id="slide-out" class="side-nav">
                            <li class="brand">
                                <a href="#" class="waves-effect waves-light"><h5 class="myfont">MyNVENTORY</h5></a>
                            </li>
                            <li class="active">
                                <a href="#" class="waves-effect waves-light"><i class="mdi-action-home left"></i>INICIO</a>
                            </li>
                            <li>
                                <a href="./pages/inventarios.php" class="waves-effect waves-light"><i class="mdi-action-assignment left"></i>INVENTARIOS</a>
                            </li>
                            <li>
                                <?php
                                if (isset($_SESSION['user'])){
                                    echo '<a href="#modal_disconnect" class="waves-effect waves-light modal-trigger user"><i class="mdi-action-account-circle left"></i>'.$_SESSION['user'].'&nbsp;<span class="uppercase">(logout)</span></a>';
                                }
                                else{
                                    echo '<a href="./pages/login.php" class="waves-effect waves-light"><i class="mdi-action-https left"></i>LOGIN</a>';
                                }
                                ?>
                            </li>
                            <li>
                                <a href="./pages/contacto.php" class="waves-effect waves-light"><i class="mdi-content-mail left"></i>CONTACTO</a>
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
            <div class="container-wide">
                <div class="row margintop50">
                    <div id="central-panel" class="col l12 m12 s12 center-align light-green lighten-4 z-depth-1">
                        <h2>Bienvenido a &nbsp;<strong class="myfont">MyNVENTORY</strong></h2>
                        <h5>¡Registrate ahora y empieza a crear tus propios inventarios personalizados!</h5>
                        <a href="./pages/registro.php" class="waves-effect waves-light btn-large light-green accent-4">REGISTRATE</a>
                    </div>
                </div>
                <div class="row margintop30">
                    <div class="col l8 m12 s12">
                        <p class="p-big">
                            <strong>MyNVENTORY</strong> es una página web pensada para la creación y gestión de inventarios
                            digitales personalizados. La composición y el contenido de los inventarios quedan totalmente 
                            abiertos a tus necesidades, permitiéndote crear los inventarios según las especificaciones 
                            que tu requieras.<br/><br/>
                            ¿Quieres hacer un inventario de lo que sea? ¿Libros? ¿Peliculas? ¿Articulos de coleccion?<br/><br/>
                            <strong>¡Diseña tu propio inventario, con los campos de información que tu necesites!</strong>
                        </p>
                    </div>
                    <div class="col l4 m12 s12">
                        <img class="responsive-img" src="images/inventory_256.png">
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
                    <a href="./functions/usersdb.php?logout=logout" class=" modal-action modal-close waves-effect waves-green btn-flat right">Desconectar</a>

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
        <script type="text/javascript" src="vendor/jquery/js/jquery-2.1.4.js"></script>
        <script type="text/javascript" src="vendor/jquery.flip/js/jquery.flip.js"></script>
        <script type="text/javascript" src="vendor/materialize/js/materialize.js"></script>
        <script type="text/javascript" src="js/custom-scripts-inventory.js"></script>
    </body>
  </html>
        