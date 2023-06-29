<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Result after Lab04 - Task 3</title>
</head>

<body>
    <h1>Lab04 - Task 2 Perfect Palindrome</h1>
    <hr>
    <?php
    if (isset($_POST["input"])) {
        $string = $_POST["input"];
        $str = preg_replace("/[^a-zA-Z]+/", "", strtolower($string));
        $pattern = "/^[a-zA-Z,.!?]++$/";
        if (preg_match($pattern, $str)) {
            // Convert to lowercase
            $convertinput = strtolower($str);
            // Reverse the input string
            $reversedString = strrev($convertinput);
            // Check if the reversed string is equal to the original string
            $perfect = false;
            $convert_input = strtolower($string);
            $reversed_String = strrev($convert_input);
            if (strcmp($convert_input, $reversed_String) === 0) {
                $perfect = true;
            }
            if (strcmp($convertinput, $reversedString) === 0 && $perfect) {
                echo "<p>The text you entered '{$string}' is a perfect palindrome.</p>";
            } else if (strcmp($convertinput, $reversedString) === 0) {
                echo "<p>The text you entered '{$string}' is a standard palindrome.</p>";
            } else {
                echo "<p>The text you entered '{$string}' is not a perfect palindrome.</p>";
            }
        } else {
            echo "<p>Please enter a string containing only letters.</p>";
        }
    } else {
        echo "<p>Please enter string from the input form.</p>";
    }
    ?>
</body>

</html>