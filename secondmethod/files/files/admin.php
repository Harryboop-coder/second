<?php
session_start();
if (!isset($_SESSION["fullname"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            display: grid;
            place-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }
        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        h2 {
            margin: 5px 0;
        }
        p {
            color: #555;
            margin: 5px 0;
        }
        a {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 15px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="<?= htmlspecialchars($_SESSION['photo']) ?>" alt="">
        <p><?= htmlspecialchars($_SESSION["fullname"]) ?> WELCOME TO FILE ASSIGNMENT HOME PAGE </p>
        <a href="logout.php">Logout</a>
        <a href="delete.php">Delete Account</a>
    </div>
</body>
</html>
