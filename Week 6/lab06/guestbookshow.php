<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab06 - Task 2</title>
</head>

<body>
    <h1>Lab06 Task 2 - Guestbook</h1>
    <h2>View Guestbook</h2>
    <hr>
    <?php
    $dir = "../../data/lab06/";
    $filename = "guestbook.txt";

    if (file_exists($dir.$filename)) {
        $guestbook = file($dir.$filename); //read file into array
        // Sort the array by name
        sort($guestbook);
        $structure = "<table border=\"1\">";
        $structure .= "<tr><th>Number</th><th>Name</th><th>Email</th></tr>";
        $i = 0;
        foreach ($guestbook as $entry) {
            $data = explode(",", $entry); //explode each line
            $name = trim($data[0]);
            $email = trim($data[1]);
            if ($name !== "" && $email !== "") {
                $i++;
                $structure .= "<tr><td>$i</td><td>" . stripslashes($name) . "</td><td>$email</td></tr>";
            }
        }

        $structure .= "</table>";
        echo $structure;
    } else {
        echo "<p>The file does not exist.</p>";
    }
    ?>

    <hr>
    <a href="guestbookform.php">Add another Visitor</a>
</body>

</html>