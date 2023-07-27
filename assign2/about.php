<?php
session_start();
if (!isset($_SESSION['status'])) { // check if the session status is set or not
    $_SESSION['status'] = "";
}
?>

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
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="signup.php">Register</a>
                <a href="about.php">About</a>
                <div class="nav-about" id="animation"></div>
            </nav>
            <h1>My Friend System</h1>
        </header>
        <div class="about-div">
            <ul>
                <li>What tasks I have not attempted or not completed ?</li>
                <ul>
                    <li>
                        I have done all the required tasks and also implement some features that are not included.
                    </li>
                </ul>

                <li>What special features have I done or attempted in creating site that you should know about ?
                </li>
                <ul>
                    <li>
                        I have done the mutual friends part where the add page will show number of mutual friends
                    </li>
                    <li>
                        I have done the part that view the current user profile and can delete the account (which is
                        quite the same with the nowadays implemented features on the social media like Facebook).
                    </li>
                    <li>
                        I also have done the part where the user can view the friend list of current user friend. I also
                        made it so that the current user can't see themselves in the list but the displayed number of
                        total friend is correct.
                    </li>
                </ul>
                <li>Which parts did I have trouble with ? </li>
                <ul>
                    <li>
                        I have trouble with SQL query to get the right result and I have to try many time to get the
                        suitable SQL query.
                    </li>
                    <li>
                        I also have trouble with optimizing the query when I am not sure about how to optimize the query
                        in the most effective way.
                    </li>
                </ul>
                <li>What would I like to do better next time?</li>
                <ul>
                    <li>
                        I will implement more features like friend request, public/private account, request
                        notification.
                    </li>
                    <li>
                        I will also improve the design of the website so that the user can have a more user-friendly
                        interface.
                    </li>
                    <li>
                        I would like to make a big improvement for the SQL query for optimizing and boosting up the
                        process of taking the data out of the database.
                    </li>
                </ul>
                <li>Additional features did I add to the assignment ?</li>
                <ul>
                    <li>
                        I have added show all friend of current user's friend which is not included the current user
                        name on <a href="friendlist.php">Friend List Page.</a>
                    </li>
                    <li>
                        I have added feature of deleting account on page <a href="profile.php">Profile Page</a> for
                        easier to test whenever the system is working well
                        or not. Furthermore, this feature make the system more realistic.
                    </li>
                    <li>
                        I have added feature of printing out the message for better user experience by using
                        $_SESSION['message'] on page <a href="friendlist.php">Friend List Page</a> and
                        <a href="friendadd.php">Add Friend Page</a> for letting the current user know that what
                        action they just have done.

                    </li>

                </ul>
                <li>Screenshot of discussion response</li>
                <ul>
                    <li>
                        Question: Could you share instances / examples where we might apply destructors and magic
                        methods in practical applications?
                    </li>
                    <li>
                        <img src="images/evidence.png" alt="evidence of discussion" class="evidence" />
                    </li>
                </ul>
            </ul>
        </div>
    </main>
</body>

</html>