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

function registrationValidation() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var mobilenumber = document.getElementById('mobilenumber').value;
    var country = document.getElementById('country').value;

    // Validation logic
    if (name.trim() === '') {
        alert('Please enter your name.');
        return false;
    }

    if (email.trim() === '') {
        alert('Please enter your email address.');
        return false;
    }

    if (mobilenumber.trim() === '') {
        alert('Please enter your mobile number.');
        return false;
    }

    if (country.trim() === '') {
        alert('Please enter your country.');
        return false;
    }

    return true;
}