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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM kritik_saran WHERE id_kritik_saran = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak tersedia!";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_kritik_saran"];
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $kritik_dan_saran = $_POST["kritik_saran"];
    $status = $_POST["status"];

    $sql = "UPDATE kritik_saran SET nama='$nama', email='$email', isi='$kritik_dan_saran', status='$status' WHERE id_kritik_saran=$id";

    if ($conn->query($sql) === true) {
        echo "Record updated successfully";
        header("Location: kritik-saran.php?status=success");
    } else {
        header("Location: edit_kritik_saran.php?id=$id&status=failure");
    }
}

$conn->close();
?>


<?php include 'header.php' ?>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <?php include 'brand.php' ?>
        <ul class="side-menu top">
            <li>
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="artikel.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_user.php">
                    <i class='bx bxs-file'></i>
                    <span class="text">Pengajuan User</span>
                </a>
            </li>
            <li>
                <a href="galeri.php">
                    <i class='bx bxs-camera' ></i>
                    <span class="text">Galeri Desa</span>
                </a>
            </li>
            <li class="active">
                <a href="kritik-saran.php">
                    <i class='bx bxl-discord'></i>
                    <span class="text">Kritik Dan Saran</span>
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
                    <h1>Edit Kritik Dan Saran</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Admin</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a href="index.php">Kritik dan Saran</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="kritik-saran.php">Edit Kritik Dan Saran</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="formulir-pengajuan" id="pengajuanForm">
                        <div class="head">
                            <h3>Form Edit Kritik Dan Saran</h3>
                        </div>
                        <form action="edit_kritik_saran.php" method="POST">
                            <input type="hidden" name="id_kritik_saran" value="<?php echo $row['id_kritik_saran']; ?>">
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="nama">Nama</label>
                                        <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" value="<?php echo $row['email']; ?>" required>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="kritik_saran">Kritik dan Saran</label>
                                        <textarea name="kritik_saran" id="kritik_saran" required><?php echo $row['isi']; ?></textarea>
                                    </div>
                                    <div class="data-user">
                                        <label for="status">Status:</label>
                                        <select id="status" name="status" required>
                                            <option value="Dibaca" <?php if ($row['status'] == 'Dibaca') echo 'selected'; ?>>Dibaca</option>
                                            <option value="Belum Dibaca" <?php if ($row['status'] == 'Belum Dibaca') echo 'selected'; ?>>Belum Dibaca</option>
                                        </select><br><br>
                                    </div>
                                </div>
                            </div>
                            <button type="submit">Update</button>
                        </form>
                        <?php
                        if (isset($_GET['status']) && $_GET['status'] == 'failure') {
                            echo "<div id='notification' style='color: red;'>Gagal mengupdate data, silakan coba lagi.</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <script src="../user/js/script.js"></script>
    <script>
        // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'failure') {
			Swal.fire({
				icon: 'error',
				title: 'Gagal!',
				text: 'Silahkan coba lagi',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		}
    </script>
</body>
</html>
