<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Thanh Minh">
    <meta name="description" content="Web Developer">
    <meta name="keywords" content="HTML, CSS, PHP">
    <link rel="stylesheet" href="style.css">
    <title>Search Job Result</title>
</head>

<body>
    <?php
    $dir = "../../data/jobposts/";
    $filename = "jobs.txt";
    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $error_msg = "<p><a href=\"index.php\" class=\"menu-link\">Back to Home Page</a><a href=\"searchjobform.php\" class=\"menu-link\">Search for another job vacancy</a></p>";
    $structure = "<main>";    // structure will store the HTML file for later to echo out
    $structure .= "<header>";
    $structure .= "<h1>Job Vacancy Posting System</h1>";
    $structure .= "</header>";
    $structure .= "<article class=\"display_content\">";
    if (!empty($_GET["searchterm"]) && isset($_GET["searchterm"])) { //check if the input is filled or not
        if (file_exists($dir . $filename)) { //check if the file exist or not
            $handle = fopen($dir . $filename, "r"); //open file for read
            $search_term = sanitize_input($_GET['searchterm']); //remove case of code injection
            $search_job_crit  = array(); // array of value for storing the checkbox values 
            if (isset($_GET['search_job_crit'])) { //check the input for the checkboxes
                foreach ($_GET['search_job_crit'] as $value) { //foreach checkbox is checked
                    array_push($search_job_crit, $value); //push all the checkbox value into array
                }
            }
            $results = array(); // create empty array to store the displayed ones.
            $positionid = "positionid";
            $title = "title";
            $description = "description";
            $day = "day";
            $position = "position";
            $contract = "contract";
            $application = "application";
            $location = "location";
            $search_num_array = [
                $positionid => [
                    "similar_text" => 3, "levenshtein" => 3,
                ],
                $title      => [
                    "similar_text" => 2, "levenshtein" => 3,
                ],
                $description => [
                    "similar_text" => 3, "levenshtein" => 3,
                ],
                $day        => [
                    "similar_text" => 6, "levenshtein" => 0,
                ],
                $position => [
                    "similar_text" => 4, "levenshtein" => 0,
                ],
                $contract => [
                    "similar_text" => 3, "levenshtein" => 3,
                ],
                $application => [
                    "similar_text" => 3, "levenshtein" => 1,
                ],
                $location => [
                    "similar_text" => 2, "levenshtein" => 0,
                ]
            ];
            $search_term_words = explode(' ', $search_term); // explode each word of the search term into array
            while (!feof($handle)) { // loop while not the end of file
                $onedata = fgets($handle); // read a line from the text file
                if ($onedata != "") { // ignore blank lines
                    $data = explode("\t", $onedata); // explode string to array
                    $match_found = false; // set the default to false
                    $current_data = [[ //convert the data in to array key format
                        $positionid => $data[0],
                        $title => $data[1],
                        $description => $data[2],
                        $day => $data[3],
                        $position => $data[4],
                        $contract => $data[5],
                        $application => $data[6],
                        $location => $data[7],
                    ]];
                    foreach ($current_data as $current_data_key => $current_data_value) { // take out the value in the current data array for processing
                        foreach ($search_term_words as $search_value) { // take out the word in each word
                            if (count($search_job_crit) == 0) { // if the user didn't check any checkbox
                                array_push($search_job_crit, $positionid, $title, $description, $day, $position, $contract, $application, $location); //push all the criteria into the array
                            }
                            foreach ($search_job_crit as $job_crit) {
                                $store_words = explode(" ", $current_data_value[$job_crit]); // explode into array to compare each word
                                foreach ($store_words as $store_word) {
                                    if ((similar_text(strtolower($store_word), strtolower($search_value)) >= $search_num_array[$job_crit]["similar_text"] && levenshtein(strtolower($store_word), strtolower($search_value)) <= $search_num_array[$job_crit]["similar_text"])) {
                                        $match_found = true;
                                        break 4; //break out 5 foreach loop
                                    }
                                }
                            }
                        }
                    }
                    if ($match_found) {
                        $results[] = $current_data; // add to the array for those have qualified the search criteria
                    }
                }
            }
            fclose($handle); //close the file
            $current_date = date("d/m/y"); // get the day in d/m/Y format
            function compareDate($date1, $date2) // 2 parameters in array
            {
                $array_date1 = explode("/", $date1); //explode into array to compare
                $array_date2 = explode("/", $date2); //explode into array to compare
                if ($array_date1[2] == $array_date2[2]) { //compare year
                    if ($array_date1[1] == $array_date2[1]) { //compare month
                        if ($array_date1[0] >= $array_date2[0]) { //compare date
                            return true;
                        } else {
                            return false;
                        }
                    } else if ($array_date1[1] > $array_date2[1]) { //compare the month
                        return true;
                    } else {
                        return false;
                    }
                } else if ($array_date1[2] > $array_date2[2]) { //if the store year is bigger than current year will always true
                    return true;
                } else {
                    return false;
                }
            }
            $display_results = []; // create array for later display it
            foreach ($results as $result) {
                $val_date = false; //set the default to false
                foreach ($result as $key => $value) {
                    $store_date = $value['day']; //get the day store in the array
                    if (compareDate($store_date, $current_date)) { //compare the day
                        $val_date = true;
                        break;
                    }
                }
                if ($val_date) {
                    $display_results[] = $result; // add the valid day item data to array to display
                }
            }

            usort( //using usort to sort the arrays based on the element in the array
                $display_results, //used array
                function ($a, $b) {
                    $date1 = DateTime::createFromFormat('d/m/y', current($a)['day']); //take out the current data in the object format to compare
                    $date2 = DateTime::createFromFormat('d/m/y', current($b)['day']);
                    if ($date1 == $date2) {
                        return 0;
                    }
                    return ($date1 < $date2) ? 1 : -1; //  if the first date is before the second date, return false;
                }
            );


            if (count($display_results) == 0) { //if there is no found result
                $structure .= "<p class=\"error\">No results were found.</p>" . $error_msg;
            } else {
                // print out in table format
                $structure .= "<p class=\"found\">There are " . count($display_results) . " results have been found for \"" . $search_term . "\".</p>";
                $structure .= "<table>";
                $structure .= "<tr>";
                $structure .= "<th>Job Title</th>";
                $structure .= "<th>Position ID</th>";
                $structure .= "<th>Description</th>";
                $structure .= "<th>Closing Date</th>";
                $structure .= "<th>Position</th>";
                $structure .= "<th>Contract</th>";
                $structure .= "<th>Application By</th>";
                $structure .= "<th>Location</th>";
                $structure .= "</tr>";
                foreach ($display_results as $display_result) {
                    foreach ($display_result as $key => $value) {
                        $structure .= "<tr>";
                        $structure .= "<td>" . addslashes($value['title']) . "</td>";
                        $structure .= "<td>" . $value['positionid'] . "</td>";
                        $structure .= "<td>" . addslashes($value['description']) . "</td>";
                        $structure .= "<td>" . $value['day'] . "</td>";
                        $structure .= "<td>" . $value['position'] . "</td>";
                        $structure .= "<td>" . $value['contract'] . "</td>";
                        $structure .= "<td>" . $value['application'] . "</td>";
                        $structure .= "<td>" . $value['location'] . "</td>";
                        $structure .= "</tr>";
                    }
                }
                $structure .= "</table>";
                $error_msg = "";
            }
        } else { // if the find is not found
            $structure .= "<p class=\"error\">No file was found</p>" . $error_msg;
        }
    } else { // if the field is empty
        $structure .= "<p class=\"error\">Please do not leave the field empty</p>" . $error_msg;
    }
    $structure .= "</article>";
    $structure .= "</main>";
    if ($error_msg == "") {
        $structure .= "<article>";
        $structure .= "<p>";
        $structure .= "<a href=\"index.php\" class=\"menu-link\">Home Page</a>";
        $structure .= "<a href=\"searchjobform.php\" class=\"menu-link\">Search Job Form</a>";
        $structure .= "</p>";
        $structure .= "</article>";
    }
    echo $structure; //print out all the structure
    ?>
    <footer>
        <p><strong>Author:</strong> Tran Thanh Minh</p>
        <p><strong>Student ID:</strong> 103809048</p>
    </footer>
</body>

</html>