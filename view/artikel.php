<?php
require '../function/koneksi.php';

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../style/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <!-- navbar -->
    <?php include '../template/header.php' ?>
    <!-- end navbar -->

    <div class="container mt-5">
        <!-- Breadcrumb start -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home"></i></a></li>
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
            <img src="<?php echo "../admin/uploads/" . $image; ?>" alt="<?php echo $title; ?>" style="width:400px">
            <p><?php echo nl2br($content); ?></p>
        </div>
        <!-- end isi artikel -->
    </div>


    <!-- Footer -->
    <?php include '../template/footer.php' ?>
    <!-- end footer -->

    <script src="../js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>