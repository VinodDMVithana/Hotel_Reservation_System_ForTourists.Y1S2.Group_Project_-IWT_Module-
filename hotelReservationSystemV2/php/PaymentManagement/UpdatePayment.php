<?php
include './PaymentHeader.php';
require '../DbConfig.php';

// Check if paymentID is provided in URL parameters
if (!isset($_GET['paymentID'])) {
    // Redirect to ViewPayment.php if paymentID is not provided
    header("Location: ./MyPayment.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    // Retrieve form data
    $paymentID = $_POST['paymentID'];
    $name = $_POST['name'];
    $cardnumber = $_POST['cardnumber'];
    $cvv = $_POST['cvv'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // SQL update statement
    $updateQuery = "UPDATE payment SET name = ?, cardnumber = ?, cvv = ?, month = ?, year = ? WHERE paymentid = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssissi", $name, $cardnumber, $cvv, $month, $year, $paymentID);

    // Execute the query
    if ($stmt->execute()) {
        echo '<script>alert("Payment details updated successfully."); window.location.href = "MyPayment.php";</script>';
    } else {
        echo '<script>alert("Error updating payment details.");</script>';
    }

    $stmt->close();
    $conn->close();
}

$paymentID = $_GET['paymentID'];

// Retrieve existing payment details based on paymentID
$sql = "SELECT name, cardnumber, cvv, month, year FROM payment WHERE paymentid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $paymentID);
$stmt->execute();
$result = $stmt->get_result();

// Check if payment record exists
if ($result->num_rows === 0) {
    // Redirect to ViewPayment.php if payment record does not exist
    header("Location: ./MyPayment.php");
    exit;
}

// Fetch existing payment details
$row = $result->fetch_assoc();
$name = $row['name'];
$cardnumber = $row['cardnumber'];
$cvv = $row['cvv'];
$month = $row['month'];
$year = $row['year'];

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ceylon Bookings</title>
    <link rel="stylesheet" href="../../css/payment.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Update Payment Details</h1>
    <form action="UpdatePayment.php?paymentID=<?php echo $_GET['paymentID']; ?>" method="POST">
        <input type="hidden" name="paymentID" value="<?php echo $paymentID; ?>">
        <div class="first-row">
            <div class="owner">
                <h3>Owner*</h3>
                <div class="input-field">
                    <input type="text" name="name" value="<?php echo $name; ?>" required>
                </div>
            </div>
            <div class="cvv">
                <h3>CVV*</h3>
                <div class="input-field">
                    <input type="password" name="cvv" value="<?php echo $cvv; ?>" required pattern="\d{3}" title="CVV must be a 3-digit number">
                </div>
            </div>
        </div>
        <div class="second-row">
            <div class="card-number">
                <h3>Card Number*</h3>
                <div class="input-field">
                    <input type="text" name="cardnumber" value="<?php echo $cardnumber; ?>" required pattern="\d{16}" title="Card number must be a 16-digit number">
                </div>
            </div>
        </div>
        <div class="third-row">
            <h3>Expire Date*</h3>
            <div class="selection">
                <div class="date">
                    <select name="month" id="months" required>
                        <option value="<?php echo $month; ?>" selected><?php echo $month; ?></option>
                        <option value="Jan">Jan</option>
                            <option value="Feb">Feb</option>
                            <option value="Mar">Mar</option>
                            <option value="Apr">Apr</option>
                            <option value="May">May</option>
                            <option value="Jun">Jun</option>
                            <option value="Jul">Jul</option>
                            <option value="Aug">Aug</option>
                            <option value="Sep">Sep</option>
                            <option value="Oct">Oct</option>
                            <option value="Nov">Nov</option>
                            <option value="Dec">Dec</option>
                    </select>
                    <select name="year" id="years" required>
                        <option value="<?php echo $year; ?>" selected><?php echo $year; ?></option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                    </select>
                </div>
                <div class="cards">
                    <img src="../../assets/mc.png" alt="">
                    <img src="../../assets/vi.png" alt="">
                    <img src="../../assets/pp.png" alt="">
                </div>
            </div>
        </div>
        <button type="submit" id="confirm" name="confirm" value="confirm" class="confirm">Update</button>
    </form>
</div>
</body>
</html>
<?php include '../footer.php'; ?>
