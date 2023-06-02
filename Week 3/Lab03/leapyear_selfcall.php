<!DOCTYPE html>
<html lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 3" />
    <meta name="keywords" content="Web,programming" />
    <meta name="author" content="Thanh Minh" />
    <title>Extra Challenge: Leap Year</title>
</head>

<body>

    <h1>Lab03 Extra Challenge - Leap Year</h1>
    <hr>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="num">Input:</label>
        <input type="num" name="number" id="num">
        <input type="submit" value="Check for Leap Year">
    </form>
    <?php

    if (isset($_POST["number"]) && is_numeric($_POST["number"])) {
        $num = $_POST["number"];
        echo "<br>";
        if ($num % 4 == 0) {
            if ($num % 100 == 0) {
                if ($num % 400 == 0) {
                    echo "The year you enter " . $num . " is a leap year";
                } else {
                    echo "The year you enter " . $num . " is not leap year";
                }
            } else {
                echo "The year you enter " . $num . " is a leap year";
            }
        }
    } else {
        echo "<br>Please enter a number";
    }

    ?>
</body>

</html>