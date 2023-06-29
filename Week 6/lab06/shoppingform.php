<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab06 - Task 1</title>
</head>

<body>
    <h1>Web Programming Form - Lab06</h1>
    <hr>
    <form action="shoppingsave.php" method="post">
        <label for="item">Name:</label>
        <input type="text" name="item" id="item">
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity">
        <br>
        <input type="submit" name="submit" value="Sign">
        <input type="reset" name="reset" value="Reset Form">
    </form>
</body>

</html>