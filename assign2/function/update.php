<?php
function updatefriend($host, $user, $pswd, $dbnm, $table, $table2)
{
    $conn = new mysqli($host, $user, $pswd);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    @$conn->select_db($dbnm);
    // Reset num_of_friends for all users
    $reset_sql = "UPDATE $table SET num_of_friends = 0";
    $conn->query($reset_sql);
    // Count number of friends for each user
    $count_sql = "SELECT friend_id1, COUNT(*) FROM $table2 GROUP BY friend_id1
                  UNION ALL
                  SELECT friend_id2, COUNT(*) FROM $table2 GROUP BY friend_id2";
    $count_result = $conn->query($count_sql);
    while ($row = $count_result->fetch_row()) {
        $friend_id = $row[0];
        $num_of_friends = $row[1];
        // Update num_of_friends for this user
        $update_sql = "UPDATE $table SET num_of_friends = num_of_friends + " . (int)$num_of_friends . " WHERE friend_id = " . (int)$friend_id;
        $conn->query($update_sql);
    }
    $conn->close();
}
