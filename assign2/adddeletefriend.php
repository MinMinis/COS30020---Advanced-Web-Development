<?php
session_start();
if ($_SESSION['status'] !== "logged") {
    header("Location: login.php");
}
if (isset($_POST['addfriend']) || isset($_POST['unfriend'])) {
    $email = $_SESSION['email'];
    require("settings.php");
    $conn = new mysqli($host, $user, $pswd);
    @$conn->select_db($dbnm);
    // Get the record of the current user from table friends
    $sql = "SELECT friend_id FROM $table WHERE friend_email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_row(); // get the first row of the returned result
    $id = $row[0]; // get the current user id
    $friend_id = $_POST['friend_id']; // Get the ID of the friend to add
    if (isset($_POST['addfriend'])) { // check if the add friend button is press
        // Add the friendship to the database
        $insert_sql = "INSERT INTO $table2 (friend_id1, friend_id2) VALUES ($id, $friend_id)";
        $conn->query($insert_sql);
        // Update the number of friends for both users
        $update_sql = "UPDATE $table SET num_of_friends = num_of_friends + 1 WHERE friend_id = $id OR friend_id = $friend_id";
        $conn->query($update_sql);
        $conn->close();
        $_SESSION['message'] = "<p class=\"success\">You have added friend successfully</p>";
        header("Location: " . $_SERVER['HTTP_REFERER']); // back to the previous page
    } else {
        $delete_sql = "DELETE FROM $table2 WHERE (friend_id1 = $id AND friend_id2 = $friend_id) OR (friend_id1 = $friend_id AND friend_id2 = $id)"; // Delete the friendship from the database
        $conn->query($delete_sql);
        $update_sql = "UPDATE $table SET num_of_friends = num_of_friends - 1 WHERE friend_id = $id OR friend_id = $friend_id";        // Update the number of friends for both users
        $conn->query($update_sql);
        $conn->close();
        $_SESSION['message'] = "<p class=\"success\">You have unfriended successfully</p>";
        header("Location: friendlist.php"); // Redirect back to the friend list page
    }
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']); // back to the previous page
}
