<?php
    include_once("../../../library/php/userControl.php");
    include_once("../../../library/php/sqlServer.php");
    include_once("../../../library/php/generalControl.php");

    $currentUser = userGetCurrentUser();
    $productId = $_GET["productId"];

    // checking if the user is blocked
    // if blocked, the user is not allowed to submit comments
    if (userIsBlocked()) {
        header("Location: http://localhost/PHP/online_shop/com/php/site/ShowProduct.php?productId=$productId");
        die();
    }

    $userComment = $_GET["commentText"];
    // filtering the words
    $filteredText = $userComment; // generalFilterString($userComment);

    if (strlen($filteredText) > 0) {
        $query = "
            INSERT INTO productcomments (productId, customerId, creationDate, text)
            VALUES  ('$productId', '$currentUser', CURRENT_TIMESTAMP, '$filteredText');
        ";

        sqlSaveData($query);
    }
    
    header("Location: http://localhost/PHP/online_shop/com/php/site/ShowProduct.php?productId=$productId");
    die();
?>