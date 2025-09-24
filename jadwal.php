<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

$user_id = $_SESSION['user_id'];
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$showResults =  !empty($keyword);

if($showResults){
    $sql = 
    "SELECT k.nama_matkul, k.dosen, k.kelas, j.hari, j.waktu_mulai, j.waktu_selesai, j.ruang
    FROM jadwal j
    JOIN krs_admin k ON j.krs_admin_id = k.id
    WHERE (k.nama_matkul LIKE ? OR k.dosen LIKE ?)
    ORDER BY j.hari, j.waktu_mulai";


    $stmt = $conn->prepare($sql);
    $likeKeyword = '%'. $keyword . '%';
    $stmt->bind_param("ss", $likeKeyword, $likeKeyword);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>





<div id="jadwal">
    <h1> Jadwal </h1>
    <hr style="width: 1100px; border: 1px solid black;">

    <form method="GET" class="input-jadwal">   
        <input type="text" name="keyword" placeholder="Search Dosen/Mata Kuliah" value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

    
    <?php if ($showResults): ?>
    <table class="data-jadwal">
        <thead>
            <tr>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Mata Kuliah</th>
                <th>Waktu</th>
                <th>Ruang</th>
                <th>Dosen</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kelas']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                        <td><?= htmlspecialchars(substr($row['waktu_mulai'], 0, 5)) ?> - <?= htmlspecialchars(substr($row['waktu_selesai'], 0, 5)) ?></td>
                        <td><?= htmlspecialchars($row['ruang']) ?></td>
                        <td><?= htmlspecialchars($row['dosen']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Tidak ada hasil.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>

