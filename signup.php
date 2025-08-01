<?php  
session_start();
error_reporting(E_ALL); // Enable error reporting for debugging

$servername = "localhost";
$username = "root";
$password = "";
$database = "tradehive_db";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Ensure OTP is verified before signup
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    echo "❌ OTP not verified. Please verify OTP first.";
    exit();
}

// Handle signup request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Secure password hashing

        // Check if email already exists
        $check_email = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check_email->bind_param("s", $email);
        $check_email->execute();
        $result = $check_email->get_result();

        if ($result->num_rows > 0) {
            echo "❌ Email already registered. Try logging in!";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $full_name, $email, $password);
            
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['user_name'] = $full_name;
                
                unset($_SESSION['otp_verified']); // Clear OTP session
                
                echo "✅ Account created successfully!";
            } else {
                echo "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_email->close();
    } else {
        echo "❌ Please fill all the fields!";
    }
}

$conn->close();
?>
