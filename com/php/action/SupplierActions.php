<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") exit(1);

    include_once("../../../library/php/sqlServer.php");
    include("../../../library/php/userControl.php");

    $action = $_POST["action"];
    $userId = userGetCurrentUser();

    switch ($action) {

        case 'mostPurchase':
            $sql("
                SELECT productId, price, purchases
                FROM products
                WHERE supplierId = '$userId'
                GROUP BY productId
                ORDER BY COUNT(*) DESC
                LIMIT 1;
            ");
            $result = $_SERVER->query($sql);

            $row = $result->fetch_assoc();
            $productIdWithMostPurchases = $row["productId"];
            $price = $row["price"];
            $purchases = $row["purchases"];
            break;

        case 'addProduct':
            $productId = $_POST["productId"];
            $price = $_POST["price"];
            $productName = $_POST["productName"];
            sqlExecute("
                INSERT INTO products (productId, supplierId, productName, price, sale, tags, productDescription, availableCountry, purchases)
                VALUES ('$productId', '$userId', '$productName', $price, '', '', 'N/A', 'de-DE', '0');
            ");
            break;
            
        default:
            // something went wrong...
            break;
    }

    // redirect to previous site
    $preSite = $_SERVER['HTTP_REFERER'];
    header("Location: $preSite");
?>