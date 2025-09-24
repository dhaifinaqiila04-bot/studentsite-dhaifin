<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'connect.php';

$errors = [];
$nama = $alamat = $email = $nomor_hp = "";
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id === null) {
    echo "Please log in first.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['delete_all'])) {
        $stmt = $conn->prepare("DELETE FROM biodata WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: student-site.php");
        exit;
    } else {
        $checkStmt = $conn->prepare("SELECT id FROM biodata WHERE user_id = ?");
        $checkStmt->bind_param("i", $user_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            header("Location: student-site.php");
            exit;
        }
        $checkStmt->close();

        $nama = $_POST['nama'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $email = $_POST['email'] ?? '';
        $nomor_hp = $_POST['nomor_hp'] ?? '';

        $foto_name = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto_tmp = $_FILES['foto']['tmp_name'];
            $foto_name = basename($_FILES['foto']['name']);
            $target_dir = 'uploads/images/';
            $target_path = $target_dir . $foto_name;
            move_uploaded_file($foto_tmp, $target_path);
        }

        $stmt = $conn->prepare("INSERT INTO biodata (user_id, nama, alamat, email, nomor_hp, foto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $nama, $alamat, $email, $nomor_hp, $foto_name);
        $stmt->execute();
        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$stmt = $conn->prepare("SELECT nama, alamat, email, nomor_hp, foto FROM biodata WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nama, $alamat, $email, $nomor_hp, $foto);
$biodata_exists = $stmt->fetch();
$stmt->close();

$readonly = $biodata_exists ? 'readonly' : '';        
$disabled_file = $biodata_exists ? 'disabled' : '';    
$disabled_submit = $biodata_exists ? 'disabled' : ''; 

?>






<div id="biodata">
    <div class="biodata-header">
        <h2>BIODATA & FOTO</h2>
    </div>

    <div class="biodata-flex">
        <div class="biodata-content">
            <form id="biodata-form" method="POST" enctype="multipart/form-data" action="student-site.php">
                <div class=biodata-form-body>
                    <div class="input-field">
                        <label for="nama">Nama:</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" <?= $readonly ?> >
                        <div class="error-message" id="nama-error"></div>

                        <label for="alamat">Alamat:</label>
                        <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($alamat) ?>" <?= $readonly ?> >
                        <div class="error-message" id="alamat-error"></div>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" <?= $readonly ?> >
                        <div class="error-message" id="alamat-error"></div>

                        <label for="hp">Nomor HP:</label>
                        <input type="text" id="nomor_hp" name="nomor_hp" value="<?= htmlspecialchars($nomor_hp) ?>" <?= $readonly ?> >
                        <div class="error-message" id="hp-error"></div>

                        <label for="foto">Foto:</label>
                        <input type="file" id="foto" name="foto" onchange="previewImage(event)" <?= $disabled_file ?> >
                        <div class="error-message" id="foto-error"></div>
                    </div>
                <div class="preview-foto-box">
                    <img id="preview" alt="Preview Foto" style="width:100%; height:100%; object-fit:cover;" />
                </div>
                </div>
            <div class="biodata-buttons">
            <button type='submit' class="submit-btn" <?= $disabled_submit ?>>Submit</button>
            <button type='submit'name='delete_all' class="delete-btn">Delete</button>
            </div>
            </form>
    
        </div>
    
    </div>

</div>
