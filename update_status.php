<?php
session_start();
include 'config.php'; // Database connection

// Fetch all orders
$query = "SELECT o.id as order_id, o.total_amount, o.payment_method, o.status, 
                 p.product_name, p.image, oi.quantity 
          FROM orders o 
          JOIN order_items oi ON o.id = oi.order_id 
          JOIN products p ON oi.product_id = p.id 
          ORDER BY o.id DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to CSS -->
</head>
<body>
    <h2>Update Order Status</h2>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Amount</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td>
                    <img src="uploads/<?php echo $row['image']; ?>" width="50" height="50">
                    <?php echo $row['product_name']; ?>
                </td>
                <td><?php echo $row['quantity']; ?></td>
                <td>₹<?php echo $row['total_amount']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td>
                    <form action="update_status.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                        <select name="status">
                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Processing" <?php if ($row['status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                            <option value="Shipped" <?php if ($row['status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="Delivered" <?php if ($row['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>


