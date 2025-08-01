<?php
include 'config.php';
session_start();

if (!isset($_GET['order_id'])) {
    echo "Invalid Order ID!";
    exit;
}

$order_id = $_GET['order_id'];

// Fetch order details
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "Order not found!";
    exit;
}

// Define expected delivery date (e.g., +5 days from order date)
$expected_delivery = date('Y-m-d', strtotime($order['order_date'] . ' +5 days'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status - TradeHive</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">📦 Order Tracking</h2>
    
    <div class="card p-4">
        <h4>Order Details</h4>
        <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
        <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Payment Method:</strong> <?php echo $order['payment_method']; ?></p>
        
        <h4>Order Status</h4>
        <p><strong>Status:</strong> <?php echo $order['order_status']; ?> 🚚</p>

        <h4>Expected Delivery</h4>
        <p><strong>Date:</strong> <?php echo $expected_delivery; ?></p>
        
        <a href="index.html" class="btn btn-success">Back to Home</a>
      

    </div>
</div>

</body>
</html>
