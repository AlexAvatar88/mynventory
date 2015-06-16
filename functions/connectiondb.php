<?php
function connectDb(){  //mysqli_real_escape_string($connection, $var)
    $connection=mysqli_connect('localhost', 'root', '', 'mynventory');
    return $connection;
}

function queryDb($connection, $sql){
    $result=mysqli_query($connection, $sql);
    return $result;
}