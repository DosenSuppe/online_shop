<?php

    include_once("../../../library/php/sqlServer.php");

    $productId = $_POST["productId"];
    $customerId = $_POST["customerId"];
    $timestamp = $_POST["timestamp"];

    $query = "
        DELETE FROM productcomments
        WHERE
            productId = '$productId'    AND
            customerId = '$customerId'  AND
            creationDate = '$timestamp'
    ";

    sqlExecute($query);

    header("Location: http://localhost/PHP/online_shop/com/php/site/ShowProduct.php?productId=$productId");
    die();

?>