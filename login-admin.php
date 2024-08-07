<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="user/style.css">
	<!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
		.swal2-popup {
			font-size: 0.8rem !important; 
			width: 95%;
			max-width: 400px !important; /* Ukuran lebar kustom */
			max-height: 300px;
            z-index: 0 !important; 
		}

        @media screen and (max-width: 500px) {
            .swal2-popup {
                font-size: 0.6rem !important; 
                width: 95%;
                max-width: 400px !important; /* Ukuran lebar kustom */
                max-height: 300px;
                z-index: 0 !important; 
            }
        }
	</style>

	<title>Halaman User</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<?php include 'brand.php' ?>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bx-log-in-circle'></i>
					<span class="text">Login</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<?php include 'navbar.php' ?>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Login</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.html">#</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
                        <li>
							<a class="active" href="#">Login Admin</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
                    <div class="formulir-pengajuan" id="pengajuanForm">
                        <form action="login-register/login-admin.php" method="POST">
                            <h3>Login</h3>
                                    <div class="data-user">
                                        <label for="nip">NIP</label>
                                        <input type="number" name="nip" id="nip" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                            <button type="submit">Login</button>
                        </form>
						<div id="notification" style="display: none; color: red;">
							Harap isi semua kolom yang diperlukan!
						</div>
                    </div>
				</div>
			</div>
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="user/js/script.js"></script>
	<script>
        // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');
		const logout = urlParams.get('logout');

		if (status === 'error-password-salah') {
			Swal.fire({
				icon: 'error',
				title: 'Password Salah!',
				text: 'Silahkan coba lagi!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error-nip-tidak-ditemukan') {
			Swal.fire({
				icon: 'error',
				title: 'NIP tidak ditemukan!',
				text: 'Silahkan coba kembali!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (logout === 'success') {
			Swal.fire({
				icon: 'success',
				title: 'Logout berhasil!',
				text: '',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		}

		document.getElementById('pengajuanForm').addEventListener('submit', function(event) {
            let form = event.target;
            let inputs = form.querySelectorAll('input[required], textarea[required]');
            let allFilled = true;

            inputs.forEach(function(input) {
                if (!input.value) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                event.preventDefault();
                document.getElementById('notification').style.display = 'block';
            }
        });
    </script>
</body>
</html>