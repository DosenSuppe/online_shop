<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST") return;

    $email = $_POST["email"];

    $subject = "Email Subject";

    $message = 'Dear '.$_POST['name'].',<br>';
    $message .= "We welcome you to be part of family<br><br>";
    $message .= "Regards,<br>";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <enquiry@example.com>' . "\r\n";
    $headers .= 'Cc: myboss@example.com' . "\r\n";

    mail($email,$subject,$message,$headers);
?>