<?php
 require '../function/koneksi.php';

 // Define the number of results per page
 $results_per_page = 5;

 // Find out the number of results stored in database
 $sql = "SELECT COUNT(id) AS total FROM agenda";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_assoc($result);
 $total_results = $row['total'];

 // Determine number of total pages available
 $total_pages = ceil($total_results / $results_per_page);

 // Determine which page number visitor is currently on
 $page = isset($_GET['page']) ? $_GET['page'] : 1;

 // Determine the SQL LIMIT starting number for the results on the displaying page
 $starting_limit = ($page - 1) * $results_per_page;

 // Retrieve selected results from database and display them on page
 $sql = "SELECT id, judul, created_at, konten, image FROM agenda ORDER BY created_at DESC LIMIT $starting_limit, $results_per_page";
 $result = mysqli_query($conn, $sql);
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Kegiatan</title>
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="icon" href="../desa-img/logo_indra.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

    <!-- top info -->
    <div class="top-bar">
        <a href="tel:0226623181">022-6623181</a> |
        <a href="mailto:pemdes@jatibarang.desa.id">pemdes@jatibarang.desa.id</a> |
        <span>Kabupaten Indramayu</span>
    </div>
    <!-- end top info -->

    <!-- navbar -->
    <header>
        <div class="container d-flex justify-content-between align-items-center ">
            <div class="logo d-flex ">
                <a href="../view/index.php">
                    <img src="../desa-img/logo_indra.jpeg" alt="Logo Desa Bulak"> <!-- Replace with your logo -->
                </a>
                <div class="ms-3">
                    <span>Desa Bulak</span><br>
                    <span>Kabupaten Indramayu</span>
                </div>
            </div>
            <nav class=" navbar navbar-expand-lg navbar-light ">
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#profil" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Profil Desa
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <li><a class="dropdown-item" href="visi_misi.php">Visi & Misi</a></li>
                                <li><a class="dropdown-item" href="sejarah.php">Sejarah Desa</a></li>

                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#pemerintahan" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pemerintahan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="struktur.php">Struktur Organisasi</a></li>
                                <li><a class="dropdown-item" href="perangkat_desa.php">Perangkat Desa</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#informasi" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Informasi Publik
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="berita_desa.php">Berita Desa</a></li>
                                <li><a class="dropdown-item" href="pengumuman.php">Pengumuman</a></li>
                                <li><a class="dropdown-item" href="agenda.php">Agenda Kegiatan</a></li>
                                <li><a class="dropdown-item" href="galeri.php">Galeri</a></li>
                            </ul>
                        </li>
                        <li class="nav-user"><a class="nav-link"
                                style="color: #ffffff; background-color: #00ba88; border-radius: 5px; margin-right: 10px; font-weight: normal;"
                                href="#potensi">Layanan
                                Mandiri</a></li>
                        <li class="nav-admin"><a class="nav-link"
                                style="color: #ffffff; background-color: #007bff; border-radius: 5px; font-weight: normal;"
                                href="#produk">Login Admin</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- end navbar -->


    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../view/index.php"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Agenda Kegiatan</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->

    <!-- agenda -->
    <main class="container my-5">
        <div class="row">
            <section class="agenda-list col-md-8">
                <h2>Agenda Kegiatan</h2>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<article class="mb-4 d-flex">';
                        echo '<img src="../admin/uploads/' . $row["image"] . '" class="img-fluid me-3" alt="Agenda Image" style="width: 150px; height: 190px;">';
                        echo '<div>';
                        echo '<h3> <a href="../view/agenda_detail.php?id=' . $row["id"] . '" style="text-decoration: none;">' . $row["judul"] . '</a></h3>';
                        echo '<p><i class="fas fa-calendar-alt"></i> ' . date('d F Y', strtotime($row["created_at"])) . ' <i class="fas fa-user"></i> Administrator</p>';
                        echo '<p>' . substr($row["konten"], 0, 50) . '...</p>';
                        echo '<a href="../view/agenda_detail.php?id=' . $row["id"] . '" class="btn btn-primary">selengkapnya</a>';
                        echo '</div>';
                        echo '</article>';
                    }
                } else {
                    echo "<p>No agenda found.</p>";
                }
                ?>
            </section>
            <!-- end agenda -->

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    for ($page = 1; $page <= $total_pages; $page++) {
                        echo '<li class="page-item"><a class="page-link" href="agenda.php?page=' . $page . '">' . $page . '</a></li>';
                    }
                    ?>
                </ul>
            </nav>

        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Profil</h5>
                    <p>Desa Bulak - jatibarang<br>Kabupaten Indramayu - Jawa Barat</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit tempore itaque qui voluptates
                        minima autem placeat nemo similique eligendi nisi aliquam doloribus dignissimos odit odio
                        eius
                        quo quia neque, hic a inventore tenetur mollitia! Obcaecati officia natus dolorem excepturi
                        quae....</p>
                    <a href="#">selengkapnya ➔</a>
                </div>
                <div class="col-md-4">
                    <h5>Tautan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Kabupaten Indramayu</a></li>
                        <li><a href="#">KEMENDAGRI</a></li>
                        <li><a href="#">KEMENDESA</a></li>
                        <li><a href="#">KEMENKOMINFO</a></li>
                        <li><a href="#">Produk Desa Bulak</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <p>Jl. Raya Bulak No. 122 jatibarang, Kode Pos 45273</p>
                    <p><a href="tel:0226623181">022-6623181</a></p>
                    <p><a href="mailto:pemdes@kertamulya-padalarang.desa.id">pemdes@jatibarang.desa.id</a>
                    </p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p>2024 © Rekayasa Perangkat Lunak POLINDRA.</p>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <script src="../js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>