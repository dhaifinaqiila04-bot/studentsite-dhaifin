<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT kelas, semester, jurusan, npm FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT id, nama_matkul, sks FROM krs_admin WHERE kelas = ? AND semester = ? AND jurusan = ?");
$stmt->bind_param("sis", $student['kelas'], $student['semester'], $student['jurusan']);
$stmt->execute();
$courses = $stmt->get_result();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete-krs'])) {
        $stmt = $conn->prepare("DELETE FROM krs WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: student-site.php");
        exit;
    }

    if (isset($_POST['submit-krs'])) {
        $checkStmt = $conn->prepare("SELECT krs_id FROM krs WHERE user_id = ?");
        $checkStmt->bind_param("i", $user_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows === 0) {
            $checkStmt->close();

            if (isset($_POST['ambil']) && is_array($_POST['ambil'])) {
                foreach ($_POST['ambil'] as $krs_admin_id => $value) {
                    if ($value === 'Y') {
                        $stmt = $conn->prepare("INSERT INTO krs (user_id, krs_admin_id, ambil) VALUES (?, ?, ?)");
                        $stmt->bind_param("iis", $user_id, $krs_admin_id, $value);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        } else {
            $checkStmt->close();
        }

        header("Location: student-site.php");
        exit;
    }
}
?>

<head>
    <meta charset="UTF-8">
    <title>Pengisian KRS</title>
    <link rel="stylesheet" href="krs.css">
</head>

<div id="krs">
    <div class="table-header">
        <h1>Pengisian KRS</h1>
    </div>
    <div class="body">
        <div class="table-content">
            <div class="data-mahasiswa">
                <div class="column">
                    <p><span class="label">NPM:</span> <span class="value"><?= htmlspecialchars($student['npm']) ?></span></p>
                    <p><span class="label">Kelas:</span> <span class="value"><?= htmlspecialchars($student['kelas']) ?></span></p>
                </div>
                <div class="column">
                    <p><span class="label">Jurusan:</span> <span class="value"><?= htmlspecialchars($student['jurusan']) ?></span></p>
                    <p><span class="label">Semester:</span> <span class="value"><?= htmlspecialchars($student['semester']) ?></span></p>
                </div>
            </div>

            <hr style="width: 900px; border: 1px solid black;">

            <?php if ($courses && $courses->num_rows > 0): ?>
                <form method="POST">
                    <table class="data-krs">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Ambil</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no_krs = 1;
                            $totalSKS = 0;
                            while ($krs = $courses->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $no_krs++ ?></td>
                                <td><?= htmlspecialchars($krs['nama_matkul']) ?></td>
                                <td><?= htmlspecialchars($krs['sks']) ?></td>
                                <td>
                                    <select name="ambil[<?= $krs['id'] ?>]">
                                        <option value="N">Tidak</option>
                                        <option value="Y">Ya</option>
                                    </select>
                                </td>
                            </tr>
                            <?php
                            $totalSKS += $krs['sks'];
                            endwhile;
                            ?>
                        </tbody>
                    </table>

                    <div class="total-sks">
                        <p><span class="label">Total SKS (semua):</span> <span class="value"><?= $totalSKS ?></span></p>
                    </div>
                    
                    <div class="krs-buttons">
                        <button type="submit" name="submit-krs" class="submit-krs-btn">Submit</button>
                        <button type="submit" name="delete-krs" class="delete-krs-btn">Delete</button>
                        <a href="student-site.php" class="exit-link">Exit</a>
                    </div>

                </form>
            <?php else: ?>
                <p>Tidak ada mata kuliah untuk kelas ini. Admin mungkin belum menambahkan KRS.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/07/03/12/20250703120315-5G2VUDQ5.js"></script>