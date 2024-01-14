<?php
    $user_currentUser = null;
    
    /**
     * returns the userId for the current logged-in user
     */
    function userGetCurrentUser() {
        return $user_currentUser;
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
            SELECT isBlocked FROM users WHERE userId = '$currentUser'
        ")->fetch_assoc();

        return ($result["isBlocked"] == 1) ? true : false; 
    }

    /**
     * userIsLoggedIn 
     * 
     * checks if the client is logged into a user-account
     * 
     * outputs:
     *  is logged in     -> true
     *  is not logged in -> false
     * 
     */
    function userIsLoggedIn() {
        return ($user_currentUser == null) ? false : true;
    }

    /**
     * userIsSupplier
     * 
     * $userId -> supplierId
     * 
     * checks if the client is logged into a supplier-account
     * 
     * outputs:
     *  supplier        -> true
     *  non-supplier    -> false
     * 
     * requires: library/php/sqlServer.php:sqlExecute
     */
    function userIsSupplier($userId) {
        $isSupplier = sqlExecute("
            SELECT 
                isAdmin isAdmin
            FROM
                users
            WHERE 
            userId = '$userId';
        ")->fetch_assoc();

        return $isSupplier == 0 ? false : true;
    }

    /**
     * userIsAdmin
     * 
     * $userId -> userId
     * 
     * checks if the user is an admin.
     * 
     * outputs:
     *  admin     -> true
     *  non-admin -> false
     * 
     * requires: library/php/sqlServer.php:sqlExecute
     */
    function userIsAdmin($userId) {
        $isAdmin = sqlExecute("
            SELECT 
                isAdmin isAdmin
            FROM
                users
            WHERE 
            userId = '$userId';
        ")->fetch_assoc();

        return $isAdmin == 1 ? true : false;
    }

    /**
     * userLogIn
     * 
     * $userEmail -> the user's email
     * $userPassw -> the user's password
     * 
     * tries to log in a user with given parameters
     * 
     * outputs: 
     *  login-success -> true
     *  login-failed -> false
     * 
     * requires: library/php/sqlServer.php:sqlExecute
     */
    function userLogin($userEmail, $userPassw) {
        $userData = sqlExecute("
            SELECT 
            
            FROM

            WHERE
        ");

        // gotta check if there is acutally data for the given credentials


    }
?>