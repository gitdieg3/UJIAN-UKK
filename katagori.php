<?php
include 'conn.php'; // koneksi database

$sukses = "";
$error = "";

// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $query = "DELETE FROM tabel_katagori WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $sukses = "Kategori berhasil dihapus.";
    } else {
        $error = "Gagal menghapus kategori: " . mysqli_error($conn);
    }
}

// Proses simpan data
if (isset($_POST['simpan'])) {
    $katagori = trim($_POST['nama_katagori']);

    if ($katagori != "") {
        $query = "INSERT INTO tabel_katagori (katagori) VALUES ('$katagori')";
        if (mysqli_query($conn, $query)) {
            $sukses = "Kategori berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan kategori: " . mysqli_error($conn);
        }
    } else {
        $error = "Nama kategori tidak boleh kosong.";
    }
}

// Ambil daftar kategori
$katagori_result = mysqli_query($conn, "SELECT * FROM tabel_katagori ORDER BY id DESC");

if (!$katagori_result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-primary text-white p-3 vh-100 position-fixed" style="width: 220px;">
            <h4 class="mb-4">Aplikasi E-Data</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'beranda.php' ? 'active fw-bold' : ''; ?>" href="beranda.php">
                        <i class="bi bi-house-door me-2"></i> Beranda
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active fw-bold' : ''; ?>" href="index.php">
                        <i class="bi bi-box-seam me-2"></i> Daftar Produk
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'tambah.php' ? 'active fw-bold' : ''; ?>" href="tambah.php">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Data
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'katagori.php' ? 'active fw-bold' : ''; ?>" href="katagori.php">
                        <i class="bi bi-tags me-2"></i> Tambah Kategori
                    </a>
                </li>
            </ul>
        </div>

        <!-- Konten utama -->
        <div class="flex-grow-1" style="margin-left: 220px;">
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded p-4">

                    <h3 class="text-primary">Tambah Kategori</h3>

                    <?php if ($sukses) : ?>
                        <div class="alert alert-success"><?php echo $sukses; ?></div>
                    <?php elseif ($error) : ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" class="mb-4">
                        <div class="mb-3">
                            <label for="nama_katagori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_katagori" name="nama_katagori" required>
                        </div>
                        <button type="submit" name="simpan" class="btn btn-primary">Tambah</button>
                    </form>

                    <h5>Daftar Kategori:</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($katagori_result)) :
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['katagori']); ?></td>
                                    <td>
                                        <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>