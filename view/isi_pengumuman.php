<?php
require '../config/db.php';


$announcement_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Get ID from URL or default to 1

$sql = "SELECT judul_artikel, gambar, tanggal, isi_artikel FROM artikel WHERE id_artikel = $announcement_id and kategori = 'Pengumuman'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $title = $row['judul_artikel'];
    $gambar = $row['gambar'];
    $isi_artikel = $row['isi_artikel'];
    $tanggal = $row['tanggal'];
  
} else {
    echo "No announcement found.";
    exit;
}


?>

    <!-- navbar -->
    <?php include '../template/header.php' ?>

    <!-- end navbar -->
    <div class="container mt-5">
        <!-- Breadcrumb start -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="pengumuman.php">Pengumuman</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
            </ol>
        </nav>
        <!-- Breadcrumb end -->

        <!-- isi pengumuman -->
        <div class="article-content break-word">
            <h1 class="text-primary"><?php echo $title; ?></h1><br>
            <div class="meta">
                <span><i class="fas fa-calendar-alt"></i> <?php echo date('d F Y', strtotime($tanggal)); ?></span> |
                <span><i class="fas fa-user"></i>Administrator</span>
            </div><br>
            <img src="<?php echo "../admin/image/" . $gambar; ?>" alt="<?php echo $title; ?>" style="width:400px">
            <p><?php echo nl2br($isi_artikel); ?></p>
        </div>
        <!-- end isi pengumuman -->
    </div>


    <!-- Footer -->
    <?php include '../template/footer.php' ?>

    <!-- end footer -->

    <script src="../js/script.js"></script>
</body>

</html>