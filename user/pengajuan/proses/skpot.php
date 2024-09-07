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
    $nama_ortu = $_POST['nama_ortu'];
    $nik_ortu = $_POST['nik_ortu'];
    $pekerjaan_ortu = $_POST['pekerjaan_ortu'];
    $penghasilan = $_POST['penghasilan'];
    $nama = $_POST['nama_kk'];
    $pengajuan = $_POST['tgl_pengajuan'];
    $id_kategori = 7;
    $status = "Pending";

    // Menyimpan data ke database
    $sql = "INSERT INTO pengajuan (id_kategori, nik, nik_ortu, pekerjaan_ortu, nama_ortu, nama_kk, tanggal_pengajuan, penghasilan, status) 
            VALUES ('$id_kategori', '$nik', '$nik_ortu', '$pekerjaan_ortu', '$nama_ortu', '$nama', '$pengajuan', '$penghasilan', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../index.php?status=success");
    } else {
        header("Location: ../../index.php?status=error");
    }

    mysqli_close($conn);
}
?>
