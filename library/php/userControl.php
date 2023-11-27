<?php
    /**
     * returns the customerId for the current logged-in user
     */
    function userGetCurrentUser() {
        return "C0001";
    }

    /**
     * userIsBlocked
     * 
     * checks if the current user is blocked. 
     * 
     * outputs:
     *  blocked     -> true
     *  not blocked -> false
     * 
     * requires: library/php/sqlServer.php
     */
    function userIsBlocked() {
        $currentUser = userGetCurrentUser();
        $result = sqlExecute("
            SELECT isBlocked FROM customers WHERE customerId = '$currentUser'
        ")->fetch_assoc();

        return ($result["isBlocked"] == 1) ? true : false; 
    }

    /**
     * userIsLoggedIn 
     * 
     * checks if there the client is logged into a user-account
     * 
     * outputs:
     *  is logged in     -> true
     *  is not logged in -> false
     * 
     * requires: library/php/sqlServer.php
     */
    function userIsLoggedIn() {

    }

    /**
     * userIsAdmin
     * 
     * $userId -> customerId
     * 
     * Checks if the user is an admin.
     * 
     * outputs:
     *  admin     -> true
     *  non-admin -> false
     * 
     * requires: library/php/sqlServer.php
     */
    function userIsAdmin($userId) {
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