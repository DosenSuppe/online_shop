<?php

$verbindung = mysqli_connect("127.0.0.1", "root", "", "dbp");

$unblockUser = mysqli_real_escape_string($verbindung, $_POST['unblockUser']);

$sql2 = "DELETE FROM Test WHERE Blocked_User = '$unblockUser'";

if (mysqli_query($verbindung, $sql2)) {

} else {
    echo mysqli_error($verbindung);
}

$unblockUser = NULL;
include("AdminB.html");

?>
