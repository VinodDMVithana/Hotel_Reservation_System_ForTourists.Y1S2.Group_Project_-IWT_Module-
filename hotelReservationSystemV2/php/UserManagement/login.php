<?php
include './UserHeader.php';

require '../DbConfig.php';
if (isset($_POST['submit'])) {
    $log = $_POST['email'];
    $pword = $_POST['password'];


    // $sql = "SELECT * FROM users WHERE email LIKE '%" . $log . "%' AND password LIKE '%" . $pword . "%'";
    $sql = "SELECT * FROM user WHERE email= '" . $log . "'";
    $result = $conn->query($sql);
    // $data = json_encode($result->user);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_hash = $row['password'];
        if (password_verify($pword, $password_hash)) {
            $cookie_name = "user";

            $sql1 = "SELECT name, userid, usertype, email FROM user WHERE email= '" . $log . "'";
            $result1 = $conn->query($sql1);
            $row1 = $result1->fetch_assoc();

            $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
            $cookie_value = json_encode($row1);
            setcookie($cookie_name, $cookie_value, time() + (86400), '/', $domain, false);
        } else {
            echo '<script language ="javascript">';
            echo 'alert("Incorrect Username or password1")';
            echo '</script>';
        }
    } else {
        echo '<script language ="javascript">';
        echo 'alert("Incorrect Username or password2")';
        echo '</script>';
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/register&login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <script type="text/javascript" src="../../js/login.js"></script>
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">

                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="./register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
