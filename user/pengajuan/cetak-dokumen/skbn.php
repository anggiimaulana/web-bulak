<?php 
    include_once ('../../fpdf/fpdf.php');
    require ('../../../config/db.php');

    session_start(); // Memulai sesi

    // Mengecek apakah pengguna sudah login
    if (!isset($_SESSION['nik'])) {
        header('Location: ../../../../project/login.php');
        exit();
    }

    // Mendapatkan id_pengajuan dari URL
    if (!isset($_GET['id_pengajuan'])) {
        die('Error: ID Pengajuan tidak ditemukan');
    }
    $id_pengajuan = $_GET['id_pengajuan'];
    $nik = $_SESSION['nik'];

    // Mengambil data user dari database
    $sql = "SELECT * FROM user WHERE nik = '$nik'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
    } else {
        die('Error: Data user tidak ditemukan');
    }

    // Mengambil data pengajuan dari database
    $sql2 = "SELECT * FROM pengajuan WHERE id_pengajuan = '$id_pengajuan' AND nik = '$nik'";
    $result2 = mysqli_query($conn, $sql2);
    if ($result2 && mysqli_num_rows($result2) > 0) {
        $data_pengajuan = mysqli_fetch_assoc($result2);
        $usaha = $data_pengajuan['nama_usaha'];
        $nama_kk = $data_pengajuan['nama_kk'];
        $nama_akte_dokumen = $data_pengajuan['nama_akte_dokumen'];
        // Pastikan kolom `tanggal_pengajuan` benar-benar ada dan tidak kosong
        $tanggal_pengajuan = $data_pengajuan['tanggal_pengajuan'];
    } else {
        die('Error: Data pengajuan tidak ditemukan');
    }

    // Membuat nama file sesuai format yang diinginkan
    $nama_file = 'SKBN_' . $userData['nama'] . '_' . $tanggal_pengajuan . '.pdf';

    // membuat pdf
    $pdf = new FPDF('P', 'mm', 'A4');

    // mengatur margin
    $pdf->SetMargins(25.4, 10.2, 25.4); // kiri, atas, kanan (dalam mm)
    $pdf->SetAutoPageBreak(true, 15.2); // margin bawah (dalam mm)

    // membuat halaman baru
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 16);

    // menyisipkan gambar di sebelah kiri
    $imageX = 25.4;
    $imageY = 15;
    $imageWidth = 25.6;
    $imageHeight = 25.6;
    $pdf->Image('../../img/bulak.jpg', $imageX, $imageY, $imageWidth, $imageHeight); // Sesuaikan path gambar dan ukuran

    // menetapkan posisi X dan Y untuk teks agar sejajar dengan gambar
    $textX = $imageX + $imageWidth + 5; // Posisi teks setelah gambar dengan spasi 5 mm
    $textY = $imageY;

    $pdf->SetXY($textX, $textY);
    $pdf->Cell(115, 7, 'PEMERINTAH KABUPATEN INDRAMAYU', 0, 1, 'C');

    $pdf->SetXY($textX, $textY + 7);
    $pdf->Cell(115, 7, 'KECAMATAN JATIBARANG', 0, 1, 'C');

    $pdf->SetXY($textX, $textY + 14);
    $pdf->Cell(115, 7, 'DESA BULAK', 0, 1, 'C');

    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($textX, $textY + 21);
    $pdf->Cell(120, 7, 'Jalan Raya Bulak No. 18 / 01 Desa Bulak - Jatibarang - Indramayu 45273', 0, 1, 'C');

    // Menambahkan garis di bawah
    $pdf->Line($textX - 30, $textY + 28, $textX + 125 + 5, $textY + 28); // Garis bawah sepanjang teks (dengan spasi tambahan)
    $pdf->SetLineWidth(1); // Ketebalan garis (dalam mm)
    $pdf->Line($textX - 30, $textY + 29, $textX + 125 + 5, $textY + 29); // Garis bawah sepanjang teks (dengan spasi tambahan)
    
    // keterangan surat
    $pdf->SetFont('Times', 'B', 16);
    $pdf->SetXY($textX, $textY + 36);
    $pdf->Cell(115, 7, 'SURAT KETERANGAN BEDA NAMA', 0, 1, 'C');
    $pdf->SetLineWidth(0.5); // Ketebalan garis (dalam mm)
    $pdf->Line($textX + 5, $textY + 42, $textX + 105 + 5, $textY + 42); // Garis bawah sepanjang teks (dengan spasi tambahan)

    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($textX, $textY + 42);
    $pdf->Cell(115, 7, 'Nomor : 470/ 119 /Des', 0, 1, 'C');

    // keterangan 1
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 5);
    $keterangan = 'Yang bertanda tangan di bawah ini kami Kuwu Desa Bulak Kecamatan Jatibarang Kabupaten Indramayu, dengan ini menerangkan bahwa :';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');
    
    // keterangan 2
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 2);
    $keterangan = 'Yang tercantum dalam Kartu Keluarga (KK) :';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');

    // Menentukan posisi untuk tabel data diri
    $startX = 30; // Posisi X
    $startY = 92; // Posisi Y, sesuaikan sesuai kebutuhan

    // Tabel data diri
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Nama', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 7, $nama_kk, 0, 1, 'J'); // Data

    $pdf->SetFont('Times', '', 12);
    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'NIK', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['nik'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Tempat/Tanggal Lahir', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'

    $bulan2 = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tanggal_lahir_array = explode('-', $userData['tanggal_lahir']);
    $tanggal_lahir_indo = $tanggal_lahir_array[2] . ' ' . $bulan2[(int)$tanggal_lahir_array[1]] . ' ' . $tanggal_lahir_array[0];

    $pdf->Cell(0, 7, $userData['tempat_lahir'].', '.$tanggal_lahir_indo, 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Status', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['status_pernikahan'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Agama', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['agama'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Pekerjaan', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['pekerjaan'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Alamat', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->MultiCell(0, 7, $userData['alamat'], 0, 'J'); // Data

    // data 2
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 2);
    $keterangan = 'Yang tercantum dalam AKTA Kelahiran & IJAZAH :';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');

    // Menentukan posisi untuk tabel data diri
    $startX = 30; // Posisi X
    $startY = 157; // Posisi Y, sesuaikan sesuai kebutuhan

    // Tabel data diri
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Nama', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 7, $nama_akte_dokumen, 0, 1, 'L'); // Data

    $pdf->SetFont('Times', '', 12);
    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'NIK', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['nik'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Tempat/Tanggal Lahir', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'

    $bulan2 = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tanggal_lahir_array = explode('-', $userData['tanggal_lahir']);
    $tanggal_lahir_indo = $tanggal_lahir_array[2] . ' ' . $bulan2[(int)$tanggal_lahir_array[1]] . ' ' . $tanggal_lahir_array[0];

    $pdf->Cell(0, 7, $userData['tempat_lahir'].', '.$tanggal_lahir_indo, 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Status', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['status_pernikahan'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Agama', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['agama'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Pekerjaan', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['pekerjaan'], 0, 1, 'L'); // Data

    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Alamat', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->MultiCell(0, 7, $userData['alamat'], 0, 'J'); // Data

    // keterangan 2
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 2);
    $keterangan2 = 'Benar nama tersebut diatas adalah penduduk Desa Bulak Kecamatan Jatibarang Kabupaten Indramayu, kami menerangkan bahwa nama tersebut diatas adalah orang yang sama. Demikian Surat keterangan ini kami buat dengan sebenarnya dan untuk dipergunakan sebagaimana mestinya.';
    $pdf->MultiCell(0, 7, $keterangan2, 0, 'J');

    // waktu pengajuan
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 2);
    $tempat = 'Bulak, ';

    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tanggal_pengajuan_array = explode('-', $tanggal_pengajuan);
    $tanggal_pengajuan_indo = $tanggal_pengajuan_array[2] . ' ' . $bulan[(int)$tanggal_pengajuan_array[1]] . ' ' . $tanggal_pengajuan_array[0];

    $pdf->MultiCell(145, 7, $tempat . $tanggal_pengajuan_indo, 0, 'R');

    // kuwu
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 0);
    $waktu = 'Kuwu Bulak';
    $pdf->MultiCell(139, 7, $waktu, 0, 'R');

    // ttd
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 15);
    $nama_kuwu = 'SURADI BUDIYANTO';
    $pdf->MultiCell(150, 7, $nama_kuwu, 0, 'R');
    $pdf->SetLineWidth(0); // Ketebalan garis (dalam mm)
    $pdf->Line($textX + 119, $textY + 265, $textX + 68 + 7, $textY + 265); // Garis bawah sepanjang teks (dengan spasi tambahan)

    ob_clean();
    flush();
    // $pdf->Output();
    $pdf->Output('D', $nama_file);

?>
