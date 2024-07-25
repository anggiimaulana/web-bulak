<?php 
// Menghubungkan ke database
require '../config/db.php'; 

// Query untuk mengambil data pengajuan dengan join
$sql = "SELECT p.id_pengajuan, u.nama AS nama_user, k.jenis_pengajuan, p.tanggal_pengajuan, p.status 
        FROM pengajuan p
        JOIN user u ON p.nik = u.nik
        JOIN kategori_pengajuan k ON p.id_kategori = k.id_kategori_pengajuan order by id_pengajuan desc";
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
            <li>
                <a href="artikel.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li class="active">
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
                    <i class='bx bxs-cog'></i>
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
                    <h1>Pengajuan User</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Admin</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="pengajuan_user.php">Pengajuan User</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Pengajuan</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Menampilkan data pengajuan
                            if ($result->num_rows > 0) {
                                $no = 1; // Nomor urut
                                while($row = $result->fetch_assoc()) {
                                    // Menentukan kelas status berdasarkan nilai status
                                    $statusClass = '';
                                    if ($row['status'] == 'Acc') {
                                        $statusClass = 'completed'; // Kelas CSS untuk status "acc"
                                    } elseif ($row['status'] == 'Pending') {
                                        $statusClass = 'pending'; // Kelas CSS untuk status "pending"
                                    } else {
                                        $statusClass = 'process'; // Kelas CSS default untuk status lainnya
                                    }
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td><p>" . htmlspecialchars($row['nama_user']) . "</p></td>";
                                    echo "<td>" . htmlspecialchars($row['jenis_pengajuan']) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['tanggal_pengajuan'])) . "</td>";
                                    echo "<td><span class='status " . htmlspecialchars($statusClass) . "'>" . htmlspecialchars(ucfirst($row['status'])) . "</span></td>";
                                    echo "<td><a href='edit-pengajuan.php?id=" . $row['id_pengajuan'] . "' class='status edit'>Edit</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No data available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <script src="../user/js/script.js"></script>
</body>
</html>
