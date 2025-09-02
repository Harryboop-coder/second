<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $found = false;
    $lines = file("users.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    for ($i = 0; $i < count($lines); $i += 5) {
        $savedName = trim($lines[$i]);
        $savedEmail = trim($lines[$i + 1]);
        $savedPhone = trim($lines[$i + 2]);
        $savedImage = trim($lines[$i + 3]);
        $savedPassword = trim($lines[$i + 4]);

        if ($email === $savedEmail && $password === $savedPassword) {
            $found = true;
            $_SESSION['user'] = [
                'name' => $savedName,
                'email' => $savedEmail,
                'phone' => $savedPhone,
                'image' => $savedImage
            ];

            break;
        }
    }

    if ($found) {
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #3498db;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }
        input {
            width: 90%;
            padding: 8px;
            margin: 8px 0;
        }
        .error {
            color: red;
        }
        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px;
            width: 95%;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>";?>
        <form method="post">
            <input type="email" name="email" placeholder="Enter your email" required><br>
            <input type="password" name="password" placeholder="Enter your password" required><br>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            <p><a href="forgot.php">Forgot Password</a></p>
        </form>
        
    </div>
</body>
</html>