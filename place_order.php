<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to place an order.'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user email from the users table
$user_query = "SELECT email FROM users WHERE user_id = ?";
$user_stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($user_stmt, "i", $user_id);
mysqli_stmt_execute($user_stmt);
$result = mysqli_stmt_get_result($user_stmt);
$user_data = mysqli_fetch_assoc($result);
$email = $user_data['email'] ?? '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $total_price = isset($_POST['total_price']) ? $_POST['total_price'] : 0;
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    if (empty($payment_method)) {
        echo "<script>alert('Please select a payment method'); window.history.back();</script>";
        exit;
    }

    // Insert order with user_id and email
    $query = "INSERT INTO orders (user_id, email, full_name, address, phone, total_price, payment_method, order_status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issssds", $user_id, $email, $full_name, $address, $phone, $total_price, $payment_method);
    $execute = mysqli_stmt_execute($stmt);

    if ($execute) {
        $order_id = mysqli_insert_id($conn);

        if ($order_id) {
            // Fetch cart items and insert into order_items table
            $cart_items = mysqli_query($conn, "SELECT cart.product_id, cart.quantity, products.price 
                                               FROM cart 
                                               INNER JOIN products ON cart.product_id = products.id");

            $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $order_stmt = mysqli_prepare($conn, $order_item_query);

            while ($item = mysqli_fetch_assoc($cart_items)) {
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                mysqli_stmt_bind_param($order_stmt, "iiid", $order_id, $product_id, $quantity, $price);
                mysqli_stmt_execute($order_stmt);
            }

            // Clear cart after order is placed
            mysqli_query($conn, "DELETE FROM cart");
        }
    } else {
        echo "Error placing order: " . mysqli_error($conn);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .order-container {
            text-align: center;
        }

        .order-card {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2), -6px -6px 12px rgba(255, 255, 255, 0.7);
            display: inline-block;
            max-width: 500px;
            transition: transform 0.3s ease-in-out;
        }

        .order-card:hover {
            transform: scale(1.03);
        }

        h1 {
            color: #28a745;
            font-size: 28px;
        }

        p {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }

        .track-btn {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            color: white;
            background: #007bff;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .track-btn:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="order-container">
        <div class="order-card">
            <h1>🎉 Thank You, <?php echo htmlspecialchars($full_name); ?>! 🎉</h1>
            <p>Your order has been placed successfully.</p>
            <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
            <p><strong>Total Amount:</strong> ₹<?php echo $total_price; ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
            
            <!-- Updated Track Order Button -->
            <a href="order_status.php?order_id=<?php echo $order_id; ?>" class="track-btn">Track Your Order</a>
        </div>
    </div>
</body>
</html>
