<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "desa_bulak";

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn) {
        die("Koneksi database error" . mysqli_connect_error());
    }
?>