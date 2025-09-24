<?php
session_start();
require_once 'connect.php';

$username = $_SESSION['username'] ?? 'guest';
$user_id = $_SESSION['user_id'] ?? null;

$foto = null;
$foto_dir = 'uploads/images/';
$placeholder = 'uploads/placeholder/placeholder.jpg';
$foto_path = $placeholder;

if ($user_id) {
    $stmt = $conn->prepare("SELECT foto FROM biodata WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($foto);
    if ($stmt->fetch() && !empty($foto) && file_exists($foto_dir . $foto)) {
        $foto_path = $foto_dir . $foto;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="student-site.css">
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="biodata.css">
    <link rel="stylesheet" href="krs.css">
    <link rel="stylesheet" href="jadwal.css">
    <link rel="stylesheet" href="password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <div class="page">
        <div class="header">
            <h1>STUDENT SITE</h1>
            <h2><?php echo htmlspecialchars($username) ?></h2>
            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($foto_path); ?>" alt="Profile Picture" />
            </div>
        </div>

        <div class="container">
            <div class="sidebar">
                <button type="button" onclick="showSection('home')"><i class="fa-solid fa-house"></i> Home</button>
                <button type="button" onclick="showSection('biodata')"><i class="fa-solid fa-address-card"></i> Biodata</button>
                <a href="krs.php" class="sidebar-link"><i class="fa-solid fa-clipboard-list"></i> KRS</a>
                <button type="button" onclick="showSection('jadwal')"><i class="fa-solid fa-calendar"></i> Jadwal</button>
                <a href="password.php" class="sidebar-link"><i class="fa-solid fa-key"></i> Password</a>
                <a href="index.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>

            <div class="content">
                <div id="home" class="section active">
                    <?php include 'homepage.php'; ?>
                </div>  
                <div id="biodata" class="section">
                    <?php include 'biodata.php'; ?>
                </div>  
                <div id="jadwal" class="section">
                    <?php include 'jadwal.php'; ?>
                </div>
                <div id="password" class="section">
                    <?php include 'password.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="studentsite.js"></script>
    <script src="biodata.js"></script>

    <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/07/03/12/20250703120315-5G2VUDQ5.js"></script>

</body>
</html>
