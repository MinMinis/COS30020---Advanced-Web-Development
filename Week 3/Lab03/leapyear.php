<!DOCTYPE html>
<html lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 3" />
    <meta name="keywords" content="Web,programming" />
    <meta name="author" content="Thanh Minh" />
    <title>Task 2: Leap Year</title>
</head>

<body>
    <h1>Lab03 Task 2 - Leap Year</h1>
    <hr>
    <?php
    if (isset($_POST["number"])) {
        $num = $_POST["number"];
        function is_leapyear($num)
        {
            if (is_numeric($num)) {
                if ($num % 4 == 0) {
                    if ($num % 100 == 0) {
                        if ($num % 400 == 0) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return true;
                    }
                }
            } else {
                return false;
            }
        };
        if (is_leapyear($num)) {
            echo "The year you enter " . $num . " is a leap year";
        } else {
            echo "The year you enter " . $num . " is not leap year";
        }
    } else {
        echo "Please enter a number";
    }


    ?>
</body>

</html>