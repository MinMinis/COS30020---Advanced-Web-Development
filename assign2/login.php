<?php
session_set_cookie_params(1800);
session_start();
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = ""; // if the status is not set yet
}
if ($_SESSION['status'] == "logged") {
    $_SESSION['message'] = "<p class=\"remind-message\">You need to logout first</p>";
    header("Location: friendlist.php");
}
$error = array(); // array of error message to be printed out 

if (isset($_POST['submit'])) {
    require("function/security.php"); //import the sanitize input function
    $email = sanitize_input($_POST['email']); // remove unnecessary characters
    $password = sanitize_input($_POST['password']);
    if (empty($email)) { // check if the user leave the field email empty
        $error[0] = "<p class=\"error-message\">Please fill email</p>"; // error message is stored to be printed out
    }
    if (empty($password)) { // check if the user leave the field password empty
        $error[1] = "<p  class=\"error-message\">Please fill in password</p>";
    }
    if (count($error) == 0) { // if there is not error occur
        require("settings.php"); //import credentials for connect to db
        $conn = new mysqli($host, $user, $pswd);
        if ($conn->connect_error) {
            $error[3] = "Connection failed: " . $conn->connect_error;
        }
        @$conn->select_db($dbnm);
        $stmt = $conn->prepare("SELECT password, profile_name FROM $table WHERE friend_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_row();
            if ($password == $row[0]) {
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $row[1];
                $_SESSION['status'] = "logged";
                $_SESSION['message'] = "<p class=\"success\">Login Successfully</p>";
                header("Location: friendlist.php");
            } else {
                $error[5] = "<p class=\"error-message\">Incorrect password</p>";
            }
        } else {
            $error[4] = "<p class=\"error-message\">Invalid email</p>";
        }
        $conn->close();
    }
    $_SESSION['email'] = $email; // set the input email to the session email
}


if (!isset($_SESSION['email'])) { //check if the session email have set 
    $_SESSION['email'] = "";        // if not then assign it
}
$email = $_SESSION['email']; //assign to the variable for displaying in form

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
    <title>Login</title>
</head>

<body>
    <main class="login-main">
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="signup.php">Register</a>
                <a href="about.php">About</a>
                <div class="nav-login" id="animation"></div>
            </nav>
            <h1 class="register-head">My Friend System</h1>
        </header>
        <section class="login-section">
            <div class="form-box">
                <div class="form-value">
                    <form action="login.php" autocomplete="off" method="post">
                        <h2 class="sign body-head">Login</h2>
                        <?php
                        // print the error message
                        if (isset($error[3])) echo $error[3];
                        if (isset($error[4])) echo $error[4];
                        if (isset($error[5])) echo $error[5];
                        if (isset($error[1])) echo $error[1];
                        ?>
                        <div class="input-div">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="text" name="email" id="email" value="<?php echo $email ?>" />
                            <label class="label" for="email">Email</label>
                        </div>
                        <?php if (isset($error[0])) echo $error[0]; ?>
                        <div class="input-div">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" name="password" id="password" />
                            <label class="label" for="password">Password</label>
                        </div>
                        <input class="submit-button" type="submit" value="Login" name="submit" />
                        <div class="register">
                            <p>Don't have an account yet ? <a href="signup.php">Register</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>

</html>