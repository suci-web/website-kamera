<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login_pelanggan.php"); // Redirect jika bukan admin
    exit();
}  
// Sertakan koneksi ke database
include('koneksi.php');

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'add') {
        $nama_peralatan = $_POST['nama_peralatan'];
        $jenis = $_POST['jenis'];
        $harga_sewa = $_POST['harga_sewa'];
        $stok = $_POST['stok'];
        // Menyimpan data peralatan ke dalam database
        mysqli_query($conn, "INSERT INTO peralatan (nama_peralatan, jenis, harga_sewa, stok) VALUES ('$nama_peralatan', '$jenis', '$harga_sewa', '$stok')");
    } elseif ($action == 'edit') {
        $id = $_POST['id'];
        $nama_peralatan = $_POST['nama_peralatan'];
        $jenis = $_POST['jenis'];
        $harga_sewa = $_POST['harga_sewa'];
        $stok = $_POST['stok'];
        // Update data peralatan
        mysqli_query($conn, "UPDATE peralatan SET nama_peralatan='$nama_peralatan', jenis='$jenis', harga_sewa='$harga_sewa', stok='$stok' WHERE id='$id'");
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        // Hapus data peralatan
        mysqli_query($conn, "DELETE FROM peralatan WHERE id='$id'");
    }
}

$peralatan = mysqli_query($conn, "SELECT * FROM peralatan");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Peralatan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <!-- Sidebar -->
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="admin_pelanggan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            pelanggan
                        </a>
                        <a class="nav-link" href="admin_peralatan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                            Peralatan
                        </a>                       
                        <a class="nav-link" href="admin_sewa.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            sewa peralatan
                        </a>
                        <a class="nav-link" href="admin_kembali.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            pengembalian
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Peralatan</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Peralatan
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Peralatan</th>
                                        <th>Jenis</th>
                                        <th>Harga Sewa</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($peralatan)): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['nama_peralatan'] ?></td>
                                        <td><?= $row['jenis'] ?></td>
                                        <td><?= $row['harga_sewa'] ?></td>
                                        <td><?= $row['stok'] ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Data Peralatan -->
                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Data Peralatan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="action" value="edit">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="nama_peralatan" class="form-label">Nama Peralatan</label>
                                                            <input type="text" name="nama_peralatan" class="form-control" id="nama_peralatan" value="<?= $row['nama_peralatan'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jenis" class="form-label">Jenis</label>
                                                            <input type="text" name="jenis" class="form-control" id="jenis" value="<?= $row['jenis'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="harga_sewa" class="form-label">Harga Sewa</label>
                                                            <input type="number" step="0.01" name="harga_sewa" class="form-control" id="harga_sewa" value="<?= $row['harga_sewa'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="stok" class="form-label">Stok</label>
                                                            <input type="number" name="stok" class="form-control" id="stok" value="<?= $row['stok'] ?>" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Peralatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="nama_peralatan" class="form-label">Nama Peralatan</label>
                            <input type="text" name="nama_peralatan" class="form-control" id="nama_peralatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" name="jenis" class="form-control" id="jenis" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_sewa" class="form-label">Harga Sewa</label>
                            <input type="number" step="0.01" name="harga_sewa" class="form-control" id="harga_sewa" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" id="stok" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
