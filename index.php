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
        <a class="user-account-display">Gast</a>
      </div>

      <br>

      <nav>
        <ul>
          <li><div><a href="./index.php">Home</a></div></li>
          <li><div><a href="#">Search</a></div></li>
          <li><div><a href="#">Contact</a></div></li>
          <li><div><a href="#">Log-In</a></div></li>
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
      <p>&copy; 2023 Your Shop. All rights reserved.</p>
    </div>
  </footer>
  
  <script src="./com/js/app.js"></script>
</body>
</html>
