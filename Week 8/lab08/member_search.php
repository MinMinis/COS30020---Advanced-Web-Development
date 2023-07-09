<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab 08 Task 2</title>
</head>

<body>
    <h1>Web Programming - Lab08</h1>
    <h2>Search member</h2>
    <form action="member_search.php" method="get">
        <label for="search">Search name</label>
        <input type="text" name="search" id="search" />
        <br>
        <input type="submit" name="submit" value="search" />
    </form>
    <?php
    if (!isset($_GET['search'], $_GET['submit'])) {
        echo "Please enter last name of the one you want to search for";
    } else {
        require_once("settings.php");
        $table = "vipmembers";
        // complete your answer based on Lecture 8 slides 26 and 44
        $conn = @mysqli_connect($host, $user, $pswd)
            or die('Fail to connect to server ');
        @mysqli_select_db($conn, $dbnm)
            or die('Database not available');
        $search = $_GET['search'];
        $search = mysqli_real_escape_string($conn, $search);
        $query = "SELECT member_id, fname, lname, email FROM $table WHERE lname = '$search'";
        $result = mysqli_query($conn, $query);
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            echo "<table width='100%' border='1'>";
            echo "<tr><th>Member ID</th><th>Family name</th><th>Last name</th><th>Email</th></tr>";
            while ($row = mysqli_fetch_row($result)) {
                echo "<tr><td>{$row[0]}</td>";
                echo "<td>{$row[1]}</td>";
                echo "<td>{$row[2]}</td>";
                echo "<td>{$row[3]}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No such member";
        }

        mysqli_free_result($result);
        mysqli_close($conn);
    }

    ?>
</body>

</html>