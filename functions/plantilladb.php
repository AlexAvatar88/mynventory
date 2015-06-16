<?php
session_start ();

if (isset($_POST['submit-delPlantilla'])){
    $action='delete';
}
elseif (isset($_POST['submit-updatePlantilla'])){
    $action='update';
}


switch($action){
    case 'delete': deletePlantilla();
        break;

    case 'update': updatePlantilla();
        break;


    default: header('Location: ./../index.php');
        break;
}

function connectDb(){  //mysqli_real_escape_string($connection, $var)
    $connection=mysqli_connect('localhost', 'root', '', 'mynventory');
    return $connection;
}

function queryDb($connection, $sql){
    $result=mysqli_query($connection, $sql);
    return $result;
}


/* DELETE PLANTILLA */
function deletePlantilla(){
    $table=$_SESSION['see'].'_'.$_SESSION['user'];
    if (isset($_POST['plantilla'])) {
        if (count($_POST['plantilla'])>0) {
            $connection=connectDb();
            $borrados=0;
            foreach ($_POST['plantilla'] as $campo) {
                $sql='ALTER TABLE `'.$table.'` DROP `'.$campo.'`';
                $result=queryDb($connection, $sql);
                if ($result===true){
                    $borrados++;
                }
            }
            header('Location: ./../pages/plantilla.php?action=delete&deleted='.$borrados);
        }
        else{
            header('Location: ./../pages/fichas.php');
        }
    }
    else{
        header('Location: ./../pages/fichas.php'); //handler JS ningun inventario seleccionado
    }
}

//ALTER TABLE `pruebas_eliminar` CHANGE `qww` `qwwr` INT(11) NOT NULL, CHANGE `we` `wer` INT(11) NOT NULL;

/* UPDATE PLANTILLA*/
function updatePlantilla(){
    $connection=connectDb();
    $table=$_SESSION['see'].'_'.$_SESSION['user'];
    $sql = 'DESC `'.$table.'`';
    $result = queryDb($connection, $sql);
    $fields = [];
    $counter = 0;
    if (mysqli_affected_rows($connection) != 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $fields[$counter] = $row['Field'];
            $counter++;
        }
        $sql='ALTER TABLE `'.$table.'` '; // CHANGE `qww` `qwwr` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
        $sqlNew='ALTER TABLE `'.$table.'` ';//ADD `nombre 22` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL`;
        $num=$_POST['fields'];
        $newfields=false;

        for($i=1; $i<=$num; $i++ ){
            $nameField=mysqli_real_escape_string($connection, trim($_POST['field'.$i]));
            if ($i>(count($fields)-1)){
                $newfields=true;
                $sqlNew=$sqlNew.'ADD `'.$nameField.'` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL';
                if ($i<$num){
                    $sqlNew=$sqlNew.', ';
                }
            }
            else{
                $sql=$sql.'CHANGE `'.$fields[$i].'` `'.$nameField.'` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL';
                if ($i<(count($fields)-1)){
                    $sql=$sql.', ';
                }
            }
        }
        echo $sql;
        echo $sqlNew;
        $result=queryDb($connection, $sql);

        if ($newfields==true){
            $resultNew=queryDb($connection, $sqlNew);

            if ($result===true && $resultNew==true){
                header('Location: ./../pages/plantilla.php?action=update&update=true&inventory='.$_SESSION['see']);
            }
            else{
                header('Location: ./../pages/plantilla.php?action=update&update=false');
            }
        }
        else{
            if ($result===true){
                header('Location: ./../pages/plantilla.php?action=update&update=true&inventory='.$_SESSION['see']);
            }
            else{
                header('Location: ./../pages/plantilla.php?action=update&update=false');
            }
        }
    }
}















/* CREATE FILE (creacion plantilla) */
function createFile(){
    $connection=connectDb();

    $numFields=$_POST['numFields'];
    $table=$_SESSION['see'].'_'.$_SESSION['user'];
    $sql='CREATE TABLE IF NOT EXISTS `'.$table.'` (
        item_id int(11) NOT NULL AUTO_INCREMENT, ';
    echo $numFields;
    for ($i=1; $i<=$numFields; $i++){
        $nameField=mysqli_real_escape_string($connection, $_POST['field'.$i]);
        $sql=$sql.'`'.$nameField.'` varchar(200), ';
        echo $_POST['field'.$i];
    }

    $sql=$sql.'PRIMARY KEY (`item_id`))
        ENGINE=InnoDB
        DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';

    $result=queryDb($connection, $sql);

    $created=false;
    if(mysqli_num_rows(mysqli_query($connection, 'SHOW TABLES LIKE \''.$table.'\''))==0){
        $created=false;
    }
    elseif(mysqli_num_rows(mysqli_query($connection, 'SHOW TABLES LIKE \''.$table.'\''))==1){
        $created=true;
    }

    if ($created){
        header('Location: ./../pages/fichas.php?action=create&create=true&inventory='.$_SESSION['see']);
    }
    else{
        header('Location: ./../pages/fichas.php?action=create&create=false');
    }
}


/* ADD FILE */
function addFile(){
    $connection=connectDb();
    $table=$_SESSION['see'].'_'.$_SESSION['user'];
    $sql = 'DESC `'.$table.'`';
    $result = queryDb($connection, $sql);
    $fields = [];
    $counter = 0;
    if (mysqli_affected_rows($connection) != 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $fields[$counter] = $row['Field'];
            $counter++;
        }
        $sql='INSERT INTO `'.$table.'` (item_id';
        for($i=1; $i<count($fields); $i++){
            $sql=$sql.', `'.$fields[$i].'`';
        }
        $sql=$sql.') VALUES (NULL';
        for($i=1; $i<count($fields); $i++){
            $valueField=mysqli_real_escape_string($connection, $_POST['value'.$i]);
            $sql=$sql.', \''.$valueField.'\'';
        }
        $sql=$sql.');';
        echo $sql;
        $result=queryDb($connection, $sql);

        if ($result===true){
            header('Location: ./../pages/fichas.php?action=add&add=true&inventory='.$_SESSION['see']);
        }
        else{
            header('Location: ./../pages/fichas.php?action=add&add=false');
        }
    }
}





/* EDIT INVENTORY */
function editFile(){
    $connection=connectDb();
    $table=$_SESSION['see'].'_'.$_SESSION['user'];
    $sql = 'DESC `'.$table.'`';
    $result = queryDb($connection, $sql);
    $fields = [];
    $counter = 0;
    if (mysqli_affected_rows($connection) != 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $fields[$counter] = $row['Field'];
            $counter++;
        }
        $sql='UPDATE `'.$table.'` SET ';
        for($i=1; $i<count($fields); $i++){
            $value=mysqli_real_escape_string($connection, $_POST['value'.$i]);
            $sql=$sql.'`'.$fields[$i].'`=\''.$value.'\'';
            if ($i<(count($fields)-1)){
                $sql=$sql.', ';
            }
        }
        $sql=$sql.' WHERE item_id='.$_POST['item_id'];
        echo $sql;
        $result=queryDb($connection, $sql);
        if ($result===true){
            header('Location: ./../pages/fichas.php?action=edit&edit=true');
        }
        else{
            header('Location: ./../pages/fichas.php?action=add&add=false');
        }

    }
}