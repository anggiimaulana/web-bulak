-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 10 Agu 2024 pada 08.04
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
(1, 'Samsul Rena', '123456789', '$2y$10$mpXaFY6QE7w4MnQBmi3kaeLDm1xuFLqS5URuKFtoD6L5Y.sdsQ6jS', 'Indramayu', '1992-11-11', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat', 'PNS', 'Diploma', 'Belum Menikah'),
(2, 'Samsul Rena', '12345678910', '$2y$10$9XZ79b2P7Jguj2vzRsjJNebz1u6RbpdtqzJMLF5gwUwQ0B.HH/3kq', 'Indramayu', '1992-11-11', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat', 'PNS', 'Diploma', 'Sudah Menikah'),
(3, 'Anggi Maulana', '12', '$2y$10$4A3FcvPK/Spn7gx12W8u6.Ss6LgSGWo59vuZ.z8XqGMg4kZ8Ejrvy', '12', '2024-07-28', 'Laki-Laki', 'Budha', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', 'Petani', 'SD/Sederajat', 'Sudah Menikah'),
(4, '123', '123', '$2y$10$nK.rH7HQfucQgh/LFwOmgOVvxTzk/P1yBxJr4m16eLIJYb1eJCwae', 'Indramayu', '2024-07-29', 'Laki-Laki', 'Islam', '123', 'PNS', 'Sarjana', 'Belum Menikah'),
(5, 'Muhammad Malik Hakim Argadiredja', '1111', '$2y$10$Y/xKE74KBiEfPSCqL9bsu.TpXZO./0xfkA8Zx2kX/Dbq1vGQ0wiSC', '1111', '2000-11-11', 'Laki-Laki', 'Khatolik', 's nkegk segbkjjsvvsbkbnb sbn skvk vskvgbsknvbke sn ghsl hbgeskg sn gseges hgs;hihgo;sihouvsjbwi bibjsbj', 'Petani', 'SMA/Sederajat', 'Belum Menikah');

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
(48, '3212131307050003', 1, 'anggii.id', NULL, NULL, NULL, NULL, NULL, '2024-07-26', '2024-07-27', 'Acc', NULL, NULL),
(49, '3212131307050003', 2, NULL, 'Anggi Maulana, S.Tr.Kom', 'Anggi', NULL, NULL, NULL, '2024-07-26', '2024-08-01', 'Acc', 'Anggi Maulana', NULL),
(50, '3212131307050003', 4, NULL, NULL, NULL, NULL, '2024-08-26', NULL, '2024-07-26', '2024-07-29', 'Acc', NULL, NULL),
(51, '3212131307050003', 6, NULL, NULL, NULL, NULL, NULL, 'Belum Menikah', '2024-07-13', '2024-08-10', 'Acc', NULL, NULL),
(52, '3212131307050003', 1, 'anggii.id', NULL, NULL, NULL, NULL, NULL, '2024-07-26', '2024-08-03', 'Acc', NULL, NULL),
(53, '3212131307050003', 2, NULL, 'Anggi', 'Anggi Maulana', NULL, NULL, NULL, '2024-07-26', '2024-08-03', 'Acc', NULL, NULL),
(54, '3212131307050003', 3, NULL, NULL, NULL, 'untuk daftar kuliah', NULL, NULL, '2024-07-26', '2024-08-01', 'Acc', 'Muhammad Rafli', NULL),
(55, '3212131307050003', 4, NULL, NULL, NULL, NULL, '2024-08-26', NULL, '2024-07-26', '2024-08-01', 'Acc', 'Muhammad Rafli', NULL),
(56, '3212131307050003', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-26', '2024-08-01', 'Acc', NULL, NULL),
(57, '3212131307050003', 6, NULL, NULL, NULL, NULL, NULL, 'Belum Menikah', '2024-07-26', '2024-08-01', 'Acc', 'SURADI BUDIYANTO', NULL),
(58, '3212131307050005', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-18', '2024-07-31', 'Acc', NULL, NULL),
(59, '21', 1, 'Baber shop', NULL, NULL, NULL, NULL, NULL, '2024-07-27', '2024-07-30', 'Acc', NULL, NULL),
(60, '21', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-27', '2024-07-18', 'Acc', NULL, NULL),
(61, '21', 4, NULL, NULL, NULL, NULL, '2024-08-27', NULL, '2024-07-27', '2024-08-01', 'Acc', 'Muhammad Rafli', NULL),
(62, '3212131307050003', 1, 'gyyy', NULL, NULL, NULL, NULL, NULL, '2024-07-30', NULL, 'Pending', NULL, NULL),
(63, '3212131307050003', 1, 'jokii.anggi', NULL, NULL, NULL, NULL, NULL, '2024-07-30', '2025-08-11', 'Acc', 'Anggi Maulana Hakim', NULL),
(64, '3212131307050003', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31', '2024-08-01', 'Acc', 'Muhammad Rafli', NULL),
(65, '3212131307050003', 1, 'anggii.id.com', NULL, NULL, NULL, NULL, NULL, '2024-08-01', '2024-08-24', 'Acc', 'Muhammad Rafli', NULL),
(66, '3212131307050003', 2, NULL, 'Anggi', 'Anggi Maulana', NULL, NULL, NULL, '2024-08-01', '2024-11-11', 'Acc', 'Anggi Maulana', NULL),
(67, '3212131307050003', 3, NULL, NULL, NULL, 'untuk daftar kuliah', NULL, NULL, '2024-08-01', '2024-08-30', 'Acc', 'Anggi Maulana', NULL),
(68, '3212131307050003', 4, NULL, NULL, NULL, NULL, '2024-09-01', NULL, '2024-08-01', '2024-08-01', 'Acc', 'Muhammad Rafli', NULL),
(69, '3212131307050003', 5, NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-01', '2024-08-07', 'Acc', 'SURADI BUDIYANTO', NULL),
(70, '3212131307050003', 6, NULL, NULL, NULL, NULL, NULL, 'Sudah Menikah', '2024-08-01', '2024-08-09', 'Acc', 'SURADI BUDIYANTO', NULL),
(71, '3212131307050003', 1, 'AM Project', NULL, NULL, NULL, NULL, NULL, '2024-08-01', '2024-11-11', 'Acc', 'SURADI BUDIYANTO', NULL),
(72, '3212131307050003', 1, 'MyStore', NULL, NULL, NULL, NULL, NULL, '2024-08-07', NULL, 'Pending', NULL, NULL);

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
(17, 'Muhammad Malik Hakim Argadiredja ', '3212131307050005', 'Subang', '2005-07-02', 'Laki-Laki', 'Islam', 'Subang Barat', 'Pelajar/Mahasiswa', 'Sarjana', 'Belum Menikah', '$2y$10$jLmvNRcoNaviWM6l9xnL8.GE9RdwZZqfP8PB3ZQ7fPfEj8rWLiPkO'),
(18, 'Rafli', '21', 'Indramayu ', '2024-07-31', 'Laki-Laki', 'Islam', 'Pamayahan', 'Wiraswasta', 'Doktor', 'Belum Menikah', '$2y$10$wH8zFyK9CVbclGKryBLOhOTaB6N.loaqBnIyTtiYtex0f/AVA5otK'),
(19, 'Anggi Maulana', '123', 'Indramayu', '2024-07-28', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', 'PNS', 'Diploma', 'Belum Menikah', '$2y$10$5MAz.aGq7Qpj5kaEvnySFuX6GqOoHEfea31p/FJxvxrKy1eE35S9q'),
(20, 'Anggi Maulana', '111', '111', '2024-07-05', 'Laki-Laki', 'Islam', 'Blok Kuwod, Jatisawit Lor, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273', 'PNS', 'Sarjana', 'Belum Menikah', '$2y$10$WrbAA6eTofn.yeMShaxjfuTV7/AHeZTVcznjowhfJ0dhSYbq2lhRm'),
(21, 'Muhammad Malik Hakim Argadiredja', '1111', '1111', '2024-08-01', 'Laki-Laki', 'Islam', 's nkegk segbkjjsvvsbkbnb sbn skvk vskvgbsknvbke sn ghsl hbgeskg sn gseges hgs;hihgo;sihouvsjbwi bibjsbj', 'Wiraswasta', 'Sarjana', 'Belum Menikah', '$2y$10$u3UOU/IVdEGw4T7O/pZo6.7tGwWFykgE81c26C3qhBRqWttkNB2J2'),
(22, 'Muhammad Malik Hakim Argadiredja ', '12345', 'Indramayu', '1998-08-02', 'Laki-Laki', 'Kristen', 'Blok Kuwod ', 'Pelajar/Mahasiswa', 'SMA/Sederajat', 'Belum Menikah', '$2y$10$FxwF7w9wlGQn7cJCEi/ij.iYblBuGCNbVAHlMspkMtTSRST/13wFu');

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
  MODIFY `id_artikel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kategori_pengajuan`
--
ALTER TABLE `kategori_pengajuan`
  MODIFY `id_kategori_pengajuan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
