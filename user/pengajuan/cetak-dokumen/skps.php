<?php 
    include_once ('../../fpdf/fpdf.php');
    require ('../../../config/db.php');

    session_start(); // Memulai sesi

    // Mengecek apakah pengguna sudah login
    if (!isset($_SESSION['nik'])) {
        header('Location: ../../../../project-bulak/login.php');
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
        $ktp_sementara_berlaku = $data_pengajuan['masa_ktp_sementara'];
        // Pastikan kolom `tanggal_pengajuan` benar-benar ada dan tidak kosong
        $tanggal_acc = $data_pengajuan['tanggal_acc'];
    } else {
        die('Error: Data pengajuan tidak ditemukan');
    }

    // Membuat nama file sesuai format yang diinginkan
    $nama_file = 'SKPS_' . $userData['nama'] . '_' . $tanggal_acc . '.pdf';

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
    $pdf->Cell(115, 7, 'SURAT KETERANGAN PENDUDUK SEMENTARA', 0, 1, 'C');
    $pdf->SetLineWidth(0.5); // Ketebalan garis (dalam mm)
    $pdf->Line($textX - 10, $textY + 42, $textX + 120 + 5, $textY + 42); // Garis bawah sepanjang teks (dengan spasi tambahan)

    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($textX, $textY + 42);
    $pdf->Cell(115, 7, ' Nomor : /Ds-2004/V/2013', 0, 1, 'C');

    // keterangan 1
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 10);
    $keterangan = 'Yang   bertanda   tangan   di  bawah  ini,  Kuwu   Desa  Bulak  Kecamatan Jatibarang Kabupaten Indramayu';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');
    
    // keterangan 2
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 2);
    $keterangan = 'Menerangkan dengan sebenarnya bahwa :';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');

    // Menentukan posisi untuk tabel data diri
    $startX = 40; // Posisi X
    $startY = 97; // Posisi Y, sesuaikan sesuai kebutuhan

    // Tabel data diri
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(45, 7, 'Nama', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['nama'], 0, 1, 'J'); // Data

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
    $pdf->Cell(45, 7, 'Jenis Kelamin', 0, 0, 'L'); // Teks Label
    $pdf->Cell(9, 7, '', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(5, 7, ':', 0, 0, 'L'); // Tanda ':'
    $pdf->Cell(0, 7, $userData['jenis_kelamin'], 0, 1, 'L'); // Data

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

    // keterangan 3
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 5);
    $keterangan = 'Benar  nama tersebut adalah masyarakat kami yang sampai saat sekarang yang bersangkutan kartu Tanda Penduduk  ( KTP ) aslinya  masih  dalam  proses pembuatan / penyelesaian.';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');
    
    // penutup
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 2);
    $keterangan = 'Demikian surat keterangan ini, dibuat dengan sebenarnya dan dapat dipergunakan seperlunya.';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');
    
    // atur kapan pengajuan dan masa akhir ktp
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tanggal_pengajuan_array2 = explode('-', $ktp_sementara_berlaku);
    $tanggal_pengajuan_array = explode('-', $tanggal_pengajuan);
    $tanggal_pengajuan_indo = $tanggal_pengajuan_array[2] . ' ' . $bulan[(int)$tanggal_pengajuan_array[1]] . ' ' . $tanggal_pengajuan_array[0];
    $tanggal_pengajuan_indo2 = $tanggal_pengajuan_array2[2] . ' ' . $bulan[(int)$tanggal_pengajuan_array2[1]] . ' ' . $tanggal_pengajuan_array2[0];

    // akhir ktp
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 5);
    $keterangan = 'Catatan : KTP Sementara ini berlaku sampai tanggal : '. $tanggal_pengajuan_indo2;
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');

    // Menentukan posisi untuk tabel bersangkutan dan kuwu
    $startX = 45; // Posisi X
    $startY = 210; // Posisi Y, sesuaikan sesuai kebutuhan

    // bersangkutan
    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(85, 7, ' ', 0, 0, 'L'); // Teks Label
    $pdf->Cell(0, 7, 'Bulak, '.$tanggal_acc, 0, 1, 'L'); // Data
    
    $startY += 7; // Tambahkan Y untuk baris berikutnya
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(90, 7, 'Yang Bersangkutan,', 0, 0, 'L'); // Teks Label
    $pdf->Cell(0, 7, 'Kuwu Bulak,', 0, 1, 'L'); // Data
    
    // data 
    $startY += 25; // Tambahkan Y untuk baris berikutnya
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetXY($startX, $startY);
    $pdf->Cell(80, 7, $userData['nama'], 0, 0, 'L'); // Teks Label
    
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 7, 'SURADI BUDIYANTO', 0, 1, 'L'); // Data

    // // ttd
    // $pdf->SetFont('Times', 'B', 12);
    // $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 20);
    // $nama_kuwu = 'SURADI BUDIYANTO';
    // $pdf->MultiCell(152, 7, $nama_kuwu, 0, 'R');

    ob_clean();
    flush();
    // $pdf->Output();
    $pdf->Output('D', $nama_file);

