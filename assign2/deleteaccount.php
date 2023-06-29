<?php
session_start();
if ($_SESSION['status'] !== "logged") {
    header("Location: login.php");
    exit();
}
require("settings.php");
$conn = new mysqli($host, $user, $pswd);
@$conn->select_db($dbnm);
$email = $_SESSION['email'];
// Delete the account from the table
$find_id_sql = "SELECT friend_id FROM $table WHERE friend_email = '$email'";
$result_id = $conn->query($find_id_sql);
$row = $result_id->fetch_row();
$id = $row[0];
$sql = "DELETE FROM $table WHERE friend_id = '$id'";
$conn->query($sql);
$sql = "DELETE FROM $table2 WHERE friend_id1 = '$id' OR friend_id2 = '$id'";
$conn->query($sql);
// Destroy the session and redirect to the index page
session_unset();
session_destroy();
header("Location: index.php");
exit();
