<?php
session_start ();

if (isset($_GET['logout'])){
    $action='logout';
}
elseif (isset($_POST['submit-log'])){
    $action='login';
}
elseif (isset($_POST['submit-reg'])){
    $action='register';
}
elseif (isset($_POST['submit-cntct'])){
    $action='contact';
}

switch($action){
    case 'logout': logoutUser();
        break;

    case 'login': checkLoginUser($_POST['user-log'], $_POST['pass-log']);
        break;

    case 'register': registerUser($_POST['email-reg'], $_POST['user-reg'], $_POST['pass-reg']);
        break;

    case 'contact':
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

/* LOGOUT */
function logoutUser(){
    unset($_SESSION['user']);
    session_destroy();
    header('Location: ./../index.php');
}

/* LOGIN */
function checkLoginUser($user, $pass){
    $connection=connectDb();
    $user=mysqli_real_escape_string($connection, $user);
    $pass=mysqli_real_escape_string($connection, $pass);
    $sql='select username from users where username=\''.$user.'\' and password=\''.$pass.'\'';
    $result=queryDb($connection, $sql);

    if ($result!=false && mysqli_affected_rows($connection)==1){
        $_SESSION['user']=$user;
        header('Location: ./../pages/login.php?success=true');
    }
    else{
        header('Location: ./../pages/login.php?success=false&user='.$user);
    }
}

/* REGISTRO */
function checkValidUser($user, $connection){
    $sql='select username from users where username=\''.$user.'\'';
    $result=queryDb($connection, $sql);
    $valid=false;

    if ($result==true && mysqli_affected_rows($connection)==0){
        $valid=true;
    }
    return $valid;
}

function checkValidEmail($email, $connection){
    $sql='select username from users where email=\''.$email.'\'';
    $result=queryDb($connection, $sql);
    $valid=false;

    if ($result==true && mysqli_affected_rows($connection)==0){
        $valid=true;
    }
    return $valid;
}

function registerUser($email, $user, $pass){
    $connection=connectDb();
    $email=mysqli_real_escape_string($connection, $email);
    $user=mysqli_real_escape_string($connection, $user);
    $pass=mysqli_real_escape_string($connection, $pass);

    $validEmail=checkValidEmail($email, $connection);
    $validUser=checkValidUser($user, $connection);

    if ($validEmail && $validUser){
        $sql='INSERT INTO users (username, password, email) VALUES (\''.$user.'\', \''.$pass.'\', \''.$email.'\')';
        $result=queryDb($connection, $sql);

        if ($result===true){
            header('Location: ./../pages/login.php?success=true&register=true&user='.$user);
        }
        else{
            header('Location: ./../pages/registro.php?success=false');
        }
    }
    else{
        if ($validEmail === false){
            header('Location: ./../pages/registro.php?success=false&fail=email&email='.$email.'&user='.$user);
        }
        elseif ($validUser === false){
            header('Location: ./../pages/registro.php?success=false&fail=user&email='.$email.'&user='.$user);
        }
    }
}







