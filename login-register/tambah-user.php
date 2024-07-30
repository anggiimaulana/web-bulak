<?php

require '../config/db.php'; // Pastikan file ini berisi koneksi ke database

// Mendapatkan data dari form
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$tempat = $_POST['tempat'];
$tgl_lahir = $_POST['tgl_lahir'];
$jk = $_POST['jk'];
$pekerjaan = $_POST['pekerjaan'];
$pendidikan = $_POST['pendidikan'];
$status_nikah = $_POST['status_nikah'];
$alamat = $_POST['alamat'];
$password = $_POST['password'];
$agama = $_POST['agama'];

// Validasi NIK
if (!is_numeric($nik)) {
    header("Location: ../daftar.php?status=error-nik-harus-angka");
    exit();
}

// Cek jika NIK sudah ada
$sql = "SELECT * FROM user WHERE nik = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nik);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../daftar.php?status=error-nik-sudah-terdaftar");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyiapkan dan mengeksekusi query untuk menyimpan data
$sql = "INSERT INTO user (nama, nik, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, pekerjaan, pendidikan, status_pernikahan, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssssssss', $nama, $nik, $tempat, $tgl_lahir, $jk, $agama, $alamat, $pekerjaan, $pendidikan, $status_nikah, $hashed_password);

if ($stmt->execute()) {
    header("Location: ../admin/tambah_user.php?status=success");
} else {
    header("Location: ../admin/tambah_user.php?status=error" . $stmt->error);
}

