<?php
session_start(); // Memulai sesi
require '../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../../login.php');
    exit();
}

// Memeriksa apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mendapatkan data dari form
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat'];
    $tanggal_lahir = $_POST['tanggal'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $pekerjaan = $_POST['pekerjaan'];
    $pendidikan = $_POST['pendidikan'];
    $status_pernikahan = $_POST['status_pernikahan'];

    // Query untuk memperbarui data pengguna
    $sql = "UPDATE admin SET 
                nama = '$nama', 
                nip = '$nip',
                tempat_lahir = '$tempat_lahir', 
                tanggal_lahir = '$tanggal_lahir', 
                jenis_kelamin = '$jenis_kelamin', 
                agama = '$agama', 
                alamat = '$alamat', 
                pekerjaan = '$pekerjaan',
                pendidikan = '$pendidikan',
                status_pernikahan = '$status_pernikahan'
            WHERE nip = '$nip'";

    // Mengeksekusi query
    if (mysqli_query($conn, $sql)) {
        header("Location: ../profile_akun.php?status=success");
    } else {
        header("Location: ../edit-profil.php?status=error");
    }

    // Menutup koneksi
    mysqli_close($conn);
} else {
    // Jika data tidak dikirim melalui POST, arahkan kembali ke halaman profil
    header('Location: ../profile_akun.php');
}
?>
