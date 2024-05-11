<?php
include './FeedbackHeader.php';

// Include your database connection file
require '../DbConfig.php';

// Fetch hotel names from the database
$hotel_query = "SELECT hotelid, name FROM hotels";
$hotel_result = $conn->query($hotel_query);


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['name'];
    $description = $_POST['description'];
    $hotelID = $_POST['hotel'];

    // Get user ID from cookie (assuming it's stored as 'user')
    $userID = isset($_COOKIE['user']) ? json_decode($_COOKIE['user'])->userid : null;

    // Prepare INSERT statement
    $insertQuery = "INSERT INTO feedbacks (title, description, userid, hotelid) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssii", $title, $description, $userID, $hotelID);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Feedback added successfully."); window.location.href = "ViewAllFeedback.php";</script>';
    } else {
        echo '<script>alert("Error adding feedback.");</script>';
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
    <link rel="stylesheet" href="../../css/addfeedback.css" />
    <script type="text/javascript" src="../../js/addfeedback.js"></script>
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Add New Feedback</header>
            <form id="registerForm" action="AddNewFeedback.php" method="POST">
                <div class="field input">
                    <label for="name">Title</label>
                    <input type="text" name="name" id="name" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" autocomplete="off" required>
                </div>
                <div class="field select">
                    <label for="hotel">Select Hotel:</label>
                    <select id="hotel" name="hotel" required>
                        <option value="" disabled selected>Select Hotel</option>
                        <?php
                        // Fetch hotel names from the database and populate the dropdown
                        if ($hotel_result->num_rows > 0) {
                            while ($row = $hotel_result->fetch_assoc()) {
                                echo "<option value='" . $row['hotelid'] . "'>" . $row['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
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

