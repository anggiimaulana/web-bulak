<?php
require '../config/db.php'; // Pastikan file ini berisi koneksi ke database

// Mendapatkan data dari form
$nip = $_POST['nip'];
$password = $_POST['password'];

// Validasi nip
if (!is_numeric($nip)) {
    header('Location: ../login-admin.php?status=error&message=NIP harus berupa angka.');
    exit();
}

// Cek jika nip ada di database
$sql = "SELECT * FROM admin WHERE nip = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nip);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: ../login-admin.php?status=error-nip-tidak-ditemukan');
    exit();
}

$user = $result->fetch_assoc();

// Verifikasi password
if (!password_verify($password, $user['password'])) {
    header('Location: ../login-admin.php?status=error-password-salah');
    exit();
}

// Set session atau cookie sesuai kebutuhan
session_start();
$_SESSION['nip'] = $nip;

// Redirect ke halaman index user
header('Location: ../admin/');
exit();

