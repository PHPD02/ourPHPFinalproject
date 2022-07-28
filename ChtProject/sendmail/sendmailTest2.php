<?php
$to      = 'drama3fu@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: 順便外送平台' . "\r\n" .
    'Reply-To: 順便外送平台' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>