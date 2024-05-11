<?php
include './PaymentHeader.php';
require '../DbConfig.php';

$userID = isset($_COOKIE['user']) ? json_decode($_COOKIE['user'])->userid : null;

if (!$userID) {
    // Redirect if user is not logged in
    header("Location: ../../index.php");
    exit;
}

// Check if the delete button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Get the payment ID to be deleted
    $paymentID = $_POST['delete'];

    // SQL query to delete the payment record
    $deleteQuery = "DELETE FROM payment WHERE paymentid = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $paymentID);

    // Execute the delete query
    if ($stmt->execute()) {
        // Redirect to the same page after successful deletion
        header("Location: ./MyPayment.php");
        exit;
    } else {
        // Handle error if deletion fails
        echo '<script>alert("Error deleting payment.");</script>';
    }

    $stmt->close();
}
// SQL query to select payment details for the current user
$sql = "SELECT name, cardnumber, cvv, month, year, userid, paymentid FROM payment WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
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
    <link rel="stylesheet" href="../../css/viewpayment.css" />
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <a href="payment.php" class="add-hotel-button">Add New Card</a>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>CVV</th>
                        <th>Exp Year</th>
                        <th>Exp Month</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result) && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['cardnumber']; ?></td>
                                <td><?php echo $row['cvv']; ?></td>
                                <td><?php echo $row['year']; ?></td>
                                <td><?php echo $row['month']; ?></td>
                                <td class="action-buttons">
                                    <a href="./UpdatePayment.php?paymentID=<?php echo $row['paymentid']; ?>">
                                        <button type="button"><img src="../../assets/edit-text.png" alt="edit" width="16" height="16"></button>
                                    </a>
                                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this card?');" style="margin-top: 10px;">
                                        <input type="hidden" name="delete" value="<?php echo $row['paymentid']; ?>">
                                        <button type="submit" value="delete"><img src="../../assets/delete.png" alt="delete" width="16" height="16"></button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No card details found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
