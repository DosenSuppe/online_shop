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
                <a class="user-account-display">Gast</a>
            </div>

            <br>

            <nav>
                <ul>
                <li><div><a href="../../../index.php">Home</a></div></li>
                <li><div><a href="#">Search</a></div></li>
                <li><div><a href="#">Contact</a></div></li>

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

                <li><div><a href="#">Log-In</a></div></li>
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
                    s.country supplierCountry
            
            FROM 
                products p, 
                suppliers s

            WHERE 
                p.productId = '$productId' AND
                p.supplierId = s.supplierId;";

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
                    <h1>$productName</h1>
                    <img class="country-icon" src="../../../src/img/$supplierCountry.png"> <h4>$supplierName</h4><br>
                    <a class="product-description">$productDescription</a>
                </div>
            HTML;

            // displaying the product's comments
            include_once("../action/ShowComments.php");



        ?>
    </main>

    <form action="../action/upload.php" method="post" enctype="multipart/form-data">
        <label>Select Image File:</label>

        <input type="file" name="image">
        <input type="text" name="productId">
        <input type="text" name="isFront">
        <input type="submit" name="submit" value="Upload">
    </form>

    <footer>
        <div class="container">
        <p>&copy; 2023 Useless-Things. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="./com/js/app.js"></script>
</body>
</html>
