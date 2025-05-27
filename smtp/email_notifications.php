<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mehtapooja38170@gmail.com';  // Replace with your Gmail
        $mail->Password   = '12345';     // Use App Password, not Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('mehtapooja3817@gmail.com', 'Library Admin');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}

// Example use case (you can delete this in production)
if (isset($_GET['test'])) {
    $to = 'poojamehta0603@gmail.com';
    $subject = 'New Book Arrived';
    $body = 'Hello! A new book has been added to the library. Login to check it out.';
    
    if (sendEmail($to, $subject, $body)) {
        echo "Email sent successfully!";
    } else {
        echo "Email sending failed.";
    }
}
?>
