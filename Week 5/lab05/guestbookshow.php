<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Week 5 - Task 2</title>
</head>

<body>
    <h1>Lab05 Task 2 - Guestbook</h1>
    <hr>
    <?php
    umask(0007);
    $filename = "../../data/lab05/guestbook.txt";
    // $filename = "./data/guestbook.txt";
    if (file_exists($filename)) { // check if file exist
        $handle = fopen($filename, "r+");
        while (!feof($handle)) {
            $line = fgets($handle);
            echo "<p>" . stripslashes($line) . "</p>";
        }
        fclose($handle);
        echo '<a href="guestbookform.php">Back to form</a>';
    } else {
        echo "<p>File does not exit</p>";
        echo '<a href="guestbookform.php">Back to form</a>';
    }
    ?>

</body>

</html>