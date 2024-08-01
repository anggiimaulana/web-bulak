<?php
session_start(); // Memulai sesi
include "header.php";
require '../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header('Location: ../../login.php');
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
    <?php include 'brand.php'; ?>
    <ul class="side-menu top">
        <li>
            <a href="../index.php">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="active">
            <a href="../pengajuan.php">
                <i class='bx bxs-file' ></i>
                <span class="text">Pengajuan</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">            
        <li>
            <a href="../profil.php">
                <i class='bx bxs-user' ></i>
                <span class="text">Profil Akun</span>
            </a>
        </li>
        <li>
            <a href="../logout.php" class="logout">
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
                <h1>Pengajuan SKBN</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="../index.html">User</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a href="../pengajuan.html">Pengajuan</a>
                    </li>
                    <li><i class='bx bx-chevron-right' ></i></li>
                    <li>
                        <a class="active" href="#">SKBN</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <div class="formulir-pengajuan"  id="pengajuanForm">
                    <form action="proses/skbn.php" method="POST">
                        <h4>* Mohon cek kembali data diri anda!</h4>
                        <div class="form-row">
                            <div class="form-column">
                                <h5>Yang tercantum dalam Kartu Keluarga (KK)</h5>
                                <div class="data-user">
                                    <label for="nama_kk">Nama Lengkap</label>
                                    <input type="text" name="nama_kk" id="nama_kk" required>
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
                                        <input type="text" name="tanggal" id="tanggal" value="<?php echo $userData['tanggal_lahir']; ?>" required>
                                    </div>
                                </div>
                                <div class="data-user">
                                    <label for="status_pernikahan">Status Pernikahan</label>
                                    <input type="text" name="status_pernikahan" id="status_pernikahan" value="<?php echo $userData['status_pernikahan']; ?>" required>
                                </div>
                                <div class="data-user">
                                    <label for="agama">Agama</label>
                                    <input type="text" name="agama" id="agama" value="<?php echo $userData['agama']; ?>" required>
                                </div>
                                <div class="data-user">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="pekerjaan" value="<?php echo $userData['pekerjaan']; ?>" required>
                                </div>
                                <div class="data-user">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat"><?php echo $userData['alamat']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-column">
                                <h5>Yang tercantum dalam AKTA Kelahiran & IJAZAH</h5>
                                <div class="data-user">
                                    <label for="nama_akte_dokumen">Nama Lengkap</label>
                                    <input type="text" name="nama_akte_dokumen" id="nama" required>
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
                                        <input type="text" name="tanggal" id="tanggal" value="<?php echo $userData['tanggal_lahir']; ?>" required>
                                    </div>
                                </div>
                                <div class="data-user">
                                    <label for="status_pernikahan">Status Pernikahan</label>
                                    <input type="text" name="status_pernikahan" id="status_pernikahan" value="<?php echo $userData['status_pernikahan']; ?>" required>
                                </div>
                                <div class="data-user">
                                    <label for="agama">Agama</label>
                                    <input type="text" name="agama" id="agama" value="<?php echo $userData['agama']; ?>" required>
                                </div>
                                <div class="data-user">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" id="pekerjaan" value="<?php echo $userData['pekerjaan']; ?>" required>
                                </div>
                                <div class="data-user">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" id="alamat"><?php echo $userData['alamat']; ?></textarea>
                                </div>
                                <div class="data-user">
                                    <label for="tgl_pengajuan">Tanggal Pengajuan</label>
                                    <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit">Ajukan</button>
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
    <script src="../js/script.js"></script>
</body>
</html>
