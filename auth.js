function goBack() {
    window.history.back();
}
function validateLogin() {
    let email = document.getElementById("email").value;
    if (email === "") {
        document.getElementById("loginError").innerText = "Wpisz email!";
        return false;
    }
    return true;
}
function validateRegister() {
    let u = document.getElementById("username").value;
    let e = document.getElementById("email").value;
    let p1 = document.getElementById("password").value;
    let p2 = document.getElementById("password2").value;

    if (u === "" || e === "" || p1 === "" || p2 === "") {
        document.getElementById("regError").innerText = "Wszystkie pola są wymagane!";
        return false;
    }

    if (p1 !== p2) {
        document.getElementById("regError").innerText = "Hasła nie są takie same!";
        return false;
    }

    if (p1.length < 6) {
        document.getElementById("regError").innerText = "Hasło musi mieć min. 6 znaków.";
        return false;
    }

    return true;
}
function validateReset() {
    let email = document.getElementById("resetEmail").value;

    if (email === "") {
        document.getElementById("resetError").innerText = "Wpisz email!";
        return false;
    }

    return true;
}
