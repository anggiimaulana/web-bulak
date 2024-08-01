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
					<h1>Edit Profil</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.html">User</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a href="#">Profil Akun</a>
						</li>
                        <li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Edit Profil</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
            <div class="order">
                <div class="formulir-pengajuan"  id="pengajuanForm">
                <form action="edit-profil/proses-edit.php" method="POST">
                            <h3>Daftar Akun</h3>
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" value="<?php echo $userData['nama']; ?>" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="nik">NIK</label>
                                        <input type="number" name="nik" id="nik" value="<?php echo $userData['nik']; ?>" required>
                                    </div>
                                    <div class="data-user">
                                        <div class="ttl">
                                            <label for="tempat">Tempat Lahir</label>
                                            <input type="text" name="tempat" id="tempat" value="<?php echo $userData['tempat_lahir']; ?>" required>
                                        </div>
                                        <div class="ttl">
                                            <label for="tanggal">Tanggal Lahir</label>
                                            <input type="date" name="tanggal" id="tanggal" value="<?php echo $userData['tanggal_lahir']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="data-user">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin" required>
                                            <option disabled value="">Pilih salah satu</option>
                                            <option value="Laki-Laki" <?php if($userData['jenis_kelamin'] == 'Laki-Laki') echo 'selected'; ?>>Laki-Laki</option>
                                            <option value="Perempuan" <?php if($userData['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="agama">Agama</label>
                                        <select name="agama" id="agama" required>
                                            <option disabled value="">Pilih salah satu</option>
                                            <option value="Islam" <?php if($userData['agama'] == 'Islam') echo 'selected'; ?>>Islam</option>
                                            <option value="Kristen" <?php if($userData['agama'] == 'Kristen') echo 'selected'; ?>>Kristen</option>
                                            <option value="Khatolik" <?php if($userData['agama'] == 'Khatolik') echo 'selected'; ?>>Khatolik</option>
                                            <option value="Budha" <?php if($userData['agama'] == 'Budha') echo 'selected'; ?>>Budha</option>
                                            <option value="Hindu" <?php if($userData['agama'] == 'Hindu') echo 'selected'; ?>>Hindu</option>
                                            <option value="Konghuchu" <?php if($userData['agama'] == 'Konghuchu') echo 'selected'; ?>>Konghuchu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" required><?php echo $userData['alamat']; ?></textarea>
                                    </div>
                                    <div class="data-user">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <select name="pekerjaan" id="pekerjaan" required>
                                            <option disabled value="">Pilih salah satu</option>
                                            <option value="Wiraswasta" <?php if($userData['pekerjaan'] == 'Wiraswasta') echo 'selected'; ?>>Wiraswasta</option>
                                            <option value="Petani" <?php if($userData['pekerjaan'] == 'Petani') echo 'selected'; ?>>Petani</option>
                                            <option value="Buruh" <?php if($userData['pekerjaan'] == 'Buruh') echo 'selected'; ?>>Buruh</option>
                                            <option value="PNS" <?php if($userData['pekerjaan'] == 'PNS') echo 'selected'; ?>>PNS</option>
                                            <option value="Pelajar/Mahasiswa" <?php if($userData['pekerjaan'] == 'Pelajar/Mahasiswa') echo 'selected'; ?>>Pelajar/Mahasiswa</option>
                                            <option value="Ibu Rumah Tangga" <?php if($userData['pekerjaan'] == 'Ibu Rumah Tangga') echo 'selected'; ?>>Ibu Rumah Tangga</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="pendidikan">Pendidikan</label>
                                        <select name="pendidikan" id="pendidikan" required>
                                            <option disabled value="">Pilih Salah Satu</option>
                                            <option value="Tidak Tamat SD" <?php if($userData['pendidikan'] == 'Tidak Tamat SD') echo 'selected'; ?>>Tidak Tamat SD</option>
                                            <option value="SD/Sederajat" <?php if($userData['pendidikan'] == 'SD/Sederajat') echo 'selected'; ?>>SD/Sederajat</option>
                                            <option value="SLTA/Sederajat" <?php if($userData['pendidikan'] == 'SLTA/Sederajat') echo 'selected'; ?>>SLTA/Sederajat</option>
                                            <option value="SMA/Sederajat" <?php if($userData['pendidikan'] == 'SMA/Sederajat') echo 'selected'; ?>>SMA/Sederajat</option>
                                            <option value="Diploma" <?php if($userData['pendidikan'] == 'Diploma') echo 'selected'; ?>>Diploma</option>
                                            <option value="Sarjana" <?php if($userData['pendidikan'] == 'Sarjana') echo 'selected'; ?>>Sarjana</option>
                                            <option value="Pascasarjana" <?php if($userData['pendidikan'] == 'Pascasarjana') echo 'selected'; ?>>Pascasarjana</option>
                                            <option value="Doktor" <?php if($userData['pendidikan'] == 'Doktor') echo 'selected'; ?>>Doktor</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="status_pernikahan">Status Pernikahan</label>
                                        <select name="status_pernikahan" id="status_pernikahan" required>
                                            <option disabled value="">Pilih salah satu</option>
                                            <option value="Belum Menikah" <?php if($userData['status_pernikahan'] == 'Belum Menikah') echo 'selected'; ?>>Belum Menikah</option>
                                            <option value="Sudah Menikah" <?php if($userData['status_pernikahan'] == 'Sudah Menikah') echo 'selected'; ?>>Sudah Menikah</option>
                                            <option value="Cerai Hidup" <?php if($userData['status_pernikahan'] == 'Cerai Hidup') echo 'selected'; ?>>Cerai Hidup</option>
                                            <option value="Cerai Mati" <?php if($userData['status_pernikahan'] == 'Cerai Mati') echo 'selected'; ?>>Cerai Mati</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit">Simpan Perubahan</button>
                        </form>
                    <div id="notification" style="display: none; color: red;">
                        Harap isi semua kolom yang diperlukan!
                    </div>
                </div>
            </div>
        </div>
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script>
        document.getElementById('pengajuanForm').addEventListener('submit', function(event) {
            let form = event.target;
            let inputs = form.querySelectorAll('input[required], textarea[required]');
            let allFilled = true;

            inputs.forEach(function(input) {
                if (!input.value) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                event.preventDefault();
                document.getElementById('notification').style.display = 'block';
            }
        });
    </script>
	<script src="js/script.js"></script>
</body>
</html>
