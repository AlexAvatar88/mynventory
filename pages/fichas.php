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
            <form id="fileForm" action="./../functions/fichasdb.php" method="post">
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
                                <a id="deleteFile"  class="btn-floating red tooltipped waves-effect waves-light" data-position="left" data-delay="0" data-tooltip="Eliminar">
                                    <i class="large mdi-action-delete"></i>
                                </a>
                            </li>
                            <li>
                                <a id="editFile" class="btn-floating yellow darken-1 tooltipped waves-effect waves-light" data-position="left" data-delay="0" data-tooltip="Modificar">
                                    <i class="large mdi-editor-mode-edit"></i>
                                </a>
                            </li>
                            <li>
                                <a id="addFile" class="btn-floating cyan tooltipped waves-effect waves-light" data-position="left" data-delay="0" data-tooltip="Añadir">
                                    <i class="large mdi-content-add"></i>
                                </a>
                            </li>
                            <li>
                                <a id="seeFile" class="btn-floating  amber darken-2 tooltipped waves-effect waves-light"  data-position="left" data-delay="0" data-tooltip="Ver">
                                    <i class="large mdi-action-visibility"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- / floating action buttons -->
                <!-- Inventory list -->
                <h4 id="file-title">Inventario - <?php echo $_SESSION['see']; ?></h4>
                <a id="editPlantilla" href="plantilla.php" class="btn waves-effect waves-light disabled">
                    Editar Plantilla<i class="mdi-content-create left"></i>
                </a>

                <a id="return" href="inventarios.php" class="btn waves-effect waves-light red lighten-1 right">
                    Volver<i class="mdi-navigation-arrow-back left"></i>
                </a>
                <div id="file-wrapper" class="col l12 m12 s12 aux-html">
                    <ul id="files" class="collection">
                        <?php
                        $table=$_SESSION['see'].'_'.$_SESSION['user'];
                        $connection=connectDb();
                        $fileCreated=false;
                        if(mysqli_num_rows(mysqli_query($connection, 'SHOW TABLES LIKE \''.$table.'\''))==0){
                            $fileCreated=false;
                        }
                        elseif(mysqli_num_rows(mysqli_query($connection, 'SHOW TABLES LIKE \''.$table.'\''))==1){
                            $fileCreated=true;
                        }

                        if($fileCreated==false){
                            echo    '<li class="collection-item avatar file z-depth-1">
                                        <span class="title red-text lighten-1">Aun no has creado ninguna plantilla.</span><br><br>
                                        <button id="createFile" class="btn waves-effect waves-light light-green accent-4" type="button" >Crear Plantilla
                                            <i class="mdi-content-add right"></i>
                                        </button>
                                    </li>';
                        }
                        elseif($fileCreated==true) {
                            $sql= 'SELECT * FROM `'.$table.'`';
                            $result = queryDb($connection, $sql);
                            $hasContent=false;
                            if(mysqli_affected_rows($connection)==0){
                                $hasContent=false;
                            }
                            elseif(mysqli_affected_rows($connection)>0){
                                $hasContent=true;
                            }

                            if($hasContent==true){
                                $sql = 'DESC `'.$table.'`';
                                $result = queryDb($connection, $sql);
                                $fields = [];
                                $counter = 0;
                                if (mysqli_affected_rows($connection) != 0) {
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        $fields[$counter] = $row['Field'];
                                        $counter++;
                                    }
                                    if(isset($_GET['files'])){
                                        $sql = 'select * from `'.$table.'` WHERE ';
                                        for($i=0; $i<$_GET['files']; $i++){
                                            $sql=$sql.'item_id=\''.$_GET['file'.$i].'\' ';
                                            if($i<($_GET['files']-1)){
                                                $sql=$sql.'OR ';
                                            }
                                        }
                                    }
                                    else{
                                        $sql = 'select * from `'.$table.'`';
                                    }
                                    $result = queryDb($connection, $sql);
                                    if (mysqli_affected_rows($connection) != 0) {
                                        $counter=0;
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            echo '<li class="collection-item avatar file z-depth-1">
                                                    <div class="flip-wrapper">
                                                        <div class="flip" onclick="checkboxToggle(\'#file'.$counter.'\')">
                                                            <div class="front">
                                                                <i class="mdi-action-description circle indigo"></i>
                                                            </div>
                                                            <div class="back">
                                                                <i class="mdi-action-done circle grey"></i>
                                                            </div>
                                                        </div>
                                                    </div>';
                                            for ($i = 1; $i < count($fields); $i++) {
                                                echo '<p class="field-title">' . $fields[$i] . ':&nbsp;</p><p class="field-value">' .$row[$fields[$i]]. '</p><br>';
                                            }
                                            echo        '<div class="secondary-content">
                                                        <input type="checkbox" id="file'.$counter.'" name="files[]" value="'.$row['item_id'].'"/>
                                                        <label for="file'.$counter.'"></label>
                                                    </div>
                                                </li>';
                                            $counter++;
                                        }
                                    }
                                }
                            }
                            else{
                                echo    '<li class="collection-item avatar file z-depth-1">
                                            <span class="title red-text lighten-1">Aun no has creado ninguna ficha en tu inventario.</span>
                                        </li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- / Inventory list -->
                <div id="modal_delete" class="modal">
                    <div class="modal-content">
                        <h4>¿Esta seguro que desea eliminar las fichas(s) seleccionada(s)?</h4>
                    </div>
                    <div class="modal-footer">
                        <button class=" modal-action modal-close waves-effect waves-green btn-flat left" type="submit" name="submit-delFile" value="submit">Confirmar</button>
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
                    <span>&nbsp;&nbsp;-&nbsp; Botón para borrar las fichas seleccionadas.</span>
                </li><br>
                <li>
                    <a class="btn-floating yellow darken-1 waves-effect waves-light">
                        <i class="large mdi-editor-mode-edit"></i>
                    </a>
                    <span>&nbsp;&nbsp;-&nbsp; Botón para modificar la ficha seleccionada (solo una).</span>
                </li><br>
                <li>
                    <a class="btn-floating cyan waves-effect waves-light">
                        <i class="large mdi-content-add"></i>
                    </a>
                    <span>&nbsp;&nbsp;-&nbsp; Botón para añadir una nueva ficha.</span>
                </li><br>
                <li>
                    <a class="btn-floating amber darken-2 waves-effect waves-light">
                        <i class="large mdi-action-visibility"></i>
                    </a>
                    <span>&nbsp;&nbsp;-&nbsp; Botón para ver solo las fichas seleccionadas.</span>
                </li><br>
                <li>
                    <p>Nota: Las fichas se seleccionan haciendo click sobre el icono azul de cada ficha.</p>
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
<script type="text/javascript" src="../js/custom-scripts-file.js"></script>
<script type="text/javascript">
    var fileCreated='';
    var fields=[];
    <?php
        if($fileCreated){
            echo 'fileCreated=true;';
            $sql = 'DESC `'.$table.'`';
            $result = queryDb($connection, $sql);
            $counter = 0;
            if (mysqli_affected_rows($connection) != 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo 'fields['.$counter.']="'.$row['Field'].'";';
                    $counter++;
                }
            }
        }
        else{
            echo 'fileCreated=false;';
        }
    ?>

    $('#addFile').click(function(){
        addFile(fileCreated, fields);
    });

    $('#editFile').click(function(){
        editFile(fields);
    });

    if(fileCreated===true){
        $('#editPlantilla').addClass('blue').addClass('lighten-2').removeClass('disabled')
    }

    var action="<?php if(isset($_GET['action'])){ echo $_GET['action']; }else{ echo ''; } ?>";
    var create=<?php if(isset($_GET['create'])){ echo $_GET['create']; }else{ echo '""'; } ?>;
    var add=<?php if(isset($_GET['add'])){ echo $_GET['add']; }else{ echo '""'; } ?>;
    var deleted=<?php if(isset($_GET['deleted'])){ echo $_GET['deleted']; }else{ echo '""'; } ?>;
    var edit=<?php if(isset($_GET['edit'])){ echo $_GET['edit']; }else{ echo '""'; } ?>;

    var inventory="<?php if(isset($_GET['inventory'])){ echo $_GET['inventory']; }else{ echo ''; } ?>";

    if (action!=''){
        if (action=='create'){
            if(create===true){
                Materialize.toast('Se ha creado la plantilla del inventario '+inventory+' con exito.', 4000);
            }
            else{
                Materialize.toast('Ups! ha ocurrido un error.', 4000);
            }
        }
        if (action=='add'){
            if(add===true){
                Materialize.toast('Se ha añadido una nueva ficha a '+inventory+' con exito.', 4000);
            }
            else{
                Materialize.toast('Ups! ha ocurrido un error.', 4000);
            }
        }

        if (action=='delete'){
            if(deleted>0){
                Materialize.toast(deleted+' ficha(s) borrada(s) con exito.', 4000);
            }

        }
        if (action=='edit'){
            if(edit===true){
                Materialize.toast('La ficha ha sido modificada con exito.', 4000);
            }
            else{
                Materialize.toast('Ups! ha ocurrido un error.', 4000);
            }
        }
    }

    var files=<?php if(isset($_GET['files'])){ echo 'true'; }else{ echo 'false'; } ?>;
    if(files===true){
        $('#return').attr('href', 'fichas.php').html('Ver todas<i class="mdi-navigation-arrow-back left"></i>');
    }

</script>
</body>
</html>