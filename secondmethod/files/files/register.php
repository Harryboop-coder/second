<?php
session_start();
$filename = "users.txt";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $photo = $_FILES["photo"];

    if (empty($fullname) || empty($email) || empty($phone) || empty($password) || empty($photo["name"])) {
        $error = "Please fill in all fields and select a profile photo!";
    } else {
        if (file_exists($filename)) {
            $file = fopen($filename, "r");
            while (!feof($file)) {
                $line1 = trim(fgets($file)); 
                $line2 = trim(fgets($file)); 
                $line3 = trim(fgets($file)); 
                $line4 = trim(fgets($file)); 
                $line5 = trim(fgets($file));

                if ($email === $line2) {
                    $error = "This email is already registered!";
                    break;
                }
                if ($phone === $line3) {
                    $error = "This phone number is already registered!";
                    break;
                }
            }
            fclose($file);
        }

        if (empty($error)) {
            
            $photoFolder = "uploads/";
            if (!is_dir($photoFolder)) {
                mkdir($photoFolder);
            }
            $photoName = time() . "_" . basename($photo["name"]);
            $photoPath = $photoFolder . $photoName;
            move_uploaded_file($photo["tmp_name"], $photoPath);


            $file = fopen($filename, "a");
            fwrite($file, $fullname . "\n");
            fwrite($file, $email . "\n");
            fwrite($file, $phone . "\n");
            fwrite($file, $photoPath . "\n");
            fwrite($file, $password . "\n");
            fclose($file);

            $_SESSION["fullname"] = $fullname;
            $_SESSION["photo"] = $photoPath;

            header("Location: admin.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: grid;
            place-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        input {
            display: block;
            margin-bottom: 15px;
            width: 270px;
            padding: 10px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <input type="text" name="fullname" placeholder="Full Name">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="phone" placeholder="Phone Number">
        <input type="file" name="photo" accept="image/*">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Register">
        <a href="login.php">Already have an account? Login</a>
    </form>
</body>
</html>
