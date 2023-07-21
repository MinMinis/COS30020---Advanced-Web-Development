<?php session_start();
unset($_SESSION['random']);
unset($_SESSION['guess_time']);
session_destroy();
header("location:guessinggame.php");
