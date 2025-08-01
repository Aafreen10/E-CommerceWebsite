<?php
include 'config.php'; // Ensure you have a database connection file

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'], $_POST['order_status'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Update the order status in the database
    $update_query = "UPDATE orders SET order_status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("si", $order_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully!');</script>";
        echo "<script>window.location.href='update_order_status.php';</script>"; // Refresh page
        exit();
    } else {
        echo "<script>alert('Error updating order status: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Fetch all orders to display
$query = "SELECT id AS order_id, total_price, payment_method, order_status FROM orders ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        select {
            padding: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Order Status</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Order Status</th>
                <th>Update</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo $row['payment_method']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <select name="order_status">
                                <option value="Pending" <?php if ($row['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Processing" <?php if ($row['order_status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                <option value="Shipped" <?php if ($row['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                                <option value="Delivered" <?php if ($row['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
