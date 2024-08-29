<?php
session_start(); // Memulai sesi
require '../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../../login-admin.php');
    exit();
}

// Mendapatkan data pengguna dari tabel admin
$nip = $_SESSION['nip'];
$sql = "SELECT * FROM admin WHERE nip = '$nip'";
$result = mysqli_query($conn, $sql);
$userData = mysqli_fetch_assoc($result);

// Membatasi panjang nama menjadi maksimal 15 karakter
$displayName = $userData['nama'];
if (strlen($displayName) > 30) {
    $displayName = substr($displayName, 0, 30) . '...';
}

// Query untuk menghitung jumlah pengajuan baru dengan status 'Pending'
$jumlah_pengajuan_baru = "SELECT COUNT(*) as total_pengajuan FROM pengajuan WHERE status = 'Pending'";
$hasil = mysqli_query($conn, $jumlah_pengajuan_baru);

$total_pengajuan = 0;

if ($hasil && mysqli_num_rows($hasil) > 0) {
    $row = mysqli_fetch_assoc($hasil);
    $total_pengajuan = $row['total_pengajuan'];
}

$row = null; // Inisialisasi variabel

// Ambil id dari parameter GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT p.id_pengajuan, u.nama AS nama_user, k.jenis_pengajuan AS kategori, p.tanggal_pengajuan, u.status_pernikahan as status_pernikahan, p.status 
            FROM pengajuan p
            JOIN user u ON p.nik = u.nik
            JOIN kategori_pengajuan k ON p.id_kategori = k.id_kategori_pengajuan
            WHERE p.id_pengajuan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak tersedia!";
        exit;
    }
}

// Proses update data pengajuan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_pengajuan"];
    $status = $_POST["status"];
    $ttd = $_POST["ttd"];
    $tanggal_acc = $_POST["tanggal_acc"];

    $stmt = $conn->prepare("UPDATE pengajuan SET status=?, tanggal_acc=?, nama_kuwu=? WHERE id_pengajuan=?");
    $stmt->bind_param("sssi", $status, $tanggal_acc, $ttd, $id);

    if ($stmt->execute()) {
        header("Location: ../pengajuan_user.php?keterangan=pengajuan-sk-success");
        exit;
    } else {
        echo "Error updating record: " . htmlspecialchars($conn->error);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../../user/style.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
		.swal2-popup {
			font-size: 0.8rem !important; 
			width: 95%;
			max-width: 400px !important; /* Ukuran lebar kustom */
			max-height: 300px;
            z-index: 0 !important; 
		}

        @media screen and (max-width: 500px) {
            .swal2-popup {
                font-size: 0.6rem !important; 
                width: 95%;
                max-width: 400px !important; /* Ukuran lebar kustom */
                max-height: 300px;
                z-index: 0 !important; 
            }
        }
	</style>
	<title>Halaman Admin</title>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <?php include 'brand.php' ?>
        <ul class="side-menu top">
            <li>
                <a href="../">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../artikel.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li class="active">
                <a href="../pengajuan_user.php">
                    <i class='bx bxs-file'></i>
                    <span class="text">Pengajuan User 
                        <?php if ($total_pengajuan > 0): ?>
                            <sup><?php echo $total_pengajuan; ?></sup>
                        <?php endif; ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="../galeri.php">
                    <i class='bx bxs-camera' ></i>
                    <span class="text">Galeri Desa</span>
                </a>
            </li>
            <li>
                <a href="../tambah_user.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Tambah User</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="../tambah_admin.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">Tambah Admin</span>
                </a>
            </li>
            <li>
                <a href="../profile_akun.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Profile Akun</span>
                </a>
            </li>
            <li>
                <a href="../logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include '../navbar.php' ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Pengajuan Surat Keterangan</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Admin</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a href="index.php">Pengajuan User</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="pengajuan_user.php">SK</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                        <div class="formulir-pengajuan" id="pengajuanForm">
                        <h3 style="margin-bottom:10px; font-size:22px; font-weight: 600;">Form Pengajuan</h3>
                        <form action="sk.php" method="POST">
                            <input type="hidden" name="id_pengajuan" value="<?php echo htmlspecialchars($row['id_pengajuan'] ?? ''); ?>">

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="nama">Nama</label>
                                        <input type="text" id="nama" value="<?php echo htmlspecialchars($row['nama_user'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="jenis_pengajuan">Kategori</label>
                                        <input type="text" id="jenis_pengajuan" value="<?php echo htmlspecialchars($row['kategori'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <h3 style="margin-bottom:10px; font-size:20px; font-weight: 600;">Mengajukan Usaha: </h3>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="status_pernikahan">Status Pernikahan</label>
                                        <input type="text" id="status_pernikahan" value="<?php echo htmlspecialchars($row['status_pernikahan'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                                        <input type="date" id="tanggal_pengajuan" value="<?php echo htmlspecialchars($row['tanggal_pengajuan'] ?? ''); ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="tanggal_acc">Tanggal Acc</label>
                                        <input type="date" id="tanggal_acc" name="tanggal_acc" required>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="ttd">Yang Bertanda Tangan</label>
                                        <input type="text" id="ttd" name="ttd" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="status">Status</label>
                                        <select id="status" name="status" required>
                                            <option value="Acc" <?php echo ($row['status'] ?? '') === 'Acc' ? 'selected' : ''; ?>>Acc</option>
                                            <option value="Pending" <?php echo ($row['status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <script src="../../user/js/script.js"></script>
</body>
</html>
