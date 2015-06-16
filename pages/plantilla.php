<?php session_start();
if (!isset($_SESSION['user'])){
    header('Location: login.php');
}
else{
    require_once('./../functions/connectiondb.php');
}
if (isset($_GET['see'])){
    $_SESSION['see']=$_GET['see'];
}
if(!isset($_SESSION['see'])){
    header('Location: inventarios.php');
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
            <form id="plantillaForm" action="./../functions/plantilladb.php" method="post">
                <!-- Inventory list -->
                <h4 id="file-title">Edicion de plantilla - <?php echo $_SESSION['see']; ?></h4>
                <button id="submit-plantilla" class="btn waves-effect waves-light light-green accent-4 left" type="submit" name="submit-updatePlantilla" value="submit">
                    Guardar<i class="mdi-content-save right"></i>
                </button>
                <a id="return" href="fichas.php" class="btn waves-effect waves-light red lighten-1 right">
                    Volver<i class="mdi-navigation-arrow-back left"></i>
                </a>
                <div id="plantilla-wrapper" class="col l12 m12 s12 aux-html">
                    <ul id="plantilla" class="collection">
                        <?php
                        $table=$_SESSION['see'].'_'.$_SESSION['user'];
                        $connection=connectDb();

                        $sql = 'DESC `'.$table.'`';
                        $result = queryDb($connection, $sql);
                        $fields = [];
                        $counter = 0;
                        if (mysqli_affected_rows($connection) != 0) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $fields[$counter] = $row['Field'];
                                $counter++;
                            }
                            $counter=1;
                            for( $i=1; $i<count($fields); $i++) {
                                echo '<li class="collection-item avatar">
                                        <div class="flip-wrapper">
                                            <div class="flip" onclick="checkboxToggle(\'#plantilla' .$i. '\')">
                                                <div class="front">
                                                    <i class="mdi-editor-attach-file circle teal lighten-1"></i>
                                                </div>
                                                <div class="back">
                                                    <i class="mdi-action-done circle grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-field col l12 m12 s12">
                                            <input id="field'.$i.'" name="field'.$i.'" type="text" value="'.$fields[$i].'" required>
                                            <label for="field'.$i.'" class="active">Campo '.$i.'</label>
                                        </div>
                                        <div class="secondary-content">
                                            <input type="checkbox" id="plantilla' .$i. '" name="plantilla[]" value="'.$fields[$i].'"/>
                                            <label for="plantilla' .$i. '"></label>
                                        </div>
                                    </li>';
                                $counter++;
                            }
                        }
                        ?>
                    </ul>
                    <div class="input-field">
                        <input id="fields" name="fields" type="hidden" value="<?php echo (count($fields)-1); ?>">
                    </div>
                    <button id="addField-Plantilla" class="btn waves-effect waves-light light-green accent-4" type="button" onclick="addFieldPlantilla()">
                        Añadir campo<i class="mdi-content-add right hide-on-small-only"></i>
                    </button>
                    <button id="removeField-Plantilla" class="btn waves-effect waves-light red lighten-1 right" type="button" onclick="confirmDelete()">
                        Quitar campo<i class="mdi-content-remove right hide-on-small-only"></i>
                    </button>
                    <br><br><br>


                </div>
                <!-- / Inventory list -->
                <div id="modal_delete" class="modal">
                    <div class="modal-content">
                        <h4>¿Esta seguro que desea eliminar los campo(s) seleccionado(s)?</h4><h5>Tenga en cuenta que toda la informacion que contenga(n) dicho(s) campo(s) se perderá.</h5>
                    </div>
                    <div class="modal-footer">
                        <button class=" modal-action modal-close waves-effect waves-green btn-flat left" type="submit" name="submit-delPlantilla" value="submit">Confirmar</button>
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
<script type="text/javascript" src="../js/custom-scripts-plantilla.js"></script>
<script type="text/javascript">
    var action="<?php if(isset($_GET['action'])){ echo $_GET['action']; }else{ echo ''; } ?>";
    var deleted=<?php if(isset($_GET['deleted'])){ echo $_GET['deleted']; }else{ echo '""'; } ?>;
    var update=<?php if(isset($_GET['update'])){ echo $_GET['update']; }else{ echo '""'; } ?>;

    var inventory="<?php if(isset($_GET['inventory'])){ echo $_GET['inventory']; }else{ echo ''; } ?>";

    if (action!=''){

        if (action=='delete'){
            if(deleted>0){
                Materialize.toast(deleted+' campo(s) borrado(s) con exito.', 4000);
            }

        }

        if (action=='update'){
            if(update===true){
                Materialize.toast('Inventario '+inventory+' actualizado con exito.', 4000);
            }
            else{
                Materialize.toast('Ups! ha ocurrido un error.', 4000);
            }
        }
    }



</script>
</body>
</html>