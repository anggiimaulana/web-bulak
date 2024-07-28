<?php
session_start(); // Memulai sesi
require '../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../login-admin.php');
    exit();
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
        header("Location: kritik-saran.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<?php include 'header.php' ?>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Administrator</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="index.php">
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
                    <span class="text">Pengajuan User</span>
                </a>
            </li>
            <li class="active">
                <a href="kritik-saran.php">
                    <i class='bx bxl-discord' ></i>
                    <span class="text">Kritik Dan Saran</span>
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
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu' ></i>
            <input type="checkbox" id="switch-mode" hidden>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Edit Kritik Dan Saran</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Admin</a></li>
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
                        <div id="notification" style="display: none; color: red;">
                            Harap isi semua kolom yang diperlukan!
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </section>
    <    <script src="../user/js/script.js"></>
</body>
</html>
