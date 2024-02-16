<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/UserSettings.css">
    <title>Useless-Things.com</title>
</head>
<body>

    <header>
        <div class="container">
            <h1>Willkommen bei</h1>
            <h1>&emsp;&emsp;&emsp;Useless-Things.com</h1>
            
            <div class="user-account-div">
            <a href="./UserSettings.php" class="user-account-display"><?php 
            include_once("../../../library/php/sqlServer.php");
            include_once("../../../library/php/userControl.php");
            $currUser = userGetCurrentUser();

            if ($currUser) {
                $userName = sqlExecute("SELECT name name FROM users WHERE userId = '$currUser';")->fetch_assoc()["name"];
                echo $userName;
            } else {
                echo "Gast";
            }
            ?></a>
        </div>

        <br>

        <nav>
            <ul>
            <li><div><a href="../../../index.php">Home</a></div></li>
            <li><div><a href="#">Search</a></div></li>
            <li><div><a href="#">Contact</a></div></li>

            <!-- giving suppliers access to the supplier interface -->
            <?php 
                include_once("../../../library/php/sqlServer.php");
                include_once("../../../library/php/userControl.php");

                if (userIsSupplier(userGetCurrentUser())) {
                echo <<<HTML
                    <li><div><a href="./SupplierInterface.php">Supplies</a></div></li>
                HTML;
                }
            ?>
            
            <!-- giving admin-users access to the admin-panel -->
            <?php 
                include_once("../../../library/php/sqlServer.php");
                include_once("../../../library/php/userControl.php");

                if (userIsAdmin(userGetCurrentUser())) {
                echo <<<HTML
                    <li><div><a href="./AdminInterface.php">Admin</a></div></li>
                HTML;
                }
            ?>

            <li><div><a href="./SignUpLogIn.php">Log-In</a></div></li>
            </ul>
        </nav>
        </div>
    </header>

    <main class="container" id="product-container">
    
        <section class="product">
        <?php 
        include_once("../../../library/php/sqlServer.php");
        include_once("../../../library/php/userControl.php");

        $userId = userGetCurrentUser();
        $userData = sqlExecute("SELECT 
                                    name name, 
                                    surname surname, 
                                    email email, 
                                    countryOrigin countryOrigin,
                                    saleMail saleMail 
                                FROM 
                                    users 
                                WHERE 
                                    userId = '$userId';")->fetch_assoc();

        $email = $userData["email"];
        $name = $userData["name"];
        $surname = $userData["surname"];
        $countryOrigin = $userData["countryOrigin"];
        $saleMail = $userData["saleMail"];

        echo <<<HTML
                <form action="../action/updateUserSettings.php" method="POST" class="product-info">
                    <a>Vorname: </a>
                    <input type="text" name="name" value="$name"><br>
                    <a>Nachname: </a>
                    <input type="text" name="surname" value="$surname"><br>
                    <a>Email: </a>
                    <a>$email</a><br>
                    <a>Herkunftsland: </a>
                    <input type="text" name="countryOrigin" value="$countryOrigin"><br>
        HTML;

        if ($saleMail == "1") {
            echo <<<HTML
                <input type="checkbox" name="saleMail" value="0" checked>
            HTML;
        } else {
            echo <<<HTML
                <input type="checkbox" name="saleMail" value="1">
            HTML;
        }

        echo <<<HTML
                    <label for="saleMail">Bekomme E-Mail mitteilungen bei Rabatten</label><br><br>

                    <input type="submit" value="Speichern">

                </form>
        HTML;
        
        ?>
        </section>
        <section class="product">
            <div class="product-info">
            <?php
            $products = sqlLoadData("SELECT a.productName productName FROM products as a , cart as b WHERE a.productId = b.productId;")->fetch_assoc()["productName"];
                echo <<<HTML
                    <tr>
                        <td>$products</td>
                    </tr>;
                HTML;
            ?>
            </div>
    </section>
    </main>



    <footer>
        <div class="container">
        <p>&copy; 2023 Useless-Things. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>