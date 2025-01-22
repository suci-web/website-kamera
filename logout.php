<?php
session_start(); // Memulai session

// Hapus semua session
session_unset();

// Hancurkan session
session_destroy();

// Arahkan pengguna ke halaman login
header("Location: login_pelanggan.php");
exit();
?>
