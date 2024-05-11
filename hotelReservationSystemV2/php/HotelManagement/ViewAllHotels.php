<?php
include './HotelHeader.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let user = getCookie('user')
            if (!user) {
                window.location = "../../index.php"
                return
            }
            if (user && JSON.parse(user).usertype !== "2") {
                window.location = "../../index.php"
                return
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="../../css/viewhotel.css" />
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <a href="AddNewHotel.php" class="add-hotel-button">Add New Hotel</a>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Mobile Number</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../DbConfig.php';

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
                        $hotelID = $_POST['delete'];
                        $deleteQuery = "DELETE FROM hotels WHERE hotelid = ?";
                        $stmt = $conn->prepare($deleteQuery);
                        $stmt->bind_param("i", $hotelID);
                        if ($stmt->execute()) {
                            echo '<script>alert("Hotel deleted successfully."); window.location.href = "ViewAllHotels.php";</script>';
                        } else {
                            echo '<script>alert("Error deleting hotel.");</script>';
                        }
                    }
                    $acc_sql = "SELECT * FROM hotels";
                    $acc_result = $conn->query($acc_sql);
                    if ($acc_result) {
                        if ($acc_result->num_rows > 0) {
                            while ($acc_row = $acc_result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $acc_row['name']; ?></td>
                                    <td><?php echo $acc_row['description']; ?></td>
                                    <td><?php echo $acc_row['mobilenumber']; ?></td>
                                    <td><?php echo $acc_row['location']; ?></td>
                                    <td class="action-buttons">
                                        <a href="./UpdateHotel.php?hotelID=<?php echo $acc_row['hotelid']; ?>">
                                            <button type="submit" value="editBtn"><img src="../../assets/edit-text.png" alt="edit" width="16" height="16"></button>
                                        </a>
                                        <form method="post" onsubmit="return confirm('Are you sure you want to delete this hotel?');" style="margin-top: 10px;">
                                            <input type="hidden" name="delete" value="<?php echo $acc_row['hotelid']; ?>">
                                            <button type="submit" value="delete"><img src="../../assets/delete.png" alt="delete" width="16" height="16"></button>
                                        </form>
                                    </td>
                                </tr>
                    <?php }
                        }
                    } ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
