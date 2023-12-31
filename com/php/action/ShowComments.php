
<div class="comment-container">
    <h2>Käufer Kommentare</h2>

    <?php
        include_once("../../../library/php/userControl.php");


        $query = "
            SELECT
                c.creationDate commentDate,
                c.text commentText,
                c.customerId customerId,

                u.name customerName,
                u.surname customerSurname,
                u.countryOrigin customerCountry

            FROM
                customers u,
                productcomments c

            WHERE
                c.customerId = u.customerId     AND
                c.productId = '$productId';
        ";

        $comments = sqlLoadData($query);
        
        while ($comment = $comments->fetch_assoc()) {

            $commentCreator = $comment["customerName"]." ".$comment["customerSurname"];
            $commentText = $comment["commentText"];
            $commentDate = $comment["commentDate"];

            $customerId = $comment["customerId"];
            $customerCountry = $comment["customerCountry"];

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

            // checking if the current user is the author
            // giving them the ability to remove their comments
            if ($customerId == userGetCurrentUser() || userIsAdmin($customerId) ) {
                echo <<<HTML
                    <form action="../action/RemoveComment.php" method="POST" class="removeComment">
                            <input name="productId" type="text" value="$productId" readonly hidden>
                            <input name="customerId" type="text" value="$customerId" readonly hidden>
                            <input name="timestamp" type="text" value="$commentDate" readonly hidden>

                            <input type="submit" value="Kommentar löschen">
                        </form>
                    </div>
                HTML;

            } else // non-authors cannot remove the comment
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

                <input type="submit" value="Kommentar abschicken">
            </form>
        HTML;
        ?>
        
        
    </div>
</div>


