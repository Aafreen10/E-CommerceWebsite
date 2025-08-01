<?php
session_start();
include 'config.php'; // Ensure this file has a valid DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM sellers WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['seller_logged_in'] = true;
        $_SESSION['seller_username'] = $username;
        header("Location: seller_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login - TradeHive</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ensure this file exists -->
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        .login-container h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #333;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
        .login-container button:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Seller Login</h2>
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
        <form method="POST" action="seller.php">
            <input type="text" id="username" name="username" placeholder="Enter Username" required>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
