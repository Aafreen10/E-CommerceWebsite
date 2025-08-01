<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_otp = $_POST['otp'];

    if ($user_otp == $_SESSION['otp']) {
        echo "✅ OTP Verified! You can now sign up.";
        $_SESSION['otp_verified'] = true;
    } else {
        echo "❌ Invalid OTP. Please try again.";
    }
}
?>