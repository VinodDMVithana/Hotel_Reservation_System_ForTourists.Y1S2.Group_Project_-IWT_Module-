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

$reservationID = isset($_GET['reservationID']) ? $_GET['reservationID'] : null;

if ($reservationID) {
    $reservation_query = "SELECT nic, roomtype, bedsize, airconditioning FROM resavation WHERE resavationid = ?";
    $stmt_reservation = $conn->prepare($reservation_query);
    $stmt_reservation->bind_param("i", $reservationID);
    $stmt_reservation->execute();
    $stmt_reservation->store_result();

    if ($stmt_reservation->num_rows > 0) {
        $stmt_reservation->bind_result($nic, $roomtype, $bedsize, $airconditioning);
        $stmt_reservation->fetch();
    } else {
        echo '<script>alert("Reservation not found."); window.location.href = "./MyReservation.php";</script>';
        exit;
    }

    $stmt_reservation->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nic = $_POST['nic'];
    $roomtype = $_POST['roomtype'];
    $bedsize = $_POST['bedsize'];
    $airconditioning = $_POST['airconditioning'];

    if ($reservationID) {

        $updateQuery = "UPDATE resavation SET nic = ?, roomtype = ?, bedsize = ?, airconditioning = ? WHERE resavationid = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssi", $nic, $roomtype, $bedsize, $airconditioning, $reservationID);
        if ($stmt->execute()) {
            echo '<script>alert("Reservation updated successfully."); window.location.href = "./MyReservation.php";</script>';
        } else {
            echo '<script>alert("Error updating reservation.");</script>';
        }
    } else {

        echo '<script>alert("Reservation not found."); window.location.href = "MyReservation.php";</script>';

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
            <header>Update Reservation</header>
            <form id="registerForm" action="UpdateReservation.php?hotelID=<?php echo $hotelID; ?><?php echo $reservationID ? '&reservationID='.$reservationID : ''; ?>" method="POST">
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
                    <input type="text" name="nic" id="nic" autocomplete="off" value="<?php echo $nic ?? ''; ?>" required>
                </div>
                <div class="field select">
                    <label for="roomtype">Select Room type:</label>
                    <select id="roomtype" name="roomtype" required>
                        <option value="" disabled>Select Room type</option>
                        <option value="Room Size 1" <?php echo ($roomtype == 'Room Size 1') ? 'selected' : ''; ?>>Room Size 1</option>
                        <option value="Room Size 2" <?php echo ($roomtype == 'Room Size 2') ? 'selected' : ''; ?>>Room Size 2</option>
                        <option value="Room Size 3" <?php echo ($roomtype == 'Room Size 3') ? 'selected' : ''; ?>>Room Size 3</option>
                        <option value="Room Size 4" <?php echo ($roomtype == 'Room Size 4') ? 'selected' : ''; ?>>Room Size 4</option>
                    </select>
                </div>
                <div class="field select">
                    <label for="bedsize">Select Bed Size:</label>
                    <select id="bedsize" name="bedsize" required>
                        <option value="" disabled>Select Bed Size</option>
                        <option value="Bed Size 1" <?php echo ($bedsize == 'Bed Size 1') ? 'selected' : ''; ?>>Bed Size 1</option>
                        <option value="Bed Size 2" <?php echo ($bedsize == 'Bed Size 2') ? 'selected' : ''; ?>>Bed Size 2</option>
                        <option value="Bed Size 3" <?php echo ($bedsize == 'Bed Size 3') ? 'selected' : ''; ?>>Bed Size 3</option>
                        <option value="Bed Size 4" <?php echo ($bedsize == 'Bed Size 4') ? 'selected' : ''; ?>>Bed Size 4</option>
                    </select>
                </div>
                <div class="field select">
                    <label for="airconditioning">Air-conditioning Type:</label>
                    <select id="airconditioning" name="airconditioning" required>
                        <option value="" disabled>Select Air-conditioning Type</option>
                        <option value="Air conditioned" <?php echo ($airconditioning == 'Air conditioned') ? 'selected' : ''; ?>>Air conditioned</option>
                        <option value="Non-Air conditioned" <?php echo ($airconditioning == 'Non-Air conditioned') ? 'selected' : ''; ?>>Non-Air conditioned</option>
                    </select>
                </div>
                <div class="field">
                    <button type="submit" id="submit" name="submit" value="submit" class="btn">Update Reservation</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
