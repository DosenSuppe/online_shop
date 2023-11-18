<?php
    include_once("../../../library/php/userControl.php");
    include_once("../../../library/php/sqlServer.php");

    $currentUser = userGetCurrentUser();
    $productId = $_GET["productId"];
    $userComment = $_GET["commentText"];

    $query = "
        INSERT INTO productcomments (productId, customerId, creationDate, text)
        VALUES  ('$productId', '$currentUser', CURRENT_TIMESTAMP, '$userComment');
    ";

    sqlSaveData($query);

    header("Location: https://localhost/PHP/online_shop/com/php/site/ShowProduct.php?productId=$productId");
    die();
?>