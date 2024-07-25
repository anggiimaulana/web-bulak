-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 20 Jul 2024 pada 02.57
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
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id_artikel` int(11) NOT NULL,
  `kode_artikel` int(11) NOT NULL,
  `judul_artikel` varchar(255) NOT NULL,
  `isi_artikel` varchar(5000) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `id_kategori_artikel` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id_kategori_artikel` int(11) NOT NULL,
  `judul_artikel` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(6, 'Surat Keterangan Belum Menikah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isi_komentar` varchar(500) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kritik_saran`
--

CREATE TABLE `kritik_saran` (
  `id_kritik_saran` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isi` varchar(500) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `masa_ktp_sementara` varchar(255) DEFAULT NULL,
  `keterangan_menikah` varchar(255) DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `id_admin` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `nik`, `id_kategori`, `nama_usaha`, `nama_kk`, `nama_akte_dokumen`, `keterangan_tidak_mampu`, `masa_ktp_sementara`, `keterangan_menikah`, `tanggal_pengajuan`, `status`, `id_admin`) VALUES
(2, '3212131307050004', 1, 'MyStore', NULL, NULL, NULL, NULL, NULL, '2024-07-20', 'Acc', NULL),
(3, '3212131307050004', 2, NULL, 'Anggi', 'Anggi Maulana, S.Tr.Kom', NULL, NULL, NULL, '2024-07-13', 'Pending', NULL),
(4, '3212131307050003', 1, 'AM Project', NULL, NULL, NULL, NULL, NULL, '2024-07-20', 'Pending', NULL),
(5, '3212131307050003', 2, NULL, 'Anggi', 'Anggi Maulana', NULL, NULL, NULL, '2024-07-20', 'Pending', NULL),
(6, '3212131307050004', 1, 'anggii', NULL, NULL, NULL, NULL, NULL, '2024-07-20', 'Pending', NULL),
(7, '3212131307050003', 3, NULL, NULL, NULL, 'Untuk masuk kuliah', NULL, NULL, '2024-07-20', 'Pending', NULL),
(9, '3212131307050003', 4, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-20', 'Pending', NULL),
(10, '3212131307050003', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-20', 'Pending', NULL),
(11, '3212131307050003', 6, NULL, NULL, NULL, NULL, NULL, 'Belum Menikah', '2024-07-20', 'Pending', NULL);

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
(7, 'Anggi Maulana', '3212131307050004', 'Indramayu', '2005-07-13', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', 'PNS', 'Pascasarjana', 'Belum Menikah', '$2y$10$25A2WZZE9yQR.QNiV0FxzO5gGeCQbIvMOJAqNGA1/37vInyBdlxda');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id_artikel`),
  ADD KEY `fk_kategori` (`id_kategori_artikel`),
  ADD KEY `fk_admin` (`id_admin`);

--
-- Indeks untuk tabel `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id_kategori_artikel`);

--
-- Indeks untuk tabel `kategori_pengajuan`
--
ALTER TABLE `kategori_pengajuan`
  ADD PRIMARY KEY (`id_kategori_pengajuan`);

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`);

--
-- Indeks untuk tabel `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD PRIMARY KEY (`id_kritik_saran`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `fk_admin_acc` (`id_admin`),
  ADD KEY `fk_user` (`nik`);

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
  MODIFY `admin_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id_kategori_artikel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori_pengajuan`
--
ALTER TABLE `kategori_pengajuan`
  MODIFY `id_kategori_pengajuan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kritik_saran`
--
ALTER TABLE `kritik_saran`
  MODIFY `id_kritik_saran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kategori_artikel`) REFERENCES `kategori_artikel` (`id_kategori_artikel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `fk_admin_acc` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`nik`) REFERENCES `user` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
