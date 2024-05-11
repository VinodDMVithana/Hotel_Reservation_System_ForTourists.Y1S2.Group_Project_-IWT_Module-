<?php
// Include your database connection file
include './HotelHeader.php';
require '../DbConfig.php';

// Check if hotel ID is provided in the URL
if (isset($_GET['hotelID'])) {
    // Get the hotel ID from the URL
    $hotelID = $_GET['hotelID'];

    // Fetch hotel details from the database based on hotel ID
    $query = "SELECT * FROM hotels WHERE hotelid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $hotelID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if hotel exists
    if ($result->num_rows > 0) {
        // Hotel exists, fetch hotel data
        $hotel = $result->fetch_assoc();

        // Check if form is submitted for updating hotel
        if (isset($_POST['submit'])) {
            // Get updated hotel information from the form
            $name = $_POST['name'];
            $description = $_POST['description'];
            $mobilenumber = $_POST['mobilenumber'];
            $location = $_POST['location'];

            // Prepare UPDATE statement
            $updateQuery = "UPDATE hotels SET name = ?, description = ?, mobilenumber = ?, location = ? WHERE hotelid = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ssssi", $name, $description, $mobilenumber, $location, $hotelID);
            $updateStmt->execute();

            // Check if update was successful
            if ($updateStmt->affected_rows > 0) {
                echo '<script>alert("Hotel updated successfully."); window.location.href = "ViewAllHotels.php";</script>';
            } else {
                echo '<script>alert("Error updating hotel.");</script>';
            }
        }
    } else {
        echo '<script>alert("Hotel not found."); window.location.href = "ViewAllHotels.php";</script>';
    }
} else {
    echo '<script>alert("Invalid request."); window.location.href = "ViewAllHotels.php";</script>';
}

// Close connection
$conn->close();
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
            <header>Update Hotel</header>
            <form id="updateForm" action="UpdateHotel.php?hotelID=<?php echo $hotel['hotelid']; ?>" method="POST">
                <div class="field input">
                    <label for="name">Hotel Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" required value="<?php echo $hotel['name']; ?>">
                </div>
                <div class="field input">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" autocomplete="off" required value="<?php echo $hotel['description']; ?>">
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="tel" name="mobilenumber" id="mobilenumber" autocomplete="off" required value="<?php echo $hotel['mobilenumber']; ?>">
                </div>
                <div class="field input">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" autocomplete="off" required value="<?php echo $hotel['location']; ?>">
                </div>
                <div class="field">
                    <button type="submit" id="submit" name="submit" value="submit" class="btn">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>

