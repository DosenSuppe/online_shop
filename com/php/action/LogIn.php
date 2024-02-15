<?php
    $userEmail = $_POST["email"];
    $userPassword = $_POST["password"];

    include_once("../../../library/php/userControl.php");
    include_once("../../../library/php/sqlServer.php");

    $loginSuccess = userLogin($userEmail, $userPassword);
    
    echo "Success: ".$loginSuccess;

?>