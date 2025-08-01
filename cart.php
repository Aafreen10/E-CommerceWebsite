<?php
include 'config.php';
session_start();

// Fetch cart items with product details
$query = "SELECT cart.id, cart.product_id, cart.quantity, products.name, products.price, products.image 
          FROM cart 
          INNER JOIN products ON cart.product_id = products.id";
$result = mysqli_query($conn, $query);

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - TradeHive</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cart-container {
            width: 70%;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .cart-table img {
            width: 70px;
            border-radius: 5px;
        }
        .cart-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="cart-container">
    <h2 class="text-center">🛒 Your Shopping Cart</h2>
    <table class="table table-bordered text-center cart-table">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="cart-items">
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                $subtotal = $row['price'] * $row['quantity'];
                $total_price += $subtotal;
            ?>
                <tr id="row-<?php echo $row['id']; ?>">
                    <td><img src="images/<?php echo $row['image']; ?>" alt="Product Image"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>₹<?php echo number_format($row['price'], 2); ?></td>
                    <td>
                        <input type="number" value="<?php echo $row['quantity']; ?>" min="1" 
                            class="form-control quantity" 
                            data-id="<?php echo $row['id']; ?>">
                    </td>
                    <td>₹<span class="subtotal" id="subtotal-<?php echo $row['id']; ?>">
                        <?php echo number_format($subtotal, 2); ?>
                    </span></td>
                    <td>
                        <button class="btn btn-danger remove-btn" data-id="<?php echo $row['id']; ?>">Remove</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="cart-total">
        Total: ₹<span id="total-price"><?php echo number_format($total_price, 2); ?></span>
    </div>

    <div class="text-end mt-3">
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</div>

<script>
document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('change', function() {
        let cartId = this.getAttribute('data-id');
        let newQuantity = this.value;

        fetch('update_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + cartId + '&quantity=' + newQuantity
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('subtotal-' + cartId).innerText = data.new_subtotal;
                document.getElementById('total-price').innerText = data.new_total;
            } else {
                alert("Error updating cart!");
            }
        });
    });
});

document.querySelectorAll('.remove-btn').forEach(button => {
    button.addEventListener('click', function() {
        let cartId = this.getAttribute('data-id');

        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + cartId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('row-' + cartId).remove(); // Remove the row from UI
                document.getElementById('total-price').innerText = data.new_total; // Update total price
            } else {
                alert("Error removing product!");
            }
        });
    });
});
</script>

</body>
</html>
