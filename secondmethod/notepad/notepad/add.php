<?php
$file = "notes.txt";

if (isset($_POST['save'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $date = date("Y-m-d H:i:s");

    if ($title != "" && $content != "") {
        $note = $title . "|" . $content . "|" . $date . "\n";

        $fp = fopen($file, "a"); 
        fwrite($fp, $note);
        fclose($fp);

        header("Location: index.php"); 
        exit;
    } else {
        $error = "Please add a title and content";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Note</title>
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
        }
        .notepad {
            color: #fff;
        }
        input, textarea { 
            background: #1c1c1c; 
            color: #fafafa;
            width: 98%; 
            margin: 5px 0; 
            padding: 10px; 
            border-radius: 5px;
        }
        textarea { 
            min-height: 100px;
        }
        button { 
            padding: 10px; 
            margin: 5px 0; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer;
        }
        .save { 
            background: #a09d9d5e; 
            color: white; 
        }
        .clear { 
            background: #a09d9d5e; 
            color: white; 
        }
        .save:hover { 
            background: green; 
            color: white; 
        }
        .clear:hover { 
            background: red; 
            color: white; 
        }
        .back { 
            background: blue;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }
        .back:hover { 
            background: red; 
            color: white; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="notepad"><h2>Add Note</h2></div>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <p><input type="text" name="title" placeholder="Enter note title..."></p>
            <textarea name="content" placeholder="Write your notes here..." required></textarea>
            <button type="submit" name="save" class="save">Save</button>
            <button type="reset" class="clear">Clear</button>
        </form>
        <br>
        <a href="index.php" class="back">⬅ Back to Notes</a>
    </div>
</body>
</html>
