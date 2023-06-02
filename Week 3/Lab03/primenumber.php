<!DOCTYPE html>
<html lang="en" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Web Application Development :: Lab 3" />
    <meta name="keywords" content="Web,programming" />
    <meta name="author" content="Thanh Minh" />
    <title>Task 3: Prime Number</title>
</head>

<body>
    <h1>Lab03 Task 3 - Prime number</h1>
    <?php


    if (isset($_GET["number"]) && is_numeric($_GET["number"])) {
        $num = $_GET["number"];
        /*
            for ($i = 2; $i < $num; $i++) {
                if ($num % $i == 0) {
                    echo "The number you entered ".$num." is not a prime number.";
                    break;
                }
            }
            echo "The number you entered ".$num." is a prime number.";
        }*/
        function is_prime($number)
        {
            for ($i = 2; $i < $number; $i++) {
                if ($number % $i == 0) {
                    return false;
                }
            }
            return true;
        }
        if (is_prime($num)) {
            echo "The number you entered " . $num . " is a prime number";
        } else {
            echo "The number you entered " . $num . " is not a prime number.";
        }
    } else {
        echo "Please input a number";
    }
    ?>
</body>

</html>