<?php
require 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Bulak</title>
    <link rel="icon" href="../desa-img/logo_indra.jpeg">
    <link rel="stylesheet" href="style/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <!-- loader -->
    <div class="loader" id="loader"></div>
    <!-- end loader -->

    <!-- top info -->
    <div class="top-bar">
        <a href="tel:0226623181">022-6623181</a> |
        <a href="mailto:pemdes@jatibarang.desa.id">pemdes@jatibarang.desa.id</a> |
        <span>Kabupaten Indramayu</span>
    </div>
    <!-- end top info -->

    <!-- navbar -->
    <nav class="container navbar navbar-expand-lg bg-body-light">
      <div class="container-fluid">
        <a href="index.php">
            <img src="desa-img/logo_indra.jpeg" alt="Logo Desa Bulak"> <!-- Replace with your logo -->
        </a>
        <div class="ms-3">
            <span>Desa Bulak</span><br>
            <span>Kabupaten Indramayu</span>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#profil" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Profil Desa
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <li><a class="dropdown-item" href="view/visi_misi.php">Visi & Misi</a></li>
                                <li><a class="dropdown-item" href="view/sejarah.php">Sejarah Desa</a></li>

                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#pemerintahan" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Pemerintahan
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="view/struktur.php">Struktur Organisasi</a></li>
                                <li><a class="dropdown-item" href="view/perangkat_desa.php">Perangkat Desa</a></li>

                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#informasi" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Informasi Publik
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="view/berita_desa.php">Berita Desa</a></li>
                                <li><a class="dropdown-item" href="view/pengumuman.php">Pengumuman</a></li>
                                <li><a class="dropdown-item" href="view/galeri.php">Galeri</a></li>

                            </ul>
                        </li>
            <li class="nav-user"><a class="nav-link"
                            style="color: #ffffff; background-color: #00ba88; border-radius: 5px; margin-right: 10px; font-weight: normal;"
                            href="login.php">Layanan
                            Mandiri</a></li>
                    <li class="nav-admin"><a class="nav-link"
                            style="color: #ffffff; background-color: #007bff; border-radius: 5px; font-weight: normal;"
                            href="login-admin.php">Login Admin</a>
                    </li>
          </ul>
        </div>
      </div>
    </nav>
    <hr class="mb-4">
    <!-- end navbar -->

    <!-- crousel -->
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img-crousel/pasar.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img-crousel/wisata_alun.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img-crousel/wisata_agungf.jpeg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>

        </button>
    </div>

    <!-- end crousel -->

    <!-- marque -->
    <div class="marquee">
        <P>MARI KITA WUJUDKAN DESA BULAK YANG BERSERI (BERSIH, RELEGIUS, SEJAHTERA, RAPI, DAN INDAH)</P>
    </div>
    <!-- end marque -->

    <!-- Berita Terkini dan Pengumuman -->
    <section class="news-announcements container mt-5">
        <div class="row">
            <div class="head-news col-md-8">
                <h4 style="font-weight: bold; margin-bottom:15px; margin-top:10px"><a href="../view/berita_desa.php">Berita Terkini</a></h4>
                <?php
                $kategori = 
                $sql = "SELECT id_artikel, judul_artikel, tanggal, isi_artikel, gambar FROM artikel where kategori = 'Berita' ORDER BY id_artikel DESC LIMIT 4";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="news-item">';
                        echo '<img src="admin/image/' . $row["gambar"] . '" alt="News" style="width:100px; height: 100px;">';
                        echo '<div class="news-content">';
                        echo '<h3> <a href="view/artikel.php?id=' . $row["id_artikel"] . '" style="text-decoration: none;">' . $row["judul_artikel"] . '</a></h3>';
                        echo '<p>' . date('d F Y', strtotime($row["tanggal"]))  . '</p>';
                        echo '<p>' . substr($row["isi_artikel"], 0, 50 ) . '... <a href="view/artikel.php?id=' . $row["id_artikel"] . '">Selengkapnya</a></p>';
                        echo '<p>oleh: administrator</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                }  else {
                    echo '<ul class="announcements-list">';
                    echo "<li>Tidak ada berita</li>";
                    echo '</ul>';
                }
                ?>
            </div>
            <!-- pengumuman -->
            <div class="col-md-4">
                <h4 style="font-weight: bold; margin-bottom:15px; margin-top:10px"><a href="../view/pengumuman.php">Pengumuman</a></h4>
                <ul class="announcements-list">
                    <?php
                    $sql = "SELECT id_artikel, judul_artikel, tanggal, isi_artikel, gambar FROM artikel where kategori = 'Pengumuman' ORDER BY id_artikel DESC LIMIT 4";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="news-item">';
                            echo '<img src="admin/image/' . $row["gambar"] . '" alt="News" style="width:100px; height: 100px;">';
                            echo '<div class="news-content">';
                            echo '<h3> <a href="view/artikel.php?id=' . $row["id_artikel"] . '" style="text-decoration: none;">' . $row["judul_artikel"] . '</a></h3>';
                            echo '<p>' . date('d F Y', strtotime($row["tanggal"]))  . '</p>';
                            echo '<p>' . substr($row["isi_artikel"], 0, 50 ) . '... <a href="view/pengumuman.php?id=' . $row["id_artikel"] . '">Selengkapnya</a></p>';
                            echo '<p>oleh: administrator</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<li>Tidak ada pengumuman</li>";
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<li><a href="view/pengumuman.php?id=' . $row["id_artikel"] . '">' . $row["judul_artikel"] . '</a></li>';
                        }
                    }
                    ?>
                </ul>
                <!-- end pengumuman -->
            </div>
        </div>
    </section>
    <!-- end Berita Terkini dan Pengumuman -->

    <!-- Map Section -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ebebeb" fill-opacity="1" d="M0,224L1440,160L1440,320L0,320Z"></path>
    </svg>
    <div class="map-all">
        <section class="map-section container mt-5">
            <h2>Lokasi Desa Bulak</h2>
            <div id="mapp">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.3586808019672!2d108.30824577436303!3d-6.476172493515648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ec7992543c9fb%3A0xee009a3dbcdea6c7!2sDesa%20bulak%20kecamatan%20jatibarang!5e0!3m2!1sid!2sid!4v1723801665379!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    </div>
    <svg class="secsvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ebebeb" fill-opacity="1" d="M0,224L1440,160L1440,0L0,0Z"></path>
    </svg>
    <!-- end Map Section -->


    <!-- Footer -->
    <?php include 'template/footer.php' ?>
    <!-- end footer -->

    <script src="js/script.js"></script>
    </script>


</body>

</html>