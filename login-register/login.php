<?php
require '../config/db.php'; // Pastikan file ini berisi koneksi ke database

// Mendapatkan data dari form
$nik = $_POST['nik'];
$password = $_POST['password'];

// Validasi NIK
if (!is_numeric($nik)) {
    header('Location: ../login.php?status=error-NIK-harus-berupa-angka');
    exit();
}

// Cek jika NIK ada di database
$sql = "SELECT * FROM user WHERE nik = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nik);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: ../login.php?status=error-NIK-tidak-ditemukan');
    exit();
}

$user = $result->fetch_assoc();

// Verifikasi password
if (!password_verify($password, $user['password'])) {
    header('Location: ../login.php?status=error-password-salah');
    exit();
}

// Set session atau cookie sesuai kebutuhan
session_start();
$_SESSION['nik'] = $nik;

// Redirect ke halaman index user
header('Location: ../user/');
exit();

