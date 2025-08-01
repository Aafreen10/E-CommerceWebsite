<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = '86e528001@smtp-brevo.com';
        $mail->Password = 'NCIzc8shnTB2FvQS';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('bytefusion15@gmail.com', 'TradeHive');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Your OTP Code";
        $mail->Body    = "<p>Your OTP for verification is: <b>$otp</b></p>";

        $mail->send();
        echo "OTP sent successfully!";
    } catch (Exception $e) {
        echo "Error in sending OTP: " . $mail->ErrorInfo;
    }
}
?>