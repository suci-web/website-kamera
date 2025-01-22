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
        $pelanggan_id = mysqli_real_escape_string($conn, $_POST['pelanggan_id']);
        $peralatan_id = mysqli_real_escape_string($conn, $_POST['peralatan_id']);
        $nama_penyewa = mysqli_real_escape_string($conn, $_POST['nama_penyewa']);
        $tanggal_sewa = mysqli_real_escape_string($conn, $_POST['tanggal_sewa']);
        $tanggal_kembali = mysqli_real_escape_string($conn, $_POST['tanggal_kembali']);
        $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
        $total_harga = mysqli_real_escape_string($conn, $_POST['total_harga']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        mysqli_query($conn, "INSERT INTO sewa (pelanggan_id, peralatan_id, nama_penyewa, tanggal_sewa, tanggal_kembali, jumlah, total_harga, status) 
                             VALUES ('$pelanggan_id', '$peralatan_id', '$nama_penyewa', '$tanggal_sewa', '$tanggal_kembali', '$jumlah', '$total_harga', '$status')");
    } elseif ($action == 'edit') {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $pelanggan_id = mysqli_real_escape_string($conn, $_POST['pelanggan_id']);
        $peralatan_id = mysqli_real_escape_string($conn, $_POST['peralatan_id']);
        $nama_penyewa = mysqli_real_escape_string($conn, $_POST['nama_penyewa']);
        $tanggal_sewa = mysqli_real_escape_string($conn, $_POST['tanggal_sewa']);
        $tanggal_kembali = mysqli_real_escape_string($conn, $_POST['tanggal_kembali']);
        $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
        $total_harga = mysqli_real_escape_string($conn, $_POST['total_harga']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        mysqli_query($conn, "UPDATE sewa SET pelanggan_id='$pelanggan_id', peralatan_id='$peralatan_id', nama_penyewa='$nama_penyewa', 
                             tanggal_sewa='$tanggal_sewa', tanggal_kembali='$tanggal_kembali', jumlah='$jumlah', total_harga='$total_harga', status='$status' 
                             WHERE id='$id'");
    } elseif ($action == 'delete') {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        mysqli_query($conn, "DELETE FROM sewa WHERE id='$id'");
    } elseif ($action == 'return') {
        $sewa_id = mysqli_real_escape_string($conn, $_POST['sewa_id']);
        $tanggal_pengembalian = mysqli_real_escape_string($conn, $_POST['tanggal_pengembalian']);
        $kondisi_peralatan = mysqli_real_escape_string($conn, $_POST['kondisi_peralatan']);
        $denda = mysqli_real_escape_string($conn, $_POST['denda']);

        mysqli_query($conn, "INSERT INTO pengembalian (sewa_id, tanggal_pengembalian, kondisi_peralatan, denda) 
                             VALUES ('$sewa_id', '$tanggal_pengembalian', '$kondisi_peralatan', '$denda')");
        mysqli_query($conn, "UPDATE sewa SET status='Kembali' WHERE id='$sewa_id'");
    }
}

$sewa = mysqli_query($conn, "SELECT * FROM sewa");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Sewa</title>
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
                            peralatan
                        </a>
                        
                        <a class="nav-link" href="admin_sewa.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Sewa Peralatan
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
                    <h1 class="mt-4">Data Sewa Peralatan</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Sewa Peralatan
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Penyewa</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($sewa)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_penyewa']) ?></td>
                                        <td><?= htmlspecialchars($row['tanggal_sewa']) ?></td>
                                        <td><?= htmlspecialchars($row['tanggal_kembali']) ?></td>
                                        <td><?= htmlspecialchars($row['jumlah']) ?></td>
                                        <td><?= htmlspecialchars($row['total_harga']) ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                            <?php if ($row['status'] == 'Disewa'): ?>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal<?= $row['id'] ?>">Kembalikan</button>
                    <?php endif; ?>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Data Sewa -->
                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Data Sewa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="action" value="edit">
                                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="nama_penyewa" class="form-label">Nama Penyewa</label>
                                                            <input type="text" name="nama_penyewa" class="form-control" value="<?= htmlspecialchars($row['nama_penyewa']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                                            <input type="date" name="tanggal_sewa" class="form-control" value="<?= htmlspecialchars($row['tanggal_sewa']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                                            <input type="date" name="tanggal_kembali" class="form-control" value="<?= htmlspecialchars($row['tanggal_kembali']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jumlah" class="form-label">Jumlah</label>
                                                            <input type="number" name="jumlah" class="form-control" value="<?= htmlspecialchars($row['jumlah']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="total_harga" class="form-label">Total Harga</label>
                                                            <input type="number" name="total_harga" class="form-control" value="<?= htmlspecialchars($row['total_harga']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-control" required>
                                                                <option value="Disewa" <?= $row['status'] == 'Disewa' ? 'selected' : '' ?>>Disewa</option>
                                                                <option value="Kembali" <?= $row['status'] == 'Kembali' ? 'selected' : '' ?>>Kembali</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal Pengembalian -->
                                    <div class="modal fade" id="returnModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="returnModalLabel">Proses Pengembalian</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="action" value="return">
                                                        <input type="hidden" name="sewa_id" value="<?= $row['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                                                            <input type="date" name="tanggal_pengembalian" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kondisi_peralatan" class="form-label">Kondisi Peralatan</label>
                                                            <select name="kondisi_peralatan" class="form-control" required>
                                                                <option value="Baik">Baik</option>
                                                                <option value="Rusak">Rusak</option>
                                                                <option value="Hilangkan">Hilangkan</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="denda" class="form-label">Denda (jika ada)</label>
                                                            <input type="number" name="denda" class="form-control" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
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

    <!-- Modal Tambah Data Sewa -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Sewa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">ID Pelanggan</label>
                            <input type="text" name="pelanggan_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="peralatan_id" class="form-label">ID Peralatan</label>
                            <input type="text" name="peralatan_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_penyewa" class="form-label">Nama Penyewa</label>
                            <input type="text" name="nama_penyewa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                            <input type="date" name="tanggal_sewa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="number" name="total_harga" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Disewa">Disewa</option>
                                <option value="Kembali">Kembali</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Sewa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
