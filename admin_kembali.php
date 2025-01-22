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
        $sewa_id = $_POST['sewa_id'];
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
        $kondisi_peralatan = $_POST['kondisi_peralatan'];
        $denda = $_POST['denda'];
        // Menyimpan data pengembalian ke dalam database
        mysqli_query($conn, "INSERT INTO pengembalian (sewa_id, tanggal_pengembalian, kondisi_peralatan, denda) VALUES ('$sewa_id', '$tanggal_pengembalian', '$kondisi_peralatan', '$denda')");
    } elseif ($action == 'edit') {
        $id = $_POST['id'];
        $sewa_id = $_POST['sewa_id'];
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'];
        $kondisi_peralatan = $_POST['kondisi_peralatan'];
        $denda = $_POST['denda'];
        // Update data pengembalian
        mysqli_query($conn, "UPDATE pengembalian SET sewa_id='$sewa_id', tanggal_pengembalian='$tanggal_pengembalian', kondisi_peralatan='$kondisi_peralatan', denda='$denda' WHERE id='$id'");
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        // Hapus data pengembalian
        mysqli_query($conn, "DELETE FROM pengembalian WHERE id='$id'");
    }
}

$pengembalian = mysqli_query($conn, "SELECT * FROM pengembalian");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Pengembalian</title>
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
                            peralatan
                        </a>
                        
                        <a class="nav-link" href="admin_sewa.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Sewa Peralatan
                        </a>
                        <a class="nav-link" href="admin_kembali.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Pengembalian
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Pengembalian</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Pengembalian
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Sewa ID</th>
                                        <th>Tanggal Pengembalian</th>
                                        <th>Kondisi Peralatan</th>
                                        <th>Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($pengembalian)): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['sewa_id'] ?></td>
                                        <td><?= $row['tanggal_pengembalian'] ?></td>
                                        <td><?= $row['kondisi_peralatan'] ?></td>
                                        <td><?= $row['denda'] ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Data Pengembalian -->
                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Data Pengembalian</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="action" value="edit">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="sewa_id" class="form-label">Sewa ID</label>
                                                            <input type="text" name="sewa_id" class="form-control" id="sewa_id" value="<?= $row['sewa_id'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                                            <input type="date" name="tanggal_pengembalian" class="form-control" id="tanggal_pengembalian" value="<?= $row['tanggal_pengembalian'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kondisi_peralatan" class="form-label">Kondisi Peralatan</label>
                                                            <select name="kondisi_peralatan" class="form-control" id="kondisi_peralatan" required>
                                                                <option value="Baik" <?= $row['kondisi_peralatan'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
                                                                <option value="Rusak" <?= $row['kondisi_peralatan'] == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                                                                <option value="Hilangkan" <?= $row['kondisi_peralatan'] == 'Hilangkan' ? 'selected' : '' ?>>Hilangkan</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="denda" class="form-label">Denda</label>
                                                            <input type="number" step="0.01" name="denda" class="form-control" id="denda" value="<?= $row['denda'] ?>" required>
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
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="sewa_id" class="form-label">Sewa ID</label>
                            <input type="text" name="sewa_id" class="form-control" id="sewa_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" name="tanggal_pengembalian" class="form-control" id="tanggal_pengembalian" required>
                        </div>
                        <div class="mb-3">
                            <label for="kondisi_peralatan" class="form-label">Kondisi Peralatan</label>
                            <select name="kondisi_peralatan" class="form-control" id="kondisi_peralatan" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Hilangkan">Hilangkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="denda" class="form-label">Denda</label>
                            <input type="number" step="0.01" name="denda" class="form-control" id="denda" required>
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
