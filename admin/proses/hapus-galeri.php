<?php
session_start();
require '../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../../login-admin.php');
    exit();
}

// Mengecek apakah ID artikel sudah diberikan
if (isset($_GET['id_galeri'])) {
    $id_galeri = $_GET['id_galeri'];

    // Mendapatkan informasi artikel dari database
    $sql = "SELECT gambar FROM galeri WHERE id_galeri = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_galeri);
    $stmt->execute();
    $result = $stmt->get_result();
    $artikel = $result->fetch_assoc();

    if ($artikel) {
        // Hapus gambar dari folder image
        $gambar_path = '../image/' . $artikel['gambar'];
        if (file_exists($gambar_path)) {
            unlink($gambar_path);
        }

        // Hapus artikel dari database
        $sql = "DELETE FROM galeri WHERE id_galeri = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_galeri);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Galeri berhasil dihapus!";
            header('Location: ../galeri.php?status=hapus-success');
        } else {
            $_SESSION['message'] = "Gagal menghapus artikel.";
            header('Location: ../galeri.php?status=hapus-gagal');
        }
    } else {
        $_SESSION['message'] = "Artikel tidak ditemukan.";
        header('Location: ../galeri.php?status=galeri-tidak-ditemukan');
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['message'] = "ID artikel tidak valid.";
    header('Location: ../galeri.php?status=id-tidak-valid');
}

exit();
