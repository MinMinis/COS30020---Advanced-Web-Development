<?php
session_set_cookie_params(1800);
session_start();
if (!isset($_SESSION['status'])) {
    $_SESSION['status'] = "";
}
if ($_SESSION['status'] == "logged") {
    $_SESSION['message'] = "<p class=\"remind-message\">You need to logout first</p>";
    header("Location: friendadd.php");
}
$error = array();

if (isset($_POST['submit'])) {              //check if the submit button is pressed
    require_once("function/security.php"); //import function to sanitize input of the user
    $email = sanitize_input($_POST['email']);
    $name = sanitize_input($_POST['name']);
    $password = sanitize_input($_POST['password']);
    $re_password = sanitize_input($_POST['re_password']);
    if (!empty($email) && !empty($name) && !empty($password) && !empty($re_password)) {
        $pattern_mail = '/^[a-z0-9_.+-]+@[a-z0-9-]+\.[a-z]{2,6}$/i';
        if (!preg_match($pattern_mail, $email)) {
            $error[1] = "<p class=\"error-message\">Please enter a valid email address</p>"; // store the error message
        }
        $pattern_name = '/^[a-zA-Z]+$/';
        if (!preg_match($pattern_name, $name)) {
            $error[2] = "<p class=\"error-message\">Name can only contain letters</p>";
        }
        if ($password !== $re_password) {
            $error[3] = "<p class=\"error-message\">Passwords do not match</p>";
        }
        $pattern_pass = '/^[a-zA-Z0-9]+$/';
        if (preg_match($pattern_pass, $password)) {
            if (count($error) == 0) { // check if there is any error
                require_once("settings.php");
                $conn = new mysqli($host, $user, $pswd);
                if ($conn->connect_error) {
                    $error[5] = "Connection failed: " . $conn->connect_error;
                }
                @$conn->select_db($dbnm);
                $stmt = $conn->prepare("SELECT friend_id FROM $table WHERE friend_email = ?"); //prepare statement for getting the table friend
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $error[6] = "<p class=\"error-message\">Email already exists</p>";
                } else {
                    $row = $result->fetch_row();
                }
                if (count($error) == 0) {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $date = date("Y-m-d");
                    $stmt = $conn->prepare("INSERT INTO $table (friend_email, password, profile_name, date_started, num_of_friends) VALUES (?, ?, ?, ?, 0)");
                    $stmt->bind_param("ssss", $email, $password, $name, $date);
                    if ($stmt->execute()) {
                        $conn->close();
                        $_SESSION['email'] = $email;
                        $_SESSION['name'] = $name;
                        $_SESSION['status'] = "logged"; //logged status 
                        $_SESSION['message'] = "<p class=\"success\">You have registered successfully</p>";
                        header("Location: friendadd.php");
                    } else {
                        $error[7] = "Error: " . $stmt->error;
                    }
                }
                $conn->close();
            } else {
                $error[4] = "<p class=\"error-message\">Password must contain letters and characters</p>";
            }
        }
    } else {
        $error[0] = "<p class=\"error-message\">Please fill in all the fields</p>";
    }
    $_SESSION['email'] = $email; // reassign the input email of the user to the session
    $_SESSION['name'] = $name; // reassign the input name of the user to the session
};

if (!isset($_SESSION['email'])) { //check if the session email have set 
    $_SESSION['email'] = "";        // if not then assign it
}
$register_mail = $_SESSION['email']; //assign to the variable for displaying in form
if (!isset($_SESSION['name'])) { //check if the session name have set
    $_SESSION['name'] = "";        // if not then assign it
}
$register_name = $_SESSION['name']; //assign to the variable for displaying in form
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
    <title>Sign Up</title>
</head>

<body>
    <main class="signup-main">
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="signup.php">Register</a>
                <a href="about.php">About</a>
                <div class="nav-signup" id="animation"></div>
            </nav>
            <h1 class="register-head">My Friend System</h1>
        </header>
        <section class=" signup-section">
            <div class="signup-box">
                <div class="form-value">
                    <form action="signup.php" method="post">
                        <h2 class="sign body-head">Register</h2>
                        <?php if (isset($error[0])) echo $error[0]; ?>
                        <?php if (isset($error[5])) echo $error[5]; ?>
                        <?php if (isset($error[7])) echo $error[7]; ?>
                        <div class="input-div">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="text" id="email" name="email" value="<?php echo $register_mail; ?>" />
                            <label class="label" for="email">Email</label>
                        </div>
                        <?php if (isset($error[1])) echo $error[1]; ?>
                        <?php if (isset($error[6])) echo $error[6]; ?>
                        <div class="input-div">
                            <ion-icon name="person-outline"></ion-icon>
                            <input type="text" id="name" name="name" value="<?php echo $register_name; ?>" />
                            <label class="label" for="name">Profile Name</label>
                        </div>
                        <?php if (isset($error[2])) echo $error[2]; ?>

                        <div class="input-div">
                            <ion-icon name="key-outline"></ion-icon>
                            <input type="password" id="password" name="password" />
                            <label class="label" for="password">Password</label>
                        </div>
                        <?php if (isset($error[3])) echo $error[3]; ?>
                        <?php if (isset($error[4])) echo $error[4]; ?>
                        <div class="input-div">
                            <ion-icon name="key-outline"></ion-icon>
                            <input type="password" id="re_password" name="re_password" />
                            <label class="label" for="re_password">Retype Password</label>
                        </div>
                        <input type="submit" class="submit-button" value="Register" name="submit" />
                        <div class="register">
                            <p>Already have an account ? <a href="login.php">Login</a></p>
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