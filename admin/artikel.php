<?php
session_start(); // Memulai sesi
require '../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../login-admin.php');
    exit();
}

// Query untuk mengambil data artikel
$sql = "SELECT id_artikel, gambar, judul_artikel, isi_artikel, tanggal, status FROM artikel ORDER BY id_artikel DESC";
$result = $conn->query($sql);
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
                    <span class="text">Pengajuan User</span>
                </a>
            </li>
            <li>
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
                <a href="#" class="logout">
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
        <nav>
            <i class='bx bx-menu'></i>
            <input type="checkbox" id="switch-mode" hidden>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Artikel</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.php">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="artikel.php">Artikel</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Artikel</h3>
                        <button onclick="window.location.href='tambah_artikel.php'">Tambah Artikel</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul Artikel</th>
                                <th>Isi Artikel</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $isi_artikel = $row['isi_artikel'];
                                    // Potong isi artikel jika lebih dari 50 karakter
                                    if (strlen($isi_artikel) > 50) {
                                        $isi_artikel = substr($isi_artikel, 0, 50) . '...';
                                    }

									$judul = $row['judul_artikel'];
                                    // Potong judul artikel jika lebih dari 50 karakter
                                    if (strlen($judul) > 50) {
                                        $judul = substr($judul, 0, 50) . '...';
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td><img src='image/" . $row['gambar'] . "' alt='Gambar' style='width:50px; height: 50px;'></td>";
                                    echo "<td>" . $judul . "</td>";
                                    echo "<td>" . $isi_artikel . "</td>";
                                    echo "<td>" . $row['tanggal'] . "</td>";
                                    $statusClass = $row['status'] == 'Publish' ? 'completed' : 'pending';
                                    echo "<td><span class='status " . $statusClass . "'>" . ($row['status'] == 'Publish' ? 'Publish' : 'Pending') . "</span></td>";
                                    echo "<td>
                                        <a href='edit_artikel.php?id_artikel=" . $row['id_artikel'] . "' class='status edit'>Edit</a>
                                    </td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>Tidak ada artikel ditemukan</td></tr>";
                            }
                            $conn->close();
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
