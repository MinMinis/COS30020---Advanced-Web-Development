<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Thanh Minh" />
    <meta name="description" content="Web Developer" />
    <meta name="keywords" content="HTML, CSS, PHP" />
    <link rel="stylesheet" href="style.css" />
    <script async data-id="five-server" src="http://localhost:5500/fiveserver.js"></script>
    <title>Search Job Result</title>
</head>

<body>
    <?php
    $dir = "./data/jobposts/";
    $filename = "./job.txt";
    // $filename = "../../data/jobposts/job.txt";
    function sanitise_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $current_date = date('d/m/Y h:i:s a', time());
    $error_msg = "<p><a href=\"index.php\" class=\"menu-link\">Back to Home Page</a><a href=\"searchjobform.php\" class=\"menu-link\">Search for another job vacancy</a></p>";
    // structure will store the HTML file for later to echo out
    $structure = "<main>";
    $structure .= "<header>";
    $structure .= "<h1>Job Vacancy Posting System</h1>";
    $structure .= "</header>";
    $structure .= "<article class=\"display_content\">";
    if (!empty($_GET["searchterm"]) && isset($_GET["searchterm"])) {
        if (file_exists($dir . $filename)) {
            $handle = fopen($dir . $filename, "r");
            $search_term = sanitise_input($_GET['searchterm']);
            $results = array();
            while (!feof($handle)) { // loop while not end of file
                $onedata = fgets($handle); // read a line from the text file
                if ($onedata != "") { // ignore blank lines
                    $data = explode("\t", $onedata); // explode string to array
                    $get_date = $data[3]; // get the date from the file
                    $job_title = $data[1]; // assign the job title get from the file to var
                    $job_title_words = explode(' ', $job_title); //explode each word of it into array
                    $search_term_words = explode(' ', $search_term); // explode each word of the search term into array
                    $match_found = false; // set the default to false
                    foreach ($job_title_words as $job_title_word) { //for each word in the array of the field
                        foreach ($search_term_words as $search_term_word) { //for each word in the array of the search term
                            // if the similar character >= 80% and or the different character <= 3
                            if (similar_text(strtolower($job_title_word), strtolower($search_term_word)) >= 0.8 && levenshtein(strtolower($job_title_word), strtolower($search_term_word)) <= 3) {
                                $match_found = true;
                                break;
                            }
                        }
                        if ($match_found) {
                            break;
                        }
                    }
                    if ($match_found) {
                        // The job title contains the search term, so add it to the results array.
                        $results[] = $data;
                    }
                    $get_date_array = explode("/", $get_date);
                    $current_date_array = explode("/", $current_date);
                }
            }
            fclose($handle); //close the file
            if (count($results) == 0) { //if there is no found result
                $structure .= "<p>No results were found.</p>" . $error_msg;
            } else {
                // print out in table format
                $structure .= "<p class=\"found\">There are " . count($results) . " results have found</p>";
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
                foreach ($results as $result) {
                    //assign each data of the record then display it
                    $job_title = $result[1];
                    $position_id = $result[0];
                    $description = $result[2];
                    $closing_date = $result[3];
                    $position = $result[4];
                    $contract = $result[5];
                    $application_by = $result[6];
                    $location = $result[7];
                    $structure .= "<tr>";
                    $structure .= "<td>$job_title</td>";
                    $structure .= "<td>$position_id</td>";
                    $structure .= "<td>$description</td>";
                    $structure .= "<td>$closing_date</td>";
                    $structure .= "<td>$position</td>";
                    $structure .= "<td>$contract</td>";
                    $structure .= "<td>$application_by</td>";
                    $structure .= "<td>$location</td>";
                    $structure .= "</tr>";
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