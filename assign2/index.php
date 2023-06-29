<?php
session_set_cookie_params(1800);
session_start();
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = "";
}
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
    <title>Home Page</title>
</head>

<body>
    <main class="index-main">
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="signup.php">Register</a>
                <a href="about.php">About</a>
                <div class="nav-home" id="animation"></div>
            </nav>
            <h1>My Friend System<br>Assignment Home Page</h1>
        </header>
        <div class="index-container">
            <div class="index-info">
                <p>Name: Tran Thanh Minh</p>
                <p>Student ID: 103809048</p>
                <p>Email: 103809048@student.swin.edu.au</p>
                <p>I declare that this assignment is my individual work.
                    I have not worked collaboratively nor have I copied
                    from any other student's work or from any other source.</p>
            </div>
            <div class="index-message">
                <h2 class="body-head">System Message</h2>
                <?php
                require_once("settings.php"); // get the credential details for connecting to the db
                $conn = new mysqli($host, $user, $pswd);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $system_message = "";
                @$conn->select_db($dbnm); // selecting the db
                // create table if it not exist query
                $query = "CREATE TABLE IF NOT EXISTS $table (
                        friend_id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        friend_email VARCHAR(50) NOT NULL,
                        password VARCHAR(20) NOT NULL,
                        profile_name VARCHAR(30) NOT NULL,
                        date_started DATE NOT NULL,
                        num_of_friends INT(6) UNSIGNED
                        )";
                if ($conn->query($query) === true) { // check if the query successfully execute
                    $system_message .= "<p class=\"success\">Table <strong>$table</strong> created successfully</p>"; // success message
                    $select_all_tb1 = "SELECT * FROM $table";
                    $result1 = $conn->query($select_all_tb1); // query to get all the data from the friends table
                    if ($result1->num_rows > 0) { // if table friends already has data
                        $system_message .= "<p class=\"success\"><strong>$table</strong> already has data</p>";
                    } else {
                        //populate data into table
                        $populate_tb1 =
                            "INSERT INTO $table (friend_email, password, profile_name, date_started, num_of_friends)
                    VALUES ('jamessmith@gmail.com', 'abc123', 'James Smith', '2023-07-01', 5),
                           ('michaeljohnson@gmail.com', 'abc123', 'Michael Johnson', '2023-07-01', 3),
                           ('robertwilliams@gmail.com', 'abc123', 'Robert Williams', '2023-07-01', 7),
                           ('davidbrown@gmail.com', 'abc123', 'David Brown', '2023-07-01', 2),
                           ('williamjones@gmail.com', 'abc123', 'William Jones', '2023-07-01', 6),
                           ('richardgarcia@gmail.com', 'abc123', 'Richard Garcia', '2023-07-01', 4),
                           ('josephmiller@gmail.com', 'abc123', 'Joseph Miller', '2023-07-01', 8),
                           ('thomasdavis@gmail.com', 'abc123', 'Thomas Davis', '2023-07-01', 1),
                           ('charlesrodriguez@gmail.com','abc123','Charles Rodriguez','2023-07-01',9),
                           ('christopherwilson@gmail.com','abc123','Christopher Wilson','2023-07-01',10)";
                        if ($conn->query($populate_tb1) === true) { // check if the query execute successfully
                            $system_message .= "<p class=\"success\">Table <strong>$table</strong> populated successfully</p>"; // success message 
                        } else {
                            $system_message .= "Error populating table: " . $conn->error; // alert message 
                        }
                    }
                } else {
                    $system_message .= "Error creating table: " . $conn->error; // alert message 
                }
                // create table if it not exist and check so that record in friend_id1 can not be the same with friend_id2
                $query_tb = "CREATE TABLE IF NOT EXISTS $table2 (
                            friend_id1 INT(6) NOT NULL,
                            friend_id2 INT(6) NOT NULL
                            CHECK (friend_id1 <> friend_id2)
                            )";
                if ($conn->query($query_tb) !== false) { // check if the query execute successfully
                    $system_message .= "<p class=\"success\">Table <strong>$table2</strong> created successfully</p>"; // success message
                    $select_all_tb2 = "SELECT * FROM $table2";
                    $result2 = $conn->query($select_all_tb2);
                    if ($result2->num_rows > 0) { // check if the myfriends table has data
                        $system_message .= "<p class=\"success\"><strong>$table2</strong> already has data</p>";
                    } else {
                        //populate data into the myfriends table
                        $populate_tb2 = "INSERT INTO $table2 (friend_id1, friend_id2)
                                VALUES (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
                                       (2, 3), (2, 4), (2, 5), (2, 6), (3, 4), 
                                       (3, 5), (3, 6), (4, 5), (4, 6), (5, 6),
                                       (6, 7), (6, 8), (6, 9), (6, 10),(7, 8)";
                        if ($conn->query($populate_tb2) !== false) {
                            $system_message .= "<p class=\"success\">Table <strong>$table2</strong> populated successfully</p>"; //success message
                        } else {
                            $system_message .= "Error populating table: " . $conn->error;
                        }
                    }
                } else {
                    $system_message .= "Error creating table: " . $conn->error;
                }
                $conn->close();

                echo $system_message;

                require_once("function/update.php"); //import the update friend function
                updatefriend($host, $user, $pswd, $dbnm, $table, $table2); // set the num_of_friends of friends table to be correct
                ?>
            </div>
        </div>

    </main>
</body>

</html>