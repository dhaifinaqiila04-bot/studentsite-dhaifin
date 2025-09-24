const newUsername = document.getElementsByName('newusername')[0];
const newPassword = document.getElementsByName('newpassword')[0];
const samePassword = document.getElementsByName('samepassword')[0];
const form = document.getElementById('form');

const usernameError = document.getElementById('username-error');
const passwordError = document.getElementById('password-error');
const confirmError = document.getElementById('confirm-error');

form.addEventListener('submit', (e) => {
    let hasError = false;

    usernameError.innerText = '';
    passwordError.innerText = '';
    confirmError.innerText = '';

    if (newUsername.value.trim() === '') {
        usernameError.innerText = "Insert your username";
        hasError = true;
    } else if (newUsername.value.length > 20) {
        usernameError.innerText = "Username too long";
        hasError = true;

    } else if (newUsername.value.length < 5) {
        usernameError.innerText = "Username too short";
        hasError = true;
    }
    if (newPassword.value === '') {
        passwordError.innerText = "Enter a password";
        hasError = true;
    } else if (newPassword.value.length < 6) {
        passwordError.innerText = "Password too short";
        hasError = true;
    } else if (newPassword.value.length > 20) {
        passwordError.innerText = "Password too long";
        hasError = true;
    }

    if (samePassword.value !== newPassword.value) {
        confirmError.innerText = "Passwords do not match";
        hasError = true;
    }

    if (hasError) {
        e.preventDefault();
    }
});
