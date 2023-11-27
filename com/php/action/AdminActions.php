<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") exit(1);

    include_once("../../../library/php/sqlServer.php");

    $action = $_POST["action"];
    $userId = $_POST["userId"];

    switch ($action) {
        /**
         * blocking a user
         * inputs:
         *      userId
         */
        case 'block':
            sqlExecute("
                UPDATE customers
                SET isBlocked = 1
                WHERE customerId = '$userId';
            ");

            break;
        

        /**
         * unblocking a user
         * inputs:
         *      userId
         */
        case 'unblock':
            sqlExecute("
                UPDATE customers
                SET isBlocked = 0
                WHERE customerId = '$userId';
            ");

            break;

        default:
            // something went wrong...
            break;
    }

    $preSite = $_SERVER['HTTP_REFERER'];
    header("Location: $preSite");
?>