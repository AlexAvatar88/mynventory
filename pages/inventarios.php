<?php session_start();
if (!isset($_SESSION['user'])){
    header('Location: login.php');
}
else{
    require_once('./../functions/connectiondb.php');
    if (isset($_SESSION['see'])){
        unset($_SESSION['see']);
    }
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
                            <li class="active">
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
                            <li class="active">
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
                    <form id="inventoryForm" action="./../functions/inventorydb.php" method="post">
                        <!-- floating action buttons -->
                        <div id="action-button-wrapper">
                            <div class="fixed-action-btn" style="bottom: 60px; right: 24px;">
                                <a class="btn-floating btn-large light-green accent-4 waves-effect waves-light">
                                    <i class="large mdi-navigation-more-vert"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a class="btn-floating purple tooltipped waves-effect waves-light modal-trigger" href="#modal_help" data-position="left" data-delay="0" data-tooltip="Ayuda">
                                            <i class="large mdi-action-help"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="deleteInv"  class="btn-floating red tooltipped waves-effect waves-light" data-position="left" data-delay="0" data-tooltip="Eliminar">
                                            <i class="large mdi-action-delete"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="editInv" class="btn-floating yellow darken-1 tooltipped waves-effect waves-light" data-position="left" data-delay="0" data-tooltip="Modificar">
                                            <i class="large mdi-editor-mode-edit"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="addInv" class="btn-floating cyan tooltipped waves-effect waves-light" data-position="left" data-delay="0" data-tooltip="Añadir">
                                            <i class="large mdi-content-add"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="seeInv" class="btn-floating  amber darken-2 tooltipped waves-effect waves-light"  data-position="left" data-delay="0" data-tooltip="Ver">
                                            <i class="large mdi-action-visibility"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- / floating action buttons -->
                        <!-- Inventory list -->
                        <div id="inventory-wrapper" class="col l12 m12 s12 aux-html">
                            <h4>Inventarios</h4>
                            <ul id="inventories" class="collection">
                                <?php
                                    $connection=connectDb();
                                    $sql='SELECT * FROM inventories WHERE username=\''.$_SESSION['user'].'\'';
                                    $result=queryDb($connection, $sql);
                                    $counter=1;

                                    if (mysqli_affected_rows($connection)!=0){
                                        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
                                        {
                                            echo '<li class="collection-item avatar">
                                                    <div class="flip-wrapper">
                                                        <div class="flip" onclick="checkboxToggle(\'#inventory'.$counter.'\')">
                                                            <div class="front">
                                                                <i class="mdi-action-assignment circle orange"></i>
                                                            </div>
                                                            <div class="back">
                                                                <i class="mdi-action-done circle grey"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="title">'.$row['inventory_name'].'</span>
                                                    <p class="description">'.$row['inventory_desc'].'</p>
                                                    <div class="secondary-content">
                                                        <input type="checkbox" id="inventory'.$counter.'" name="inventories[]" value="'.$row['inventory_name'].'"/>
                                                        <label for="inventory'.$counter.'"></label>
                                                    </div>
                                                </li>';
                                            $counter++;
                                        }
                                    }
                                    elseif(mysqli_affected_rows($connection)==0 && $result==true){
                                        echo    '<li class="collection-item avatar">
                                                    <span class="title red-text lighten-1">Aun no has creado ningun inventario.</span>
                                                </li>';
                                    }
                                    elseif($result==false){
                                        echo    '<li class="collection-item avatar">
                                                    <span class="title red-text lighten-1">Ups! Ha ocurrido un error. Intentalo de nuevo mas tarde.</span>
                                                    <p>Si el error persiste ponte en contacto con nosotros a traves de nuestro formulario.</p>
                                                </li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    <!-- / Inventory list -->
                        <div id="modal_delete" class="modal">
                            <div class="modal-content">
                                <h4>¿Esta seguro que desea eliminar los inventario(s) seleccionado(s)?</h4>
                            </div>
                            <div class="modal-footer">
                                <button class=" modal-action modal-close waves-effect waves-green btn-flat left" type="submit" name="submit-delInv" value="submit">Confirmar</button>
                                <a class=" modal-action modal-close waves-effect waves-green btn-flat right">Cancelar</a>
                            </div>
                        </div>
                    </form>
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
            <div id="modal_help" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h4>Ayuda</h4>
                    <ul>
                        <li>
                            <a class="btn-floating purple waves-effect waves-light" >
                                <i class="large mdi-action-help"></i>
                            </a>
                            <span>&nbsp;&nbsp;-&nbsp; Botón de ayuda.</span>
                        </li><br>
                        <li>
                            <a class="btn-floating red waves-effect waves-light">
                                <i class="large mdi-action-delete"></i>
                            </a>
                            <span>&nbsp;&nbsp;-&nbsp; Botón para borrar los inventarios seleccionados.</span>
                        </li><br>
                        <li>
                            <a class="btn-floating yellow darken-1 waves-effect waves-light">
                                <i class="large mdi-editor-mode-edit"></i>
                            </a>
                            <span>&nbsp;&nbsp;-&nbsp; Botón para modificar el inventario seleccionado (solo uno).</span>
                        </li><br>
                        <li>
                            <a class="btn-floating cyan waves-effect waves-light">
                                <i class="large mdi-content-add"></i>
                            </a>
                            <span>&nbsp;&nbsp;-&nbsp; Botón para añadir un nuevo inventario.</span>
                        </li><br>
                        <li>
                            <a class="btn-floating amber darken-2 waves-effect waves-light">
                                <i class="large mdi-action-visibility"></i>
                            </a>
                            <span>&nbsp;&nbsp;-&nbsp; Botón para ver un inventario (solo uno).</span>
                        </li><br>
                        <li>
                            <p>Nota: Los inventarios se seleccionan haciendo click sobre el icono naranja de cada inventario.</p>
                        </li><br>

                    </ul>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">OK</a>
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
            var success=<?php if(isset($_GET['success'])){echo $_GET['success']; }else{ echo '""'; } ?> ;
            var inventory="<?php if(isset($_GET['inventory'])){echo $_GET['inventory']; }else{ echo ''; } ?>";
            var deleted=<?php if(isset($_GET['deleted'])){echo $_GET['deleted']; }else{ echo '0'; } ?> ;
            var edit=<?php if(isset($_GET['edit'])){echo $_GET['edit']; }else{ echo '""'; } ?> ;

            if (success===true){
                Materialize.toast('El inventario '+inventory+' ha sido añadido con exito.', 4000);
            }
            else if(success===false && success!=undefined){
                Materialize.toast('El inventario '+inventory+' ya existe.', 4000);
            }

            if (deleted>0){
                Materialize.toast(deleted+' inventario(s) borrado(s) con exito.', 4000);
            }

            if (edit===true){
                Materialize.toast('El inventario '+inventory+' ha sido modificado con exito.', 4000);
            }
            else if(edit===false && inventory!=''){
                Materialize.toast('El inventario '+inventory+' no se ha modificado, ya existe un inventario con ese nombre.', 4000);
            }

        </script>
    </body>
  </html>