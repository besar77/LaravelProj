function togglePasswordVisibility(fieldname) {
    var passwordField = document.getElementById(fieldname);
    var passwordIcon = document.getElementById(fieldname + "Icon");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        passwordIcon.classList.remove("far", "fa-eye");
        passwordIcon.classList.add("far", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        passwordIcon.classList.remove("far", "fa-eye-slash");
        passwordIcon.classList.add("far", "fa-eye");
    }
}
