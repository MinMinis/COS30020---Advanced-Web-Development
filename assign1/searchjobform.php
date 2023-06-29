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
    <title>Search Job Form</title>
</head>

<body>
    <header>
        <h1>Job Vacancy Posting System</h1>
    </header>
    <main class="searchformain">
        <article class="searchforarticle">
            <form action="searchjobprocess.php" class="postjobform" id="searchjobform" method="GET">
                <label for="title">Job Title: </label>
                <input type="text" id="title" name="searchterm">
                <section class="row">
                    <section class="rad_check">
                        <input type="checkbox" class="job_form_attr" id="position" name="search_job_crit[]" value="position">
                        <label for="position">Position</label>
                        <input type="checkbox" class="job_form_attr" id="contract" name="search_job_crit[]" value="contract">
                        <label for="contract">Contract</label>
                    </section>
                </section>
                <section class="row">
                    <section class="rad_check">
                        <input type="checkbox" class="job_form_attr" id="location" name="search_job_crit[]" value="location">
                        <label for="location">Location</label>
                        <input type="checkbox" class="job_form_attr" id="application" name="search_job_crit[]" value="application">
                        <label for="application">Application</label>
                    </section>
                </section>
                <input type="submit" class="formbutton" value="Search">
            </form>
        </article>
    </main>
    <article>
        <p>
            <a class="menu-link" href="index.php">Return to Home Page</a>
        </p>
    </article>
    <footer>
        <p><strong>Author:</strong> Tran Thanh Minh</p>
        <p><strong>Student ID:</strong> 103809048</p>
    </footer>
</body>

</html>