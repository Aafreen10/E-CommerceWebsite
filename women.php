<?php
include 'config.php'; // Database connection

$category = 'Women'; // Set the category for this page
$query = "SELECT * FROM products WHERE category = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Women's Clothing - TradeHive</title>
    <link rel="stylesheet" href="women.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo2.png" alt="TradeHive Logo">
            <span class="site-name">TradeHive</span>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>  
                <li><a href="wishlist.html">Wishlist</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="seller.html">Seller</a></li>
            </ul>
        </nav>
    </header>

    <section class="women-section">
        <h1>Women's Clothing Collection</h1>
        <div class="offer-banner">🔥 Flat 50% OFF on Selected Items! Limited Time Offer! 🔥</div>
        <div class="product-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product">
                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <p><?php echo $row['name']; ?></p>
                    <p>₹<?php echo $row['price']; ?></p>
                    <button class="cart-btn" onclick="addToCart(<?php echo $row['id']; ?>)">Add to Cart</button>
                    <a href="checkout.php?product_name=<?php echo urlencode($row['name']); ?>&product_price=<?php echo $row['price']; ?>" 
                       class="buy-btn">
                       Buy Now
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <script>
        function addToCart(productId) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + productId
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show success message
                window.location.href = 'cart.php'; // Redirect to cart page
            });
        }
    </script>
</body>
</html>
