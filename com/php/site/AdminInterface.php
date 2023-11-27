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
                <li><div><a href="#">Log-In</a></div></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="product-display">
    <div class="product">
            <form action="AdminB_block.php" method="POST">
                <h1 class="TextMiddle">Benutzer sperren</h1><br>
                <div class="FieldMiddle"><input type="text" id="blockUser" name="blockUser" placeholder="Benutzername" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
            <form action="AdminB_unblock.php" method="POST">
                <h1 class="TextMiddle">Sperrung aufheben</h1><br>
                <div class="FieldMiddle"><input type="text" id="unblockUser" name="unblockUser" placeholder="Benutzername" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>

        <div class="product">
            <form action="AdminB.php" method="POST">
                <h1 class="TextMiddle">Hersteller sperren</h1><br>
                <div class="FieldMiddle"><input type="text" id="blockUser" name="blockUser" placeholder="Benutzername" required></div>
                <div class="inputBox"><br><br><br>
                  <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>

        <div class="product">
            <form action="AdminB.php" method="POST">
                <h1 class="TextMiddle">...</h1><br>
                <div class="FieldMiddle"><input type="text" id="blockUser" name="blockUser" placeholder="Benutzername" required></div>
                <div class="inputBox"><br><br><br>
                    <input class="button" type="submit" name="" value="Submit">
                </div>
            </form>
        </div>

        <?php 
            include_once("../../../library/php/sqlServer.php");

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
