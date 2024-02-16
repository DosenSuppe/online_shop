<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/displayStyle.css">
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

    <main class="product-display">
        <?php 
            include_once("../../../library/php/sqlServer.php");

            $productId = $_GET["productId"];

            $query = "
            SELECT  p.productName productName, 
                    p.productDescription productDescription, 
                    p.price price, 
                    p.availableCountry productCountry,

                    s.name supplierName,
                    s.countryOrigin supplierCountry,
                    s.userId userId
            
            FROM 
                products p, 
                users s

            WHERE 
                p.productId = '$productId'";

            $productData = sqlLoadData($query)->fetch_assoc();

            $image = sqlLoadData("SELECT * FROM images WHERE productId = '$productId';")->fetch_assoc();
        
            if ($image == null) {
                $productThumbnail = "../../../src/img/cart.png";
            } else {
                $productThumbnail = "data:image/jpg;charset=utf8;base64,".base64_encode($image['imageData']);
            }
        
            $productName = $productData["productName"];
            $productDescription = $productData["productDescription"];
            $productPrice = $productData["price"];

            $supplierId = $productData["userId"];

            $supplierName = $productData["supplierName"];
            $supplierCountry = $productData["supplierCountry"];

            // error-condition checking -- product has to have a country linked to it!
            if ($productData["productCountry"] == null) {
                header("Location: http://localhost/PHP/online_shop/");
                die();
            }

            // displaying the country
            $countryCode = $productData["productCountry"];

            echo <<<HTML
                <div class="product-container">
                    <div class="product-image">
                        <!-- img src="../../../src/img/product.jpg" -->
                        <img src="$productThumbnail">
                    </div>
                </div>
                <div class="product-info-insh">
                    <h1>$productName</h1>
                    <img class="country-icon" src="../../../src/img/$supplierCountry.png"> <h4>$supplierName</h4><br>
                    <a class="product-price"> $productPrice €</a><br><br>
                    <a class="product-description">$productDescription</a>
                    <button onClick="addCart'$productId');" type="button" class="Zum-warenkorb-fuegen">Zum Warenkorb hinzufügen</button>
            HTML;

            if (userGetCurrentUser() == $supplierId) {
                echo <<<HTML
                    <form action="../action/SupplierActions.php" method="POST">
                        <input type="text" value="$productId" name="id" hidden readonly>
                        <input type="text" value="deleteProduct" name="action" hidden readonly>
                        <input type="submit" class="delete" value="Produkt löschen">
                    </form>
                HTML;
            }

            echo "</div>";
            // displaying the product's comments
            include_once("../action/ShowComments.php");

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