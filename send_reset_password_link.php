<?php
session_start(); // Start session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require_once __DIR__ . '/src/Exception.php';
require_once __DIR__ . '/src/PHPMailer.php';
require_once __DIR__ . '/src/SMTP.php';

function sendResetPasswordLink($email, $reset_token) {
    $reset_link = "http://localhostfinalapp/reset_password.php?token=$reset_token";
    $mail = new PHPMailer(true); // Passing true enables exceptions

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ict2020024@as.rjt.ac.lk'; // Your Gmail address
        $mail->Password = 'pgmm xvbk rdce kuep'; // Your Gmail App Password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        //Recipients
        $mail->setFrom('ict2020024@as.rjt.ac.lk', 'Admin');
        $mail->addAddress($email); // Add a recipient

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Link';
        $mail->Body    = "Click this link to reset password: <a href=\"" . $reset_link . "\">Reset Now</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log or echo the error message
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
