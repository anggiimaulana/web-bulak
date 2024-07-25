<?php
session_start(); // Memulai sesi

include '../../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header('Location: ../../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nik = $_SESSION['nik']; // Mendapatkan NIK dari session
    $pengajuan = $_POST['pengajuan'];
    $nama_usaha = $_POST['nama_usaha'];
    $id_kategori = 1;
    $status = "Pending";

    // Menyimpan data ke database
    $sql = "INSERT INTO pengajuan (id_kategori, nik, tanggal_pengajuan, nama_usaha, status) 
            VALUES ('$id_kategori', '$nik', '$pengajuan', '$nama_usaha', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=error");
    }

    mysqli_close($conn);
}
?>
