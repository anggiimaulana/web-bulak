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
    $sql = "SELECT id_galeri, gambar, judul,tanggal FROM galeri ORDER BY id_galeri DESC";
    $result = $conn->query($sql);

    // Query untuk menghitung jumlah pengajuan baru dengan status 'Pending'
    $jumlah_pengajuan_baru = "SELECT COUNT(*) as total_pengajuan FROM pengajuan WHERE status = 'Pending'";
    $hasil = mysqli_query($conn, $jumlah_pengajuan_baru);

    $total_pengajuan = 0;

    if ($hasil && mysqli_num_rows($hasil) > 0) {
        $row = mysqli_fetch_assoc($hasil);
        $total_pengajuan = $row['total_pengajuan'];
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
                <a href="#.php">
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
                    <h1>Galeri Desa</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.php">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="index.php">Galeri</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Galeri</h3>
                        <button onclick="window.location.href='tambah-galeri.php'">Tambah Galeri</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {

                                    $judul = $row['judul'];
                                    // Potong judul artikel jika lebih dari 50 karakter
                                    if (strlen($judul) > 50) {
                                        $judul = substr($judul, 0, 50) . '...';
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td><img src='image/" . $row['gambar'] . "' alt='Gambar' style='width:50px; height: 50px;'></td>";
                                    echo "<td>" . $judul . "</td>";
                                    echo "<td>" . $row['tanggal'] . "</td>";
                                    echo "<td>
                                        <a href='edit-galeri.php?id_galeri=" . $row['id_galeri'] . "' class='status edit'>Edit</a>
                                        <span>
                                        <a href='proses/hapus-galeri.php?id_galeri=" . $row['id_galeri'] . "' class='status hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus galeri ini?\")'>Hapus</a>
                                        </span>
                                    </td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>Tidak ada galeri!</td></tr>";
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

		if (status === 'success') {
			Swal.fire({
				icon: 'success',
				title: 'Galeri berhasil di upload!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'edit-galeri-success') {
            Swal.fire({
				icon: 'success',
				title: 'Galeri berhasil di edit!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'hapus-success') {
            Swal.fire({
				icon: 'success',
				title: 'Galeri berhasil di hapus!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'hapus-gagal') {
            Swal.fire({
				icon: 'error',
				title: 'Galeri gagal di hapus!',
                text: 'Sillahkan coba lagi!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'galeri-tidak-ditemukan') {
            Swal.fire({
				icon: 'error',
				title: 'Galeri tidak ditemukan!',
                text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'id-tidak-valid') {
            Swal.fire({
				icon: 'error',
				title: 'Id galeri tidak valid!',
                text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        }
    </script>

</body>
</html>