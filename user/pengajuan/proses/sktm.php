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
    $id_kategori = 3;
    $nik = $_SESSION['nik']; // Mendapatkan NIK dari session
    $keterangan_tidak_mampu = $_POST['keterangan_tidak_mampu'];
    $pengajuan = $_POST['tgl_pengajuan'];
    $status = "Pending";

    // Menyimpan data ke database
    $sql = "INSERT INTO pengajuan (id_kategori, nik, keterangan_tidak_mampu, tanggal_pengajuan, status) 
            VALUES ('$id_kategori', '$nik', '$keterangan_tidak_mampu', '$pengajuan', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=error");
    }

    mysqli_close($conn);
}
?>
