<?php
include 'config.php'; // Include your database connection

if (isset($_POST['check_orders'])) {
    $email = $_POST['email'];

    // Fetch orders where the email matches
    $query = "SELECT * FROM orders WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status - TradeHive</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; }
        th { background: #333; color: white; }
    </style>
</head>
<body>

    <h2>Check Your Order Status</h2>

    <!-- Simple Email Input Form -->
    <form method="post">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit" name="check_orders">Check Orders</button>
    </form>

    <?php if (isset($result)) { ?>
        <h3>Your Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Order Status</th>
            </tr>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>₹{$row['total_price']}</td>
                        <td>{$row['payment_method']}</td>
                        <td>{$row['order_status']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No orders found for this email.</td></tr>";
            }
            ?>
        </table>
    <?php } ?>

</body>
</html>
