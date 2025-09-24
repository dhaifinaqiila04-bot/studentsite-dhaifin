<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'connect.php';

$user_id = $_SESSION['user_id'];

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['password-lama'] ?? '';
    $newPassword = $_POST['password-baru'] ?? '';
    $confirmPassword = $_POST['konfirmasi-password'] ?? '';

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "Semua kolom harus diisi";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Password tidak sama";
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($oldPassword, $hashedPassword)) {
            $error = "Password lama salah";
        } else {
            $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->bind_param("si", $newHashed, $user_id);
            if ($update->execute()) {
                $success = "Password berhasil diperbarui";
            } else {
                $success = "Gagal memperbarui password";
            }
        }
    }
}
?>


<head>
    <meta charset="UTF-8">
    <title>Penggantian Password</title>
    <link rel="stylesheet" href="password.css">
</head>
<div id="password">
    <div class="password-header">
        <h1>Ganti Password</h1>
    </div>   
    <form method='POST'>
        <div class="input-group">
            <?php if (!empty($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="success-message"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <div class ="input-field">
                <label> Password Lama: </label>
                <input type="password" id="password-lama" name="password-lama">
            </div>
            <div class ="input-field">
                <label> Password Baru: </label>
                <input type="password" id="password-baru" name="password-baru"> 
            </div>
            <div class ="input-field">
                <label> Konfirmasi Password: </label>
                <input type="password" id="konfirmasi-password" name="konfirmasi-password">
            </div>
        <button type="submit" class="btn">Submit</button>
        <a href="http://localhost/Sign%20Up/index.php">Exit</a>
        </div>
    </form>
</div>

<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/07/03/12/20250703120315-5G2VUDQ5.js"></script>
