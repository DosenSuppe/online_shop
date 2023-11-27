<?php

$verbindung = mysqli_connect("127.0.0.1", "root", "", "dbp");

$blockUser = $_POST['blockUser'];

$sql1 = "INSERT INTO Test (Blocked_User)
         VALUES ('$blockUser')";

if (mysqli_query($verbindung, $sql1)) {

} else {
    echo  mysqli_error($verbindung);
}

$blockUser = NULL;
include("AdminB.html");

?>