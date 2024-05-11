<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <!-- <link rel="stylesheet" href="../css/header.css" /> -->
    <style>
        :root {
            --color-primary: #0dc44a;
            --color-white: #e9e9e9;
            --color-black: #141d28;
            --color-black-1: #212b38;
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: monospace;
        }

        .header-body {
            font-family: sans-serif;

        }

        .logo {
            color: var(--color-white);
            font-size: 30px;
            font-family: monospace;
        }

        .logo span {
            color: var(--color-primary);
        }

        .menu-bar {
            background-color: var(--color-black);
            height: 80px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;

            position: relative;
        }

        .menu-bar ul {
            list-style: none;
            display: flex;
        }

        .menu-bar ul li {
            /* width: 120px; */
            padding: 10px 20px;
            /* text-align: center; */

            position: relative;
        }

        .menu-bar ul li a {
            font-size: 20px;
            color: var(--color-white);
            text-decoration: none;

            transition: all 0.3s;
        }

        .menu-bar ul li a:hover {
            color: var(--color-primary);
        }

        .fas {
            float: right;
            margin-left: 10px;
            padding-top: 3px;
        }

        .signup-login {
            margin-left: 10px;
        }

        .logo {
            width: 25%;
            height: 100%;
            margin-top: 3px;
        }
    </style>
    <script>
        // Function to clear the 'user' cookie
        function logout() {
            document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            // Redirect the user to the home page or any other page after logout
            window.location.href = "../../index.php";
        }
    </script>
</head>

<body class="header-body">
    <div class="menu-bar">
        <div class="logo">
            <a href="../../index.php"><img class="logo" src="../../assets/logo.png"></a>
        </div>
        <ul>
            <li><a href="../../index.php">Home</a></li>
            <?php if (isset($_COOKIE['user'])) : ?>
                <?php if (json_decode($_COOKIE['user'])->usertype == "1") : ?>
                    <li><a href="../HotelManagement/Hotels.php">Hotels</a></li>
                    <li><a href="../FeedbackManagement/MyFeedback.php">My Feedback</a></li>
                    <li><a href="../ResavationManagement/MyReservation.php">My Reservations</a></li>
                    <li><a href="../PaymentManagement/MyPayment.php">My Payments</a></li>
                <?php elseif (json_decode($_COOKIE['user'])->usertype == "2") : ?>
                    <li><a href="../HotelManagement/ViewAllHotels.php">All Hotels</a></li>
                    <li><a href="./ViewAllUser.php">All Users</a></li>
                    <li><a href="../FeedbackManagement/ViewAllFeedback.php">All Feedback</a></li>
                <?php endif; ?>
                <li><a href="#" onclick="logout()">Log out</a></li>
            <?php else : ?>
                <li><a href="./register.php">Sign Up</a></li>
                <li><a href="./login.php">Log in</a></li>
            <?php endif; ?>

            <li><a href="../joinwithUs.php">Join With Us</a></li>
            <li><a href="../contactus.php">Contact Us</a></li>
            <li><a href="../privacyPolicy.php">Privacy & Policy</a></li>
            <li><a href="../aboutUs.php">About Us</a></li>
        </ul>
    </div>


</body>

</html>
