<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'vermavaibhav268@gmail.com';
    $mail->Password   = 'vpdh aolk hnpr wgov';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email content
    $mail->setFrom('vermavaibhav268@gmail.com', 'Edu-spehere');
    $mail->addAddress('vaibhavverma2115@gmail.com', 'Recipient');

    $mail->isHTML(true);
    $mail->Subject = 'Subscription Confirmation';
    $mail->Body    = 'Thank you for subscribing to our newsletter! We are excited to have you on board.';
    $mail->AltBody = 'Thank you for subscribing to our newsletter! We are excited to have you on board.';

    $mail->send();
    echo '✅ Email has been sent successfully.';
} catch (Exception $e) {
    echo "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
