<?php
$file = "notes.txt";

if (isset($_GET['delete'])) {
    $deleteIndex = $_GET['delete'];
    $lines = file($file);
    unset($lines[$deleteIndex]); 

    $fp = fopen($file, "w"); 
    foreach ($lines as $line) {
        fwrite($fp, $line);
    }
    fclose($fp);

    header("Location: index.php");
    exit;
}

$notes = [];
$fp = fopen($file, "r");
if ($fp) {
    while (($line = fgets($fp)) !== false) {
        $parts = explode("|", trim($line));
        if (count($parts) == 3) {
            $notes[] = $parts;
        }
    }
    fclose($fp);
}

$search = isset($_GET['search']) ? strtolower($_GET['search']) : "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notepad</title>
    <style>
        body { 
            font-family: Arial; 
            background: #f2f2f2; 
            display: flex; 
            justify-content: center; 
            margin-top: 30px; 
        }
        .container { 
            background: #000; 
            padding: 20px; 
            border-radius: 10px; 
            min-width: 380px; 
            min-height:500px;
        }
        .notepad {
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .note { 
            background: #1c1c1c; 
            color: #fafafa;
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 5px; 
            width: 98%;
        }
        .delete { 
            background: red; 
            color: white; 
            padding: 5px 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        .add-note {
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 35px;
            border-radius: 50%;
            background: green;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            position: fixed;
            margin-left: 25%;
        }
        .add-note:hover {
            background: blue;
        }
        .search-bar {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }
        .search-input {
            padding: 5px;
            border-radius: 5px;
            border: none;
            width: 80%;
        }
        .search-button {
            background: #333;
            color: white;
            border: none;
            padding: 6px 10px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .search-button:hover {
            background: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="notepad">
            <h2>All Notes</h2>
            <a href="add.php" class="add-note">+</a>
        </div>

        <form method="get" class="search-bar">
            <input type="text" name="search" placeholder="Search by title..." class="search-input">
            <button type="submit" class="search-button">🔍</button>
        </form>

        <?php 
        $found = false;
        foreach ($notes as $index => $note): 
            if ($search == "" || strpos(strtolower($note[0]), $search) !== false): 
                $found = true;
        ?>
            <div class="note">
                <strong><?= htmlspecialchars($note[0]) ?></strong><br>
                <?= nl2br(htmlspecialchars($note[1])) ?><br>
                <small><?= $note[2] ?></small><br>
                <a href="?delete=<?= $index ?>"><button class="delete">Delete</button></a>
            </div>
        <?php 
            endif;
        endforeach;

        if (!$found): ?>
            <p style="color:white;">No notes found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
