document.addEventListener('DOMContentLoaded', function() {
    let user = getCookie('user')
    if (!user) {
        window.location = "../../index.php"
        return
    }
    if (user && JSON.parse(user).usertype !== "2") {
        window.location = "../../index.php"
        return
    }
});

function getCookie(name) {
 
    var cookieArr = document.cookie.split(";");

    
    for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split("=");

      
        if (name == cookiePair[0].trim()) {
          
            return decodeURIComponent(cookiePair[1]);
        }
    }

   
    return null;
}