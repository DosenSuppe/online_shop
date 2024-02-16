<?php
    /**
     * createVerificationToken
     * 
     * generates an returns a verification code for email verification
     * 
     * output:
     *  verificationCode -> string
     */
    function createVerificationToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // checking if that code already exists
        $codeExists = sqlExecute("
            SELECT verificationCode code FROM verifications WHERE verificationCode = '$randomString';
        ")->fetch_assoc();

        // if the code has already been created, create a new code
        return $codeExists == null ? $randomString : createVerificationToken();
    }

    /**
     * createSaltToken
     * 
     * generates an returns a verification code for email verification
     * 
     * output:
     *  verificationCode -> string
     */
    function createSaltToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?!*#\´`/%&=}[]{$';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * userGetCurrentUser
     * 
     * returns the userId for the current logged-in user
     * 
     * outputs:
     *  user    -> userId: string
     *  no user -> null
     */
    function userGetCurrentUser() {
        $path = realpath("./");

        $modifiedPath = strstr($path, "online_shop", true)."online_shop/src/other/user.dat";

        $fileContents =  file_get_contents($modifiedPath);
        
        return $fileContents != false ? $fileContents : null;
    }

    /**
     * addToShoppingCart
     * 
     * adds a product to the shoppingcart
     * 
     * inputs:
     *  productId   -> string
     *  amount      -> number
     * 
     * requires:
     *  library/php/sqlServer.php
     */
    function addToShoppingCar($productId, $amount) {
        $user = userGetCurrentUser();

        sqlExecute("INSERT INTO cart (productId, userId, amount) 
                    VALUES ('$productId', '$user', '$amount');");
    }

    /**
     * removeFromShoppingCart
     * 
     * removes a product from the shoppingcart
     * 
     * inputs:
     *  productId   -> string
     * 
     * requires:
     *  library/php/sqlServer.php
     */
    function removeFromShoppingCart($productId) {
        $user = userGetCurrentUser();

        sqlExecute("DELETE 
                        * 
                    FROM 
                        cart 
                    WHERE 
                        productId = '$productid' AND
                        userId = '$user';");
    }

    /**
     * userSetCurrentUser
     * 
     * sets the currently logged-in user
     * 
     * inputs:
     *  userId  -> string
     * 
     * outputs:
     *  stored successfully -> true
     *  failed so store     -> false
     */
    function userSetCurrentUser($userId) {
        $path = realpath("./");
        $modifiedPath = strstr($path, "online_shop", true)."online_shop/src/other/user.dat";

        $writeSuccess = file_put_contents($modifiedPath, $userId);

        return $writeSuccess != false ? true : false;
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
        return ($userCurrentUser == null) ? false : true;
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
                isSupplier isSupplier
            FROM
                users
            WHERE 
                userId = '$userId';
        ")->fetch_assoc()['isSupplier'];
        
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
        ")->fetch_assoc()["isAdmin"];

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