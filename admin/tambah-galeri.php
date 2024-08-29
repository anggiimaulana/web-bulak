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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $judul = $_POST['judul'];
        $tanggal = $_POST['tanggal'];
    
        // Proses unggah gambar
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['gambar']['tmp_name'];
            $fileName = $_FILES['gambar']['name'];
            $fileSize = $_FILES['gambar']['size'];
            $fileType = $_FILES['gambar']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Generate unique file name
            $newFileName = rand(0, 9999) . '-' . $fileName;
    
            // Directory where the file will be uploaded
            $uploadFileDir = 'image/';
            $dest_path = $uploadFileDir . $newFileName;
    
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $gambar = $newFileName;
    
                // Query untuk menambah artikel
                $sql = "INSERT INTO galeri (gambar, judul, tanggal) VALUES ('$gambar', '$judul','$tanggal')";
    
                if ($conn->query($sql) === true) {
                    header("Location: galeri.php?status=success");
                    exit;
                } else {
                    header("Location: tambah-galeri.php?status=error");
                    // echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        } else {
            echo 'There was some error in the file upload. Please check the following error.<br>';
            echo 'Error:' . $_FILES['gambar']['error'];
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
?>

<?php include 'header.php' ?>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <?php include 'brand.php' ?>
        <ul class="side-menu top">
            <li>
                <a href="./">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="artikel.php">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_user.php">
                    <i class='bx bxs-file' ></i>
                    <span class="text">Pengajuan User 
                        <?php if ($total_pengajuan > 0): ?>
                            <sup><?php echo $total_pengajuan; ?></sup>
                        <?php endif; ?>
                    </span>
                </a>
            </li>
            <li class="active">
                <a href="galeri.php">
                    <i class='bx bxs-camera' ></i>
                    <span class="text">Galeri Desa</span>
                </a>
            </li>
            <li>
                <a href="tambah_user.php">
                    <i class='bx bxs-user-plus' ></i>
                    <span class="text">Tambah User</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="tambah_admin.php">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Tambah Admin</span>
                </a>
            </li>
            <li>
                <a href="profile_akun.php">
                    <i class='bx bxs-user' ></i>
                    <span class="text">Profile Akun</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <section id="content">
        <!-- NAVBAR -->
        <?php include 'navbar.php' ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Tambah Galeri</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.php">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a href="index.php">Galeri</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="index.php">Tambah</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="formulir-pengajuan" id="pengajuanForm">
                        <div class="head">
                            <h3>Tambah Galeri</h3>
                        </div>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="judul">Nama Kegiatan:</label>
                                        <input type="text" id="judul" name="judul" required>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="gambar">Gambar:</label>
                                        <input type="file" id="gambar" name="gambar" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="tanggal">Tanggal:</label>
                                        <input type="date" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit">Upload</button>
                        </form>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="../user/js/script.js"></script>
    <script>
        // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'error') {
			Swal.fire({
				icon: 'error',
				title: 'Galeri gagal di upload!',
				text: 'Silahkan ulangi lagi',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		}
    </script>

</body>
</html>