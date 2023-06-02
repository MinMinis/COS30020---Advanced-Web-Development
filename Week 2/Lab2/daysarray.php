<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web Programming :: Lab 2">
    <meta name="keywords" content="Web,programming">
    <meta name="author" content="Thanh Minh">
    <title>Experimenting on arrays</title>
</head>

<body>
    <h1>Lab02 - Task 2</h1>
    <?php
    $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    echo 'The Days of the week in English are ' . $days[0] . ', ' . $days[1] . ', ' . $days[2] . ', ' . $days[3] . ', ' . $days[4] . ', ' . $days[5] . ', ' . $days[6] . '.';
    $days[0] = "Dimanche";
    $days[1] = "Lundi";
    $days[2] = "Mardi";
    $days[3] = "Mercredi";
    $days[4] = "Jeudi";
    $days[5] = "Vendredi";
    $days[6] = "Samedi";
    echo 'The Days of the week in French are ' . $days[0] . ', ' . $days[1] . ', ' . $days[2] . ', ' . $days[3] . ', ' . $days[4] . ', ' . $days[5] . ', ' . $days[6] . '.';
    echo '<br>';

    // $stringday = "";
    // foreach ($days as $day) {
    //     if ($days[0] == $day) {
    //         $stringday .= "$day";
    //     } else if ($days[count($days) - 1] == $day) {
    //         $stringday .= ", and $day.";
    //     } else {
    //         $stringday .= ", $day";
    //     }
    // }
    // echo 'The Days of the week in English are ' . $stringday;
    echo "<br>";
    ?>
</body>

</html>