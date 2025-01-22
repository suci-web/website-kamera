<?php
// koneksi.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kamera"; // Ganti sesuai nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
