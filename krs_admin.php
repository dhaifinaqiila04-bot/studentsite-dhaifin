<?php
session_start();
require_once 'connect.php';

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_matkul = trim($_POST['nama_matkul']);
    $sks = trim($_POST['sks']);
    $dosen = trim($_POST['dosen']);
    $kelas = trim($_POST['kelas']);
    $jurusan = $_POST['jurusan'];
    $semester = trim($_POST['semester']);


    $stmt = $conn->prepare("INSERT INTO krs_admin (nama_matkul, sks, dosen, semester, kelas, jurusan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisiss", $nama_matkul, $sks, $dosen, $semester, $kelas, $jurusan);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: krs_admin.php?success=1 ");
        exit();
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
  <title>KRS_admin</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="krs_admin.css">
</head>
<div id="krs-admin">
    <div class="biodata-header">
        <h2>PEMBUATAN KRS</h2>
    </div>
    <div class="biodata-flex">
        <div class="biodata-content">
            <form id="biodata-form" method="POST" action="krs_admin.php">
                <div class=biodata-form-body>
                    <div class="input-field">
                        <label for="nama_matkul">Mata Kuliah:</label>
                        <input type="text" name="nama_matkul" value="" >
                        <div class="error-message" id="matkul-error"></div>

                        <label for="sks">SKS:</label>
                        <input type="number" id="sks" name="sks" value="" >
                        <div class="error-message" id="sks-error"></div>

                        <label for="dosen">Dosen:</label>
                        <input type="text" id="dosen" name="dosen" value="">
                        <div class="error-message" id="dosen-error"></div>

                        <label for="kelas">Kelas:</label>
                        <input type="text" id="kelas" name="kelas" value="">
                        <div class="error-message" id="kelas-error"></div>

                        <label for="jurusan">Jurusan:</label>
                        <select name='jurusan'>
                            <option value="">--</option>
                            <option>Akutansi</option>
                            <option>Teknik Informatika</option>
                            <option>Teknik Mesin</option>
                        </select>
                        <div class="error-message" id="jurusan-error"></div>

                        <label for="semester">Semester:</label>
                        <input type="number" id="semester" name="semester" value="">
                        <div class="error-message" id="semester-error"></div>


                    </div>
                </div>
            <div class="buttons">
                <button type='submit' class="submit-btn">Submit</button>
            </div>
            <a href="http://localhost/Sign%20Up/admin.php">Exit</a>
            </form>
    
        </div>
    
    </div>
    <script src="krs_admin.js"> </script>
</div>