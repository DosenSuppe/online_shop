<?php

    include_once("./library/php/sqlServer.php");

    $products = sqlLoadData("SELECT productId, productName, price, productDescription FROM products;");
    
    while ($product = $products->fetch_assoc())
    {
        $productId = $product["productId"];
        $productName = $product["productName"];
        $productPrice = $product["price"];
        $productThumbnail = "src/img/product.jpg";
        $productDescription = $product["productDescription"];

        if (strlen($productDescription) > 150) {
            $productDescription = strtok(wordwrap($productDescription, 150, "...\n"), "\n");
        }

        echo <<<HTML
        <section class="product">
            <img src="$productThumbnail" alt="$productName">
            <form action="./com/php/action/ShowProduct.php" method="GET" class="product-info">
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