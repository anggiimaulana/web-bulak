<?php
session_start();
require '../../config/db.php';

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['nip'])) {
    header('Location: ../../login-admin.php');
    exit();
}

// Mengecek apakah ID artikel sudah diberikan
if (isset($_GET['id_artikel'])) {
    $id_artikel = $_GET['id_artikel'];

    // Mendapatkan informasi artikel dari database
    $sql = "SELECT gambar FROM artikel WHERE id_artikel = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_artikel);
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
        $sql = "DELETE FROM artikel WHERE id_artikel = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_artikel);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Artikel berhasil dihapus!";
            header('Location: ../artikel.php?status=artikel-berhasil-dihapus');
        } else {
            $_SESSION['message'] = "Gagal menghapus artikel.";
            header('Location: ../artikel.php?status=artikel-gagal-dihapus');
        }
    } else {
        $_SESSION['message'] = "Artikel tidak ditemukan.";
        header('Location: ../artikel.php?status=artikel-tidak-ditemukan');
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['message'] = "ID artikel tidak valid.";
    header('Location: ../artikel.php?status=id-tidak-valid');
}

exit();
