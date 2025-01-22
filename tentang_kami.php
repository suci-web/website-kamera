<?php
// Menghubungkan dengan file koneksi
include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Penyewaan Peralatan Fotografi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Navbar transparan */
        .navbar {
            background-color: transparent !important;
            justify-content: center;
        }
        
        /* Styling untuk card di halaman tentang kami */
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-body h5 {
            color: #007bff;
        }

        

        /* Menambahkan kelas untuk merubah warna teks dan posisi */
        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: #000; /* Ubah warna menjadi hitam */
            text-align: center; /* Teks terpusat */
            margin-bottom: 30px;
        }

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

        /* Galeri Foto */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item .description {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 16px;
        }

        /* Untuk judul Visi, Misi, dan Mengapa Memilih Kami */
        .card-header {
            text-align: center; /* Pusatkan teks */
            color: black; /* Ubah warna teks menjadi hitam */
        }

        .card-body h5 {
            text-align: center; /* Pusatkan teks */
            color: black; /* Ubah warna teks menjadi hitam */
        }
    </style>
</head>
<body>

    <!-- Navbar dari index.php -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Penyewaan Fotografi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
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
        <h1 class="section-title">Tentang Kami</h1>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Visi Kami
                    </div>
                    <div class="card-body">
                        <h5>Menjadi Platform Terpercaya</h5>
                        <p>Menjadi platform penyewaan peralatan fotografi terbaik di Indonesia dengan menyediakan peralatan berkualitas tinggi dan layanan yang memuaskan pelanggan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        Misi Kami
                    </div>
                    <div class="card-body">
                        <h5>Menyediakan Layanan Penyewaan yang Mudah</h5>
                        <p>Memberikan pengalaman penyewaan yang mudah, aman, dan cepat, serta menyediakan pilihan peralatan yang lengkap sesuai kebutuhan fotografer.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        Mengapa Memilih Kami?
                    </div>
                    <div class="card-body">
                        <h5>Peralatan Berkualitas dan Terpercaya</h5>
                        <p>Kami menyediakan peralatan fotografi berkualitas tinggi dari merek terkemuka yang siap digunakan untuk berbagai kebutuhan foto dan video Anda.</p>
                        <h5>Layanan Cepat dan Mudah</h5>
                        <p>Proses pemesanan dan pengembalian peralatan kami dirancang agar sesimpel dan secepat mungkin untuk kenyamanan Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Galeri Foto Pelanggan -->
        <h2 class="section-title">Dokumentasi Foto Pelanggan</h2>
        <div class="gallery">
            <!-- Gambar 1 -->
            <div class="gallery-item">
                <img src="10.jpg" alt="Pelanggan 1">
                <div class="description">Pelanggan dengan peralatan kamera terbaik kami.</div>
            </div>

            <!-- Gambar 2 -->
            <div class="gallery-item">
                <img src="g11.jpg" alt="Pelanggan 2">
                <div class="description">Mengabadikan momen indah di luar ruangan.</div>
            </div>

            <!-- Gambar 3 -->
            <div class="gallery-item">
                <img src="g12.jpg" alt="Pelanggan 3">
                <div class="description">Penyewaan drone untuk pengambilan gambar udara.</div>
            </div>

            <!-- Gambar 4 -->
            <div class="gallery-item">
                <img src="g13.jpg" alt="Pelanggan 4">
                <div class="description">Studio foto dengan peralatan pro kami.</div>
            </div>
            <!-- Gambar 5 -->
            <div class="gallery-item">
                <img src="g14.jpg" alt="Pelanggan 5">
                <div class="description">Menggunakan peralatan lighting untuk sesi foto malam hari.</div>
            </div>

            <!-- Gambar 6 -->
            <div class="gallery-item">
                <img src="g15.jpg" alt="Pelanggan 6">
                <div class="description">Pelanggan mempersiapkan pemotretan produk dengan lighting studio.</div>
            </div>
        </div>

    </div>

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
