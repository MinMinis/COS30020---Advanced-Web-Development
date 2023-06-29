<?php
session_set_cookie_params(1800);
session_start();
if ($_SESSION['status'] !== "logged") {
    header("Location: login.php");
}
$email = $_SESSION['email'];
$name = $_SESSION['name'];
require("settings.php");
require_once("function/update.php");
updatefriend($host, $user, $pswd, $dbnm, $table, $table2);
$conn = new mysqli($host, $user, $pswd);
@$conn->select_db($dbnm);
$sql = "SELECT friend_id, num_of_friends FROM $table WHERE friend_email = '$email'";
$result = $conn->query($sql);
$row = $result->fetch_row();
$id = $row[0];
$num_of_friend = $row[1];
$conn->close();
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
    <title>Friend List Page</title>
</head>

<body class="friendlist-body">
    <main class="friendlist-main">
        <header>
            <h1>My Friend System</h1>
            <h2 class="friendhead"><?php echo $name ?>'s Friend List Page</h2>
            <h2 class="friendhead">Total number of friends is <?php echo $num_of_friend ?></h2>
        </header>
        <div class="table-div">
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
                    $conn = new mysqli($host, $user, $pswd);
                    @$conn->select_db($dbnm);
                    $result_table = "<table class=\"friendlist-table\">";                                      //store the html table for printing out
                    $result_table .= "<thead><tr><th>Name</th><th>Total Friends</th></tr></thead>";         // store the table heading 
                    $result_table .= "<tbody  class=\"friendlist-tbody\">";
                    $find_friend = "SELECT * FROM $table2 WHERE friend_id1 = $id OR friend_id2 = $id GROUP BY friend_id1, friend_id2"; //sql query for get id from friends that don't match the current user id
                    $search_result = $conn->query($find_friend);                    //send the query to mysql
                    if ($search_result->num_rows > 0) {
                        while ($row = $search_result->fetch_row()) { // looping foreach row 
                            $get_friend = "SELECT friend_id, profile_name FROM $table WHERE NOT friend_email = '$email'";    //sql query for get the info of all friend
                            $search_result_get = $conn->query($get_friend);                    //send the query to mysql
                            while ($row_get =  $search_result_get->fetch_row()) { // looping for each row
                                if (($row_get[0] == $row[0] && $row[1] == $id) || ($row_get[0] == $row[1] && $row[0] == $id)) { //compare if the user id match and the friend id match

                                    // SQL query to get the total friend exclude the current user 
                                    $get_friend_of_friend = "SELECT friend_id, profile_name FROM $table 
                                                            WHERE friend_id != $id AND friend_id  
                                                            IN (SELECT friend_id1 FROM $table2 WHERE friend_id2 = $row_get[0] 
                                                            UNION 
                                                            SELECT friend_id2 FROM myfriends WHERE friend_id1 = $row_get[0])
                                                            ";
                                    $search_result_get_of_friend = $conn->query($get_friend_of_friend);
                                    $total_friends = $search_result_get_of_friend->num_rows;
                                    $result_table .= "<tr>";
                                    $result_table .= "<td>{$row_get[1]}</td>";              // print out the name of friend
                                    $result_table .= "<td class=\"expanse-cell\">";
                                    $result_table .= "Friends: " . ++$total_friends;        //print out the total friend including the current user
                                    if (!isset($_POST["view$row_get[0]"])) { // if the hide friend button toggle or default not show friend
                                        $result_table .= "<form action=\"friendlist.php\" method=\"post\">";
                                        $result_table .= "<input type=\"hidden\" name=\"friend_id\" value=\"" . $row_get[0] . "\"/>";
                                        if ($search_result_get_of_friend->num_rows > 0) {
                                            $result_table .= "<input type=\"submit\" class=\"view-button\" name=\"view$row_get[0]\" value=\"View friend\"/></form>";
                                        }
                                    } else if (isset($_POST["view$row_get[0]"])) { // if the user toggle view friend button
                                        if ($search_result_get_of_friend->num_rows > 0) {
                                            $row_get_friend = $search_result_get_of_friend->fetch_row();
                                            $result_table .= "<form action=\"friendlist.php\" method=\"post\">";
                                            $result_table .= "<input type=\"hidden\" name=\"friend_id\" value=\"" . $row_get_friend[0] . "\"/>";
                                            $result_table .= "<input type=\"submit\" class=\"view-button\" name=\"view$row_get_friend[0]\" value=\"Hide friend\"/></form>";
                                            while ($row_get_friend) { // print the friend list of current user's friend
                                                $result_table .= "<p>{$row_get_friend[1]}</p>";
                                                $row_get_friend = $search_result_get_of_friend->fetch_row();
                                            }
                                        }
                                    }
                                    $result_table .= "</td>";
                                    $result_table .= "<td>";
                                    $result_table .= "<form action=\"adddeletefriend.php\" method=\"post\">";
                                    $result_table .= "<input type=\"hidden\" name=\"friend_id\" value=\"" . $row_get[0] . "\"/>";
                                    $result_table .= "<input class=\"unfriend-button\" type=\"submit\" name=\"unfriend\" value=\"Unfriend\" /></form>"; //submit the friend id to the add delete friend page
                                    $result_table .= "</td>";
                                    $result_table .= "</tr>";
                                }
                            }
                        }
                    } else {
                        $result_table .= "<tr>";
                        $result_table .= "<td>No friends yet</td>";
                        $result_table .= "<td><a href=\"friendadd.php\">Add friends</a></td>";
                        $result_table .= "</tr>";
                    }
                    $result_table .= "</tbody>";
                    $result_table .= "</table>";
                    echo $result_table;
                    $conn->close();
                    ?>
                </section>
            </div>
        </div>
        <div class="friendlist-foot">
            <p><a class="friendlist-button" href="profile.php">Profile</a></p>
            <p><a class="friendlist-button" href="friendadd.php">Add friends</a></p>
            <p><a class="logout-button" href="logout.php">Log Out</a>
            </p>
        </div>
    </main>
</body>

</html>