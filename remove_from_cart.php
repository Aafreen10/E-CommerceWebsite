<?php
include 'config.php';
session_start();

$cart_id = $_POST['product_id']; // Assuming this is the cart item's ID

// Check if cart ID is valid
if (!isset($cart_id) || empty($cart_id)) {
    echo json_encode(["success" => false, "message" => "Invalid product!"]);
    exit;
}

// Remove product from cart
$deleteQuery = "DELETE FROM cart WHERE id = '$cart_id'";
if (mysqli_query($conn, $deleteQuery)) {
    // Get the updated total price after removing the item
    $totalQuery = "SELECT SUM(products.price * cart.quantity) AS total_price 
                   FROM cart 
                   INNER JOIN products ON cart.product_id = products.id";
    $totalResult = mysqli_query($conn, $totalQuery);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $new_total = number_format($totalRow['total_price'], 2);

    echo json_encode(["success" => true, "new_total" => $new_total]);
} else {
    echo json_encode(["success" => false, "message" => "Error removing product!"]);
}
?>
s