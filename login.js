
const loginError = document.getElementById("login-error");
const form = document.getElementById("login-form");

loginError.innerText = ""; 

form.addEventListener('submit', (e) => {
  const usernameInput = document.getElementById("username").value.trim();
  const passwordInput = document.getElementById("password").value;
  
  let hasError = false;
  loginError.innerText = ""; 

  if (usernameInput === '' || passwordInput === ''){
    loginError.innerText = "Insert your username or password";
    hasError = true;
  }
  
  if (hasError) {
    e.preventDefault(); 
    return;
  }
});
