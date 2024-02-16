<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/displayStyle.css">
    <link rel="stylesheet" href="../../styles/supplierStyle.css">
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

    <main>
        <div class="test">
            <div class="card1 card-position1">
                    <form action="../action/SupplierActions.php" method="POST" enctype="multipart/form-data">
                        <input name="action" value="addProduct" readonly hidden>

                        <h1 class="TextMiddle">Produkt erstellen</h1><br>
                        <div class="FieldMiddle">
                            <input class="itemsRow1" type="text" name="productName" placeholder="Produktname" required>
                            <input class="itemsRow1" type="text" name="price" placeholder="Preis" required>
                        </div>
                        <div class="FieldMiddle">
                            <input class="itemsRow2" type="text" name="productDesc" placeholder="Produktbeschreibung" required>
                            <input type="file" name="image" required>
                            <input class="upload itemsRow2" type="submit" name="" value="Submit">
                        </div>
                        <div class="inputBox"><br><br>
                        </div>
                    </form>
            </div>

            <?php 
                    include_once("../../../library/php/sqlServer.php");
                    include_once("../../../library/php/userControl.php");

                    $currentUser = userGetCurrentUser();

                    $result = sqlExecute("
                            SELECT
                                productName bestProduct,
                                price price,
                                purchases purchases
                            FROM
                                products
                            WHERE
                                supplierId = '$currentUser'
                            ORDER BY purchases DESC
                            LIMIT 1;
                    ")->fetch_assoc();

                    $price = floatval($result["price"]);
                    $productIdWithMostPurchases = $result["bestProduct"];
                    $purchases = intval($result["purchases"]);

                    $income = $price * $purchases;

                    echo <<<HTML
                        <div class="card1 card-position2">
                            <form action="../action/SupplierActions.php" method="POST">

                                <input name="action" value="mostPurchase" readonly hidden>
                                <h1 class="TextMiddle">Meistverkauftes Produkt</h1><br>
                                <div class="FieldMiddle">
                                    <p class="itemsRow1">Produkt</p>
                                    <p class="itemsRow1">Einnahmen</p>
                                    <p class="itemsRow1">Anzahl Käufe</p>
                                </div>
                                <div class="FieldMiddle">
                                    <p class="itemsRow2">$productIdWithMostPurchases</p>
                                    <p class="itemsRow2">$income €</p>
                                    <p class="itemsRow2">$purchases</p>
                                </div>
                            </form>
                        </div>
                    HTML;
            
            ?>
        </div>  
            

        <?php 
            include_once("../../../library/php/sqlServer.php");
        ?>
    </div>
    </main>

    <footer>
        <div class="container">
        <p>&copy; 2023 Useless-Things. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="./com/js/app.js"></script>
</body>
</html>