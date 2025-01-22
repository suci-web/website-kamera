<?php
// Koneksi ke database
include('koneksi.php');

// Cek apakah admin sudah ada di dalam database
$sql = "SELECT * FROM admin WHERE email = 'suci@gmail.com'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Admin belum ada, maka kita buat data admin baru
    $nama = 'Admin User';
    $email = 'suci@gmail.com';
    $password = 'admin'; // Password asli yang ingin disimpan

    // Meng-hash password sebelum menyimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan data admin ke database
    $sql_insert = "INSERT INTO admin (nama, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sss", $nama, $email, $hashed_password);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Data admin berhasil disimpan!";
    } else {
        echo "Gagal menyimpan data admin!";
    }
} else {
    echo "Admin sudah terdaftar di database!";
}

// Proses Login (Verifikasi password admin)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Ambil data dari form login
    $email = $_POST['email'];
    $input_password = $_POST['password'];

    // Ambil hash password dari database
    $sql = "SELECT password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($stored_hash);
    $stmt->fetch();

    // Verifikasi password
    if (password_verify($input_password, $stored_hash)) {
        echo "Login berhasil!";
        header("Location: index.php");
        exit();
        // Arahkan ke halaman dashboard admin atau halaman lainnya
        // header("Location: .php");
    } else {
        echo "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Login Admin</h2>

        <!-- Form Login -->
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
    </div>
</body>
</html>
