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
    <title>About Page</title>
</head>

<body>
    <main>
        <header>
            <h1>Job Vacancy Posting System</h1>
        </header>
        <article>
            <ol class="about_ol">
                <li class="about_ques">
                    What is the PHP version installed in mercury?
                </li>
                <ul>
                    <li>My PHP version is: <strong><?php echo phpversion() ?></strong>. I have used phpversion() to get
                        and echo it out.
                    </li>
                </ul>
                <hr>
                <li class="about_ques">
                    What tasks you have not attempted or not completed?
                </li>
                <ul>
                    <li>I didn't make the UI of my system look too attractive. I just keep it simple. I also didn't too
                        focus on the responsive design so that it may appear weird in some devices.</li>
                </ul>
                <hr>
                <li class="about_ques">
                    What special features have you done, or attempted, in creating the site that we should know about?
                </li>
                <ul>
                    <li>
                        I have done the auto generate unique ID for the <a href="postjobform.php">post job form</a>
                        whenever the user refresh the page or go to this site,
                        a new unique ID will be generate and will check against the file line by line to check if the ID
                        is unique or not.
                    </li>
                    <li>
                        I have done the search job form so that if the user check any checkbox, the system will only
                        file the search term word for that criteria. Furthermore, if the user don't check any checkbox
                        then the system will search for that string in all criteria.
                    </li>
                </ul>
                <hr>
                <li class="about_ques">
                    What discussion points did you participated on in the unit’s discussion board for
                    Assignment 1? If you did not participate, state your reason.
                </li>
                <ul>
                    <li>
                        <img src="./css/evidence.png" id="evidence" alt="Evidence of not joining discussion point" />
                    </li>
                    <li>
                        I didn't join any discussion point in the unit's discussion board because throughout the process
                        of doing the lab, I have understood the use of the built-in function of PHP so that I can
                        research a little bit beyond that to apply to the Assignment 1.
                    </li>
                </ul>
            </ol>
            <hr>
            <a class="menu-link" href="index.php">Return to Home Page</a>
        </article>
    </main>
    <footer>
        <p><strong>Author:</strong> Tran Thanh Minh</p>
        <p><strong>Student ID:</strong> 103809048</p>
    </footer>
</body>

</html>