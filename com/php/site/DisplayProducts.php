<?php

    include_once("./library/php/sqlServer.php");

    $products = sqlLoadData("products", "SELECT productName, price, productDescription FROM products;");
    
    while ($product = $products->fetch_assoc())
    {

        $productName = $product["productName"];
        $productPrice = $product["price"];
        $productThumbnail = "src/img/product.jpg";
        $productDescription = $product["productDescription"];

        if (strlen($productDescription) > 150) {
            $productDescription = strtok(wordwrap($productDescription, 150, "...\n"), "\n");
        }

        echo "<section class=\"product\">";
        echo "<img src=\"$productThumbnail\" alt=\"$productName\">";
        echo "<form action=\"./com/php/action/PutInCard.php\" method=\"GET\" class=\"product-info\">";
        echo "<h2> <input type=\"text\" name=\"product\" value=\"$productName\" readonly> </h2>";
        echo "<p class=\"description\">$productDescription</p>";
        echo "<div class=\"price-container\">";
        echo "<input type=\"text\" class=\"price\" name=\"price\" value=\"$productPrice\" readonly>";
        echo "<span>€</span></div>";
        echo "<input type=\"submit\" value=\"Direkt kaufen\">";
        echo "<input type=\"button\" class=\"putInCart\"></form></section>";
        
    }

?>