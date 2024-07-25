<?php
// Menghubungkan koneksi.php
include '../config/db.php';

// Menangani permintaan edit artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_artikel = $_POST['id_artikel'];
    $gambar = $_POST['gambar'];
    $judul_artikel = $_POST['judul_artikel'];
    $isi_artikel = $_POST['isi_artikel'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    // Query untuk mengupdate artikel
    $sql = "UPDATE artikel SET gambar='$gambar', judul_artikel='$judul_artikel', isi_artikel='$isi_artikel', tanggal='$tanggal', status='$status' WHERE id_artikel='$id_artikel'";

    if ($conn->query($sql) === TRUE) {
        header("Location: artikel.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query untuk mengambil data artikel berdasarkan id
$id_artikel = $_GET['id_artikel'];
$sql = "SELECT * FROM artikel WHERE id_artikel='$id_artikel'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
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
                    <h1>Edit Artikel</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="index.php">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="">Edit Artikel</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Edit Artikel</h3>
                    </div>
                    <form method="POST" action="">
                        <input type="hidden" name="id_artikel" value="<?php echo $row['id_artikel']; ?>">
                        <div>
                            <label for="judul_artikel">Judul Artikel:</label>
                            <input type="text" id="judul_artikel" name="judul_artikel" value="<?php echo $row['judul_artikel']; ?>">
                        </div>
                        <div>
                            <label for="isi_artikel">Isi Artikel:</label>
                            <textarea id="isi_artikel" name="isi_artikel"><?php echo $row['isi_artikel']; ?></textarea>
                        </div>
                        <div>
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>">
                        </div>
                        <div>
                            <label for="gambar">Gambar:</label>
                            <input type="file" id="gambar" name="gambar" value="<?php echo $row['gambar']; ?>">
                        </div>
                        <div>
                            <label for="status">Status:</label>
                            <select id="status" name="status">
                                <option value="publish" <?php if ($row['status'] == 'publish') echo 'selected'; ?>>publish</option>
                                <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>pending</option>
                            </select>
                        </div>
                        <button type="submit">Update Artikel</button>
                    </form>
                </div>
            </div>
           
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="script.js"></script>
</body>
</html>
