<?php
// Memulai session
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login_pelanggan.php");
    exit();
}

// Koneksi database
include 'koneksi.php';

// Ambil ID peralatan dari URL
$peralatan_id = $_GET['id'];

// Ambil data peralatan dari database berdasarkan ID
$sql = "SELECT * FROM peralatan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $peralatan_id);
$stmt->execute();
$result = $stmt->get_result();
$peralatan = $result->fetch_assoc();

$sewa_berhasil = false; // Flag untuk menandakan apakah sewa berhasil

// Ambil ID pelanggan dari session
$pelanggan_id = $_SESSION['id'];
$nama_penyewa = $_SESSION['nama']; // Mengambil nama pelanggan dari session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $jumlah = $_POST['jumlah'];

    // Konversi string tanggal ke objek DateTime
    $tanggal_sewa_obj = new DateTime($tanggal_sewa);
    $tanggal_kembali_obj = new DateTime($tanggal_kembali);

    // Format tanggal ke Y-m-d untuk disimpan ke database
    $tanggal_sewa = $tanggal_sewa_obj->format('Y-m-d');
    $tanggal_kembali = $tanggal_kembali_obj->format('Y-m-d');

    // Hitung durasi sewa (dalam hari) menggunakan metode diff()
    $interval = $tanggal_sewa_obj->diff($tanggal_kembali_obj);
    $hari_sewa = $interval->days;

    // Hitung total harga
    $total_harga = $peralatan['harga_sewa'] * $hari_sewa * $jumlah;

    // Masukkan data sewa ke tabel
    $insert_sql = "INSERT INTO sewa (pelanggan_id, peralatan_id, nama_penyewa, tanggal_sewa, tanggal_kembali, jumlah, total_harga, status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, 'Disewa')";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iisssdi", $pelanggan_id, $peralatan_id, $nama_penyewa, $tanggal_sewa, $tanggal_kembali, $jumlah, $total_harga);
    $insert_stmt->execute();

    $sewa_berhasil = true; // Set flag berhasil
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penyewaan Peralatan Fotografi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: transparent !important;
        }
        
        .form-container {
            width: 80%;
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px auto;
        }
        .form-container h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .form-container label {
            font-size: 12px;
            font-weight: bold;
        }
        .form-container input {
            font-size: 14px;
            padding: 8px;
        }
        .btn-block {
            margin-top: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .struk-container {
            width: 50%;
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #000;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
        }
        .struk-container h4 {
            text-align: center;
            margin-bottom: 10px;
        }
        .struk-container p {
            margin: 5px 0;
        }
        .struk-container .separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .struk-container .total {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .struk-container .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
        .btn-print {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Penyewaan Fotografi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tentang_kami.php">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="kontak.php">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_pelanggan.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="form-container">
            <h1>Form Penyewaan Peralatan Fotografi</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nama_peralatan">Nama Peralatan:</label>
                    <input type="text" id="nama_peralatan" name="nama_peralatan" value="<?php echo $peralatan['nama_peralatan']; ?>" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="harga_sewa">Harga Sewa Per Hari:</label>
                    <input type="text" id="harga_sewa" name="harga_sewa" value="Rp <?php echo number_format($peralatan['harga_sewa'], 0, ',', '.'); ?>" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_penyewa">Nama Penyewa:</label>
                    <input type="text" name="nama_penyewa" id="nama_penyewa" class="form-control" value="<?php echo $nama_penyewa; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="tanggal_sewa">Tanggal Sewa:</label>
                    <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_kembali">Tanggal Kembali:</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
                </div>

                <div class="form-group">
                    <label for="total_harga">Total Harga:</label>
                    <input type="text" name="total_harga" id="total_harga" class="form-control" value="Rp 500.000" readonly>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Sewa</button>
                <div class="btn-back mt-3">
                <a href="index.php" class="btn btn-secondary btn-block">Kembali</a>
            </div>
            </form>
        </div>

        <!-- Menampilkan Struk Penyewaan -->
        <?php if ($sewa_berhasil): ?>
        <div class="struk-container">
            <h4>Struk Penyewaan</h4>
            <p><strong>Nama Peralatan:</strong> <?php echo $peralatan['nama_peralatan']; ?></p>
            <p><strong>Harga Sewa Per Hari:</strong> Rp <?php echo number_format($peralatan['harga_sewa'], 0, ',', '.'); ?></p>
            <p><strong>Nama Penyewa:</strong> <?php echo $nama_penyewa; ?></p>
            <p><strong>Tanggal Sewa:</strong> <?php echo $tanggal_sewa; ?></p>
            <p><strong>Tanggal Kembali:</strong> <?php echo $tanggal_kembali; ?></p>
            <p><strong>Jumlah:</strong> <?php echo $jumlah; ?></p>
            <div class="separator"></div>
            <p class="total"><strong>Total Harga: Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></strong></p>
            <p class="footer">Terima kasih telah menyewa!</p>
        </div>
        <?php endif; ?>
    </div>
    <div class="btn-print">
        <?php if ($sewa_berhasil): ?>
        <button onclick="window.print();" class="btn btn-success">Cetak Struk</button>
        <?php endif; ?>
    </div>
</body>
</html>
