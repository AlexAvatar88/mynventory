<?php
session_start ();

if (isset($_POST['submit-addInv'])){
    $action='add';
}
elseif (isset($_POST['submit-delInv'])){
    $action='delete';
}
elseif (isset($_POST['submit-editInv'])){
    $action='edit';
}


switch($action){
    case 'add': addInventory();
        break;

    case 'delete': deleteInventory();
        break;

    case 'edit': editInventory();
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

function addInventory(){
    $connection=connectDb();

    $nameInv=mysqli_real_escape_string($connection, $_POST['name-inv']);
    $descInv=mysqli_real_escape_string($connection,$_POST['desc-inv']);

    $validName=checkValidName($nameInv, $connection);

    if ($validName){
        $sql='INSERT INTO inventories (username, inventory_name, inventory_desc) VALUES (\''.$_SESSION['user'].'\', \''.$nameInv.'\', \''.$descInv.'\')';
        $result=queryDb($connection, $sql);

        if ($result===true){
            header('Location: ./../pages/inventarios.php?success=true&inventory='.$nameInv);
        }
        else{
            header('Location: ./../pages/inventarios.php?success=false');
        }
    }
    else{
        if ($validName === false){
            header('Location: ./../pages/inventarios.php?success=false&inventory='.$nameInv);
        }
    }
}

/* DELETE INVENTORIES */
function deleteInventory(){
    if (isset($_POST['inventories'])) {
        if (count($_POST['inventories'])>0) {
            $connection=connectDb();
            $borrados=0;
            foreach ($_POST['inventories'] as $inventory) {
                $sql='DELETE FROM inventories WHERE username=\''.$_SESSION['user'].'\' AND inventory_name=\''.$inventory.'\'';
                $result=queryDb($connection, $sql);
                if (mysqli_affected_rows($connection)==1 and $result==true){
                    $borrados++;
                }
                $sql='DROP TABLE `'.$inventory.'_'.$_SESSION['user'].'`';
                $result=queryDb($connection, $sql);
            }
            header('Location: ./../pages/inventarios.php?deleted='.$borrados);
        }
        else{
            header('Location: ./../pages/inventarios.php');
        }
    }
    else{
        header('Location: ./../pages/inventarios.php'); //handler JS ningun inventario seleccionado
    }
}

/* EDIT INVENTORY */
function editInventory(){
    $connection=connectDb();

    $nameInv=mysqli_real_escape_string($connection, $_POST['name-inv']);
    $descInv=mysqli_real_escape_string($connection,$_POST['desc-inv']);
    $oldName=$_POST['old-name-inv'];

    $caseChange=strcasecmp ($nameInv,$oldName);

    if ($caseChange!=0){
        $validName=checkValidName($nameInv, $connection);
    }
    else{
        $validName=true;
    }

    if ($validName){
        $sql='UPDATE inventories SET inventory_name=\''.$nameInv.'\', inventory_desc=\''.$descInv.'\' WHERE username=\''.$_SESSION['user'].'\' AND inventory_name=\''.$oldName.'\'';
        $result=queryDb($connection, $sql);

        if (mysqli_affected_rows($connection)==1){
            header('Location: ./../pages/inventarios.php?edit=true&inventory='.$nameInv);
        }
        else{
            header('Location: ./../pages/inventarios.php?edit=false');
        }
    }
    else{
        if ($validName === false){
            header('Location: ./../pages/inventarios.php?edit=false&inventory='.$oldName);
        }
    }
}













