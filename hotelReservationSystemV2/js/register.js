function registrationValidation(e) {
    // e.preventDefault()
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var repassword = document.getElementById('repassword').value;
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

    if (password.trim() === '') {
        alert('Please enter a password.');
        return false;
    }

    if (password !== repassword) {
        alert('Passwords do not match.');
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

function success() {
    alert("Register Successfully")
    window.location = './login.php'
}

document.addEventListener('DOMContentLoaded', function () {
    let user = getCookie('user')
    if (user) {
        window.location = "../../index.php"
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