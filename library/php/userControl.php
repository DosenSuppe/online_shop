<?php

    // why the fuck is this not defining the variable?????
    $user_currentUser = null; 
    
    /**
     * returns the userId for the current logged-in user
     */
    function userGetCurrentUser() {
        if (isset($user_currentUser)) {
            return $user_currentUser;
        }
        return null;
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
     *  login-success -> userId: string
     *  login-failed -> false: boolean
     * 
     * requires: library/php/sqlServer.php:sqlExecute
     */
    function userLogin($userEmail, $userPassw) {
        
        $userData = sqlExecute(" 
            SELECT 
                userId      userId,
                email       userEmail,
                password    userPassw,
                salt        userSalt
            FROM
                users
            WHERE
                email = '$userEmail';
        ")->fetch_assoc();

        // gotta check if there is acutally data for the given credentials
        if ($userData == null) return false;
        
        $storedPassw = $userData["userPassw"];
        $storedSalt = $userData["userSalt"];
        $userId = $userData["userId"];

        $loginSuccess = password_verify($userPassw.$storedSalt, $storedPassw);

        if (!$loginSuccess) return false; 

        // checking for a re-hash
        if (password_needs_rehash($storedPassw, PASSWORD_DEFAULT)) {
            $rehashedPassw = password_hash($userPassw.$storedSalt, PASSWORD_DEFAULT);
            
            // updating the new password
            sqlExecute("
                UPDATE users 
                SET password = '$rehashedPassw' 
                WHERE email = '$userEmail';
            ");
        }
        
        return $userId;
    }
?>