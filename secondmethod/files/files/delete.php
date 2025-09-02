<?php
session_start();
$error = "";
$success = "";
$filename = "users.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Please fill in both fields.";
    } elseif (!file_exists($filename)) {
        $error = "User data file not found.";
    } else {
        $lines = [];
        $file = fopen($filename, "r");
        while (!feof($file)) {
            $fullname = trim(fgets($file));
            $userEmail = trim(fgets($file));
            $phone = trim(fgets($file));
            $gender = trim(fgets($file));
            $userPassword = trim(fgets($file));

            if ($email === $userEmail && $password === $userPassword) {
                $success = "Account deleted successfully!";
                continue;
            }

            if ($fullname !== "") {
                $lines[] = $fullname;
                $lines[] = $userEmail;
                $lines[] = $phone;
                $lines[] = $gender;
                $lines[] = $userPassword;
            }
        }
        fclose($file);

        if (empty($success)) {
            $error = "No matching user found.";
        } else {
            $file = fopen($filename, "w");
            foreach ($lines as $line) {
                fwrite($file, $line . PHP_EOL);
            }
            fclose($file);
            header("Location: register.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
            display: grid;
            place-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px gray;
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h3>Delete Account</h3>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Enter your email">
        <input type="password" name="password" placeholder="Enter your password">
        <button type="submit">Delete My Account</button>
        <a href="home.php">Go Back Home</a>
    </form>
</body>
</html>
