<?php

    include_once("../../../library/php/sqlServer.php");

    $productId = $_POST["productId"];
    $user = $_POST["userId"];
    $timestamp = $_POST["timestamp"];

    // deleting the comment
    sqlExecute("
        DELETE FROM productcomments
        WHERE
            productId = '$productId'    AND
            userId = '$user'            AND
            creationDate = '$timestamp'
    ");

    header("Location: http://localhost/PHP/online_shop/com/php/site/ShowProduct.php?productId=$productId");
    die();
?>