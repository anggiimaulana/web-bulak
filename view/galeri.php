<?php 
require '../config/db.php';
?>
    <!-- navbar -->
    <?php include '../template/header.php' ?>

    <!-- end navbar -->

    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->


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
                                <div class="card shadow-sm p-3 mb-5 bg-body-tertiary" style="height: 300px">
                                    <img style="width:100%; height: 150px;" src="../admin/image/' . $row["gambar"] . '" class="card-img-top" alt="' . $row["judul"] . '">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">' . $row["judul"] . '</h5>
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

</body>

</html>