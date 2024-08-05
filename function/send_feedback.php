<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $to = "anggabos12@gmail.com"; // Ganti dengan email admin
    $subject = "Kritik dan Saran dari $name";
    $body = "Nama: $name\nEmail: $email\n\nPesan:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "<p class='text-success'>Pesan berhasil dikirim.</p>";
    } else {
        echo "Pesan gagal dikirim.";
    }
}