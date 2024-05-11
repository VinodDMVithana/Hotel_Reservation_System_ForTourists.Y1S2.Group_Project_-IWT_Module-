<?php
include './FeedbackHeader.php';

require '../DbConfig.php';

$hotel_query = "SELECT hotelid, name FROM hotels";
$hotel_result = $conn->query($hotel_query);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $feedbackID = $_POST['feedback_id'];
    $title = $_POST['name'];
    $description = $_POST['description'];
    $hotelID = $_POST['hotel'];


    $updateQuery = "UPDATE feedbacks SET title = ?, description = ?, hotelid = ? WHERE feedbackid = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssii", $title, $description, $hotelID, $feedbackID);


    if ($stmt->execute()) {
        echo '<script>alert("Feedback updated successfully."); window.location.href = "MyFeedback.php";</script>';
    } else {
        echo '<script>alert("Error updating feedback.");</script>';
    }


    $stmt->close();
    $conn->close();
}


if (isset($_GET['feedbackID'])) {
    $feedbackID = $_GET['feedbackID'];
    $feedback_query = "SELECT * FROM feedbacks WHERE feedbackid = $feedbackID";
    $feedback_result = $conn->query($feedback_query);
    if ($feedback_result && $feedback_result->num_rows > 0) {
        $feedback_row = $feedback_result->fetch_assoc();
    } else {
        echo '<script>alert("Feedback not found."); window.location.href = "MyFeedback.php";</script>';

        exit;
    }
} else {
    echo '<script>alert("Feedback not found."); window.location.href = "MyFeedback.php";</script>';
    exit;
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
            <header>Update Feedback</header>
            <form id="registerForm" action="UpdateFeedback.php" method="POST">
                <input type="hidden" name="feedback_id" value="<?php echo $feedbackID; ?>">
                <div class="field input">
                    <label for="name">Title</label>
                    <input type="text" name="name" id="name" autocomplete="off" required value="<?php echo $feedback_row['title']; ?>">
                </div>
                <div class="field input">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" autocomplete="off" required value="<?php echo $feedback_row['description']; ?>">
                </div>
                <div class="field select">
                    <label for="hotel">Select Hotel:</label>
                    <select id="hotel" name="hotel" required>
                        <option value="" disabled>Select Hotel</option>
                        <?php
                        if ($hotel_result->num_rows > 0) {
                            while ($row = $hotel_result->fetch_assoc()) {
                                $selected = ($row['hotelid'] == $feedback_row['hotelid']) ? "selected" : "";
                                echo "<option value='" . $row['hotelid'] . "' $selected>" . $row['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
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

