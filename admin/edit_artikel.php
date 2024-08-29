<?php
session_start(); // Memulai sesi
require '../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../login-admin.php');
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

// Menangani permintaan edit artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_artikel = $_POST['id_artikel'];
    $judul_artikel = $_POST['judul_artikel'];
    $isi_artikel = $_POST['isi_artikel'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];
    $kategori = $_POST['kategori'];
    
    // Proses unggah gambar baru jika ada
    if (isset($_FILES['gambar_baru']) && $_FILES['gambar_baru']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['gambar_baru']['tmp_name'];
        $fileName = $_FILES['gambar_baru']['name'];
        $fileSize = $_FILES['gambar_baru']['size'];
        $fileType = $_FILES['gambar_baru']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Generate unique file name
        $newFileName = rand(0, 9999) . '-' . $fileName;

        // Directory where the file will be uploaded
        $uploadFileDir = 'image/';
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $gambar = $newFileName;
        } else {
            // Tetap di halaman yang sama jika gagal mengunggah gambar
            header("Location: edit_artikel.php?id_artikel=$id_artikel&status=upload-gagal");
            exit();
        }
    } else {
        // Jika tidak ada gambar baru yang diunggah, gunakan gambar lama
        $gambar = $_POST['gambar_lama'];
    }

    // Query untuk mengupdate artikel
    $sql = "UPDATE artikel SET gambar='$gambar', judul_artikel='$judul_artikel', isi_artikel='$isi_artikel', tanggal='$tanggal', kategori='$kategori', status='$status' WHERE id_artikel='$id_artikel'";

    if ($conn->query($sql) === TRUE) {
        header("Location: artikel.php?status=edit-artikel-success");
        exit;
    } else {
        // Tetap di halaman yang sama jika gagal mengupdate artikel
        header("Location: edit_artikel.php?id_artikel=$id_artikel&status=edit-artikel-gagal");
        exit();
    }
}

// Query untuk menghitung jumlah pengajuan baru dengan status 'Pending'
$jumlah_pengajuan_baru = "SELECT COUNT(*) as total_pengajuan FROM pengajuan WHERE status = 'Pending'";
$hasil = mysqli_query($conn, $jumlah_pengajuan_baru);

$total_pengajuan = 0;

if ($hasil && mysqli_num_rows($hasil) > 0) {
    $row = mysqli_fetch_assoc($hasil);
    $total_pengajuan = $row['total_pengajuan'];
}

// Query untuk mengambil data artikel berdasarkan id
$id_artikel = $_GET['id_artikel'];
$sql = "SELECT * FROM artikel WHERE id_artikel='$id_artikel'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


?>

<?php include 'header.php' ?>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <?php include 'brand.php' ?>
        <ul class="side-menu top">
            <li>
                <a href="./">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="artikel.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_user.php">
                    <i class='bx bxs-file'></i>
                    <span class="text">Pengajuan User 
                        <?php if ($total_pengajuan > 0): ?>
                            <sup><?php echo $total_pengajuan; ?></sup>
                        <?php endif; ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="galeri.php">
                    <i class='bx bxs-camera' ></i>
                    <span class="text">Galeri Desa</span>
                </a>
            </li>
            <li>
                <a href="tambah_user.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Tambah User</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="tambah_admin.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">Tambah Admin</span>
                </a>
            </li>
            <li>
                <a href="profile_akun.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Profile Akun</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="logout">
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
        <?php include 'navbar.php' ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Edit Artikel</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.php">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a href="">Artikel</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="">Edit Artikel</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="formulir-pengajuan" id="pengajuanForm">
                        <div class="head">
                            <h3>Edit Artikel</h3>
                        </div>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="id_artikel" value="<?php echo $row['id_artikel']; ?>">
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="judul_artikel">Judul Artikel:</label>
                                        <input type="text" id="judul_artikel" name="judul_artikel" value="<?php echo $row['judul_artikel']; ?>" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="tanggal">Tanggal:</label>
                                        <input type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="isi_artikel">Isi Artikel:</label>
                                        <textarea id="isi_artikel" name="isi_artikel" required><?php echo $row['isi_artikel']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="gambar_lama">Gambar Saat Ini:</label>
                                        <img src="image/<?php echo $row['gambar']; ?>" alt="Gambar Saat Ini" style="width:150px;">
                                        <input type="hidden" name="gambar_lama" value="<?php echo $row['gambar']; ?>"> <br>
                                        <?php echo $row['gambar']; ?>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="gambar_baru">Gambar Baru:</label>
                                        <input type="file" id="gambar_baru" name="gambar_baru">
                                    </div>
                                    <div class="data-user">
                                        <label for="kategori">Kategori:</label>
                                        <select name="kategori" id="kategori">
                                            <option value="Berita" <?php if ($row['kategori'] == 'Berita') echo 'selected'; ?>>Berita</option>
                                            <option value="Pengumuman" <?php if ($row['kategori'] == 'Pengumuman') echo 'selected'; ?>>Pengumuman</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="status">Status:</label>
                                        <select id="status" name="status">
                                            <option value="Publish" <?php if ($row['status'] == 'Publish') echo 'selected'; ?>>Publish</option>
                                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit">Update Artikel</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="../user/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Check URL parameters for status
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'edit-artikel-gagal') {
            Swal.fire({
                icon: 'error',
                title: 'Edit artikel gagal!',
                text: 'Silahkan coba lagi',
                customClass: {
                    popup: 'swal2-popup'
                }
            });
        } else if (status === 'upload-gagal') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal mengunggah gambar!',
                text: 'Silahkan coba lagi',
                customClass: {
                    popup: 'swal2-popup'
                }
            });
        }
    </script>
</body>
</html>

</html>
