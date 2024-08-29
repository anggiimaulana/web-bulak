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

// Query untuk menghitung jumlah artikel
$sql = "SELECT COUNT(*) as total_artikel FROM artikel";
$result = $conn->query($sql);

// Mengecek apakah query berhasil dijalankan dan ada hasilnya
if ($result->num_rows > 0) {
    // Mendapatkan hasil query
    $row = $result->fetch_assoc();
    $total_artikel = $row['total_artikel'];
} else {
    $total_artikel = 0;
}

// Query untuk menghitung jumlah pengajuan
$sql = "SELECT COUNT(*) as total_pengajuan FROM pengajuan";
$result = $conn->query($sql);

// Mengecek apakah query berhasil dijalankan dan ada hasilnya
if ($result->num_rows > 0) {
    // Mendapatkan hasil query
    $row = $result->fetch_assoc();
    $total_pengajuan = $row['total_pengajuan'];
} else {
    $total_pengajuan = 0;
}

// Query untuk menghitung jumlah akun user
$sql_users_count = "SELECT COUNT(*) as total_user FROM user";
$result_users_count = $conn->query($sql_users_count);

// Mengecek apakah query berhasil dijalankan dan ada hasilnya
if ($result_users_count->num_rows > 0) {
    // Mendapatkan hasil query
    $row_users_count = $result_users_count->fetch_assoc();
    $total_user = $row_users_count['total_user'];
} else {
    $total_user = 0;
}

// Query untuk mengambil data user
$sql_users = "SELECT user_id, nama, nik, pekerjaan, alamat FROM user";
$result_users = $conn->query($sql_users);

// Query untuk mengambil data admin
$sql_admins = "SELECT admin_id, nama, nip, pekerjaan, alamat FROM admin";
$result_admins = $conn->query($sql_admins);

// Query untuk menghitung jumlah pengajuan baru dengan status 'Pending'
$jumlah_pengajuan_baru = "SELECT COUNT(*) as total_pengajuan_user FROM pengajuan WHERE status = 'Pending'";
$hasil = mysqli_query($conn, $jumlah_pengajuan_baru);

$total_pengajuan_user = 0;

if ($hasil && mysqli_num_rows($hasil) > 0) {
    $row = mysqli_fetch_assoc($hasil);
    $total_pengajuan_user = $row['total_pengajuan_user'];
}
?>

<?php include 'header.php' ?>
<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <?php include 'brand.php' ?>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
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
                        <?php if ($total_pengajuan_user > 0): ?>
                            <sup><?php echo $total_pengajuan_user; ?></sup>
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

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'navbar.php' ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.php">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="index.php">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-group' ></i>
                    <span class="text">
                        <h3><?php echo $total_user; ?></h3>
                        <p>Jumlah Akun User</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-spreadsheet' ></i>
                    <span class="text">
                        <h3><?php echo $total_pengajuan ?></h3>
                        <p>Jumlah Pengajuan</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">
                    <h3><?php echo $total_artikel; ?></h3>
                        <p>Jumlah Artikel</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar User</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_users->num_rows > 0) {
                                $no = 1;
                                while($row = $result_users->fetch_assoc()) {
                                    $alamat = isset($row['alamat']) ? $row['alamat'] : '';

                                    // Potong alamat jika lebih dari 50 karakter
                                    if (strlen($alamat) > 50) {
                                        $alamat = substr($alamat, 0, 50) . '...';
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td><p>" . htmlspecialchars($row["nama"]) . "</p></td>";
                                    echo "<td>" . htmlspecialchars($row["nik"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["pekerjaan"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($alamat) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No data available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Admin</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Pekerjaan</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_admins->num_rows > 0) {
                                $no = 1;
                                while($row = $result_admins->fetch_assoc()) {
                                    $alamat = isset($row['alamat']) ? $row['alamat'] : '';

                                    // Potong alamat jika lebih dari 50 karakter
                                    if (strlen($alamat) > 50) {
                                        $alamat = substr($alamat, 0, 50) . '...';
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td><p>" . htmlspecialchars($row["nama"]) . "</p></td>";
                                    echo "<td>" . htmlspecialchars($row["nip"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["pekerjaan"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($alamat) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No data available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    
    <script src="../user/js/script.js"></script>
</body>
</html>
