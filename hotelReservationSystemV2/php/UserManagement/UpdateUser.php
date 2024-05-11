<?php
// Include your database connection file
include './UserHeader.php';

require '../DbConfig.php';
// Check if userID is set in the URL
if (isset($_GET['userID'])) {
    // Get the userID from the URL
    $userID = $_GET['userID'];

    // Fetch user details from the database based on userID
    $query = "SELECT * FROM user WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User exists, fetch user data
        $user = $result->fetch_assoc();
        echo '<script language = "javascript">';
        echo '</script>';
        // Check if form is submitted for updating user
        if (isset($_POST['updatebtn'])) {
            echo '<script language = "javascript">';
            echo '</script>';
            // Get updated user information from the form
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobilenumber = $_POST['mobilenumber'];
            $country = $_POST['country'];

            // Update user information in the database
            $updateQuery = "UPDATE user SET name = ?, email = ?, mobilenumber = ?, country = ? WHERE userid = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ssssi", $name, $email, $mobilenumber, $country, $userID);
            $updateStmt->execute();

            // Check if update was successful
            if ($updateStmt->affected_rows > 0) {        
                echo '<script language = "javascript">';
                echo 'alert("User profile updated success");';
                echo 'window.location.replace("./ViewAllUser.php");';
                echo '</script>';
            } else {
                echo '<script language = "javascript">';
                echo 'alert("Error while updating user");';
                echo '</script>';
            }
        }
    } else {
        echo '<script language = "javascript">';
        echo 'alert("User not found");';
        echo 'window.location.replace("./ViewAllUser.php");';
        echo '</script>';
    }
} else {
    echo '<script language = "javascript">';
    echo 'window.location.replace("./ViewAllUser.php");';
    echo '</script>';
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/register&login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="../../css/header.css" />
    <script type="text/javascript" src="../../js/updateuser.js"></script>
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <header>Update Profile</header>
            <form id="registerForm" action="UpdateUser.php?userID=<?php echo $user['userid']; ?>" method="POST" onsubmit="return registrationValidation()">

                <div class="field input">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" required value="<?php echo $user['name']; ?>">
                </div>
                <div class="field input">
                    <label for="email">E-mail Address</label>
                    <input type="email" name="email" id="email" autocomplete="off" required value="<?php echo $user['email']; ?>">
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="tel" name="mobilenumber" id="mobilenumber" autocomplete="off" required value="<?php echo $user['mobilenumber']; ?>">
                </div>
                <div class="field input">
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" autocomplete="off" required value="<?php echo $user['country']; ?>">
                </div>
                <div class="field">
                    <button type="submit" id="updatebtn" name="updatebtn" value="updatebtn" class="btn">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
