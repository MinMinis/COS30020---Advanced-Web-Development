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
    <h2>Display member</h2>
    <?php

    require_once("settings.php");
    $table = "vipmembers";
    // complete your answer based on Lecture 8 slides 26 and 44
    $conn = @mysqli_connect($host, $user, $pswd)
        or die('Fail to connect to server ');
    @mysqli_select_db($conn, $dbnm)
        or die('Database not available');
    $query = "SELECT member_id, fname, lname  FROM $table";
    $result = mysqli_query($conn, $query);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        echo "<table width='100%' border='1'>";
        echo "<tr>";
        echo "<th>Member ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "</tr>";
        $row = mysqli_fetch_row($result);
        while ($row) {
            echo "<tr>";
            echo "<td>" . $row[0] . "</td>";
            echo "<td>" . $row[1] . "</td>";
            echo "<td>" . $row[2] . "</td>";
            echo "</tr>";
            $row = mysqli_fetch_row($result);
        }
        echo "</table>";
        echo "<p>There are " . $num . " rows</p>";
    } else {
        echo "No member yet";
    }
    mysqli_free_result($result);
    mysqli_close($conn);


    ?>
</body>

</html>