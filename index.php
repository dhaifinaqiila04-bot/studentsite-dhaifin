<?php
session_start();
require_once 'connect.php';

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT ID, Password, role FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userid, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userid;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            
            if($role === 'student'){
                header("Location: student-site.php");
                exit();
            }
            if($role === 'admin') {
                header("Location: admin.php");
                exit();
            }
        } else {
            $login_error = "Wrong password.";
        }
    } else {
        $login_error = "User not found.";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang ="en">
<head>
    <meta charset="UTF-8">
    <title> Sign In </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1> Sign In </h1>
            <form id="login-form" method="POST" action="index.php">
                <div class="input-group">
                    <div class ="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Name"> 
                    </div>
                    <div class ="input-field">
                        <i class="fa-solid fa-envelope icon-left"></i>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </div>
                </div>
            <div class="login-error"><?php echo $login_error; ?></div>
            <button type="submit" class="btn">Sign In</button>
            </form>
            
            <p class="signup-link">
                Don't have an account?
                <a href="http://localhost/Sign%20Up/signup.php">Sign up</a>
            </p>
            <p class="forgot-password-link">
                <a href="http://localhost/Sign%20Up/password.php">Forgot Password?</a>
            </p>
            
        </div>
    </div>
    <script src="login.js"> </script>
</body>
    

        