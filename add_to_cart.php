<?php
include 'config.php';
session_start();

$product_id = $_POST['product_id'];

// Validate product ID
if (!isset($product_id) || empty($product_id)) {
    echo json_encode(["success" => false, "message" => "Invalid product!"]);
    exit;
}

// Check if the product is already in the cart
$checkQuery = "SELECT * FROM cart WHERE product_id = '$product_id'";
$checkResult = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($checkResult) > 0) {
    // Increase quantity if the product already exists
    $updateQuery = "UPDATE cart SET quantity = quantity + 1 WHERE product_id = '$product_id'";
    $success = mysqli_query($conn, $updateQuery);
} else {
    // Insert new product into cart
    $insertQuery = "INSERT INTO cart (product_id, quantity) VALUES ('$product_id', 1)";
    $success = mysqli_query($conn, $insertQuery);
}

if ($success) {
    echo json_encode(["Cart updated successfully!"]);
} else {
    echo json_encode(["Error updating cart!"]);
}
?>
