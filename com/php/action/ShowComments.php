
<div class="comment-container">
    <h2>Käufer Kommentare</h2>

    <?php
        include_once("../../../library/php/userControl.php");


        $query = "
            SELECT
                c.creationDate commentDate,
                c.text commentText,
                c.userId userId,

                u.name customerName,
                u.surname customerSurname,
                u.countryOrigin customerCountry,
                u.isBlocked isBlocked

            FROM
                users u,
                productcomments c

            WHERE
                c.userId = u.userId     AND
                c.productId = '$productId';
        ";

        $comments = sqlLoadData($query);
        
        while ($comment = $comments->fetch_assoc()) {

            $commentCreator = $comment["customerName"]." ".$comment["customerSurname"];
            $commentText = $comment["commentText"];
            $commentDate = $comment["commentDate"];

            $userId = $comment["userId"];
            $customerCountry = strlen($comment["customerCountry"]) > 3 ? $comment["customerCountry"] : "null";

            echo <<<HTML
                <div class="comment">
                    <div class="comment-info">
                        <img src="../../../src/img/$customerCountry.png" alt="Country of Origin">
                        <div class="comment-details">
                            <h4>$commentCreator</h4>
                            <span class="comment-date">$commentDate</span>
                        </div>
                    </div>
                    
                    <p class="comment-text">$commentText</p>   
            HTML;

            // checking if the current user is the author or admin
            // giving them the ability to remove their comments
            if ($userId == userGetCurrentUser() || userIsAdmin(userGetCurrentUser()) ) {
                echo <<<HTML
                        <form action="../action/RemoveComment.php" method="POST" class="removeComment">
                            <input name="productId" type="text" value="$productId" readonly hidden>
                            <input name="userId" type="text" value="$userId" readonly hidden>
                            <input name="timestamp" type="text" value="$commentDate" readonly hidden>

                            <input type="submit" value="Kommentar löschen">
                        </form>

                HTML;

                if (!$comment["isBlocked"]) {
                    echo <<<HTML
                         <form action="../action/EditComment.php" method="POST" class="editComment">
                            <input name="productId" type="text" value="$productId" readonly hidden>
                            <input name="userId" type="text" value="$userId" readonly hidden>
                            <input name="commentCreator" type="text" value="$commentCreator" readonly hidden>
                            <input name="timestamp" type="text" value="$commentDate" readonly hidden>
                            <input name="commentText" type="text" value="$commentText" readonly hidden>
                            <input name="userCountry" type="text" value="$customerCountry" readonly hidden>

                            <input type="submit" value="Bearbeiten">
                        </form>
                    HTML;
                }
            }

            echo "</div>";
        }
    ?>

    <!-- Adding new comments to a product -->
    <div class="comment-form">
        <h3>Kommentar hinzufügen</h3>

        <?php
        echo <<<HTML
            <form action="../action/SubmitComment.php" method="GET">   
                <input type="text" name="commentText">

                <input type="text" name="productId" value="$productId" readonly hidden>

                <input class="submitComment" type="submit" value="Kommentar abschicken">
            </form>
        HTML;
        ?>
        
        
    </div>
</div>


