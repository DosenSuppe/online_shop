<?php 

    if ($_SERVER["REQUEST_METHOD"] != "POST") exit(1);

    include_once("../../../library/php/sqlServer.php");
    include_once("../../../library/php/userControl.php");

    $action = $_POST["action"];
    $userId = userGetCurrentUser();

    switch ($action) {

        case 'deleteProduct':
            $referalId = $_POST["id"];
            sqlExecute("DELETE FROM products WHERE productId = '$referalId';");
            sqlExecute("DELETE FROM images WHERE productId = '$referalId';");
            header("Location: http://localhost/PHP/online_shop/");
            exit();
            break;

        case 'addProduct':
            $productName = $_POST["productName"];
            $price = $_POST["price"];
            $productDesc = $_POST["productDesc"];

            $products = sqlExecute("SELECT Count(productId) count FROM products;")->fetch_assoc()["count"];
            
            $productId = "P". strval(intval($products) + 1);
            
            sqlExecute("
                INSERT INTO products (productId, supplierId, productName, price, sale, tags, productDescription, availableCountry, purchases)
                VALUES ('$productId', '$userId', '$productName', $price, '', '', '$productDesc', 'de-DE', '0');
            ");

            $status = 'error'; 
            if(!empty($_FILES["image"]["name"])) { 
                // Get file info 
                $fileName = basename($_FILES["image"]["name"]); 
                $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                
                // Allow certain file formats 
                $allowTypes = array('jpg','png','jpeg','gif'); 
                if(in_array($fileType, $allowTypes)){ 
                    $image = $_FILES['image']['tmp_name']; 
                    $imgContent = addslashes(file_get_contents($image)); 
                
                    $isFront = true; 

                    // Insert image content into database 
                    $insert = sqlSaveData("
                        INSERT INTO images (productId, imageData, isFrontImage)
                        VALUES ('$productId', '$imgContent', $isFront)
                    ");

                    if($insert){ 
                        $status = 'success'; 
                        $statusMsg = "File uploaded successfully."; 
                    }else{ 
                        $statusMsg = "File upload failed, please try again."; 
                    }  
                }else{ 
                    $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
                } 
            }else{ 
                $statusMsg = 'Please select an image file to upload.'; 
            } 

            break;
            
        default:
            // something went wrong...
            break;
    }

    // redirect to previous site
    $preSite = $_SERVER['HTTP_REFERER'];
    header("Location: $preSite");
?>