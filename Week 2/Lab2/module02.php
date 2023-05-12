<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web Programming :: Lab 2">
    <meta name="keywords" content="Web,programming">
    <title>Using variables, arrays and operators</title>
</head>

<body>
    <h1>Web Programming - Lab 2</h1>
    <?php 
        $marks = array(85,85,95);
        $marks[1] = 90;
        $sum = 0;
        foreach ($marks as $mark) {
            $sum += $mark; 
        }
        $ave = $sum/count($marks);
        $ave >= 50 ? $status = "PASSED" : $status = "FAILED";
        echo "The average score is ". $ave .". You ". $status  .".";
    ?>
</body>

</html>