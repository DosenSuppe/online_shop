
<div class="comment-container">
    <h2>Käufer Kommentare</h2>


    <?php
        $query = "
            SELECT
                c.creationDate commentDate,
                c.text commentText,

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
                </div>
            HTML;

        }
    ?>

    <!-- Add more comments as needed -->

    <div class="comment-form">
        <h3>Kommentar hinzufügen</h3>
        
        <form action="comment_submission.php" method="post">
            <!-- Include input fields for user and comment -->
            <button type="submit">Kommentar abschicken</button>
        </form>
    </div>
</div>


