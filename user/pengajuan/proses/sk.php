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
    $id_kategori = 6;
    $nik = $_SESSION['nik']; // Mendapatkan NIK dari session
    $keterangan_menikah = $_POST['keterangan_menikah'];
    $pengajuan = $_POST['tgl_pengajuan'];
    $status = "Pending";

    // Menyimpan data ke database
    $sql = "INSERT INTO pengajuan (id_kategori, nik, keterangan_menikah, tanggal_pengajuan, status) 
            VALUES ('$id_kategori', '$nik', '$keterangan_menikah', '$pengajuan', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=error");
    }

    mysqli_close($conn);
}
?>
