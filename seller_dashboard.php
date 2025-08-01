<?php
session_start();
if (!isset($_SESSION['seller_logged_in'])) {
    header("Location: seller.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - TradeHive</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
        }
        .dashboard {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .dashboard h2 {
            margin-bottom: 20px;
        }
        .dashboard a {
            display: block;
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .dashboard a:hover {
            background: #218838;
        }
        .logout {
            background: #dc3545 !important;
        }
        .logout:hover {
            background: #c82333 !important;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['seller_username']); ?>!</h2>
        <a href="upload_product.php">Upload Products</a>
        <a href="update_order_status.php">Update Order Status</a> <!-- Navigates correctly -->
        <a href="sales_analysis.php">Sales Analysis</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>
