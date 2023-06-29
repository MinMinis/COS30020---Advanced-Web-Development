<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Week 5 - Task 1</title>
</head>

<body>
    <h1>Web Programming - Lab 5</h1>
    <?php                                               // read the comments for hints on how to answer each item
    if (isset($_POST["iname"], $_POST["iquantity"])) { // check if both form data exists
        if (is_string($_POST['iname'])) {
            if (is_numeric($_POST['iquantity'])) {
                $item = $_POST["iname"];                        // obtain the form item data
                $qty = $_POST["iquantity"];                     // obtain the form quantity data
                $dir = "../../data/lab05/";
                // $dir = "./data/";
                umask(0007);
                if (!is_dir($dir)) {
                    mkdir($dir, 02770);
                }
                $filename = "shop.txt";              // assumes php file is inside lab05
                $handle = fopen($dir . $filename, "a+");              // open the file in append mode
                $data = $item . ", " . $qty . "\n";                         // concatenate item and qty delimited by comma
                fwrite($handle, $data);                     // write string to text file
                fclose($handle);                                     // close the text file
                echo "<p>Shopping List</p> ";                   // generate shopping list
                $handle = fopen($dir . $filename, "r");              // open the file in read mode
                while (!feof($handle)) {                   // loop while not end of file
                    $data = fgets($handle);                // read a line from the text file
                    echo "<p>", $data, "</p>";                  // generate HTML output of the data
                }
                fclose($handle);                                    // close the text file
            } else {
                echo "<p>Please enter number for field quantity</p>";
            }
        } else {
            echo "<p>Please enter string for name</p>";
        }
    } else { // no input
        echo "<p>Please enter item and quantity in the input form.</p>";
    }
    ?>
</body>

</html>