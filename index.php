<?php
include 'conn.php';

include 'conn.php';
include 'function.php';

// Inisialisasi
$filter_kategori = $_GET['kategori'] ?? '';
$search_keyword  = $_GET['search'] ?? '';

// Pagination
$limit = 5;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil kategori & data produk
$katagori_list = ambil_kategori_list($conn);
$total_data    = count_barang($conn, $filter_kategori, $search_keyword);
$total_pages   = ceil($total_data / $limit);
$data          = ambil_barang_list($conn, $filter_kategori, $search_keyword, $start, $limit);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        @media print {

            .no-print,
            .bg-dark,
            .nav-link {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-primary text-white p-3 vh-100 position-fixed no-print" style="width: 220px;">
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
                        <i class="bi bi-tags me-2"></i> Tambah Katagori
                    </a>
                </li>
            </ul>
        </div>

        <!-- Konten utama -->


        <div class="flex-grow-1 " style="margin-left: 220px;">
            <div class="container-fluid pt-4 px-4 ">
                <div class="bg-light rounded p-4">

                    <!-- Notifikasi -->
                    <?php if (isset($_GET['sukses'])) : ?>
                        <div class="alert alert-success no-print"><?php echo htmlspecialchars($_GET['sukses']); ?></div>
                    <?php elseif (isset($_GET['error'])) : ?>
                        <div class="alert alert-danger no-print"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php endif; ?>

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Daftar Produk</h4>
                        <button onclick="window.print()" class="btn btn-success no-print"><i class="bi bi-file-earmark-arrow-down-fil mb-2"></i>Export Data</button>
    
                    </div>

                    <!-- Form Pencarian & Filter -->
                    <form method="GET" class="row g-2 mb-3 no-print">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?php echo htmlspecialchars($search_keyword); ?>">
                        </div>
                        <div class="col-md-3">
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <?php while ($row = mysqli_fetch_assoc($katagori_list)) : ?>
                                    <option value="<?php echo htmlspecialchars($row['katagori']); ?>" <?php if ($filter_kategori == $row['katagori']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($row['katagori']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                        </div>
                        <div class="col-md-2">
                            <a href="index.php" class="btn btn-secondary w-100">Reset</a>
                        </div>
                    </form>

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
                                    <th class="no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $start + 1;
                                if (mysqli_num_rows($data) > 0) :
                                    while ($row = mysqli_fetch_assoc($data)) :
                                ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                            <td><?php echo htmlspecialchars($row['katagori']); ?></td>
                                            <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                            <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                            <td class="no-print">
                                                <a href="edit.php?op=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php
                                    endwhile;
                                else :
                                    ?>
                                    <tr>
                                        <td colspan="7">Data tidak ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1) : ?>
                        <nav class="mt-4 no-print">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                        <a class="page-link" href="?<?php
                                                                    $params = $_GET;
                                                                    $params['page'] = $i;
                                                                    echo http_build_query($params);
                                                                    ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>