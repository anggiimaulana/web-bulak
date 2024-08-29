-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 22 Agu 2024 pada 04.14
-- Versi server: 11.3.2-MariaDB-log
-- Versi PHP: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa_bulak`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `agama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `status_pernikahan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `nama`, `nip`, `password`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `alamat`, `pekerjaan`, `pendidikan`, `status_pernikahan`) VALUES
(1, 'Samsul Rena', '123456789', '$2y$10$mpXaFY6QE7w4MnQBmi3kaeLDm1xuFLqS5URuKFtoD6L5Y.sdsQ6jS', 'Indramayu', '1992-11-11', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat', 'PNS', 'Diploma', 'Belum Menikah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int(11) NOT NULL,
  `judul_artikel` varchar(255) NOT NULL,
  `isi_artikel` varchar(5000) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `judul_artikel`, `isi_artikel`, `gambar`, `tanggal`, `kategori`, `status`, `id_admin`) VALUES
(24, 'Kasus Malik', 'Basis data, atau database, adalah kumpulan data yang terorganisir dan disimpan secara sistematis sehingga dapat diakses, dikelola, dan diperbarui dengan mudah. Basis data dirancang untuk mendukung penyimpanan dan pengambilan informasi secara efisien, serta untuk memastikan integritas dan keamanan data.\r\n\r\nBasis data biasanya dikelola menggunakan Sistem Manajemen Basis Data (DBMS), yang merupakan perangkat lunak yang menyediakan alat untuk membuat, mengubah, dan mengelola data dalam basis data. Contoh DBMS yang umum digunakan antara lain MySQL, PostgreSQL, Oracle, dan Microsoft SQL Server.\r\n\r\nBeberapa karakteristik penting dari basis data meliputi:\r\n\r\nTerstruktur: Data disimpan dalam format yang terstruktur, seperti tabel yang terdiri dari baris dan kolom, di mana setiap baris mewakili satu entitas dan setiap kolom mewakili atribut dari entitas tersebut.\r\n\r\nAksesibilitas: Basis data memungkinkan akses data yang cepat dan efisien, sehingga pengguna dapat dengan mudah menemukan dan memanipulasi data yang mereka butuhkan.\r\n\r\nKeamanan: Basis data biasanya dilengkapi dengan mekanisme keamanan untuk melindungi data dari akses yang tidak sah dan memastikan bahwa hanya pengguna yang berwenang yang dapat melakukan perubahan.\r\n\r\nKonsistensi: Basis data memastikan bahwa data tetap konsisten, terutama ketika ada banyak pengguna yang mengakses atau memperbarui data secara bersamaan.\r\n\r\nRedundansi yang Minim: Basis data dirancang untuk mengurangi duplikasi data, sehingga menghemat ruang penyimpanan dan mencegah inkonsistensi data.\r\n\r\nDalam dunia teknologi informasi, basis data merupakan komponen yang sangat penting karena memungkinkan penyimpanan dan pengelolaan informasi dalam berbagai aplikasi, mulai dari sistem manajemen keuangan hingga media sosial.', '257-malik.jpg', '2024-08-13', 'Pengumuman', 'Publish', NULL),
(25, 'Berkenalan dengan Blockchain.', 'Blockchain is a decentralized, distributed ledger technology that securely records transactions across a network of computers. It is designed to be transparent, immutable, and tamper-resistant, which makes it ideal for recording and verifying data without the need for a central authority.\r\n\r\nKey Components of Blockchain:\r\nBlocks: Each block contains a list of transactions. Once a block is completed, it is added to the chain in a linear, chronological order.\r\nChain: The chain is a sequence of blocks that are linked together. Each block contains a cryptographic hash of the previous block, ensuring the integrity of the entire chain.\r\nDecentralization: Instead of relying on a central authority, blockchain uses a distributed network of nodes (computers) to verify and record transactions.\r\nConsensus Mechanisms: These are protocols used by the network to agree on the validity of transactions. Common examples include Proof of Work (PoW) and Proof of Stake (PoS).\r\nCommon Uses of Blockchain:\r\nCryptocurrencies: Bitcoin and other cryptocurrencies use blockchain to securely record transactions.\r\nSmart Contracts: These are self-executing contracts with the terms directly written into code. Ethereum is a popular platform for smart contracts.\r\nSupply Chain Management: Blockchain can track products through every stage of the supply chain, improving transparency and reducing fraud.\r\nVoting Systems: Blockchain offers a tamper-proof way to conduct elections and verify results.\r\nDigital Identity: Securely managing and verifying identities on the blockchain can prevent identity theft and fraud.\r\nBlockchain technology is still evolving, with potential applications across various industries, including finance, healthcare, and logistics.', '5589-blockchain.jpg', '2024-08-24', 'Pengumuman', 'Publish', NULL),
(26, 'Gempa Megatrusth', 'Waspada Gempa Bumi', '3720-bakso.jpg', '2024-08-16', 'Pengumuman', 'Publish', NULL),
(27, 'React JS', 'htrgvkjykgvbtkgtubet4bktlg bgkuv4tkbgetv bgkevkngluvetbvgk ekgb tbk g5u', '3126-kerak-telor.jpg', '2024-08-16', 'Pengumuman', 'Publish', NULL),
(28, 'Event 2022 di Indonesia', 'ae kgklkblsfgfjgb  bgykbseg kng kn sgheb gklk ngees knkj.', '4900-jalan-braga.jpg', '2024-08-27', 'Pengumuman', 'Publish', NULL),
(29, 'Event 2024 di Indonesia', 'ljlgsljaeg k', '6930-banda-neira.jpg', '2024-08-16', 'Pengumuman', 'Publish', NULL),
(30, 'Bulak Bermartabat', 'bbskhfsj', '9922-blockchain.jpg', '2024-08-17', 'Berita', 'Publish', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul`, `gambar`, `tanggal`) VALUES
(11, 'Ice Cream Enak', '5046-ice-cream.jpg', '2024-08-17'),
(12, 'Pesona Indramayu', '5030-kelas.jpg', '2024-08-31'),
(13, 'naruto', '8645-angklung.jpg', '2024-08-29'),
(14, 'perpustakaan cuyy', '7918-highland-curug.jpg', '2024-08-25'),
(15, 'thinkpad', '1396-5g.jpg', '2024-08-29'),
(16, 'c++', '4883-kekerasan-seksual.jpg', '2024-09-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pengajuan`
--

CREATE TABLE `kategori_pengajuan` (
  `id_kategori_pengajuan` int(20) NOT NULL,
  `jenis_pengajuan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori_pengajuan`
--

INSERT INTO `kategori_pengajuan` (`id_kategori_pengajuan`, `jenis_pengajuan`) VALUES
(1, 'Surat Keterangan Usaha'),
(2, 'Surat Keterangan Beda Nama'),
(3, 'Surat Keterangan Tidak Mampu'),
(4, 'Surat Keterangan Penduduk Sementara'),
(5, 'Surat Keterangan Domisili'),
(6, 'Surat Keterangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `id_kategori` int(20) NOT NULL,
  `nama_usaha` varchar(255) DEFAULT NULL,
  `nama_kk` varchar(255) DEFAULT NULL,
  `nama_akte_dokumen` varchar(255) DEFAULT NULL,
  `keterangan_tidak_mampu` varchar(500) DEFAULT NULL,
  `masa_ktp_sementara` date DEFAULT NULL,
  `keterangan_menikah` varchar(255) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `tanggal_acc` date DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `nama_kuwu` varchar(255) DEFAULT NULL,
  `id_admin` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `nik`, `id_kategori`, `nama_usaha`, `nama_kk`, `nama_akte_dokumen`, `keterangan_tidak_mampu`, `masa_ktp_sementara`, `keterangan_menikah`, `tanggal_pengajuan`, `tanggal_acc`, `status`, `nama_kuwu`, `id_admin`) VALUES
(73, '3212131307050003', 2, NULL, 'ANGGI MAULANA', 'Angga Maulana', NULL, NULL, NULL, '2024-08-24', '2024-08-13', 'Acc', 'SURADI BUDIYANTO', NULL),
(74, '3212131307050003', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-16', '2024-08-16', 'Acc', 'Robi Permana', NULL),
(75, '3212131307050003', 1, 'Toko Seblak', NULL, NULL, NULL, NULL, NULL, '2024-08-24', '2024-08-25', 'Acc', 'Anggi Maulana', NULL),
(76, '3212131307050003', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-30', '2024-08-30', 'Acc', 'SURADI BUDIYANTO', NULL),
(77, '12345', 1, 'robzz', NULL, NULL, NULL, NULL, NULL, '2024-08-16', '2024-08-17', 'Acc', 'Anggi Maulana', NULL),
(78, '12345', 3, NULL, NULL, NULL, 'Untuk masuk kuliah', NULL, NULL, '2024-08-16', '2024-08-30', 'Acc', 'SURADI BUDIYANTO', NULL),
(79, '3212131307050003', 1, 'MyAnggi', NULL, NULL, NULL, NULL, NULL, '2024-08-30', '2024-08-31', 'Acc', 'SURADI BUDIYANTO', NULL),
(80, '3212131307050003', 6, NULL, NULL, NULL, NULL, NULL, 'Belum Menikah', '2024-08-16', '2024-08-16', 'Acc', 'Anggi Maulana Hakim', NULL),
(81, '3212131307050003', 6, NULL, NULL, NULL, NULL, NULL, 'Sudah Menikah', '2024-08-16', '2024-08-23', 'Acc', 'anggii', NULL),
(82, '3212131307050003', 4, NULL, NULL, NULL, NULL, '2024-09-16', NULL, '2024-08-16', '2024-08-24', 'Acc', 'SURADI BUDIYANTO', NULL),
(83, '3212131307050003', 3, NULL, NULL, NULL, 'Untuk masuk kuliah', NULL, NULL, '2024-08-16', '2024-08-16', 'Acc', 'SURADI BUDIYANTO', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `agama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `pekerjaan` varchar(255) NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `status_pernikahan` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `nama`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `agama`, `alamat`, `pekerjaan`, `pendidikan`, `status_pernikahan`, `password`) VALUES
(2, 'Anggi Maulana', '3212131307050003', 'Indramayu', '2005-07-13', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', 'Pelajar/Mahasiswa', 'Sarjana', 'Belum Menikah', '$2y$10$uCmLlHZL3LDuQsn8c7I.c.M.JiqeDCFe.M5pL8Zotav0GcQMhj7ku'),
(23, 'Robi Permana', '12345', 'Indramayu', '2001-11-11', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', 'Pelajar/Mahasiswa', 'Sarjana', 'Belum Menikah', '$2y$10$9zNJHXezdD3/b2GcHIe43.5add9p7yXhTfLZ6wffVvM8qXeSZaicy');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`),
  ADD KEY `fk_admin` (`id_admin`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indeks untuk tabel `kategori_pengajuan`
--
ALTER TABLE `kategori_pengajuan`
  ADD PRIMARY KEY (`id_kategori_pengajuan`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `fk_admin_acc` (`id_admin`),
  ADD KEY `fk_user` (`nik`),
  ADD KEY `fk_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `nik` (`nik`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kategori_pengajuan`
--
ALTER TABLE `kategori_pengajuan`
  MODIFY `id_kategori_pengajuan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `fk_admin_acc` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_pengajuan` (`id_kategori_pengajuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`nik`) REFERENCES `user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
