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
            let user = getCookie('user')
            if (!user) {
                window.location = "../../index.php"
                return
            }
            if (user && JSON.parse(user).usertype !== "2") {
                window.location = "./MyFeedback.php"
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
    <link rel="stylesheet" href="../../css/viewfeedback.css" />
    <title>Ceylon Bookings</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <header>All Feedbacks</header>

            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Hotel Name</th>
                        <th>User Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../DbConfig.php';
                    $feedback_query = "SELECT f.title, f.description, h.name AS hotel_name, u.name AS user_name 
                                        FROM feedbacks f 
                                        INNER JOIN hotels h ON f.hotelid = h.hotelid 
                                        INNER JOIN user u ON f.userid = u.userid";
                    $feedback_result = $conn->query($feedback_query);
                    if ($feedback_result && $feedback_result->num_rows > 0) {
                        while ($feedback_row = $feedback_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $feedback_row['title']; ?></td>
                                <td><?php echo $feedback_row['description']; ?></td>
                                <td><?php echo $feedback_row['hotel_name']; ?></td>
                                <td><?php echo $feedback_row['user_name']; ?></td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='4'>No feedbacks found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
