<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/displayStyle.css">
    <link rel="stylesheet" href="../../styles/adminStyle.css">
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

    <main class="card-display">
    <div class="card">
            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="block" readonly hidden>

                <h1 class="TextMiddle">Benutzer sperren</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="unblock" readonly hidden>
                
                <h1 class="TextMiddle">Sperrung aufheben</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>

        <div class="card">
            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="deleteProduct" readonly hidden>

                <h1 class="TextMiddle">Produkt löschen</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="Product-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>

            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="deleteUser" readonly hidden>

                <h1 class="TextMiddle">Benutzer löschen</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>
        
        <div class="card">
            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="setAdmin" readonly hidden>

                <h1 class="TextMiddle">Admin geben</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>

            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="removeAdmin" readonly hidden>

                <h1 class="TextMiddle">Admin nehmen</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>

        <div class="card">
            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="setSupplier" readonly hidden>

                <h1 class="TextMiddle">Verkäufer geben</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>

            <form action="../action/AdminActions.php" method="POST">
                <input name="action" value="removeSupplier" readonly hidden>

                <h1 class="TextMiddle">Verkäufer nehmen</h1><br>
                <div class="FieldMiddle"><input type="text" name="referralId" placeholder="User-Id" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>


        <?php 
            include_once("../../../library/php/sqlServer.php");
        ?>
    </main>


    <footer>
        <div class="container">
        <p>&copy; 2023 Useless-Things. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="./com/js/app.js"></script>
</body>
</html>