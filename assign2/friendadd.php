<?php
session_set_cookie_params(1800);
session_start();
if ($_SESSION['status'] !== "logged") {
    header("Location: login.php");
}
$email = $_SESSION['email'];                                 //assign session email to variable
$name = $_SESSION['name'];                                   //assign session name to variable
require("settings.php");                                     // get the details from the settings.php
$conn = new mysqli($host, $user, $pswd);                     // connect to the mysql
@$conn->select_db($dbnm);                                    //select the database
$sql = "SELECT friend_id, num_of_friends FROM $table WHERE friend_email = '$email'"; //sql query for get info of current user
$result = $conn->query($sql);                                //send the query
$row = $result->fetch_row();                                 //get the first row 
$id = $row[0];
$num_of_friend = $row[1];                                    //get the numbers of friends of the current user
$conn->close();                                              // close the connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Thanh Minh" />
    <meta name="description" content="Web Developer" />
    <meta name="keywords" content="HTML, CSS, PHP" />
    <link rel="stylesheet" href="style.css" />
    <script async data-id="five-server" src="http://localhost:5500/fiveserver.js"></script>
    <title>Add Friend Page</title>
</head>

<body>
    <main class="friendadd-main">
        <header>
            <h1>My Friend System</h1>
            <h2 class="friendhead"><?php echo $name ?>'s Add Friend Page</h2>
            <h2 class="friendhead">Total number of friends is <?php echo $num_of_friend ?></h2>
        </header>

        <div class="table">
            <?php
            if (isset($_SESSION['message'])) {
                if (!empty($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                $_SESSION['message'] = "";
            }
            ?>
            <section class="table_body">
                <?php
                $conn = new mysqli($host, $user, $pswd);                        //connect to the mysql
                @$conn->select_db($dbnm);                                       //select the database
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page number from the URL, default to 1 if not set
                $limit = 5; // Set the number of names to display per page
                $offset = ($page - 1) * $limit; // get the range of the query rows 
                $find_friend = "SELECT friend_id, profile_name FROM $table WHERE friend_id NOT IN 
                            (SELECT friend_id1 FROM $table2 WHERE friend_id2 = $id UNION SELECT friend_id2 FROM $table2 WHERE friend_id1 = $id) 
                            AND friend_id != $id LIMIT $limit OFFSET $offset";
                $search_result = $conn->query($find_friend);                    //send the query to mysql
                $result_table = "<table>";                                      //store the html table for printing out
                $result_table .= "<thead><tr><th>Name</th><th>Mutual friends</th></tr></thead>";
                $result_table .= "<tbody>";
                if ($search_result->num_rows > 0) {
                    $row = $search_result->fetch_row();                         // get the first row
                    // get the friends of current user friend
                    $union_select = "SELECT friend_id1 FROM $table2 WHERE friend_id2 = $id
                                            UNION
                                            SELECT friend_id2 FROM $table2 WHERE friend_id1 = $id";
                    while ($row) {                                              // loop through all the row
                        $result_table .= "<tr>";
                        $result_table .= "<td>{$row[1]}</td>";                  // get the not added friend
                        $mutual_friends_query = "SELECT friend_id, COUNT(*) AS mutual_friends_count
                                    FROM $table AS user_friends
                                    JOIN $table2 AS friend_links
                                        ON (user_friends.friend_id = friend_links.friend_id1 AND friend_links.friend_id2 = {$row[0]})
                                        OR (user_friends.friend_id = friend_links.friend_id2 AND friend_links.friend_id1 = {$row[0]})
                                    WHERE user_friends.friend_id != $id
                                        AND user_friends.friend_id IN ($union_select)";
                        $search_result_mutual_friends = $conn->query($mutual_friends_query);
                        $row_mutual_friends = $search_result_mutual_friends->fetch_assoc();
                        $mutual_friend_count = $row_mutual_friends['mutual_friends_count'];
                        $result_table .= "<td>";
                        $result_table .= "Mutual friends: " . $mutual_friend_count; // print out the mutual friend count from the query
                        $result_table .= "</td>";
                        $result_table .= "<td>";
                        $result_table .= "<form action=\"adddeletefriend.php\" method=\"post\">";
                        $result_table .= "<input type=\"hidden\" name=\"friend_id\" value=\"" . $row[0] . "\"/>"; // store the not added friend's ID
                        $result_table .= "<input type=\"submit\" class=\"add-button\" name=\"addfriend\" value=\"Add friend\"/></form>"; // button to add friend using the not added friend's ID
                        $result_table .= "</td>";
                        $result_table .= "</tr>";
                        $row = $search_result->fetch_row(); // get the next row
                    }
                } else {
                    $result_table .= "<tr>";
                    $result_table .= "<td>No friends left to add</td>";
                    $result_table .= "</tr>";
                }
                $result_table .= "</tbody>";
                $result_table .= "</table>";
                echo $result_table;
                // reassign $find_friend query
                $find_friend = "SELECT friend_id FROM $table WHERE friend_id NOT IN 
                                ($union_select) 
                                AND friend_id != $id";
                $search_result = $conn->query($find_friend);
                $total_records = $search_result->num_rows; //get the total of result
                $total_pages = ceil($total_records / $limit); //round up from the result to get the total pages
                $conn->close();
                ?>
            </section>
            <div class="next-prev-div">
                <?php
                $button = "";
                if ($page > 1) { // check if the current page is the first page 
                    $button .= "<p><a class=\"prev-button\" href=\"?page=" . ($page - 1) . "\">Previous</a></p>";
                }
                if ($page < $total_pages) { //check if the current page is the last page
                    $button .= "<p><a class=\"next-button\" href=\"?page=" . ($page + 1) . "\">Next</a></p>";
                }
                echo $button;
                ?>
            </div>
        </div>
        <div class="friendadd-foot">
            <p><a class="friendlist-button" href="profile.php">Profile</a></p>
            <p><a class="friendlist-button" href="friendlist.php">Friend List</a></p>
            <p><a class="logout-button" href="logout.php">Log Out</a>
            </p>
        </div>
    </main>
</body>

</html>