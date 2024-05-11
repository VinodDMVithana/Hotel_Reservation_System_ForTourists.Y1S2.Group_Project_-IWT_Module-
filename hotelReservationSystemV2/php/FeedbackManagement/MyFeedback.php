<?php
include './FeedbackHeader.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="../../css/viewfeedback.css" />
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>My Feedbacks</header>
            <a href="AddNewFeedback.php" class="add-hotel-button">Add New Feedback</a>

            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Hotel Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../DbConfig.php';
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
                        $feedbackID = $_POST['delete'];
                        $deleteQuery = "DELETE FROM feedbacks WHERE feedbackid = ?";
                        $stmt = $conn->prepare($deleteQuery);
                        $stmt->bind_param("i", $feedbackID);
                        if ($stmt->execute()) {
                            echo '<script>alert("Feedback deleted successfully."); window.location.href = "MyFeedback.php";</script>';
                        } else {
                            echo '<script>alert("Error deleting feedback.");</script>';
                        }
                    }
                    $user_id = isset($_COOKIE['user']) ? json_decode($_COOKIE['user'], true)['userid'] : null;
                    $feedback_query = "SELECT f.feedbackid as feedbackid, f.title, f.description, h.name AS hotel_name, u.name AS user_name 
                                        FROM feedbacks f 
                                        INNER JOIN hotels h ON f.hotelid = h.hotelid 
                                        INNER JOIN user u ON f.userid = u.userid 
                                        WHERE f.userid = ?";
                    $stmt = $conn->prepare($feedback_query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $feedback_result = $stmt->get_result();
                    if ($feedback_result->num_rows > 0) {
                        while ($feedback_row = $feedback_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $feedback_row['title']; ?></td>
                                <td><?php echo $feedback_row['description']; ?></td>
                                <td><?php echo $feedback_row['hotel_name']; ?></td>
                                <td class="action-buttons">
                                    <a href="./UpdateFeedback.php?feedbackID=<?php echo $feedback_row['feedbackid']; ?>">
                                        <button type="submit" value="editBtn"><img src="../../assets/edit-text.png" alt="edit" width="16" height="16"></button>
                                    </a>
                                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this feedback?');" style="margin-top: 10px;">
                                        <input type="hidden" name="delete" value="<?php echo $feedback_row['feedbackid']; ?>">
                                        <button type="submit" value="delete"><img src="../../assets/delete.png" alt="delete" width="16" height="16"></button>
                                    </form>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='5'>No feedbacks found.</td></tr>";
                    }
                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
