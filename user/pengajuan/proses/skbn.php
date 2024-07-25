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
    $nama_kk = $_POST['nama_kk'];
    $nama_akte_dokumen = $_POST['nama_akte_dokumen'];
    $pengajuan = $_POST['tgl_pengajuan'];
    $id_kategori = 2;
    $status = "Pending";

    // Menyimpan data ke database
    $sql = "INSERT INTO pengajuan (id_kategori, nik, nama_kk, nama_akte_dokumen, tanggal_pengajuan, status) 
            VALUES ('$id_kategori', '$nik', '$nama_kk', '$nama_akte_dokumen', '$pengajuan', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=error");
    }

    mysqli_close($conn);
}
?>
