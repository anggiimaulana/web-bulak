<?php
require '../config/db.php';

$article_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Get ID from URL or default to 1

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Add email field
    $created_at = date('Y-m-d H:i:s');

    // $sql_insert = "INSERT INTO komentar (article_id, user_name, content, email, created_at) VALUES ($article_id, '$user_name', '$content', '$email', '$created_at')";
    // mysqli_query($conn, $sql_insert);
}

$sql = "SELECT judul_artikel, tanggal, isi_artikel, gambar FROM artikel WHERE id_artikel = $article_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $title = $row['judul_artikel'];
    $content = $row['isi_artikel'];
    $image = $row['gambar'];
    $created_at = $row['tanggal'];
  
} else {
    echo "No article found.";
    exit;
}


mysqli_close($conn);
?>

    <!-- navbar -->
    <?php include '../template/header.php' ?>
    <!-- end navbar -->

    <div class="container mt-5">
        <!-- Breadcrumb start -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="berita_desa.php">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
            </ol>
        </nav>
        <!-- Breadcrumb end -->

        <!-- isi artikel -->
        <div class="article-content break-word">
            <h1 class="text-primary"><?php echo $title; ?></h1><br>
            <div class="meta">
                <span><i class="fas fa-calendar-alt"></i> <?php echo date('d F Y', strtotime($created_at)); ?></span> |
                <span><i class="fas fa-user"></i>Administrator</span>
            </div><br>
            <img src="<?php echo "../admin/image/" . $image; ?>" alt="<?php echo $title; ?>" style="width:400px">
            <p><?php echo nl2br($content); ?></p>
        </div>
        <!-- end isi artikel -->
    </div>


    <!-- Footer -->
    <?php include '../template/footer.php' ?>
    <!-- end footer -->

    <script src="../js/script.js"></script>
</body>

</html>