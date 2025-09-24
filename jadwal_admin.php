
<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_matkul = trim($_POST['matkul']);
    $hari = trim($_POST['hari']);
    $waktu_mulai = trim($_POST['waktu_mul']);
    $waktu_selesai = trim($_POST['waktu_akh']);
    $ruang = trim($_POST['ruang']);

    if (empty($nama_matkul) || empty($hari) || empty($waktu_mulai) || empty($waktu_selesai) || empty($ruang)) {
        echo "Semua kolom harus diisi.";
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM krs_admin WHERE nama_matkul = ? LIMIT 1");
    $stmt->bind_param("s", $nama_matkul);
    $stmt->execute();
    $result = $stmt->get_result();
    $krs_admin = $result->fetch_assoc();

    if (!$krs_admin) {
        echo "Mata kuliah tidak ditemukan dalam krs_admin.";
        exit;
    }

    $krs_admin_id = $krs_admin['id'];

    $insert = $conn->prepare("INSERT INTO jadwal (krs_admin_id, hari, waktu_mulai, waktu_selesai, ruang) VALUES (?, ?, ?, ?, ?)");
    $insert->bind_param("issss", $krs_admin_id, $hari, $waktu_mulai, $waktu_selesai, $ruang);

    if ($insert->execute()) {
        header("Location: jadwal_admin.php?success=1");
        exit;
    } else {
        echo "Gagal menambahkan jadwal: " . $conn->error;
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Admin</title>
  <link rel="stylesheet" href="krs_admin.css">
</head>
<body>
<div id="krs-admin">
  <div class="biodata-header">
    <h2>PEMBUATAN JADWAL</h2>
  </div>
  <div class="biodata-flex">
    <div class="biodata-content">
      <form id="biodata-form" method="POST" action="jadwal_admin.php">
        <div class="biodata-form-body">
          <div class="input-field">
            
            <label for="matkul">Mata Kuliah:</label>
            <select name="matkul" id="matkul">
              <option value="">--</option>
              <?php
              $query = $conn->query("SELECT DISTINCT nama_matkul FROM krs_admin ORDER BY nama_matkul ASC");
              while ($row = $query->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($row['nama_matkul']) . "'>" . htmlspecialchars($row['nama_matkul']) . "</option>";
              }
              ?>
            </select>
            <div class="error-message" id="matkul-error"></div>

            <label for="hari">Hari:</label>
            <select name="hari" id="hari">
                <option value="">--</option>
                <option>Senin</option>
                <option>Selasa</option>
                <option>Rabu</option>
                <option>Kamis</option>
                <option>Jumat</option>
                <option>Sabtu</option>
            </select>
            <div class="error-message" id="hari-error"></div>

            <label for="waktu_mul">Waktu Mulai:</label>
            <input type="time" id="waktu_mul" name="waktu_mul" value="">
            <div class="error-message" id="waktu-mul-error"></div>

            <label for="waktu_akh">Waktu Selesai:</label>
            <input type="time" id="waktu_akh" name="waktu_akh" value="">
            <div class="error-message" id="waktu-akh-error"></div>

            <label for="ruang">Ruang:</label>
            <input type="text" id="ruang" name="ruang" value="">
            <div class="error-message" id="ruang-error"></div>

          </div>
        </div>
        <div class="buttons">
          <button type="submit" class="submit-btn">Submit</button>
        </div>
        <a href="http://localhost/Sign%20Up/admin.php">Exit</a>
      </form>
    </div>
  </div>
  <script src="jadwal_admin.js"> </script>
</div>
</body>
</html>
