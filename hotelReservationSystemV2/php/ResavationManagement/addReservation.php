<?php
include './ReservationHeader.php';

require '../DbConfig.php';

$userID = isset($_COOKIE['user']) ? json_decode($_COOKIE['user'])->userid : null;

$hotelID = isset($_GET['hotelID']) ? $_GET['hotelID'] : null;

$hotelName = $hotelLocation = $customerName = $mobileNumber = '';

$hotel_query = "SELECT name, location FROM hotels WHERE hotelid = ?";
$stmt_hotel = $conn->prepare($hotel_query);
$stmt_hotel->bind_param("i", $hotelID);
$stmt_hotel->execute();
$stmt_hotel->store_result();

if ($stmt_hotel->num_rows > 0) {
    $stmt_hotel->bind_result($hotelName, $hotelLocation);
    $stmt_hotel->fetch();
} else {
    echo '<script>alert("Hotel not found."); window.location.href = "ViewAllHotels.php";</script>';
    exit;
}

$stmt_hotel->close();

$user_query = "SELECT name, mobilenumber FROM user WHERE userid = ?";
$stmt_user = $conn->prepare($user_query);
$stmt_user->bind_param("i", $userID);
$stmt_user->execute();
$stmt_user->store_result();

if ($stmt_user->num_rows > 0) {
    $stmt_user->bind_result($customerName, $mobileNumber);
    $stmt_user->fetch();
} else {
    echo '<script>alert("User not found."); window.location.href = "../../index.php";</script>';
    exit;
}

$stmt_user->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nic = $_POST['nic'];
    $roomtype = $_POST['roomtype'];
    $bedsize = $_POST['bedsize'];
    $airconditioning = $_POST['airconditioning'];
    $insertQuery = "INSERT INTO resavation (userid, hotelid, nic, roomtype, bedsize, airconditioning) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iissss", $userID, $hotelID, $nic, $roomtype, $bedsize, $airconditioning);

    if ($stmt->execute()) {
        echo '<script>alert("Reservation added successfully."); window.location.href = "./MyReservation.php";</script>';
    } else {
        echo '<script>alert("Error adding reservation.");</script>';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/addReservation.css">

    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>Add New Reservation</header>
            <form id="registerForm" action="addReservation.php?hotelID=<?php echo $_GET['hotelID'] ?>" method="POST">
                <div class="field input">
                    <label for="name">Hotel Name</label>
                    <input type="text" name="name" id="name" autocomplete="off" value="<?php echo $hotelName; ?>" required disabled>
                </div>
                <div class="field input">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" autocomplete="off" value="<?php echo $hotelLocation; ?>" required disabled>
                </div>
                <div class="field input">
                    <label for="customername">Customer Name</label>
                    <input type="text" name="customername" id="customername" autocomplete="off" value="<?php echo $customerName; ?>" required disabled>
                </div>
                <div class="field input">
                    <label for="mobilenumber">Mobile Number</label>
                    <input type="tel" name="mobilenumber" id="mobilenumber" autocomplete="off" value="<?php echo $mobileNumber; ?>" required disabled>
                </div>
                <div class="field input">
                    <label for="nic">NIC / Passport No</label>
                    <input type="text" name="nic" id="nic" autocomplete="off" required>
                </div>
                <div class="field select">
                    <label for="roomtype">Select Room type:</label>
                    <select id="roomtype" name="roomtype" required>
                        <option value="" disabled selected>Select Room type</option>
                        <option value="Room Size 1">Room Size 1</option>
                        <option value="Room Size 2">Room Size 2</option>
                        <option value="Room Size 3">Room Size 3</option>
                        <option value="Room Size 4">Room Size 4</option>
                    </select>
                </div>
                <div class="field select">
                    <label for="bedsize">Select Bed Size:</label>
                    <select id="bedsize" name="bedsize" required>
                        <option value="" disabled selected>Select Bed Size</option>
                        <option value="Bed Size 1">Bed Size 1</option>
                        <option value="Bed Size 2">Bed Size 2</option>
                        <option value="Bed Size 3">Bed Size 3</option>
                        <option value="Bed Size 4">Bed Size 4</option>
                    </select>
                </div>
                <div class="field select">
                    <label for="airconditioning">Air-conditioning Type:</label>
                    <select id="airconditioning" name="airconditioning" required>
                        <option value="" disabled selected>Air-conditioning Type</option>
                        <option value="Air conditioned">Air conditioned</option>
                        <option value="Non-Air conditioned">Non-Air conditioned</option>
                    </select>
                </div>
                <div class="field">
                    <button type="submit" id="submit" name="submit" value="submit" class="btn">Add Reservation</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
