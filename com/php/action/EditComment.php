<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../com/styles/styles.css">
    <link rel="stylesheet" href="../../../com/styles/editComment.css">
    <title>Useless-Things.com</title>
</head>
<body>

  <header>
    <div class="container">
      <h1>Willkommen bei</h1>
      <h1>&emsp;&emsp;&emsp;Useless-Things.com</h1>
    
      <div class="user-account-div">
        <a href="../site/UserSettings.php" class="user-account-display"><?php 
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
                <li><div><a href="../../../com/php/site/SupplierInterface.php">Supplies</a></div></li>
              HTML;
            }
          ?>
          
          <!-- giving admin-users access to the admin-panel -->
          <?php 
            include_once("../../../library/php/sqlServer.php");
            include_once("../../../library/php/userControl.php");

            if (userIsAdmin(userGetCurrentUser())) {
              echo <<<HTML
                <li><div><a href="../../../com/php/site/AdminInterface.php">Admin</a></div></li>
              HTML;
            }
          ?>

          <li><div><a href="../../../com/php/site/SignUpLogIn.php">Log-In</a></div></li>
        </ul>
      </nav>
    </div>
  </header>
  
  <main class="container" id="product-container">
    <!-- 
        contains all the products
    -->

    <div class="comment-container">
        <?php 
            if (isset($_POST["editComment"])) {
              $creator = userGetCurrentUser();
              $timestamp = $_POST["timestamp"];
              $pid = $_POST["pid"];
              $newComment = $_POST["editComment"];

              sqlExecute("UPDATE 
                              productcomments 
                          SET 
                              text = '$newComment' 
                          WHERE
                              productId = '$pid'    AND
                              creationDate = '$timestamp' AND
                              userId = '$creator' ");
              $preSite = "http://localhost/PHP/online_shop/com/php/site/ShowProduct.php?productId=".$pid;

              header('Location: ' . $preSite);
              exit();
            } 

            $productId = $_POST["productId"];
            $commentCreator = $_POST["commentCreator"];
            $commentDate = $_POST["timestamp"];
            $commentText = $_POST["commentText"];
            $customerCountry = $_POST["userCountry"];

            echo <<<HTML
                <form class="comment" action="./EditComment.php" method="POST">
                    
                    <div class="comment-info">
                        <img src="../../../src/img/$customerCountry.png" alt="Country of Origin">
                        <div class="comment-details">
                            <h4>$commentCreator</h4>
                            <span class="comment-date">$commentDate</span>
                        </div>
                    </div>
                    
                    <input type="text" name="pid" value="$productId"  hidden readonly>
                    <input type="text" name="timestamp" value="$commentDate" hidden readonly>

                    <input type="text" value="$commentText" name="editComment" class="comment-text"></p>
                    
                    <input type="submit" value="Speichern">
                </form>
            HTML;
        ?>
    </div>
  </main>

  <footer>
    <div class="container">
      <p>&copy; 2023 Useless-Things. All rights reserved.</p>
    </div>
  </footer>
  
</body>
</html>
