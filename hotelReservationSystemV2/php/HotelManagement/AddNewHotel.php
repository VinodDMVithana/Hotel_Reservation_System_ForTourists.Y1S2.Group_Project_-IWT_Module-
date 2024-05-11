<?php
include './HotelHeader.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require '../DbConfig.php';

    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $mobilenumber = $_POST['mobilenumber'];
    $location = $_POST['location'];

    // Prepare INSERT statement
    $insertQuery = "INSERT INTO hotels (name, description, mobilenumber, location) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $name, $description, $mobilenumber, $location);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Hotel added successfully."); window.location.href = "ViewAllHotels.php";</script>';
    } else {
        echo '<script>alert("Error adding hotel.");</script>';
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="../../css/addhotel.css" />
    <script type="text/javascript" src="../../js/addhotel.js"></script>
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Add New Hotel</header>
            <form id="registerForm" action="AddNewHotel.php" method="POST">
                <div class="field input">
                    <label for="name">Hotel Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="tel" name="mobilenumber" id="mobilenumber" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" autocomplete="off" required>
                </div>
                <div class="field">
                    <button type="submit" id="submit" name="submit" value="submit" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
