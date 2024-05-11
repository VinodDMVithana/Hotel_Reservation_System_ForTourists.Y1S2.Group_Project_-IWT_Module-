<?php
include './ReservationHeader.php';
require '../DbConfig.php';

// Check if user is logged in
if (isset($_COOKIE['user'])) {
    $userID = json_decode($_COOKIE['user'], true)['userid'];

    // Fetch reservations for the current user
    $sql = "SELECT r.resavationid, r.hotelid, r.nic, r.roomtype, r.bedsize, r.airconditioning, h.name, h.location FROM resavation r INNER JOIN hotels h ON r.hotelid = h.hotelid  WHERE userid = $userID";
    $result = $conn->query($sql);
}

// Handle reservation deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $reservationID = $_POST['delete'];

    // Prepare DELETE statement
    $deleteQuery = "DELETE FROM resavation WHERE resavationid = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $reservationID);

    // Execute the statement
    if ($stmt->execute()) {
        // If deletion successful, redirect to the same page
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo '<script>alert("Error deleting reservation.");</script>';
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
    <link rel="stylesheet" href="../../css/viewreservation.css" />
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let user = getCookie('user');
            if (!user) {
                window.location = "../../index.php";
                return;
            }
        });

        function getCookie(name) {
            // Split cookie string and get all individual name=value pairs in an array
            var cookieArr = document.cookie.split(";");

            // Loop through the array elements
            for (var i = 0; i < cookieArr.length; i++) {
                var cookiePair = cookieArr[i].split("=");

                /* Removing whitespace at the beginning of the cookie name
                and compare it with the given string */
                if (name == cookiePair[0].trim()) {
                    // Decode the cookie value and return
                    return decodeURIComponent(cookiePair[1]);
                }
            }

            // Return null if not found
            return null;
        }
    </script>
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <table>
                <thead>
                    <tr>
                        <th>Passport/NIC</th>
                        <th>Hotel Name</th>
                        <th>Location</th>
                        <th>Room Type</th>
                        <th>Bed Size</th>
                        <th>Air Condition Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result) && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['nic']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                                <td><?php echo $row['roomtype']; ?></td>
                                <td><?php echo $row['bedsize']; ?></td>
                                <td><?php echo $row['airconditioning']; ?></td>
                                <td class="action-buttons">
                                    <a href="./UpdateReservation.php?reservationID=<?php echo $row['resavationid']; ?>&hotelID=<?php echo $row['hotelid']; ?>">
                                        <button type="button"><img src="../../assets/edit-text.png" alt="edit" width="16" height="16"></button>
                                    </a>
                                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this reservation?');"  style="margin-top: 10px;">
                                        <input type="hidden" name="delete" value="<?php echo $row['resavationid']; ?>">
                                        <button type="submit" value="delete"><img src="../../assets/delete.png" alt="delete" width="16" height="16"></button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='7'>No reservations found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
