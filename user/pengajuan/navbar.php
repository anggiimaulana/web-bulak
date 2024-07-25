<?php
require '../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header('Location: ../../login.php');
    exit();
}

// Mendapatkan NIK dari sesi
$nik = $_SESSION['nik'];

// Mengambil data pengguna dari database
$sql = "SELECT nama FROM user WHERE nik = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nik);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mendapatkan nama pengguna
    $user = $result->fetch_assoc();
    $userName = $user['nama'];
} else {
    // Jika tidak ada pengguna ditemukan
    $userName = "User";
}
?>

<nav>
    <i class='bx bx-menu'></i>
    <input type="checkbox" id="switch-mode" hidden>
    <a href="#" class="admin-info">
        <a href="#" class="nav-link">Login sebagai:  <?php echo htmlspecialchars($userName); ?></a>
    </a>
</nav>
