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
    <title>Post Job Result</title>
</head>

<body>
    <?php
    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    umask(0007);
    $applicationby = isset($_POST['post']) || isset($_POST['email']); //check if the one of the checboxes is check or not
    $returnlink = "<a href=\"postjobform.php\" class=\"menu-link\">Post Job Form</a>";
    $homepage = "<a href=\"index.php\" class=\"menu-link\">Home Page</a>";
    // structure will store the HTML file for later to echo out
    $structure = "<main>";
    $structure .= "<header>";
    $structure .= "<h1>Job Vacancy Posting System</h1>";
    $structure .= "</header>";
    $structure .= "<article>";
    //file and directory for use
    $dir = "../../data/jobposts/";
    $filename = "jobs.txt";
    if (isset($_POST['submit'])) { // if the user has submitted
        if (
            isset($_POST['positionid']) && isset($_POST['title']) && isset($_POST['description'])
            && isset($_POST['closingdate'])
            && isset($_POST['position'])
            && isset($_POST['contract'])
            && isset($_POST['location']) && (!empty($_POST['location']))
            && $applicationby
        ) { // check the data if it has submitted fully
            // assign form value to variables
            $position = $_POST['position'];
            $contract = $_POST['contract'];
            $location = $_POST['location'];
            $pattern = true; // set the default value of pattern to true
            //store the key to validate
            $validate_fields = [
                'positionid' => [
                    'length' => 5,
                    'pattern' => '/^P\d{4}$/',
                    'message' => "Position ID must start with P (uppercase) and follow up with exact 4 digits",
                ],
                'title' => [
                    'length' => 20,
                    'pattern' => '/^[a-zA-Z0-9\s,.!]+$/',
                    'message' => "The title can only contain a maximum of 20 alphanumeric characters including spaces, comma, period (full stop), and exclamation point. ",
                ],
                'description' => [
                    'length' => 260,
                    'pattern' => '/^[a-zA-Z0-9 ,.!]+$/',
                    'message' => "The description can only contain a maximum of 260 characters. The description can't have punctuation. Can't be empty.",
                ],
                'closingdate' => [
                    'pattern' => '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2}$/',
                    'length' => 8,
                    'message' => "Closing Date must follow the dd/mm/yy rule. ",
                ],
            ];
            foreach ($validate_fields as $field => $rules) { // loop for each item in variable $validate_fields
                if (strlen($_POST[$field]) > $rules['length'] || !preg_match($rules['pattern'], sanitize_input($_POST[$field]))) { // check if the form value is not fit the requirements
                    $structure .= "<p class=\"error\">" . $rules['message'] . "</p>";
                    $pattern = false;
                }
            }
            //function to check whenever the date is in correct format or not
            function isValidDate($date)
            {
                $dateArray = explode('/', $date); //explode into array for validating
                if (count($dateArray) != 3) return false; //count if there is less than 3 elements in array
                list($day, $month, $year) = $dateArray; //convert to list
                if (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) return false; //check if is numeric
                if ($day > 31 || $month > 12) return false; //check the day and month in correct format
                return checkdate($month, $day, $year); //check if day is in correct format such as february if not leap year should have 28 days
            }
            // after processing the validate fields set it into variables for easy use
            $position_id = sanitize_input($_POST['positionid']);
            $title = sanitize_input($_POST['title']);
            $description = sanitize_input($_POST['description']);
            $closingdate = sanitize_input($_POST['closingdate']);
            // assign the variable $application_by to the value of post and email
            if (!empty($_POST['email']) && !empty($_POST['post'])) {
                $application_by = $_POST['email'] . ', ' . $_POST['post'];
            } else if (!empty($_POST['email'])) {
                $application_by = $_POST['email'];
            } else if (!empty($_POST['post'])) {
                $application_by = $_POST['post'];
            }
            $newdata = true; //set the default new data to true
            if (!is_dir($dir)) {
                mkdir($dir, 02770) //create directory
                    or die("Unable to create directory"); //print message
            }
            if (file_exists($dir . $filename)) { // check if the file exist
                $handle = fopen($dir . $filename, "r"); // open file
                $data = array(); //create empty array for later push data in
                while (!feof($handle)) { // if it has not reach the last line of the file
                    $readhandle = fgets($handle); // get the current line
                    $data = explode("\t", $readhandle); // explode data in to array
                    if (in_array($position_id, $data)) { // check if there is any same id
                        $newdata = false; //if it found
                        $structure .= "<p class=\"error\">This Position ID has been used.</p>";
                        break;
                    }
                }
                fclose($handle); //close the file
            }
            // check if the date is in correct format for not
            if (!isValidDate($closingdate)) {
                $structure .= "<p class=\"error\">Date should be in correct format</p>";
                $pattern = false;
            }
            if ($pattern && $newdata) { //check if all the data have met the pattern and it has unique ID
                // process all data here
                $handle = fopen($dir . $filename, "a+"); // open file if there is no file yet , create a new one
                $data = $position_id . "\t" . $title . "\t" . $description . "\t" . $closingdate . "\t" . $position . "\t" . $contract . "\t" . $application_by . "\t" . $location . "\n";
                if (fwrite($handle, $data)) { //write the data into the file and check if the return bytes bigger than 0
                    $structure .= "<p class=\"success\">The Data have been saved.</p> <a href=\"index.php\">Back to home page</a>"; // let the user know have been succeeded
                } else {
                    $structure .= "<p class=\"error\">Fail to store the data. </p><p><a href=\"index.php\">Back to home page</a></p>"; //print out if the file fail to store the data
                }
                fclose($handle); //close the file
            } else {
                $structure .= "<p class=\"error\">You need to go to the previous page to fill again.<br><a href=\"index.php\">Back to home page</a></p>";
            }
        } else { // if there is empty value
            $structure .= "<p class=\"error\">You need to fill all the data</p>";
        }
    } else { // if the user has not submitted
        $structure .= "<p class=\"error\">There is no data to display</p>";
    }
    $structure .= '<p>' . $homepage . '</p><p>' . $returnlink . '</p>';
    $structure .= "</article>";
    $structure .= "</main>";
    echo $structure; //print out all the structure
    ?>
    <footer>
        <p><strong>Author:</strong> Tran Thanh Minh</p>
        <p><strong>Student ID:</strong> 103809048</p>
    </footer>
</body>

</html>