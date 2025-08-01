

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeHive - Products</title>
    <link rel="stylesheet" href="products.css">  <!-- Linking products.css -->
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="logo">
            <img src="images/logo2.png" alt="TradeHive Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="products.php" class="active">Products</a></li>
                <li><a href="cart.html">Cart</a></li>
                <li><a href="wishlist.html">Wishlist</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="seller.html">Seller</a></li>
                <li><a href="logout.php">Logout</a></li> <!-- Logout option -->
            </ul>
        </nav>
    </header>

    <!-- Product Categories Section -->
    <section class="categories">
        <h1>Shop by Category</h1>
        <div class="category-container">
            <div class="category" onclick="navigateTo('women.php')"><img src="images/women2.jpg" alt="Women"><p>Women</p></div>
            <div class="category" onclick="navigateTo('men.php')"><img src="images/men3.jpg" alt="Men"><p>Men</p></div>
            <div class="category" onclick="navigateTo('kids.php')"><img src="images/kids.jfif" alt="Kids"><p>Kids</p></div>
            <div class="category" onclick="navigateTo('accessories.php')"><img src="images/accessories.jfif" alt="Accessories"><p>Accessories</p></div>
            <div class="category" onclick="navigateTo('bags.php')"><img src="images/bags.jfif" alt="Bags"><p>Bags</p></div>
            <div class="category" onclick="navigateTo('electronics.php')"><img src="images/electronic.avif" alt="Electronics"><p>Electronics</p></div>
            <div class="category" onclick="navigateTo('shoes.php')"><img src="images/shoe.jfif" alt="Shoes"><p>Shoes</p></div>
            <div class="category" onclick="navigateTo('beauty.php')"><img src="images/beauty.jfif" alt="Beauty"><p>Beauty</p></div>
            <div class="category" onclick="navigateTo('home.php')"><img src="images/home.jfif" alt="Home & Living"><p>Home & Living</p></div>
            <div class="category" onclick="navigateTo('sports.php')"><img src="images/sports.jfif" alt="Sports"><p>Sports</p></div>
            <div class="category" onclick="navigateTo('watches.php')"><img src="images/watches.jfif" alt="Watches"><p>Watches</p></div>
            <div class="category" onclick="navigateTo('jewelry.php')"><img src="images/jewellery.jfif" alt="Jewelry"><p>Jewelry</p></div>
            <div class="category" onclick="navigateTo('furniture.php')"><img src="images/furniture.jfif" alt="Furniture"><p>Furniture</p></div>
            <div class="category" onclick="navigateTo('toys.php')"><img src="images/toys.jfif" alt="Toys"><p>Toys</p></div>
            <div class="category" onclick="navigateTo('stationery.php')"><img src="images/stationary.jfif" alt="Stationery"><p>Stationery</p></div>
        </div>
    </section>

    <footer>
        <p>© 2025 TradeHive. All Rights Reserved.</p>
    </footer>

    <script>
        function navigateTo(page) {
            window.location.href = page;
        }
    </script>

</body>
</html>
