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
        // Pastikan kolom `tanggal_pengajuan` benar-benar ada dan tidak kosong
        $tanggal_acc = $data_pengajuan['tanggal_acc'];
        $ttd = $data_pengajuan['nama_kuwu'];
        $usaha = $data_pengajuan['nama_usaha'];
        $nomor_sku = $data_pengajuan['id_pengajuan'];
        $nomor_surat_berikutnya_padded = str_pad($nomor_sku, 3, '0', STR_PAD_LEFT);
    } else {
        die('Error: Data pengajuan tidak ditemukan');
    }

    // Mengetahui kategori pengajuan
    $kategori_sku = "SELECT id_kategori FROM pengajuan WHERE id_pengajuan = '$id_pengajuan'";
    $result_sku = mysqli_query($conn, $kategori_sku);

    if ($result_sku) {
        $pengajuan_sku = mysqli_fetch_assoc($result_sku);
        
        // Mengambil nilai id_kategori dari hasil query
        $id_kategori = $pengajuan_sku['id_kategori'];
        
        // Menambahkan angka 0 di depan id_kategori (misalnya menjadi 01, 02, dst.)
        $kategori_pengajuan_sku = str_pad($id_kategori, 2, '0', STR_PAD_LEFT);
        
    } else {
        die('Error: Gagal mengambil data kategori pengajuan');
    }


    // Menghitung jumlah keseluruhan data pengajuan sku
    $jumlah_sku = "SELECT COUNT(*) AS total FROM pengajuan where id_kategori = 1";
    $result_sku = mysqli_query($conn, $jumlah_sku);
    if ($result_sku) {
        $sku = mysqli_fetch_assoc($result_sku);
        $jumlah_keseluruhan_sku = $sku['total'];
        
        // Menentukan nomor surat berikutnya
        $nomor_sku_berikutnya = $jumlah_keseluruhan_sku + 1;
        
        // Menambahkan angka 0 di depan nomor surat (misalnya menjadi 001, 002, dst.)
        $nomor_sku_berikutnya_padded = str_pad($nomor_sku_berikutnya, 3, '0', STR_PAD_LEFT);
        
    } else {
        die('Error: Gagal menghitung jumlah keseluruhan data pengajuan');
    }



    // Membuat nama file sesuai format yang diinginkan
    $nama_file = 'SKU_' . $userData['nama'] . '_' . $tanggal_acc . '.pdf';

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
    $pdf->Cell(115, 7, 'SURAT KETERANGAN USAHA', 0, 1, 'C');
    $pdf->SetLineWidth(0.5); // Ketebalan garis (dalam mm)
    $pdf->Line($textX + 15, $textY + 42, $textX + 95 + 5, $textY + 42); // Garis bawah sepanjang teks (dengan spasi tambahan)

    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($textX, $textY + 42);

    // Mendapatkan tahun saat ini
    $tahun_sekarang = date('Y');

    // Mendapatkan bulan saat ini dalam format angka (01, 02, ..., 12)
    $bulan_sekarang = str_pad(date('m'), 2, '0', STR_PAD_LEFT);


    // Menggunakan variabel bulan dan tahun dalam output PDF
    $pdf->Cell(115, 7, "Nomor : $nomor_surat_berikutnya_padded / $kategori_pengajuan_sku / $nomor_sku_berikutnya_padded / $bulan_sekarang / $tahun_sekarang", 0, 1, 'C');


    // keterangan 1
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 10);
    $keterangan = 'Yang bertanda tangan di bawah ini kami Kuwu Desa Bulak Kecamatan Jatibarang Kabupaten Indramayu, Menerangkan bahwa :';
    $pdf->MultiCell(0, 7, $keterangan, 0, 'J');

    // Menentukan posisi untuk tabel data diri
    $startX = 45; // Posisi X
    $startY = 95; // Posisi Y, sesuaikan sesuai kebutuhan

    // Tabel data diri
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
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 10);
    $keterangan2 = 'Benar nama tersebut di atas adalah warga penduduk kami yang mana menurut sepengetahuan kami mempunyai usaha :';
    $pdf->MultiCell(0, 7, $keterangan2, 0, 'J');

    // Nama usaha
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 5);
    $pdf->MultiCell(0, 7, '========= '.$usaha.' =========', 0, 'C');

    // Penutup
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + 5);
    $penutup = 'Demikian surat keterangan ini kami buat dengan sebenarnya, dan dapat dipergunakan sebagaimana mestinya.';
    $pdf->MultiCell(0, 7, $penutup, 0, 'J');

    // waktu pengajuan
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY(150, $pdf->GetY() + 15);
    $tempat = 'Bulak, ';
    
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tanggal_acc_array = explode('-', $tanggal_acc);
    $tanggal_acc_indo = $tanggal_acc_array[2] . ' ' . $bulan[(int)$tanggal_acc_array[1]] . ' ' . $tanggal_acc_array[0];
    
    $pdf->Cell(0, 7, $tempat . $tanggal_acc_indo, 0, 1, 'R');
    
    // kuwu
    $pdf->SetFont('Times', '', 12);
    $pdf->SetXY(150, $pdf->GetY() + 0);
    $waktu = 'Kuwu Bulak';
    $pdf->Cell(0, 7, $waktu, 0, 1, 'c');
    
    // ttd
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetXY(150, $pdf->GetY() + 20);
    $nama_length = $pdf->GetStringWidth($ttd);
    $centered_position = (325 - $nama_length) / 2; // Menghitung posisi X agar teks berada di tengah
    $pdf->SetX($centered_position);
    $pdf->Cell(0, 7, $ttd, 0, 1, 'L');

    ob_clean();
    flush();
    // $pdf->Output();
    $pdf->Output('D', $nama_file);