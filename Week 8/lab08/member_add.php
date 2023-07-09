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
    if (!isset($_POST['fname'], $_POST['lname'], $_POST['gender'], $_POST['email'], $_POST['phone'])) {
        echo "Please fill in all the field";
    } else {
        if (!empty($_POST['fname']) || !empty($_POST['$lname']) || !empty($_POST['$gender']) || !empty($_POST['$email']) || !empty($_POST['$phone'])) {
            require_once("settings.php");
            $table = "vipmembers";
            // complete your answer based on Lecture 8 slides 26 and 44
            $conn = @mysqli_connect($host, $user, $pswd)
                or die('Fail to connect to server ');
            @mysqli_select_db($conn, $dbnm)
                or die('Database not available');

            $tb_query = "CREATE TABLE IF NOT EXISTS $table (
                member_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                fname VARCHAR(40) NOT NULL,
                lname VARCHAR(40) NOT NULL,
                gender VARCHAR(1) NOT NULL,
                email VARCHAR(40) NOT NULL,
                phone VARCHAR(20) NOT NULL
                )";
            function sanitize_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            mysqli_query($conn, $tb_query); // create table if not exist
            $fname = sanitize_input($_POST['fname']);
            $lname = sanitize_input($_POST['lname']);
            $gender = sanitize_input($_POST['gender']);
            $email = sanitize_input($_POST['email']);
            $phone = sanitize_input($_POST['phone']);

            $fname = mysqli_real_escape_string($conn, $fname);
            $lname = mysqli_real_escape_string($conn, $lname);
            $gender = mysqli_real_escape_string($conn, $gender);
            $email = mysqli_real_escape_string($conn, $email);
            $phone = mysqli_real_escape_string($conn, $phone);

            $query = "INSERT INTO $table (fname, lname, gender, email, phone) VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            } else {
                echo "<p>Successfully insert " . mysqli_affected_rows($conn) . " rows</p>";
                echo "<p>Successfully added new member</p>";
                // mysqli_free_result($result);
            }
            mysqli_close($conn);
        } else {
            echo "Please fill in all the data";
        }
    }
    ?>
    <p><a href="member_add_form.php">Add Another</a></p>
    <p><a href="vip_member.php">Home</a></p>
</body>

</html>