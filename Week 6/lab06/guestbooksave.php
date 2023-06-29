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
    <h2>Sign Guestbook</h2>
    <hr>
    <?php
    if (isset($_POST['name'], $_POST['email'], $_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        // $filename = "../../data/shop.txt"; // assumes php file is inside lab06
        $dir = "../../data/lab06/";
        $filename = "guestbook.txt";
        $regexp = '/^([a-zA-Z0-9_.+-]+)@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/';
        if (preg_match($regexp, $email)) {
            umask(0007);
            if (!is_dir($dir)) {
                mkdir($dir, 02770);
            }
            if (file_exists($dir . $filename)) {
                $handle = fopen($dir . $filename, "r"); //open file in read mode
                $onedata = array();
                $newdata = true;
                while (!feof($handle)) { // read all in file
                    $readhandle = fgets($handle); // read line in file
                    $data = explode(",", $readhandle);
                    foreach ($data as $item) {
                        if ($item == $name) {
                            $newdata = false;
                            break;
                        }
                        if ($item || true) {
                            $item = explode("\n", $item);
                            if ($item[0] == $email) {
                                $newdata = false;
                                break;
                            }
                        }
                    }
                }
                fclose($handle);
                if ($newdata) { // only process if it is new data
                    $handle = fopen($dir . $filename, "a+"); // open file in append mode
                    $data = $name . "," . $email . "\n";
                    $write_success = fputs($handle, $data); // Store data in file and capture write success

                    if ($write_success !== false) {
                        echo "Thank you for signing our guestbook\n";
                        echo "<br>";
                        echo "<p><strong>Name:</strong> $name</p>\n";
                        echo "<p><strong>Email:</strong> $email</p>";
                    } else {
                        echo "Failed to write into the file.";
                    }
                    fclose($handle);
                } else {
                    echo "<p>You have already signed the guestbook!</p>";
                }
            } else {
                echo "<p>The file is not exist</p>";
            }
        } else {
            echo "<p>Email address is not valid</p>";
        }
    } else {
        echo "<p>You must enter your name and email address</p>";
        echo '<p>Use the Browser\'s \'Go Back\' button to return to the Guestbook form</p>';
    }
    ?>
    <hr>
    <a href="guestbookform.php">Add another Visitor</a>
    <br>
    <a href="guestbookshow.php">View Guest Book</a>

</body>

</html>