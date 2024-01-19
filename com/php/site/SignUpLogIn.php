<!DOCTYPE html>
<html lang="en">
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
        
        <div class="user-account-div">
            <a class="user-account-display">Gast</a>
        </div>

        <br>

        <nav>
            <ul>
            <li><div><a href="../../../index.php">Home</a></div></li>
            <li><div><a href="#">Search</a></div></li>
            <li><div><a href="#">Contact</a></div></li>

            <!-- giving suppliers access to the supplier interface -->
            <!-- ?php 
                include_once("../../../library/php/sqlServer.php");
                include_once("../../../library/php/userControl.php");

                if (userIsSupplier(userGetCurrentUser())) {
                echo <<<HTML
                    <li><div><a href="./com/php/site/SupplierInterface.php">Supplies</a></div></li>
                HTML;
                }
            ? -->
            
            <!-- giving admin-users access to the admin-panel -->
            <!-- ?php 
                include_once("./library/php/sqlServer.php");
                include_once("./library/php/userControl.php");

                if (userIsAdmin(userGetCurrentUser())) {
                echo <<<HTML
                    <li><div><a href="./AdminInterface.php">Admin</a></div></li>
                HTML;
                }
            ? -->

            <li><div><a href="./SignUpLogIn.php">Log-In</a></div></li>
            </ul>
        </nav>
        </div>
    </header>

    <main>
    <div id="holder" class="login-signup-container">
        <div id="logIn" class="login-signup-form">
            <h2>Login</h2>
            <form action="../action/LogIn.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                        
                <button class="changeField" id="toSignUp">No Account?</button>
                <button class="changeField" id="toSignUp">Forgot Password?</button>
            </form>
        </div>

        <div id="signUp" style="display: none" class="login-signup-form">
            <h2>Sign Up</h2>
            <form action="../action/SignUp.php" method="POST">
                <input type="text" name="name" placeholder="Name" required>
                <input type="text" name="surname" placeholder="Surname" required>
                <input type="date" name="birthdate" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
                
                <button class="changeField" id="toLogin">Already have an account?</button>
            </form>
        </div>
    </div>

    <script>    
        /**
         * toggling between the sign-up and log-in interfaces
         */

        // from sign-up to log-in
        document.getElementById("toLogin").onclick = function() {
            document.getElementById("logIn").style.display = "";
            document.getElementById("signUp").style.display = "none";
        }

        // from log-in to sign-up
        document.getElementById("toSignUp").onclick = function() {
            document.getElementById("logIn").style.display = "none";
            document.getElementById("signUp").style.display = "";
        }
    </script>
</main>



    <footer>
        <div class="container">
        <p>&copy; 2023 Useless-Things. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
