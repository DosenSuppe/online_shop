<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    include_once("../../../library/php/userControl.php");
    include_once("../../../library/php/sqlServer.php");

    // checking if the email is already in use
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $emailInUse = sqlExecute("
            SELECT email FROM users WHERE email = '$email'; 
        ")->fetch_assoc();

        if ($emailInUse) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }
    

    // verifying the email verification code
    if (isset($_POST["verificationCodeVerify"])) {

        if ($_POST["verificationCodeVerify"] == $_POST["verificationCode"]) {
            // removing the getting the data and removing the verification code from the database
            $verificationCode = $_POST["verificationCode"];

            $data = sqlExecute("
                SELECT email email, password password, name name, surname surname, birthdate birthdate 
                FROM verifications 
                WHERE verificationCode = '$verificationCode';")->fetch_assoc();

            sqlExecute("DELETE FROM verifications WHERE verificationCode = '$verificationCode' ");

            $email = $data["email"];
            $password = $data["password"];
            $name = $data["name"];
            $surname = $data["surname"];
            $birthdate = $data["birthdate"];
            
            $userId = sqlCreateUser($name, $surname, $email, $password, $birthdate);

            // account already exists
            if ($userId == 2) {

            // internal server error
            } else if ($userId == 3) {

            // account has been created
            } else {
                $logSuccess = userSetCurrentUser($userId);
                if ($logSuccess != true) {
                    echo "Something went wrong! Error-Code: ".$logSuccess."<br>";
                    exit();
                }
            }

            header("Location: http://localhost/PHP/online_shop/index.php");
            exit();

        } else {
            // email failed to be verified

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    // all user-given inputs
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $birthdate = $_POST["birthdate"];
    $password = $_POST["password"];
    
    // registering the new email
    $subject = "Registration";

    // generate a new verification token
    $verificationCode = createVerificationToken();

    // email message
    $message = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Verification</title>
            <style>
                /* Email Styles */
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                }

                .email-container {
                    background-color: #fff;
                    box-shadow: 0 4px 10px #133952;
                    border-radius: 5px;
                    padding: 20px;
                }

                h2 {
                    color: #3498db;
                }

                p {
                    margin-bottom: 15px;
                }

                .verification-button {
                    background-color: #3498db;
                    color: #fff;
                    padding: 10px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    text-decoration: none;
                    display: inline-block;
                }

                .verification-button:hover {
                    background-color: #2872a4;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <h2>Email Verification</h2>
                <p>Dear $name,</p>
                <p>Thank you for registering! To complete your registration, please click the button below to verify your email:</p>
                <a class="verification-button">Verifcation Code: $verificationCode</a>
                <p>If you didn't register on our site, you can ignore this email.<br>
                <p style="color: #ff0000">This verification code expires after 15 minutes!</p></p>
                <p>Best Regards,<br>Your Useless-Things Team</p>
            </div>
            <br>
            <br>
            <br>
        </body>
        </html>
    HTML;

    // email header
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: UseLessThings.com <originniklas2017@gmail.com>' . "\r\n";

    // sending mail to the user
    $response = mail($email, $subject, $message, $headers);
    
    if ($response) {
        // email has been send
        echo <<<HTML
            <html>

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../../styles/styles.css">
                <link rel="stylesheet" href="../../styles/SignUpLogIn.css">
                <title>Useless-Things.com</title>
            </head>

            <body>
                <header> 
                    <div class="container">
                        <h1>Willkommen bei</h1>
                        <h1>&emsp;&emsp;&emsp;Useless-Things.com</h1>
                    </div>
                </header>

                <main>
                    <div id="holder" class="login-signup-container">
                        <div id="signUp" class="login-signup-form">
                            <h2>Verify Your Email</h2>
                            <p style="text-align: center;">We have send a verification code to your email. Please check out your inbox and spam-folder.</p><br>
                            <form action="../action/SignUp.php" method="POST">
                                <input type="text" name="verificationCode" placeholder="Verification Code" required>
                                <input type="text" name="verificationCodeVerify" value="$verificationCode" hidden>
                                
                                <button type="submit">Verify</button>
                                
                                <button class="changeField" id="toLogin">No Email received?</button>
                            </form>
                        </div>
                    </div>
                </main>
            </body>
            </html>
        HTML;

        // check for outdated verification Codes (codes older than 15min)
        sqlExecute("
            DELETE FROM verifications WHERE creationTimeStamp + 15 * 60 < UNIX_TIMESTAMP();
        ");

        // save info the database 
        $creationTimeStamp = strtotime("now");
        sqlExecute("
            INSERT INTO verifications (verificationCode, creationTimeStamp, email, name, surname, password, birthdate)
            VALUES ('$verificationCode', '$creationTimeStamp', '$email', '$name', '$surname', '$password', '$birthdate');
        ");

    } else {
        // email could not be send
        include("./SignUp.php");
    }    
?>