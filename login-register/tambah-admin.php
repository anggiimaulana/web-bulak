<?php

require '../config/db.php'; // Pastikan file ini berisi koneksi ke database

// Mendapatkan data dari form
$nama = $_POST['nama'];
$nip = $_POST['nip'];
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
if (!is_numeric($nip)) {
    header("Location: ../admin/tambah_admin.php?status=error-nip-harus-angka");
    exit();
}

// Cek jika NIK sudah ada
$sql = "SELECT * FROM admin WHERE nip = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $nip);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../admin/tambah_admin.php?status=error-nip-sudah-terdaftar");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menyiapkan dan mengeksekusi query untuk menyimpan data
$sql = "INSERT INTO admin (nama, nip, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, pekerjaan, pendidikan, status_pernikahan, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssssssss', $nama, $nip, $tempat, $tgl_lahir, $jk, $agama, $alamat, $pekerjaan, $pendidikan, $status_nikah, $hashed_password);

if ($stmt->execute()) {
    header("Location: ../admin/tambah_admin.php?status=success");
} else {
    header("Location: ../admin/tambah_admin.php?status=error" . $stmt->error);
}

