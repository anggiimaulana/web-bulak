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

    // Query untuk mengambil data artikel
    $sql = "SELECT id_artikel, gambar, judul_artikel, isi_artikel, tanggal, kategori, status FROM artikel ORDER BY id_artikel DESC";
    $result = $conn->query($sql);

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
        <?php include 'navbar.php'; ?>
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
                                <th>Kategori</th>
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
                                    echo "<td>" . $row['kategori'] . "</td>";
                                    $statusClass = $row['status'] == 'Publish' ? 'completed' : 'pending';
                                    echo "<td><span class='status " . $statusClass . "'>" . ($row['status'] == 'Publish' ? 'Publish' : 'Pending') . "</span></td>";
                                    echo "<td>
                                        <a href='edit_artikel.php?id_artikel=" . $row['id_artikel'] . "' class='status edit'>Edit</a>
                                        <span>
                                        <a href='proses/hapus-artikel.php?id_artikel=" . $row['id_artikel'] . "' class='status hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus artikel ini?\")'>Hapus</a>
                                        </span>
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
    <script>
        // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'tambah-artikel-success') {
			Swal.fire({
				icon: 'success',
				title: 'Artikel berhasil ditambahkan!',
				text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'edit-artikel-success') {
			Swal.fire({
				icon: 'success',
				title: 'Artikel berhasil di edit!',
				text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'artikel-berhasil-dihapus') {
            Swal.fire({
				icon: 'success',
				title: 'Artikel berhasil dihapus!',
				text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'artikel-gagal-dihapus') {
            Swal.fire({
				icon: 'error',
				title: 'Artikel gagal dihapus!',
				text: 'Silahkan ulangi kembali!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        }

    </script>
</body>
</html>
