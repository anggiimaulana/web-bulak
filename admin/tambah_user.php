<?php include 'header.php';
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

// Query untuk menghitung jumlah pengajuan baru dengan status 'Pending'
$jumlah_pengajuan_baru = "SELECT COUNT(*) as total_pengajuan FROM pengajuan WHERE status = 'Pending'";
$hasil = mysqli_query($conn, $jumlah_pengajuan_baru);

$total_pengajuan = 0;

if ($hasil && mysqli_num_rows($hasil) > 0) {
    $row = mysqli_fetch_assoc($hasil);
    $total_pengajuan = $row['total_pengajuan'];
}
?>
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
            <li>
                <a href="galeri.php">
                    <i class='bx bxs-camera' ></i>
                    <span class="text">Galeri Desa</span>
                </a>
            </li>
            <li  class="active">
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

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include 'navbar.php' ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Tambah Akun User</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="daftar.html">Admin</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Tambah Akun User</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="formulir-pengajuan" id="pengajuanForm">
                        <form action="../login-register/tambah-user.php" method="POST">
                            <h3>Daftar Akun</h3>
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="nik">NIK</label>
                                        <input type="number" name="nik" id="nik" required>
                                    </div>
                                    <div class="data-user">
                                        <div class="ttl">
                                            <label for="tempat">Tempat Lahir</label>
                                            <input type="text" name="tempat" id="tempat" required>
                                        </div>
                                        <div class="ttl">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" required>
                                        </div>
                                    </div>
                                    <div class="data-user">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select name="jk" id="jk" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="agama">Agama</label>
                                        <select name="agama" id="agama" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Khatolik">Khatolik</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Konghuchu">Konghuchu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <select name="pekerjaan" id="pekerjaan" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Wiraswasta">Wiraswasta</option>
                                            <option value="Petani">Petani</option>
                                            <option value="Buruh">Buruh</option>
                                            <option value="PNS">PNS</option>
                                            <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="pendidikan">Pendidikan</label>
                                        <select name="pendidikan" id="pendidikan" required>
                                            <option selected disabled value="">Pilih Salah Satu</option>
                                            <option value="Tidak Tamat SD">Tidak Tamat SD</option>
                                            <option value="SD/Sederajat">SD/Sederajat</option>
                                            <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                                            <option value="SMA/Sederajat">SMA/Sederajat</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Sarjana">Sarjana</option>
                                            <option value="Pascasarjana">Pascasarjana</option>
                                            <option value="Doktor">Doktor</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="status_nikah">Status Pernikahan</label>
                                        <select name="status_nikah" id="status_nikah" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Sudah Menikah">Sudah Menikah</option>
                                            <option value="Cerai">Cerai Hidup</option>
                                            <option value="Cerai">Cerai Mati</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" placeholder="*Blok, RT/RW, Desa, Kecamatan, Kabupaten" required></textarea>
                                    </div>
                                    <div class="data-user">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit">Daftar Akun</button>
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

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>
    <script src="../user/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'success') {
			Swal.fire({
				icon: 'success',
				title: 'Pendaftaran Akun User Berhasil!',
				text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error') {
			Swal.fire({
				icon: 'error',
				title: 'Pendaftaran Gagal!',
				text: 'Silahkan ulangi kembali!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error-nik-sudah-terdaftar') {
            Swal.fire({
				icon: 'error',
				title: 'NIK sudah digunakan!',
				text: 'Silahkan ulangi kembali dengan NIK yang berbeda!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'error-nik-harus-angka') {
            Swal.fire({
				icon: 'error',
				title: 'NIK harus menggunakan angka!',
				text: 'Silahkan ulangi kembali penulisan NIK!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        }

        document.getElementById('pengajuanForm').addEventListener('submit', function(event) {
            let form = event.target;
            let inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
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
</body>
</html>
