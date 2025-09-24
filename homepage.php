
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php';

$stmt = $conn->prepare("SELECT semester FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $_SESSION['semester'] = $user['semester'];
}

?>

<h1>Welcome, <?php echo htmlspecialchars($username) ?></h1>
<hr style="width: 1100px; border: 1px solid black;">
                    
<div class="deskripsi-ui">
    <div id="deskripsi-header">
        <i class="symbol-deskripsi-ui"><i class="fa-solid fa-house-user"></i></i>
        HOME PAGE
    </div>

    <div id="deskripsi-content-firsthalf">
        <div class="dashboard-info">
            Selamat Datang di Student Site
        </div>     
    </div>

    <div id="deskripsi-content-secondhalf">
        <div class="dashboard-info">

            <div class="info-box">
                <h3>Semester</h3>
                <p><?php echo isset($_SESSION['semester']) && !empty($_SESSION['semester']) ? htmlspecialchars($_SESSION['semester']) : 'Not set'; ?></p>

            </div>

            <div class="divider"></div>

            <div class="info-box">
                <h3>Calendar</h3>
                <p><?php echo date('F Y'); ?> </p>
            </div>

        </div>     
    </div>

</div>