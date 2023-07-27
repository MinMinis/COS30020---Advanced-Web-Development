<?php
// $host = "feenix-mariadb.swin.edu.au";
// $user = "s103809048";        //username 
// $pswd = "se7en";        //password
// $dbnm = "s103809048_db"; // my database
$table = "hitcounter";

$host = "localhost";
$user = "root";
$pswd = "";
$dbnm = "s103809048_db";
?>
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
    <form action="setup.php" method="post">
        <input type="submit" name="submit" />
    </form>
    <?php
    if (isset($_POST['submit'])) {
        umask(0007);
        // $dir = "../../data/lab10/";
        $dir = "./data/lab10/";
        if (!is_dir($dir)) {
            mkdir($dir, 02770);
        }
        $filename = "mykeys.inc.php";
        $handle = fopen($dir . $filename, "w+");
        if (!is_writable($dir . $filename)) {
            echo "<p>Cannot write to file</p>";
        } else {
            $data = "<?php\n";
            $data .= "\$host = '" . $host . "';\n";
            $data .= "\$user = '" . $user . "';\n";
            $data .= "\$pswd = '" . $pswd . "';\n";
            $data .= "\$dbnm = '" . $dbnm . "';\n";
            $data .= "\$table = '" . $table . "';\n";
            $data .= '?>';
            if (fwrite($handle, $data) > 0) {
                echo "Create key sucessfully in " . $dir . $filename;
            } else {
                echo "Fail to create key in " . $dir . $filename;
            }
        }
        fclose($handle);
        echo "<br>";



        $conn = new mysqli($host, $user, $pswd, $dbnm);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create hitcounter table
        $sql = "CREATE TABLE IF NOT EXISTS $table (
    id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    hits SMALLINT NOT NULL
    )";
        if ($conn->query($sql) === TRUE) {
            echo "Table $table created successfully";
            $add = "INSERT INTO $table (hits) VALUE (0)";
            echo "<br>";
            if ($conn->query($add) === true) {
                echo "Successfully create hit record";
            } else {
                echo "Error creating record: " . $conn->error;
            }
        } else {
            echo "Error creating table: " . $conn->error;
        }
        $conn->close();
    }

    ?>
</body>

</html>