<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeHive - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        }
        .login-container {
            width: 350px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background: #ff758c;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-btn:hover {
            background: #ff5478;
        }
        .error-msg {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to TradeHive</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
        <?php
        session_start();
        $conn = mysqli_connect("localhost", "root", "", "tradehive_db");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $query = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['full_name'] = $row['full_name'];
                    echo "<script>alert('Login Successful!'); window.location='index.html';</script>";
                } else {
                    echo "<p class='error-msg'>Incorrect Password!</p>";
                }
            } else {
                echo "<p class='error-msg'>User not found!</p>";
            }
        }
        ?>
    </div>
</body>
</html>
