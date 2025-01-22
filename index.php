<?php 

// Menghubungkan dengan file koneksi
include('koneksi.php');

// Ambil data peralatan dari database
$sql = "SELECT * FROM peralatan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyewaan Peralatan Fotografi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Navbar transparan */


        .navbar {
           
            background-color: transparent !important;
            justify-content: center;
        }

        /* Card peralatan */
        .peralatan-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            margin: 10px auto;
        }

        .peralatan-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }

        .peralatan-card-body {
            padding: 10px;
            text-align: center;
        }

        .peralatan-card h5 {
            margin-bottom: 5px;
            font-size: 18px;
        }

        .peralatan-card p {
            font-size: 14px;
            margin: 5px 0;
        }

        .btn-primary {
            font-size: 14px;
            padding: 8px 15px;
        }

        /* Footer styling */
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
        }

        .footer a {
            color: #007bff;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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



    <div class="container mt-4">
        <h1 class="text-center">Dashboard Penyewaan Peralatan Fotografi</h1>
        
        <div class="row mt-4">
            <?php
            // Tampilkan data peralatan dalam card
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Tentukan gambar berdasarkan peralatan
                    if ($row['nama_peralatan'] == 'Kamera Canon EOS 5D') {
                        $gambar = 'g1.jpg';
                    } elseif ($row['nama_peralatan'] == 'Lensa 50mm f/1.8') {
                        $gambar = 'g2.jpg';
                    } elseif ($row['nama_peralatan'] == 'Tripod Manfrotto') {
                        $gambar = 'g3.jpg';
                    } elseif ($row['nama_peralatan'] == 'Kamera Sony Alpha 7R IV') {
                        $gambar = 'g4.jpg';
                    } elseif ($row['nama_peralatan'] == 'Lensa 85mm f/1.4') {
                        $gambar = 'g5.jpg';
                    } elseif ($row['nama_peralatan'] == 'Flash Godox V1') {
                        $gambar = 'g6.jpg';
                    } elseif ($row['nama_peralatan'] == 'Kamera Panasonic Lumix GH5') {
                        $gambar = 'g7.jpg';
                    } elseif ($row['nama_peralatan'] == 'Lensa 70-200mm f/2.8') {
                        $gambar = 'g8.jpg';
                    } elseif ($row['nama_peralatan'] == 'Drone DJI Mavic Air 2') {
                        $gambar = 'g9.jpg';
                    } else {
                        $gambar = 'images/default.jpg'; // Gambar default jika tidak ada kecocokan
                    }
                    
                    echo "<div class='col-md-4'>
                            <div class='peralatan-card'>
                                <img src='" . $gambar . "' alt='" . $row['nama_peralatan'] . "'>
                                <div class='peralatan-card-body'>
                                    <h5>" . $row['nama_peralatan'] . "</h5>
                                    <p><strong>Jenis:</strong> " . $row['jenis'] . "</p>
                                    <p><strong>Harga Sewa:</strong> Rp " . number_format($row['harga_sewa'], 0, ',', '.') . "</p>
                                    <p><strong>Stok:</strong> " . $row['stok'] . "</p>
                                    <a href='sewa.php?id=" . $row['id'] . "' class='btn btn-primary'>Sewa</a>
                                </div>
                            </div>
                          </div>";
                }
            } else {
                echo "<p class='text-center' style='width: 100%;'>Tidak ada peralatan tersedia</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Penyewaan Peralatan Fotografi. Semua hak dilindungi.</p>
        <p><a href="#">Kebijakan Privasi</a> | <a href="#">Syarat dan Ketentuan</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   

</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
