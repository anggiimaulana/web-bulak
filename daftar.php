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
        <a href="#" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Selamat Datang</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Daftar Akun</span>
                </a>
            </li>
            <li>
                <a href="login.php">
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
        <nav>
            <i class='bx bx-menu' ></i>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Daftar Akun</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="daftar.html">User</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a href="#">Daftar</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="formulir-pengajuan" id="pengajuanForm">
                        <form action="login-register/daftar.php" method="POST">
                            <h3>Daftar Akun</h3>
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="nama">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" required>
                                    </div>
                                    <div class="data-user">
                                        <label for="nik">NIK</label>
                                        <input type="number" name="nik" id="nik" required>
                                    </div>
                                    <div class="data-user">
                                        <div class="ttl">
                                            <label for="tempat">Tempat Lahir</label>
                                            <input type="text" name="tempat" id="tempat" required>
                                        </div>
                                        <div class="ttl">
                                            <label for="tgl_lahir">Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" required>
                                        </div>
                                    </div>
                                    <div class="data-user">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select name="jk" id="jk" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="agama">Agama</label>
                                        <select name="agama" id="agama" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Khatolik">Khatolik</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Konghuchu">Konghuchu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="data-user">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <select name="pekerjaan" id="pekerjaan" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Wiraswasta">Wiraswasta</option>
                                            <option value="Petani">Petani</option>
                                            <option value="Buruh">Buruh</option>
                                            <option value="PNS">PNS</option>
                                            <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="pendidikan">Pendidikan</label>
                                        <select name="pendidikan" id="pendidikan" required>
                                            <option selected disabled value="">Pilih Salah Satu</option>
                                            <option value="Tidak Tamat SD">Tidak Tamat SD</option>
                                            <option value="SD/Sederajat">SD/Sederajat</option>
                                            <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                                            <option value="SMA/Sederajat">SMA/Sederajat</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Sarjana">Sarjana</option>
                                            <option value="Pascasarjana">Pascasarjana</option>
                                            <option value="Doktor">Doktor</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="status_nikah">Status Pernikahan</label>
                                        <select name="status_nikah" id="status_nikah" required>
                                            <option selected disabled value="">Pilih salah satu</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Sudah Menikah">Sudah Menikah</option>
                                            <option value="Cerai">Cerai Hidup</option>
                                            <option value="Cerai">Cerai Mati</option>
                                        </select>
                                    </div>
                                    <div class="data-user">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" id="alamat" placeholder="*Blok, RT/RW, Desa, Kecamatan, Kabupaten" required></textarea>
                                    </div>
                                    <div class="data-user">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit">Daftar Akun</button>
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

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>

    <script src="user/js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Check URL parameters for status
		const urlParams = new URLSearchParams(window.location.search);
		const status = urlParams.get('status');

		if (status === 'success') {
			Swal.fire({
				icon: 'success',
				title: 'Pendaftaran Berhasil!',
				text: 'Silahkan login!',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error') {
			Swal.fire({
				icon: 'error',
				title: 'Pendaftaran Gagal!',
				text: 'Silahkan ulangi kembali!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
		} else if (status === 'error-nik-sudah-terdaftar') {
            Swal.fire({
				icon: 'error',
				title: 'NIK sudah digunakan!',
				text: 'Silahkan ulangi kembali dengan NIK yang berbeda!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        } else if (status === 'error-nik-harus-angka') {
            Swal.fire({
				icon: 'error',
				title: 'NIK harus menggunakan angka!',
				text: 'Silahkan ulangi kembali penulisan NIK!.',
				customClass: {
					popup: 'swal2-popup'
				}
			});
        }

        document.getElementById('pengajuanForm').addEventListener('submit', function(event) {
            let form = event.target;
            let inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
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
