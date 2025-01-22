<?php
// Menghubungkan dengan file koneksi
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telepon = $_POST['no_telepon'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Menggunakan password hashing untuk keamanan

    // Cek jika email sudah terdaftar
    $sql = "SELECT * FROM pelanggan WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar!";
    } else {
        // Insert data ke tabel pelanggan
        $sql = "INSERT INTO pelanggan (nama, no_telepon, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $no_telepon, $email, $password);

        if ($stmt->execute()) {
            // Redirect ke halaman login setelah registrasi berhasil
            header("Location: login_pelanggan.php");
            exit();
        } else {
            echo "Terjadi kesalahan, coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            padding: 20px;
            margin-top: 50px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Registrasi</h3>
        <form method="POST">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrasi</button>
        </form>
        <p class="mt-3">Sudah punya akun? <a href="login_pelanggan.php">Login di sini</a></p>
        <p class="mt-3">kembali <a href="index.php">Dasboard</a></p>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
