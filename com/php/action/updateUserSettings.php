<?php 
    include_once("../../../library/php/userControl.php");
    include_once("../../../library/php/sqlServer.php");

    $userId = userGetCurrentUser();
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $countryOrigin = $_POST["countryOrigin"];

    sqlExecute("UPDATE 
                    users
                SET 
                    name = '$name',
                    surname = '$surname',
                    countryOrigin = '$countryOrigin'
                WHERE
                    userId = '$userId';");

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
?>