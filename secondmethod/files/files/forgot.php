<?php
session_start();

$step = 1;
$error = "";
$success = "";
$filename = "users.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["search"])) {
        $search = trim($_POST["email_or_phone"]);
        $file = fopen($filename, "r");
        $lines = [];
        $index = 0;
        $found = false;
        $passwordLine = -1;

        while (!feof($file)) {
            $line = fgets($file);
            $lines[] = trim($line);

            if ($index % 5 === 1 && trim($line) === $search) {
                $found = true;
                $passwordLine = $index + 3;
                break;
            } elseif ($index % 5 === 2 && trim($line) === $search) {
                $found = true;
                $passwordLine = $index + 2; 
                break;
            }
            $index++;
        }

        fclose($file);

        if ($found) {
            $_SESSION["lines"] = $lines;
            $_SESSION["password_line"] = $passwordLine;
            $step = 2;
        } else {
            $error = "User not found!";
        }
    }
    if (isset($_POST["update"])) {
        $newPassword = trim($_POST["new_password"]);
        $confirmPassword = trim($_POST["confirm_password"]);

        if ($newPassword !== $confirmPassword) {
            $error = "Passwords do not match!";
            $step = 2;
        } else {
            $lines = $_SESSION["lines"];
            $passwordLine = $_SESSION["password_line"];
            $lines[$passwordLine] = $newPassword;

            $file = fopen($filename, "w");
            foreach ($lines as $line) {
                fwrite($file, $line . "\n");
            }
            fclose($file);

            session_destroy();
            $success = "Password updated successfully!";
            $step = 3;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: sans-serif;
            background: #fdfdfd;
            display: grid;
            place-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }
        .msg {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .error { color: red; }
        .success { color: green; }
        a {
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<form method="post">
    <h2>Reset Password</h2>

    <?php if ($error): ?>
        <div class="msg error"><?= $error ?></div>
    <?php elseif ($success): ?>
        <div class="msg success"><?= $success ?></div>
        <a href="login.php">Back to login</a>
    <?php endif; ?>

    <?php if ($step === 1): ?>
        <input type="text" name="email_or_phone" placeholder="Enter Email or Phone" required>
        <input type="submit" name="search" value="Find Account">
        <a href="login.php">Back to login</a>
    <?php elseif ($step === 2): ?>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="submit" name="update" value="Update Password">
    <?php endif; ?>
</form>

</body>
</html>
