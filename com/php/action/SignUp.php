<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST") return;

    // verifying the email verification code
    if (isset($_POST["verificationCodeVerify"])) {
        
        if ($_POST["verificationCodeVerify"] == $_POST["verificationCode"]) {
            // updating the email in the database to "verified"
            echo <<<HTML
                <script>alert("You have been registered!") </script>
            HTML;
            
            $email = $_POST["email"];
            

            header("Location: http://localhost/PHP/online_shop/index.php");
            die();

        } else {
            // email failed to be verified
            echo <<<HTML
                <script>alert("Invalid Verification code!") </script>
            HTML;

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }
    include_once("../../../library/php/userControl.php");

    // registering new email
    $email = $_POST["email"];

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
                <p>Dear User,</p>
                <p>Thank you for registering! To complete your registration, please click the button below to verify your email:</p>
                <a class="verification-button">Verifcation Code: $verificationCode</a>
                <p>If you didn't register on our site, you can ignore this email.</p>
                <p>Best Regards,<br>Your Website Team</p>
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
                                <input type="email" name="email" value="$email" hidden>
                                <input type="text" name="name" value="$name" hidden>
                                
                                <button type="submit">Verify</button>
                                
                                <button class="changeField" id="toLogin">No Email received?</button>
                            </form>
                        </div>
                    </div>
                </main>
            </body>
            </html>
        HTML;
    } else {
        // email could not be send
        include("./SignUp.php");
    }    
?>