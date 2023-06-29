<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Week 5 - Task 1</title>
</head>

<body>
    <h1>Web Programming - Lab 5</h1>
    <hr>
    <?php
    if (isset($_POST["fname"], $_POST["lname"])) {
        $fname = addslashes($_POST["fname"]);
        $lname = addslashes($_POST["lname"]);
        // for create and access to file on mercury
        $dir = "../../data/lab05/";
        // $dir = "./data/lab05/";
        umask(0007);
        if (!is_dir($dir)) {
            mkdir($dir, 02770);
        }
        $filename = "guestbook.txt";
        $handle = fopen($dir . $filename, "a+");
        //check if the file is writable
        if (!is_writable($dir . $filename)) {
            echo "<p>Cannot write to file</p>";
            echo '<a href="guestbookform.php">Go back</a>';
        } else {
            $data = $fname . " " . $lname . "\n";
            if (fwrite($handle, $data) > 0) {
                echo "Thank you for signing the Guest book";
            } else {
                echo "Cannot add your name to the Guest book";
            }
        }
        fclose($handle);
    } else {
        echo "You must enter your first and last name!";
        echo "Use the browser's 'Go back' button to return to the Guestbook form";
    }
    ?>
    <br>
    <a href="guestbookshow.php">Show Guest Book</a>
</body>

</html>