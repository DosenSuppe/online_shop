<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./com/styles/styles.css">
    <title>Useless-Things.com</title>
</head>
<body>

  <header>
    <div class="container">
      <h1>Willkommen bei</h1>
      <h1>&emsp;&emsp;&emsp;Useless-Things.com</h1>
    
      <div class="user-account-div">
        <a href="./com/php/site/UserSettings.php" class="user-account-display"><?php 
          include_once("./library/php/sqlServer.php");
          include_once("./library/php/userControl.php");
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
          <li><div><a href="./index.php">Home</a></div></li>
          <li><div><a href="#">Search</a></div></li>
          <li><div><a href="#">Contact</a></div></li>

          <!-- giving suppliers access to the supplier interface -->
          <?php 
            include_once("./library/php/sqlServer.php");
            include_once("./library/php/userControl.php");

            if (userIsSupplier(userGetCurrentUser())) {
              echo <<<HTML
                <li><div><a href="./com/php/site/SupplierInterface.php">Supplies</a></div></li>
              HTML;
            }
          ?>
          
          <!-- giving admin-users access to the admin-panel -->
          <?php 
            include_once("./library/php/sqlServer.php");
            include_once("./library/php/userControl.php");

            if (userIsAdmin(userGetCurrentUser())) {
              echo <<<HTML
                <li><div><a href="./com/php/site/AdminInterface.php">Admin</a></div></li>
              HTML;
            }
          ?>

          <li><div><a href="./com/php/site/SignUpLogIn.php">Log-In</a></div></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container" id="product-container">
    <!-- 
        contains all the products
    -->
    <?php include("./com/php/site/DisplayProducts.php"); ?>
  </main>

  <footer>
    <div class="container">
      <p>&copy; 2023 Useless-Things. All rights reserved.</p>
    </div>
  </footer>
  
  <script src="./com/js/app.js"></script>
</body>
</html>
