<?php
    /**
     * returns the customerId for the current logged-in user
     */
    function userGetCurrentUser() {
        return "C0001";
    }

    /**
     * userIsAdmin
     * 
     * $userId -> customerId
     * 
     * Checks if the user is an admin.
     * 
     * admin     -> true
     * non-admin -> false
     */
    function userIsAdmin($userId) {
        if (!function_exists("sqlExecute")) { 
            include("./sqlServer.php");
        }

        $isAdmin = sqlExecute("
            SELECT 
                isAdmin isAdmin
            FROM
                customers
            WHERE 
                customerId = '$userId';
        ")->fetch_assoc();

        return $isAdmin == 0 ? false : true;
    }

?>