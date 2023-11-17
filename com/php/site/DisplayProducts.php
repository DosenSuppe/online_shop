<?php

    include_once("./library/php/sqlServer.php");

    $products = sqlLoadData("SELECT productId, productName, price, productDescription FROM products;");
    
    while ($product = $products->fetch_assoc())
    {

        $productId = $product["productId"];
        $productName = $product["productName"];
        $productPrice = $product["price"];
        $productDescription = $product["productDescription"];

        $image = sqlLoadData("SELECT imageData FROM images WHERE productId = '$productId';")->fetch_assoc();

        if ($image == null) {
            $productThumbnail = "src/img/cart.png";
        } else {
            $productThumbnail = "data:image/jpg;charset=utf8;base64,".base64_encode($image['imageData']);
        }

        if (strlen($productDescription) > 150) {
            $productDescription = strtok(wordwrap($productDescription, 150, "...\n"), "\n");
        }

        echo <<<HTML
        <section class="product">
            <img src="$productThumbnail" alt="$productName">
            <form action="./com/php/site/ShowProduct.php" method="GET" class="product-info">
                <h2>$productName</h2>
                <input class="hide-this" type="text" name="productId" value="$productId" readonly>

                <p class="description">$productDescription</p>
                <div class="price-container">
                    <a class="price">$productPrice</a>
                    <span>€</span>
                </div>
                <div class="button-container">
                    <input type="submit" value="Produkt anzeigen">
                    <button onClick="addWishlist('$productId');" type="button" class="wishButton">
                        <img id="wish-for-$productId" src="src/img/wish_no.png">
                    </button>
                </div>
            </form>
        </section>
        HTML;
        
    }

?>