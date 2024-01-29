<?php
    function sqlTest() {
        echo "<script>alert(\"Hello World!\")</script>";
    }

    /**
     * DEPRICATED
     * loading data from a table
     */
    function sqlLoadData($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }  

    /**
     * sqlCreateUser
     * 
     * creates a user and saves them to the database
     * 
     * inputs:
     *  name        -> Name of the user
     *  surname     -> Surname of the user
     *  birthdate   -> Birthdate of the user
     *  email       -> Email of the user
     *  password    -> Password of the user
     *  phonenumber -> Phonenumber of the user
     *  verified    -> Whether the user is verified or not
     * 
     * outputs:
     *  Id  -> user has been created
     *  2   -> user already exists
     *  3   -> unable to create user (internal server error)
     */
    function sqlCreateUser( $name, $surname, $email, $password, $birthdate) {
        // checking if the email is already in use
        $alreadyExists = sqlExecute("SELECT email FROM users WHERE email = '$email'; ")->fetch_assoc();
        
        if ($alreadyExists) return 2;
        $userCount = sqlExecute("SELECT Count(email) userCount FROM users;")->fetch_assoc()["userCount"];
        
        // hashing the password
        $passwordSalt = createSaltToken();
        $hashedPassword = password_hash($password.$passwordSalt, PASSWORD_DEFAULT);

        $newUserId = "C" . $userCount + 1;
        // saving the new user to the database
        $creationResponse = sqlExecute("
            INSERT INTO users (userId, name, surname, email, password, birthdate)
            VALUES ('$newUserId', '$name', '$surname', '$email', '$hashedPassword', 'birhtdate');
        ");

        // checking user has been created and returning the ID, else return internal error
        return $creationResponse? $creationResponse : 3;
    }

    /**
     * DEPRICATED
     * saves data to table
     */
    function sqlSaveData($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }


    /**
     * 
     * PLEASE MIGRATE TO THIS FUNCTION!
     * 
     * executes a mysql query
     */
    function sqlExecute($sqlQuery) {
        $sqlConnection = mysqli_connect("127.0.0.1", "root", "", "shop_project");

        $result = mysqli_query($sqlConnection, $sqlQuery);
        
        $sqlConnection->close();

        return $result;
    }

?>