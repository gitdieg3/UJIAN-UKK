<?php
include 'conn.php';

// Hitung statistik
$total_produk     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_barang"));
$total_stok       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) as total FROM tabel_barang"))['total'] ?? 0;
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah * harga) as total FROM tabel_barang"))['total'] ?? 0;
$produk_terjual   = 0; // Ganti ini jika punya tabel penjualan

// Pagination
$limit  = 5; // jumlah data per halaman
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$data = mysqli_query($conn, "SELECT * FROM tabel_barang ORDER BY id DESC LIMIT $limit OFFSET $offset");
$total_data = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_barang"));
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-primary text-white p-3 vh-100 position-fixed no-print" style="width: 220px;">
            <h4 class="mb-4">Aplikasi E-selt</h4>
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
                    <a class="nav-link text-white d-flex align-items-center <?php echo basename($_SERVER['PHP_SELF']) == 'tambah.php' ? 'active fw-bold' : ''; ?>" href="katagori.php">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Katagori
                    </a>
                </li>
            </ul>
        </div>

        <!-- Konten utama -->
        <div class="flex-grow-1" style="margin-left: 220px;">
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded p-4">

                    <!-- Statistik -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="bg-light p-3 rounded border d-flex align-items-center">
                                <div class="me-3 fs-1 text-success">📦</div>
                                <div>
                                    <div>Total produk</div>
                                    <strong><?= $total_produk ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-light p-3 rounded border d-flex align-items-center">
                                <div class="me-3 fs-1 text-success">📊</div>
                                <div>
                                    <div>Total Stok Produk</div>
                                    <strong><?= $total_stok ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-light p-3 rounded border d-flex align-items-center">
                                <div class="me-3 fs-1 text-success">📈</div>
                                <div>
                                    <div>total pendapatan</div>
                                    <strong>Rp<?= number_format($total_pendapatan, 0, ',', '.') ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="bg-light p-3 rounded border d-flex align-items-center">
                                <div class="me-3 fs-1 text-success">🛒</div>
                                <div>
                                    <div>Produk Terjual</div>
                                    <strong><?= $produk_terjual ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $offset + 1;
                                if (mysqli_num_rows($data) > 0) :
                                    while ($row = mysqli_fetch_assoc($data)) :
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                                            <td><?= htmlspecialchars($row['katagori']) ?></td>
                                            <td><?= htmlspecialchars($row['jumlah']) ?></td>
                                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                        </tr>
                                    <?php endwhile;
                                else: ?>
                                    <tr>
                                        <td colspan="6">Data tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>