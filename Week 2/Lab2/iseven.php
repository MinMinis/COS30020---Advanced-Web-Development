<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web Programming :: Lab 2">
    <meta name="keywords" content="Web,programming">
    <title>Using expression and looking up built-in functions</title>
</head>

<body>
    <form action="iseven.php" method="get">
        <h1>SUBMIT FORM</h1>
        <input type="text" id="number" name="number">
        <input type="submit" id="submit" name="submit" value="Submit">
    </form>
    <?php 
        $num = $_GET['number'];
        is_numeric($num)? $isnum = "True" : $isnum= "False";
        if (isset($num) &&  is_numeric($num)) {
            (int) $num%2 === 0 ? $result = "Even" : $result = "Odd";
            echo "The number is ".$num.". It is the ". $result ." number.";
            echo "<br>";
            echo "Is it a number: ". $isnum .".";
            echo "<br>";
            echo "Round number: ". round($num) .".";
        } else if (isset($num) && is_string($num) && $num !== '') {
            echo 'Please input a number not a string';
            echo '<br>';
            echo 'You have input: '. $num;
            echo '<br>';
            echo "Is it a number: ". $isnum .".";
        } else {
            echo 'There is no submit value yet';
        }
    ?>
</body>

</html>