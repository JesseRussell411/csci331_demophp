const passwordField = document.getElementById("password_field");
const confirmPasswordField = document.getElementById("confirm_password_field");
const submitButton = document.getElementById("submit_button");

function checkMatch(){
    if (passwordField.value === confirmPasswordField.value){
        passwordField.style.backgroundColor = "initial";
        confirmPasswordField.style.backgroundColor = "initial";
        submitButton.disabled = false;
    }
    else {
        passwordField.style.backgroundColor = "rgb(240, 140, 140)";
        confirmPasswordField.style.backgroundColor = "rgb(240, 140, 140)";
        submitButton.disabled = true;
    }
}

passwordField.addEventListener("change", checkMatch);
confirmPasswordField.addEventListener("change", checkMatch);
