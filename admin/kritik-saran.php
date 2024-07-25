<?php
    include '../config/db.php';
    $sql = "SELECT id_kritik_saran, nama, email, isi, status FROM kritik_saran";
    $result = $conn->query($sql);
?>
<?php include 'header.php' ?>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Administrator</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="index.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="artikel.php">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Artikel</span>
                </a>
            </li>
            <li>
                <a href="pengajuan_user.php">
                    <i class='bx bxs-file' ></i>
                    <span class="text">Pengajuan User</span>
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class='bx bxl-discord' ></i>
                    <span class="text">Kritik Dan Saran</span>
                </a>
            </li>
            <li>
                <a href="tambah_user.php">
                    <i class='bx bxs-user-plus' ></i>
                    <span class="text">Tambah User</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="tambah_admin.php">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Tambah Admin</span>
                </a>
            </li>
            <li>
                <a href="profile_akun.php">
                    <i class='bx bxs-cog' ></i>
                    <span class="text">Profile Akun</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu' ></i>
            <input type="checkbox" id="switch-mode" hidden>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Kritik Dan Saran</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.php">Admin</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="kritik-saran.php">Kritik Dan Saran</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar kritik Dan Saran</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Kritik Dan Saran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $no = 1;
                                while($row = $result->fetch_assoc()) {
                                    $status_class = ($row["status"] == "publish") ? "publish" : "pending";
                                    echo "<tr class='status $status_class'>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td><p>" . $row["nama"] . "</p></td>";
                                    echo "<td><p>" . $row["email"] . "</p></td>";
                                    echo "<td><p>" . $row["isi"] . "</p></td>";
									$statusClass = $row['status'] == 'publish' ? 'completed' : 'pending' ;
									echo "<td><span class='status " . $statusClass . "'>" . $row['status'] . "</span></td>";
                                    echo "<td><a href='edit_kritik_saran.php?id=" . $row["id_kritik_saran"] . "' class='status edit'>Edit</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Tidak ada kritik dan saran!</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <script src="script.js"></script>
</body>
</html>
