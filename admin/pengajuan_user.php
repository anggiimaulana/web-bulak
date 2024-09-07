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

// Check for reset parameter
if (isset($_GET['reset'])) {
    $kategori = 0;
    $search = '';
} else {
    // Get filter and search parameters
    $kategori = isset($_GET['kategori']) ? (int)$_GET['kategori'] : 0;
    $status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    
    // Query to fetch data
    $sql = "SELECT p.id_pengajuan, u.nama AS nama_user, k.jenis_pengajuan, p.tanggal_pengajuan, p.tanggal_acc, p.status 
            FROM pengajuan p
            JOIN user u ON p.nik = u.nik
            JOIN kategori_pengajuan k ON p.id_kategori = k.id_kategori_pengajuan";
    
    // Add conditions for filter and search
    if ($kategori > 0) {
        $sql .= " WHERE p.id_kategori = $kategori";
    } else {
        $sql .= " WHERE 1=1"; // to avoid syntax error
    }
    
    if (!empty($status)) {
        $sql .= " AND p.status = '$status'";
    }
    
    if (!empty($search)) {
        $sql .= " AND UPPER(u.nama) LIKE UPPER('%$search%')";
    }
}
    
    $sql .= " ORDER BY p.id_pengajuan DESC";
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

<?php include 'header.php'; ?>
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
            <li>
                <a href="artikel.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li class="active">
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
                        <!-- Filter dan Search -->
                        <div class="filters">
                            <a href="#" class="filter-toggle" id="filter-toggle">
                                <i class="bx bx-filter"></i> Filter
                            </a>
                            <div class="filter-menu" id="filter-menu">
                                <form method="GET" action="pengajuan_user.php">
                                    <h5>Kategori</h5>
                                    <select name="kategori" onchange="this.form.submit()">
                                        <option value="" <?php if ($kategori == 0) echo 'selected';?>>Semua</option>
                                        <option value="1" <?php if ($kategori == 1) echo 'selected';?>>Surat Keterangan Usaha</option>
                                        <option value="2" <?php if ($kategori == 2) echo 'selected';?>>Surat Keterangan Beda Nama</option>
                                        <option value="3" <?php if ($kategori == 3) echo 'selected';?>>Surat Keterangan Tidak Mampu</option>
                                        <option value="4" <?php if ($kategori == 4) echo 'selected';?>>Surat Keterangan Penduduk Sementara</option>
                                        <option value="5" <?php if ($kategori == 5) echo 'selected';?>>Surat Keterangan Domisili</option>
                                        <option value="6" <?php if ($kategori == 6) echo 'selected';?>>Surat Keterangan</option>
                                        <option value="7" <?php if ($kategori == 7) echo 'selected';?>>Surat Keterangan Penghasilan Orang Tua</option>
                                    </select>
                                    <h5 style="margin-top: 10px;">Status</h5>
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="" <?php if ($status == '') echo 'selected';?>>Semua</option>
                                        <option value="Acc" <?php if ($status == 'Acc') echo 'selected';?>>Acc</option>
                                        <option value="Pending" <?php if ($status == 'Pending') echo 'selected';?>>Pending</option>
                                    </select>
                                </form>
                            </div>
                            <a href="#" class="search-toggle" id="search-toggle">
                                <i class="bx bx-search"></i> Cari
                            </a>
                            <div class="search-menu" id="search-menu">
                                <form method="GET" action="pengajuan_user.php" class="search-form">
                                    <input type="text" name="search" placeholder="Cari Nama User" value="<?php echo htmlspecialchars($search);?>">
                                    <button class="pencarian" type="submit">Cari</button>
                                </form>
                            </div>
                            <a href="pengajuan_user.php" class="reset">Reset</a> <!-- Reset link -->
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Acc</th>
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

                                    // Menentukan URL berdasarkan jenis pengajuan
                                    $url = 'pengajuan/';
                                    switch ($row['jenis_pengajuan']) {
                                        case 'Surat Keterangan Usaha':
                                            $url .= 'sku.php';
                                            break;
                                        case 'Surat Keterangan Beda Nama':
                                            $url .= 'skbn.php';
                                            break;
                                        case 'Surat Keterangan Tidak Mampu':
                                            $url .= 'sktm.php';
                                            break;
                                        case 'Surat Keterangan Penduduk Sementara':
                                            $url .= 'skps.php';
                                            break;
                                        case 'Surat Keterangan Domisili':
                                            $url .= 'skd.php';
                                            break;
                                        case 'Surat Keterangan':
                                            $url .= 'sk.php';
                                            break;
                                        case 'Surat Keterangan Penghasilan Orang Tua':
                                            $url .= 'skpot.php';
                                            break;
                                        default:
                                            $url .= 'sk.php'; // Default URL jika tidak ada yang sesuai
                                    }

                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td><p>" . htmlspecialchars($row['nama_user']) . "</p></td>";
                                    echo "<td>" . htmlspecialchars($row['jenis_pengajuan']) . "</td>";
                                    echo "<td>" . date('d-m-Y', strtotime($row['tanggal_pengajuan'])) . "</td>";
                                    echo "<td>" . (!empty($row['tanggal_acc']) ? date('d-m-Y', strtotime($row['tanggal_acc'])) : '-') . "</td>";
                                    echo "<td><span class='status " . htmlspecialchars($statusClass) . "'>" . htmlspecialchars(ucfirst($row['status'])) . "</span></td>";
                                    echo "<td><a href='" . $url . "?id=" . $row['id_pengajuan'] . "' class='status edit'>Tinjau</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada data yang tersedia!</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <script src="../user/js/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterToggle = document.getElementById('filter-toggle');
        const searchToggle = document.getElementById('search-toggle');
        const filterMenu = document.getElementById('filter-menu');
        const searchMenu = document.getElementById('search-menu');

        // Toggle filter menu
        filterToggle.addEventListener('click', function() {
            filterMenu.style.display = filterMenu.style.display === 'block' ? 'none' : 'block';
            searchMenu.style.display = 'none'; // Hide search menu
        });

        // Toggle search menu
        searchToggle.addEventListener('click', function() {
            searchMenu.style.display = searchMenu.style.display === 'block' ? 'none' : 'block';
            filterMenu.style.display = 'none'; // Hide filter menu
        });

        // Hide menu if clicking outside
        document.addEventListener('click', function(event) {
            if (!filterMenu.contains(event.target) && !filterToggle.contains(event.target)) {
                filterMenu.style.display = 'none';
            }

            if (!searchMenu.contains(event.target) && !searchToggle.contains(event.target)) {
                searchMenu.style.display = 'none';
            }
        });
    });

    // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('keterangan');

		if (status === 'pengajuan-sk-success') {
			Swal.fire({
				icon: 'success',
				title: 'Status pengajuan berhasil di update!',
				text: 'Silahkan menghubungi user agar segera mengunduh file!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'pengajuan-skbn-success') {
			Swal.fire({
				icon: 'success',
				title: 'Status pengajuan berhasil di update!',
				text: 'Silahkan menghubungi user agar segera mengunduh file!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'pengajuan-skd-success') {
			Swal.fire({
				icon: 'success',
				title: 'Status pengajuan berhasil di update!',
				text: 'Silahkan menghubungi user agar segera mengunduh file!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'pengajuan-skps-success') {
			Swal.fire({
				icon: 'success',
				title: 'Status pengajuan berhasil di update!',
				text: 'Silahkan menghubungi user agar segera mengunduh file!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'pengajuan-sktm-success') {
			Swal.fire({
				icon: 'success',
				title: 'Status pengajuan berhasil di update!',
				text: 'Silahkan menghubungi user agar segera mengunduh file!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'pengajuan-sku-success') {
			Swal.fire({
				icon: 'success',
				title: 'Status pengajuan berhasil di update!',
				text: 'Silahkan menghubungi user agar segera mengunduh file!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		}
    </script>
</body>
</html>
