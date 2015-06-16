<?php
session_start ();

if (isset($_POST['submit-createFile'])){
    $action='create';
}
elseif (isset($_POST['submit-addFile'])){
    $action='add';
}
elseif (isset($_POST['submit-delFile'])){
    $action='delete';
}
elseif (isset($_POST['submit-editFile'])){
    $action='edit';
}

switch($action){
    case 'create': createFile();
        break;

    case 'add': addFile();
        break;

    case 'delete': deleteFile();
        break;

    case 'edit': editFile();
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

/* NEW INVENTORY */
function checkValidName($nameInv, $connection){
    $sql='select inventory_name from inventories where inventory_name=\''.$nameInv.'\'';
    $result=queryDb($connection, $sql);
    $valid=false;

    if ($result==true && mysqli_affected_rows($connection)==0){
        $valid=true;
    }
    return $valid;
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
        $nameField=mysqli_real_escape_string($connection, trim($_POST['field'.$i]));
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

/* DELETE FILES */
function deleteFile(){
    $table=$_SESSION['see'].'_'.$_SESSION['user'];
    if (isset($_POST['files'])) {
        if (count($_POST['files'])>0) {
            $connection=connectDb();
            $borrados=0;
            foreach ($_POST['files'] as $file) {
                $sql='DELETE FROM `'.$table.'` WHERE item_id=\''.$file.'\'';
                $result=queryDb($connection, $sql);
                if (mysqli_affected_rows($connection)==1 and $result==true){
                    $borrados++;
                }
            }
            header('Location: ./../pages/fichas.php?action=delete&deleted='.$borrados);
        }
        else{
            header('Location: ./../pages/fichas.php');
        }
    }
    else{
        header('Location: ./../pages/fichas.php'); //handler JS ningun inventario seleccionado
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