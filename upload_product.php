<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle Image Upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = "uploads/" . $image;

    if (move_uploaded_file($image_tmp, $image_folder)) {
        // Insert product into the database
        $sql = "INSERT INTO products (name, category, price, image, description) 
                VALUES ('$product_name', '$category', '$price', '$image', '$description')";

        if (mysqli_query($conn, $sql)) {
            $message = "Product uploaded successfully!";
            $msg_color = "green";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $msg_color = "red";
        }
    } else {
        $message = "Failed to upload image.";
        $msg_color = "red";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 10px;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Upload Product</h2>
    
    <?php if (!empty($message)): ?>
        <div class="message" style="background-color: <?= $msg_color; ?>;">
            <?= $message; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="product_name" placeholder="Product Name" required>
        
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Women">Women</option>
            <option value="Men">Men</option>
            <option value="Kids">Kids</option>
        </select>

        <input type="number" name="price" placeholder="Price (INR)" required>
        <input type="file" name="image" accept="image/*" required>
        <textarea name="description" placeholder="Product Description" required></textarea>
        
        <button type="submit" class="btn">Upload Product</button>
    </form>
</div>

</body>
</html>
