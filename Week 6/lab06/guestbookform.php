<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab06 - Task 2</title>
</head>

<body>
    <h1>Lab06 Task 2 - Guestbook</h1>
    <h2>Sign Guestbook</h2>
    <hr>
    <form action="guestbooksave.php" method="post">
        <fieldset>
            <legend>Enter your details to sign our guest book</legend>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
            <br>
            <input type="submit" name="submit" value="Sign">
            <input type="reset" name="reset" value="Reset Form">
        </fieldset>
    </form>
    <hr>
    <br>
    <a href="guestbookshow.php">View Guest Book</a>
</body>

</html>