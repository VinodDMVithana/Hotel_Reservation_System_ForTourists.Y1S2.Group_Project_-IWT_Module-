<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceylon Bookings</title>
    <link rel="stylesheet" href="./css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="./css/header.css" />
    <script>
    // Function to clear the 'user' cookie
    function logout() {
        document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        // Redirect the user to the home page or any other page after logout
        window.location.href = "./index.php";
    }
</script>
</head>

<body class="homeBody">
    <div class="menu-bar">
        <div class="logo">
            <a href="#"><img class="logo" src="./assets/logo.png"></a>
        </div>
        <ul>
            <li><a href="#">Home</a></li>
            <?php if (isset($_COOKIE['user'])) : ?>
                <?php if (json_decode($_COOKIE['user'])->usertype == "1") : ?>
                    <li><a href="./php/HotelManagement/Hotels.php">Hotels</a></li>
                    <li><a href="./php/FeedbackManagement/MyFeedback.php">My Feedback</a></li>
                    <li><a href="./php/ResavationManagement/MyReservation.php">My Reservations</a></li>
                    <li><a href="./php/PaymentManagement/MyPayment.php">My Payments</a></li>
                <?php elseif (json_decode($_COOKIE['user'])->usertype == "2") : ?>
                    <li><a href="./php/HotelManagement/ViewAllHotels.php">All Hotels</a></li>
                    <li><a href="./php/UserManagement/ViewAllUser.php">All Users</a></li>
                    <li><a href="./php/FeedbackManagement/ViewAllFeedback.php">All Feedback</a></li>
                <?php endif; ?>
                <li><a href="#" onclick="logout()">Log out</a></li>
            <?php else : ?>
                <li><a href="./php/UserManagement/register.php">Sign Up</a></li>
                <li><a href="./php/UserManagement/login.php">Log in</a></li>
            <?php endif; ?>

            <li><a href="./php/joinwithUs.php">Join With Us</a></li>
            <li><a href="./php/contactus.php">Contact Us</a></li>
            <li><a href="./php/privacyPolicy.php">Privacy & Policy</a></li>
            <li><a href="./php/aboutUs.php">About Us</a></li>
        </ul>
    </div>

    <section class="image">
        <div class="banner">
            <img src="./assets/banner4.png" alt="">
        </div>
    </section>
    <section class="maintitle">
        <div class="hometitle">
            <h1>Ceylone <span>Bookings</span>.</h1>
            <p>Welcome to Ceylon Bookings, your passport to the wonders of Sri Lanka. Explore misty highland retreats,
                serene coastal escapes, and vibrant city stays. With our expert guidance and seamless booking process,
                immerse yourself in the rich culture, stunning landscapes, and warm hospitality of Sri Lanka. Let Ceylon
                Bookings be your trusted companion as you embark on a journey of discovery and create cherished memories
                that will last a lifetime
            </p>
        </div>
    </section>
    <section class="cards">
        <div class="card-container">
            <div class="card">
                <img src="./assets/Coastal Elysium.jpg" alt="">
                <div class="card-content">
                    <h2>Coastal <span>Elysium</span>.</h2>
                    <p>
                        Surrender to the allure of Sri Lanka's Coastal Elysium, where hotels grace the sun-kissed
                        shoreline, caressed by the gentle whispers of the Indian Ocean. From the golden sands of Bentota
                        and Unawatuna to the tranquil coves of Mirissa, these coastal havens beckon with
                        promises of blissful escape and exhilarating discovery. our ticket to sun-soaked adventures.
                        Dive into water sports, explore coral reefs, and bask in tropical warmth.
                        Accommodations range from opulent beachfront resorts to intimate seaside villas, offering a
                        seamless fusion of comfort and coastal elegance.
                    </p>
                    <button class="viewbutton">View</button>
                </div>
            </div>
            <div class="card">
                <img src="./assets/Celestial Highland hotels.jpg" alt="">
                <div class="card-content">
                    <h2>Celestial <span>Highlands</span>.</h2>
                    <p>
                        Ascend to the celestial heights of Sri Lanka's Highlands, where hotels perch amidst emerald
                        vistas and misty peaks. Enveloped in an otherworldly aura, destinations like Nuwara Eliya, Ella,
                        and Bandarawela offer a sanctuary of tranquility. Guests can wander through tea-draped
                        landscapes, discover hidden cascades, and immerse themselves in the timeless allure of colonial
                        charm. Accommodations range from cozy chalets to grand manors, each providing a haven of luxury
                        amid the celestial beauty of the highlands.

                    </p>
                    <button class="viewbutton">View</button>
                </div>
            </div>
            <div class="card">
                <img src="./assets/Verdant Sanctuaries.jpg" alt="">
                <div class="card-content">
                    <h2>Verdant <span>Sanctuaries</span>.</h2>
                    <p>
                        Immerse yourself in the verdant embrace of Sri Lanka's Sanctuaries, where hotels are nestled
                        amidst lush foliage, winding streams, and exotic wildlife. Tucked away within the greenery of
                        Kandy, Kitulgala, and Sinharaja, these retreats offer a symphony of nature's wonders.
                        Adventurous spirits can embark on thrilling escapades like river rafting, jungle treks, and
                        birdwatching adventures. Retreat to accommodations that seamlessly blend with the natural
                        surroundings, providing a sanctuary of serenity amidst the vibrant biodiversity of the
                        sanctuaries.

                    </p>
                    <button class="viewbutton">View</button>
                </div>
            </div>
        </div>
    </section>
    <?php include '../hotelReservationSystemV2/php/footer.php'; ?>
</body>

</html>