<?php
	session_start(); // Memulai sesi
	include "header.php";
	require '../config/db.php';
	
	// Mengecek apakah pengguna sudah login
	if (!isset($_SESSION['nik'])) {
		header('Location: ../login.php');
		exit();
	}

    // Mendapatkan data pengguna dari tabel user
    $nik = $_SESSION['nik'];
    $sql = "SELECT * FROM user WHERE nik = '$nik'";
    $result = mysqli_query($conn, $sql);
    $userData = mysqli_fetch_assoc($result);

    // Membatasi panjang nama menjadi maksimal 15 karakter
    $displayName = $userData['nama'];
    if (strlen($displayName) > 30) {
        $displayName = substr($displayName, 0, 30) . '...';
    }
    
?>

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
            <li class="active">
                <a href="#">
                    <i class='bx bxs-file'></i>
                    <span class="text">Pengajuan</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="profil.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Profil Akun</span>
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
        <?php include "navbar.php" ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Pengajuan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.html">User</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Pengajuan</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <?php 
                $pengajuan = "SELECT * FROM kategori_pengajuan ORDER BY id_kategori_pengajuan";
                $result = mysqli_query($conn, $pengajuan);

                if ($result) {
                    $row1 = mysqli_fetch_assoc($result);
                    $row2 = mysqli_fetch_assoc($result);
                    $row3 = mysqli_fetch_assoc($result);
                    $row4 = mysqli_fetch_assoc($result);
                    $row5 = mysqli_fetch_assoc($result);
                    $row6 = mysqli_fetch_assoc($result);
                    $row7 = mysqli_fetch_assoc($result);
                }
                ?>
                <li data-jenis="sku">
                    <i class='bx bx-store'></i>
                    <span class="text">
                        <p><?php echo $row1['jenis_pengajuan']; ?></p>
                    </span>
                </li>
                <li data-jenis="skbn">
                    <i class='bx bxs-spreadsheet'></i>
                    <span class="text">
                        <p><?php echo $row2['jenis_pengajuan']; ?></p>
                    </span>
                </li>
                <li data-jenis="sktm">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">
                        <p><?php echo $row3['jenis_pengajuan']; ?></p>
                    </span>
                </li>
                <li data-jenis="skps">
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <p><?php echo $row4['jenis_pengajuan']; ?></p>
                    </span>
                </li>
                <li data-jenis="skd">
                    <i class='bx bx-current-location'></i>
                    <span class="text">
                        <p><?php echo $row5['jenis_pengajuan']; ?></p>
                    </span>
                </li>
                <li data-jenis="sk">
                    <i class='bx bx-mail-send'></i>
                    <span class="text">
                        <p><?php echo $row6['jenis_pengajuan']; ?></p>
                    </span>
                </li>
                <li data-jenis="skpot">
                    <i class='bx bx-wallet'></i>
                    <span class="text">
                        <p><?php echo $row7['jenis_pengajuan']; ?></p>
                    </span>
                </li>
            </ul>

            
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    
    <!-- script untuk mengatur pengajuan -->
    <script src="js/index.js"></script>

    <script src="js/script.js"></script>
</body>
</html>
