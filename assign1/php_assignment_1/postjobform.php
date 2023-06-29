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
    <title>Post Job Form</title>
</head>

<body>
    <?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('d/m/y');
    $random_id = 'P' . sprintf('%04d', rand(0, 9999));
    // $dir = "./data/jobposts/";
    $dir = "../../data/jobposts/";
    $filename = "job.txt";
    function checkagainst($file, $randomid)
    {
        $new_id = true; //default is true so if can't find the file, so it is unique id and will create the file in the process stage
        if (file_exists($file)) {
            $handle = fopen($file, "r"); // open file
            $data = array(); //create empty array for later push data in
            while (!feof($handle)) { // if it has not reach the last line of the file
                $readhandle = fgets($handle); // get the current line
                $data = explode("\t", $readhandle); // explode data in to array
                if (in_array($randomid, $data)) { // check if there is any same id
                    $new_id = false;
                    break;
                }
            }
            fclose($handle); //close the file
        };
        return $new_id;
    }
    while (checkagainst(($dir . $filename), $random_id) != true) { // keep looping until found the unique ID
        $random_id = 'P' . sprintf('%04d', rand(0, 9999)); //auto generate 4 random digits right after P
    }


    ?>
    <header>
        <h1>Job Vacancy Posting System</h1>
    </header>
    <main class="postjobformmain">
        <form class="postjobform" action="postjobprocess.php" method="post">
            <section class="row">
                <section class="smallblock">
                    <label class="label" for="positionid">Position ID: </label>
                    <input type="text" name="positionid" id="positionid" value=<?php echo $random_id; ?>>
                </section>
                <section class="smallblock">
                    <label class="label" for="title">Title : </label>
                    <input type="text" name="title" id="title">
                </section>
            </section>
            <section class="row">
                <section class="smallblock">
                    <label class="label" for="description">Description : </label><br>
                    <textarea name="description" id="description" cols="50" rows="10"></textarea>
                </section>
                <section class="smallblock">
                    <label class="label" for="closingdate">Closing Date: </label>
                    <input type="text" name="closingdate" id="closingdate" value=<?php echo $date; ?>>
                    <label class="label">Position:</label>
                    <section class="rad_check">
                        <input type="radio" class="job_form_attr" name="position" id="position-f" value="Full Time">
                        <label for="position-f">Full Time</label>
                        <input type="radio" class="job_form_attr" name="position" id="position-p" value="Part Time">
                        <label for="position-p">Part Time</label>
                    </section>
                    <label class="label">Contract: </label>
                    <section class="rad_check">
                        <input type="radio" class="job_form_attr" name="contract" id="contracton" value="On-going">
                        <label for="contracton">On-going</label>
                        <input type="radio" class="job_form_attr" name="contract" id="contractfix" value="Fixed term">
                        <label for="contractfix">Fixed term</label>
                    </section>
                    <label class="label">Application by:</label>
                    <section class="rad_check">
                        <input type="checkbox" class="job_form_attr" id="post" name="post" value="Post">
                        <label for="post">Post</label>
                        <input type="checkbox" class="job_form_attr" id="email" name="email" value="Mail">
                        <label for="email">Mail</label>
                    </section>
                </section>
            </section>
            <section class="row">
                <section class="smallblock">
                    <label class="label" for="location">Location: </label>
                </section>
                <section class="smallblock">
                    <select name="location" id="location">
                        <option class="form_option" value="" selected>---</option>
                        <option class="form_option" value="ACT">ACT</option>
                        <option class="form_option" value="NSW">NSW</option>
                        <option class="form_option" value="NT">NT</option>
                        <option class="form_option" value="QLD">QLD</option>
                        <option class="form_option" value="SA">SA</option>
                        <option class="form_option" value="TAS">TAS</option>
                        <option class="form_option" value="VIC">VIC</option>
                        <option class="form_option" value="WA">WA</option>
                    </select>
                </section>
            </section>
            <section class="row">
                <section class="smallblock">
                    <input class="formbutton" type="submit" name="submit" value="Post">
                </section>
                <section class="smallblock">
                    <input class="formbutton" type="reset" name="reset" value="Reset">
                </section>
            </section>
        </form>
    </main>
    <div class="back_line">
        <p class="job_form_line">All fields are required. <a href="index.php">Return to Home Page</a>.</p>
    </div>
    <footer>
        <p><strong>Author: </strong>Tran Thanh Minh</p>
        <p><strong>Student ID:</strong> 103809048</p>
    </footer>
</body>


</html>