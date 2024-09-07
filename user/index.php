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

	// Fungsi untuk menentukan URL berdasarkan id_kategori
	function getUrlByKategori($id_kategori, $id_pengajuan) {
		switch ($id_kategori) {
			case 1:
				return "pengajuan/cetak-dokumen/sku.php?id_pengajuan=" . $id_pengajuan;
			case 2:
				return "pengajuan/cetak-dokumen/skbn.php?id_pengajuan=" . $id_pengajuan;
			case 3:
				return "pengajuan/cetak-dokumen/sktm.php?id_pengajuan=" . $id_pengajuan;
			case 4:
				return "pengajuan/cetak-dokumen/skps.php?id_pengajuan=" . $id_pengajuan;
			case 5:
				return "pengajuan/cetak-dokumen/skd.php?id_pengajuan=" . $id_pengajuan;
			case 6:
				return "pengajuan/cetak-dokumen/sk.php?id_pengajuan=" . $id_pengajuan;
			case 7:
				return "pengajuan/cetak-dokumen/skpot.php?id_pengajuan=" . $id_pengajuan;
			default:
				return "#";
		}
	}
?>

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
				<a href="pengajuan.php">
					<i class='bx bxs-file' ></i>
					<span class="text">Pengajuan</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">			
			<li>
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
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.php">User</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Dashboard</a>
						</li>
					</ul>
				</div>
			</div>

			<?php
				// Pastikan NIK ada dalam session
				if (!isset($_SESSION['nik'])) {
					die("NIK tidak ditemukan dalam session.");
				}

				$nik = $_SESSION['nik'];

				// Inisialisasi variabel untuk menyimpan hasil
				$total_pengajuan = 0;
				$acc_pengajuan = 0;
				$pending_pengajuan = 0;

				// Query untuk menghitung jumlah total pengajuan
				$sql_total = "SELECT COUNT(*) AS total_pengajuan FROM pengajuan WHERE nik = ?";
				$stmt_total = $conn->prepare($sql_total);
				if ($stmt_total === false) {
					die('Prepare failed: ' . htmlspecialchars($conn->error));
				}
				$stmt_total->bind_param('s', $nik);
				$stmt_total->execute();
				$result_total = $stmt_total->get_result();
				if ($result_total === false) {
					die('Get result failed: ' . htmlspecialchars($stmt_total->error));
				}
				if ($row_total = $result_total->fetch_assoc()) {
					$total_pengajuan = $row_total['total_pengajuan'];
				}

				// Query untuk menghitung jumlah pengajuan yang disetujui
				$sql_acc = "SELECT COUNT(*) AS acc_pengajuan FROM pengajuan WHERE nik = ? AND status = 'Acc'";
				$stmt_acc = $conn->prepare($sql_acc);
				if ($stmt_acc === false) {
					die('Prepare failed: ' . htmlspecialchars($conn->error));
				}
				$stmt_acc->bind_param('s', $nik);
				$stmt_acc->execute();
				$result_acc = $stmt_acc->get_result();
				if ($result_acc === false) {
					die('Get result failed: ' . htmlspecialchars($stmt_acc->error));
				}
				if ($row_acc = $result_acc->fetch_assoc()) {
					$acc_pengajuan = $row_acc['acc_pengajuan'];
				}

				// Query untuk menghitung jumlah pengajuan yang pending
				$sql_pending = "SELECT COUNT(*) AS pending_pengajuan FROM pengajuan WHERE nik = ? AND status = 'Pending'";
				$stmt_pending = $conn->prepare($sql_pending);
				if ($stmt_pending === false) {
					die('Prepare failed: ' . htmlspecialchars($conn->error));
				}
				$stmt_pending->bind_param('s', $nik);
				$stmt_pending->execute();
				$result_pending = $stmt_pending->get_result();
				if ($result_pending === false) {
					die('Get result failed: ' . htmlspecialchars($stmt_pending->error));
				}
				if ($row_pending = $result_pending->fetch_assoc()) {
					$pending_pengajuan = $row_pending['pending_pengajuan'];
				}
			?>

			<?php

				// Pastikan NIK ada dalam session
				if (!isset($_SESSION['nik'])) {
					die("NIK tidak ditemukan dalam session.");
				}

				$nik = $_SESSION['nik'];

				// Koneksi ke database

				if ($conn->connect_error) {
					die("Koneksi gagal: " . $conn->connect_error);
				}

				// Query untuk mengambil data pengajuan
				$sql = "SELECT 
							p.id_pengajuan,
							p.id_kategori,
							p.tanggal_pengajuan,
							p.tanggal_acc,
							p.status,
							k.jenis_pengajuan
						FROM pengajuan p
						JOIN kategori_pengajuan k ON p.id_kategori = k.id_kategori_pengajuan
						WHERE p.nik = ?
						ORDER BY p.id_pengajuan DESC";
				$stmt = $conn->prepare($sql);
				if ($stmt === false) {
					die('Prepare failed: ' . htmlspecialchars($conn->error));
				}
				$stmt->bind_param('s', $nik);
				$stmt->execute();
				$result = $stmt->get_result();
				if ($result === false) {
					die('Get result failed: ' . htmlspecialchars($stmt->error));
				}

				$total_pengajuan = $result->num_rows; // Menyimpan jumlah pengajuan

				$acc_pengajuan = 0;
				$pending_pengajuan = 0;

				while ($row = $result->fetch_assoc()) {
					if ($row['status'] == 'Acc') {
						$acc_pengajuan++;
					} elseif ($row['status'] == 'Pending') {
						$pending_pengajuan++;
					}
				}

				?>

				<ul class="box-info">
					<li>
						<i class='bx bxs-spreadsheet'></i>
						<span class="text">
							<h3><?php echo $total_pengajuan; ?></h3>
							<p>Jumlah Pengajuan</p>
						</span>
					</li>
					<li>
						<i class='bx bxs-message-check'></i>
						<span class="text">
							<h3><?php echo $acc_pengajuan; ?></h3>
							<p>Pengajuan di Setujui</p>
						</span>
					</li>
					<li>
						<i class='bx bx-reset'></i>
						<span class="text">
							<h3><?php echo $pending_pengajuan; ?></h3>
							<p>Pengajuan di Pending</p>
						</span>
					</li>
				</ul>

				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Info Pengajuan</h3>
						</div>
						<table>
							<thead>
								<tr>
									<th>No</th>
									<th>Kategori</th>
									<th>Tanggal Pengajuan</th>
									<th>Tanggal Acc</th>
									<th>Status</th>
									<th>Hasil</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								$result->data_seek(0); // Kembali ke awal hasil
								while ($row = $result->fetch_assoc()) {
									$status_class = '';
									$download_text = 'Download';
									$disabled_class = '';
									$disabled_attribute = '';

									// Menentukan kelas untuk status dan teks download
									switch ($row['status']) {
										case 'Acc':
											$status_class = 'completed';
											break;
										case 'Pending':
											$status_class = 'pending';
											$download_text = 'Menunggu';
											$disabled_class = 'disabled';
											$disabled_attribute = 'disabled';
											break;
										default:
											$status_class = 'process';
											$download_text = 'Menunggu';
											$disabled_class = 'disabled';
											$disabled_attribute = 'disabled';
											break;
									}
									$url = getUrlByKategori($row['id_kategori'], $row['id_pengajuan']);
								?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><p><?php echo htmlspecialchars($row['jenis_pengajuan']); ?></p></td>
									<td><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['tanggal_pengajuan']))); ?></td>
									<td><?php echo htmlspecialchars(!empty($row['tanggal_acc']) ? date('d-m-Y', strtotime($row['tanggal_acc'])) : '-'); ?></td>
									<td><span class="status <?php echo $status_class; ?>"><?php echo ucfirst($row['status']); ?></span></td>
									<td>
										<a href="<?php echo $url; ?>" class="status-download <?php echo $disabled_class; ?>" <?php echo $disabled_attribute; ?>>
											<?php echo $download_text; ?>
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script src="js/script.js"></script>
	<script>
		// Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'success') {
			Swal.fire({
				icon: 'success',
				title: 'Pengajuan Sukses!',
				text: 'Menunggu Persetujuan Admin.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error') {
			Swal.fire({
				icon: 'error',
				title: 'Pengajuan Gagal!',
				text: 'Silahkan ulangi kembali.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		}
	</script>

</body>
</html>
