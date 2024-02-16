<?php
    $userEmail = $_POST["email"];
    $userPassword = $_POST["password"];

    include_once("../../../library/php/userControl.php");
    include_once("../../../library/php/sqlServer.php");

    $loginSuccess = userLogin($userEmail, $userPassword);
    
    if ($loginSuccess == false) {
        echo "Invalid Email or Password";
        exit();
    } 

    userSetCurrentUser($loginSuccess);
    header('Location: ' . 'http://localhost/PHP/online_shop/');
    die();
?>