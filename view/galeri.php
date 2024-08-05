<?php 
require '../function/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri</title>
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="icon" href="../desa-img/logo_indra.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- navbar -->
    <?php include '../template/header.php' ?>

    <!-- end navbar -->

    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../view/index.php"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->x`


    <!-- Galeri -->
    <main class="container my-5">
        <div class="row">
            <section class="galeri col-md-12">
                <h2 class="mb-4">Galeri</h2>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <?php
                    // Fetch gallery items from the database
                    $sql = "SELECT id_galeri, judul, gambar, tanggal FROM galeri ORDER BY id_galeri DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col ">
                                <div class="card h-100 shadow-sm p-3 mb-5 bg-body-tertiary">
                                    <img src="../admin/uploads/' . $row["gambar"] . '" class="card-img-top" alt="' . $row["judul"] . '">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row["judul"] . '</h5>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        echo "<p>No gallery items found.</p>";
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </section>
        </div>
    </main>
    <!-- end galeri -->


    <!-- Footer -->
    <?php include '../template/footer.php' ?>

    <!-- end footer -->


    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>