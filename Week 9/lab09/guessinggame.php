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
echo $random_num;
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
    <p>Enter a number between 1 and 100 then press the Guess button</p>
    <form action="guessinggame.php" method="post">
        <input type="text" name="guess" />
        <input type="submit" value="Guess" />
    </form>
    <?php
    echo "<br>";
    if (isset($_POST['guess'])) {
        if ($_POST['guess'] < 1 or $_POST['guess'] > 100) {
            echo "Please enter a number between 1 and 100";
        } elseif (!is_numeric($_POST['guess'])) {
            echo "Please enter a number";
        } else {
            if ($_POST['guess'] == $random_num) {
                echo "Congratulations! You guessed the hidden number with $guest_time guess";
            } elseif ($_POST['guess'] != $random_num) {
                echo "Incorrect! You guess the wrong number";
            }
        }
    } else {
        echo "Please guess the number";
    }
    echo "<br>";
    echo "<br>";
    echo "Number of guesses {$guest_time}";
    $guest_time++;
    $_SESSION['guest_time'] = $guest_time;
    ?>
    <p><a href="giveup.php">Give Up</a></p>
    <p><a href="startover.php">Start Over</a></p>



</body>

</html>