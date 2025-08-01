<?php
$servername = "localhost"; // XAMPP runs on localhost
$username = "root";  // Default username for MySQL in XAMPP
$password = "";  // No password in XAMPP by default
$database = "tradehive_db";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>