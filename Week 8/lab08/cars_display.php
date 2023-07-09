<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab 08 Task 1</title>
</head>

<body>
    <h1>Web Programming - Lab08</h1>
    <?php
    require_once("settings.php");
    $table = "cars";
    // complete your answer based on Lecture 8 slides 26 and 44
    $conn = @mysqli_connect($host, $user, $pswd)
        or die('Fail to connect to server ');
    @mysqli_select_db($conn, $dbnm)
        or die('Database not available');
    $query = "SELECT car_id, make, model, price FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    echo "<table width='100%' border='1'>";
    echo "<tr><th>Car ID</th><th>Make</th><th>Model</th><th>Price</th></tr>";
    while ($row) {
        echo "<tr><td>{$row[0]}</td>";
        echo "<td>{$row[1]}</td>";
        echo "<td>{$row[2]}</td>";
        echo "<td>{$row[3]}</td></tr>";
        $row = mysqli_fetch_row($result);
    }
    echo "</table>";
    echo "<p>Your query return " . mysqli_num_rows($result) . " rows and " . mysqli_num_fields($result) . " fields</p>";


    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</body>

</html>