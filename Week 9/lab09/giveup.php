<?php
session_start(); // start the session
if (!isset($_SESSION['guest_time'])) {
    $_SESSION['guest_time'] = 0;
}
$guest_time = $_SESSION['guest_time'];
if (!isset($_SESSION['random'])) {
    $_SESSION['random'] = rand(1, 100);
}
$random_num = $_SESSION['random'];
// echo $random_num;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab 9 Task 2</title>
</head>

<body>
    <h1>Web Programming - Lab09</h1>
    <h2>Guessing Game</h2>
    <?php
    echo "The hidden number was: <strong>$random_num</strong>";
    echo "<br>";
    echo "Number of guesses {$guest_time}";

    ?>
    <p><a href="startover.php">Start Over</a></p>



</body>

</html>