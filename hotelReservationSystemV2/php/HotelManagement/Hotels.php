<?php
include './HotelHeader.php';

// Include your database connection file
require '../DbConfig.php';

// Fetch hotel data from the database
$hotels_query = "SELECT * FROM hotels";
$hotels_result = $conn->query($hotels_query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ceylon Bookings</title>
    <link rel="stylesheet" href="../../css/hotels.css">
</head>

<body>
    <div class="main">
        <?php
        // Check if hotels are fetched successfully
        if ($hotels_result && $hotels_result->num_rows > 0) {
            // Iterate over each hotel data to generate cards
            while ($hotel_row = $hotels_result->fetch_assoc()) {
        ?>
                <!-- Card for each hotel -->
                <div class="card">
                    <div class="image">
                        <img src="../../assets/hotel.jpg" alt="<?php echo $hotel_row['name']; ?>">
                    </div>
                    <div class="title">
                        <h1><?php echo $hotel_row['name']; ?></h1>
                    </div>
                    <div class="des">
                        <p><?php echo $hotel_row['description']; ?></p>
                        <form method="post" action="../ResavationManagement/addReservation.php?hotelID=<?php echo $hotel_row['hotelid']; ?>">
                            <button type="submit">Book Now</button>
                        </form>
                    </div>
                </div>
        <?php
            }
        } else {
            // If no hotels found in the database
            echo "<p>No hotels found.</p>";
        }
        ?>
    </div>
</body>

</html>
<?php include '../footer.php'; ?>
