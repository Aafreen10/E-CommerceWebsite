
<?php
include 'config.php';

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
} else {
    echo "✅ Database connected successfully!";
}
?>

