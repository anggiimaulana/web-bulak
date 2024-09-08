<?php
require '../config/db.php';


 // Define the number of results per page
 $results_per_page = 5;

 // Find out the number of results stored in database
 $sql = "SELECT COUNT(id_artikel) AS total FROM artikel";
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
 $sql = "SELECT id_artikel, judul_artikel, tanggal, isi_artikel, gambar FROM artikel where kategori = 'Pengumuman' and status = 'Publish' ORDER BY tanggal DESC LIMIT $starting_limit, $results_per_page";
 $result = mysqli_query($conn, $sql);
 ?>

    <!-- navbar -->
    <?php include '../template/header.php' ?>

    <!-- end navbar -->


    <!-- breadcrumb -->
    <nav aria-label="breadcrumb" class="container mt-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->

    <!-- pengumuman -->
    <main class="container my-5">
        <div class="row">
            <section class="news-list col-md-8">
                <h2>Pengumuman</h2>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<article class="mb-4 d-flex">';
                        echo '<img src="../admin/image/' . $row["gambar"] . '" class="img-fluid me-3" alt="News Image" style="width: 150px; height: 190px;">';
                        echo '<div>';
                        echo '<h3> <a href="../view/isi_pengumuman.php?id=' . $row["id_artikel"] . '" style="text-decoration: none;">' . $row["judul_artikel"] . '</a></h3>';
                        echo '<p><i class="fas fa-calendar-alt"></i> ' . date('d F Y', strtotime($row["tanggal"])) . ' <i class="fas fa-user"></i> Administrator</p>';
                        echo '<p>' . substr($row["isi_artikel"], 0, 50) . '...</p>';
                        echo '<a href="../view/isi_pengumuman.php?id=' . $row["id_artikel"] . '" class="btn btn-primary">selengkapnya</a>';
                        echo '</div>';
                        echo '</article>';
                    }
                } else {
                    echo "<p>No announcements found.</p>";
                }
                ?>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        for ($page = 1; $page <= $total_pages; $page++) {
                            echo '<li class="page-item"><a class="page-link" href="pengumuman.php?page=' . $page . '">' . $page . '</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </section>
            <!-- end pengumuman -->


        </div>
    </main>


    <!-- Footer -->
    <?php include '../template/footer.php' ?>

    <!-- end footer -->

    <script src="../js/script.js"></script>
</body>

</html>