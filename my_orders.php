<?php
session_start();
include 'config.php'; // Ensure your database connection file is included

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your orders.";
    exit;
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Fetch user orders
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - TradeHive</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
</head>
<body>

<div class="container">
    <h2>My Orders</h2>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Total Amount</th>
            <th>Payment Method</th>
            <th>Order Status</th>
            <th>Expected Delivery</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>₹" . number_format($row['total_amount'], 2) . "</td>";
                echo "<td>" . $row['payment_method'] . "</td>";
                echo "<td>" . ucfirst($row['order_status']) . "</td>";
                echo "<td>" . $row['expected_delivery'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No orders found.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
