<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Thanh Minh" />
    <title>Lab 08 Task 2</title>
</head>

<body>
    <h1>Web Programming - Lab08</h1>
    <h2>VIP member Registration System</h2>
    <h3>Add member</h3>
    <form action="member_add.php" method="post">
        <label for="fname">Family name</label>
        <input type="text" name="fname" id="fname" />
        <br>
        <label for="lname">Last name</label>
        <input type="text" name="lname" id="lname" />
        <br>
        <label>Gender</label>
        <input type="radio" name="gender" value="M" id="male" />
        <label for="male">Male</label>
        <input type="radio" name="gender" value="F" id="female" />
        <label for="female">Female</label>
        <br>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" />
        <br>
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" />
        <br>
        <input type="submit" value="submit" />
        <input type="reset" value="reset" />
    </form>
    <p><a href="vip_member.php">Home</a></p>
</body>

</html>