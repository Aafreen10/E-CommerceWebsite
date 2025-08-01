<?php
include 'config.php';
session_start();

// Fetch product details from the URL if redirected from "Buy Now"
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
$product_price = isset($_GET['product_price']) ? $_GET['product_price'] : 0;

// Fetch cart items if user didn't come from "Buy Now"
$cart_query = "SELECT cart.*, products.name, products.price, products.image 
               FROM cart 
               INNER JOIN products ON cart.product_id = products.id";
$cart_result = mysqli_query($conn, $cart_query);

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TradeHive</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">🛍️ Checkout</h2>
    
    <form action="place_order.php" method="POST" onsubmit="return validatePayment()">
        <div class="mb-3">
            <label class="form-label">Full Name:</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address:</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number:</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <h4>Order Summary</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (!empty($product_name)) { 
                    // Single product purchase (Buy Now)
                    $total_price = $product_price;
                ?>
                <tr>
                    <td><?php echo $product_name; ?></td>
                    <td>₹<?php echo number_format($product_price, 2); ?></td>
                    <td>1</td>
                    <td>₹<?php echo number_format($product_price, 2); ?></td>
                </tr>
                <?php } else { 
                    // Cart Checkout (Multiple Items)
                    while ($row = mysqli_fetch_assoc($cart_result)) { 
                        $subtotal = $row['price'] * $row['quantity'];
                        $total_price += $subtotal;
                ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>₹<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>

        <h4>Total Price: ₹<?php echo number_format($total_price, 2); ?></h4>
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

        <h4>Select Payment Method:</h4>
        <div class="mb-3">
            <input type="radio" name="payment_method" value="Cash on Delivery"> Cash on Delivery<br>
            <input type="radio" name="payment_method" value="Online Payment"> Online Payment
        </div>

        <button type="submit" class="btn btn-success">Place Order</button>
        <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
    </form>
</div>

<script>
    function validatePayment() {
        let paymentSelected = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentSelected) {
            alert("Please select a payment method");
            return false;
        }
        return true;
    }
</script>
</body>
</html>
