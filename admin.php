<?php
session_start();
require_once 'connect.php';



$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="krs_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="page">
        <div class="header">
            <h1>ADMIN SITE</h1>
            <h2><?php echo htmlspecialchars($username) ?></h2>
        </div>
        <div class="admin-page">
            <div class="button-group">
                <div class="top-button">
                    <a href="krs_admin.php" class="btn"><i class="fa-solid fa-book"></i> KRS</a>
                    <a href="jadwal_admin.php" class="btn"><i class="fa-solid fa-calendar"></i> Jadwal</a>
                    <a href="index.php" class="btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div> 
                
        </div>
    </div>

<script src="admin.js"></script>



</body>
</html>