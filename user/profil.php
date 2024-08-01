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
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="pengajuan.php">
					<i class='bx bxs-file' ></i>
					<span class="text">Pengajuan</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">			
			<li class="active">
				<a href="profil.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Profil Akun</span>
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
		<?php include "navbar.php" ?>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Profil Akun</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.html">User</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Profil Akun</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
            <div class="order">
                <div class="formulir-pengajuan"  id="pengajuanForm">
                    <form method="post">
                        <div class="form-row">
                            <div class="form-column">
                                <div class="data-user">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" value="<?php echo $userData['nama']; ?>" disabled>
                                </div>
                                <div class="data-user">
                                    <label for="nik">NIK</label>
                                    <input type="number" name="nik" id="nik" value="<?php echo $userData['nik']; ?>" disabled>
                                </div>
                                <div class="data-user">
                                    <div class="ttl">
                                        <label for="tempat">Tempat Lahir</label>
                                        <input type="text" name="tempat" id="tempat" value="<?php echo $userData['tempat_lahir']; ?>" disabled>
                                    </div>
                                    <div class="ttl">
                                        <label for="tanggal">Tanggal Lahir</label>
                                        <input type="text" name="tanggal" id="tanggal" value="<?php echo $userData['tanggal_lahir']; ?>" disabled>
                                    </div>
                                </div>
								<div class="data-user">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" value="<?php echo $userData['jenis_kelamin']; ?>" disabled>
                                </div>
                                <div class="data-user">
                                    <label for="agama">Agama</label>
                                    <input type="text" name="agama" id="agama" value="<?php echo $userData['agama']; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-column">
								<div class="data-user">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat" disabled><?php echo $userData['alamat']; ?></textarea>
                                </div>
                                <div class="data-user">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="pekerjaan" value="<?php echo $userData['pekerjaan']; ?>" disabled>
                                </div>
								<div class="data-user">
                                    <label for="pendidikan">Pendidikan</label>
                                    <input type="text" name="pendidikan" id="pendidikan" value="<?php echo $userData['pendidikan']; ?>" disabled>
                                </div>
                                <div class="data-user">
                                    <label for="status_pernikahan">Status Pernikahan</label>
                                    <input type="text" name="status_pernikahan" id="status_pernikahan" value="<?php echo $userData['status_pernikahan']; ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </form>
					<button onclick="window.location.href='edit-profil.php'">Edit Profil</button>
                </div>
            </div>
        	</div>
			
		</main>

		<script>
		// Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'success') {
			Swal.fire({
				icon: 'success',
				title: 'Data Berhasil di Update!',
				// text: 'Menunggu Persetujuan Admin.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error') {
			Swal.fire({
				icon: 'error',
				title: 'Proses Update Data Gagal!',
				text: 'Silahkan ulangi kembali.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		}
	</script>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="js/script.js"></script>
</body>
</html>