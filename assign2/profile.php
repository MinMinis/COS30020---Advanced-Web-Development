<?php
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
$sql = "SELECT * FROM $table WHERE friend_email = '$email'";
$result = $conn->query($sql);
$row = $result->fetch_row();
$id = $row[0];
$num_of_friend = $row[5];

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
    <title>Profile</title>
</head>

<body class="profile-container">
    <main class="profile-main">
        <header>
            <h1>My Friend System</h1>
            <h2 class="friendhead"><?php echo $name ?>'s Profile</h2>
            <h2 class="friendhead">Total number of friends is <?php echo $num_of_friend ?></h2>
        </header>
        <div class="profile-div">
            <div class="profile">
                <section class="profile_body">

                    <div>
                        <?php
                        $conn = new mysqli($host, $user, $pswd);
                        @$conn->select_db($dbnm);


                        $sql = "SELECT * FROM $table WHERE friend_email = '$email'";
                        $result = $conn->query($sql);
                        $row = $result->fetch_row();
                        echo "<p>Friend ID: " . $row[0] . "</p>";
                        echo "<p>Friend Email: " . $row[1] . "</p>";
                        echo "<p>Friend Password: " . $row[2] . "</p>";
                        echo "<p>Friend Profile Name: " . $row[3] . "</p>";
                        echo "<p>Total Friend: " . $row[5] . "</p>";
                        $conn->close();
                        ?>
                    </div>
                    <div>
                        <p><a class=" logout-button" href="deleteaccount.php">Delete Account</a></p>
                    </div>
                </section>
            </div>
        </div>
        <div class="profile-foot">
            <p><a class="friendlist-button" href="profile.php">Profile</a></p>
            <p><a class="friendlist-button" href="friendlist.php">Friend List</a></p>
            <p><a class="friendlist-button" href="friendadd.php">Add friends</a></p>
            <p><a class="logout-button" href="logout.php">Log Out</a>
            </p>
        </div>
    </main>
</body>

</html>