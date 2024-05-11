<?php
    include './UserHeader.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/register&login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="../../css/header.css" />
    <script type="text/javascript" src="../../js/register.js"></script>
    <title>Ceylon Bookings</title>
</head>
    <div class="container">
        <div class="box form-box">

            <header>Sign Up</header>
            <form id="registerForm" action="register.php" method="POST" onsubmit="return registrationValidation(event)">

                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">E-mail Address</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="repassword">Re-enter Password</label>
                    <input type="password" name="repassword" id="repassword" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="tel" name="mobilenumber" id="mobilenumber" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" autocomplete="off" required>
                </div>
                <div class="field">
                    <button type="submit" id="registerbtn" name="registerbtn" value="registerbtn" class="btn">Register</button>
                </div>

                <div class="links">
                    Already a member? <a href="./login.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>

    <?php
    require '../DbConfig.php';

    // Check if the form is submitted
    if (isset($_POST['registerbtn'])) {
        // Retrieve form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobilenumber = $_POST['mobilenumber'];
        $country = $_POST['country'];
        $createdDate = date('Y-m-d H:i:s');
        $hasedPass = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $validaton = "SELECT * FROM user WHERE email= '" . $email . "'";
        $result = $conn->query($validaton);
        if ($result) {
            if ($result->num_rows > 0) {
                echo '<script language = "javascript">';
                echo 'alert("Email Already Exists :( ")';
                echo '</script>';
            } else {
                // SQL query to insert data into the database
                $sql = "INSERT INTO user (userid,name, email, password, mobilenumber, country, usertype, created_date)
                VALUES (0,'$name', '$email', '$hasedPass', '$mobilenumber', '$country', 1, '$createdDate')";

                if ($conn->query($sql) === TRUE) {
                    echo '<script language = "javascript">';
                    echo 'success()';
                    echo '</script>';
                } else {
                    echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
                }
            }
        }
    }

    // Close connection
    $conn->close();
    ?>
</body>

</html>
<?php include '../footer.php'; ?>
