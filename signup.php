<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['newusername']);
  $jurusan = trim($_POST['jurusan']);
  $password = $_POST['newpassword'];
  $confirmpassword = $_POST['samepassword'];

  $currentYear = date('Y');
  $npmPrefix = $currentYear;

  $stmt = $conn->prepare("SELECT npm FROM users WHERE npm LIKE ? ORDER BY npm DESC LIMIT 1");
  $likePattern = $npmPrefix . '%';
  $stmt->bind_param("s", $likePattern);
  $stmt->execute();
  $stmt->store_result();

  $newNpmSuffix = '0001';
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($existingNpm);
    $stmt->fetch();
    $existingNpmSuffix = substr($existingNpm, -4);
    $newNpmSuffix = str_pad((int)$existingNpmSuffix + 1, 4, '0', STR_PAD_LEFT);
  }
  $newNpm = $npmPrefix . $newNpmSuffix;
  $stmt->close();

  $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    $stmt->close();
    die("Username already taken.");
  }
  $stmt->close();

  $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $conn->prepare("INSERT INTO users (username, password, jurusan, npm) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $username, $hashedpassword, $jurusan, $newNpm);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "Sign up successful!";
  } else {
    echo "Sign up failed.";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="signup.css">
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h1>Sign Up</h1>
      <form id="form" action="signup.php" method="POST">
        <div class="input-group">
          <div class="input-field">
            <input type="text" name="newusername" placeholder="Create name" required>
          </div>
          <div class="error-message" id="username-error"></div>
          
          <select name="jurusan">
            <option value="">Jurusan</option>
            <option>Akutansi</option>
            <option>Teknik Informatika</option>
            <option>Teknik Mesin</option>
          </select>
          <div class="error-message" id="jurusan-error"> </div>
          
          <div class="input-field">
            <input type="password" name="newpassword" placeholder="Create password" required>
          </div>
          <div class="error-message" id="password-error"> </div>

          <div class="input-field">
            <input type="password" name="samepassword" placeholder="Confirm password" required>
          </div>
          <div class="error-message" id="confirm-error"></div>

          <button type="submit" class="btn" id="signupbutton">Sign up</button>
        </div>
      </form>
      <p class="signin-link">
        Already have an account?
        <a href="http://localhost/Sign%20Up/index.php">Sign in</a>
      </p>
    </div>
  </div>

  <script src="signup.js"></script>
</body>
</html>
