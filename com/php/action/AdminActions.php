<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") exit(1);

    include_once("../../../library/php/sqlServer.php");

    $action = $_POST["action"];
    $referralId = $_POST["referralId"];

    switch ($action) {
        /**
         * blocking a user
         * inputs:
         *      userId
         */
        case 'block':
            sqlExecute("
                UPDATE users
                SET isBlocked = 1
                WHERE userId = '$referralId';
            ");

            break;
        

        /**
         * unblocking a user
         * inputs:
         *      userId
         */
        case 'unblock':
            sqlExecute("
                UPDATE users
                SET isBlocked = 0
                WHERE userId = '$referralId';
            ");

            break;

        case 'deleteUser':
            sqlExecute("
                DELETE FROM users
                WHERE userId = '$referralId';
            ");
            break;

        case 'deleteProduct':
            sqlExecute("
                DELETE FROM products
                WHERE productId = '$referralId';
            ");
            break;

        case 'setAdmin':
            sqlExecute("
                UPDATE users
                SET isAdmin = 1
                WHERE userId = '$referralId';
            ");
            break;

        case 'removeAdmin':
            sqlExecute("
                UPDATE users
                SET isAdmin = 0
                WHERE userId = '$referralId';
            ");
            break;

        case 'setSupplier':
            sqlExecute("
                UPDATE users
                SET isSupplier = 1
                WHERE userId = '$referralId';
            ");
            break;

        case 'removeSupplier':
            sqlExecute("
                UPDATE users
                SET isSupplier = 0
                WHERE userId = '$referralId';
            ");
            break;
            
        default:
            // something went wrong...
            break;
    }

    // redirect to previous site
    $preSite = $_SERVER['HTTP_REFERER'];
    header("Location: $preSite");
?>