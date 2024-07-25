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
    $id_kategori = 4;
    $nik = $_SESSION['nik']; // Mendapatkan NIK dari session
    $pengajuan = $_POST['tgl_pengajuan'];
    $status = "Pending";

    // Menghitung masa berlaku (1 bulan dari tanggal pengajuan)
    $tgl_pengajuan = new DateTime($pengajuan);
    $tgl_pengajuan->modify('+1 month');
    $masa_berlaku = $tgl_pengajuan->format('Y-m-d');

    // Menyimpan data ke database
    $sql = "INSERT INTO pengajuan (id_kategori, nik, masa_ktp_sementara, tanggal_pengajuan, status) 
            VALUES ('$id_kategori', '$nik', '$masa_berlaku', '$pengajuan', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=error");
    }
    
    mysqli_close($conn);
}
?>
