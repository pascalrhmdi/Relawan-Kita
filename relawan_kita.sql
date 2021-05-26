-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2021 pada 09.12
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `relawan_kita`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAcara` (IN `id` INT(11))  BEGIN
	START TRANSACTION;
	DELETE FROM relawan_kita.status WHERE id_acara = id;
    DELETE FROM relawan_kita.acara WHERE id_acara = id;
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteOrganisasi` (IN `idOrganisasi` INT(11), IN `idAcara` INT(11))  BEGIN
	START TRANSACTION;
    DELETE FROM status WHERE id_acara = idOrganisasi;
    DELETE FROM acara WHERE id_organisasi = idAcara;
	DELETE FROM organisasi WHERE id_organisasi = idAcara;
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllOrganisasi` ()  BEGIN
	SELECT * FROM organisasi;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getJenisAcara` (IN `awalData` INT(11), IN `menampilkanDataPerHalaman` INT(11))  BEGIN
	SELECT *
    FROM jenis_acara
    LIMIT awalData, menampilkanDataPerHalaman;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getOrganisasi` (IN `namaOrganisasi` VARCHAR(255))  BEGIN
	SELECT *
    FROM organisasi
    WHERE nama_organisasi LIKE CONCAT('%',namaOrganisasi,'%');
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `acara`
--

CREATE TABLE `acara` (
  `id_acara` int(11) NOT NULL,
  `judul_acara` varchar(50) NOT NULL,
  `deskripsi_acara` text NOT NULL,
  `jumlah_kebutuhan` tinyint(3) UNSIGNED NOT NULL,
  `tanggal_batas_registrasi` date NOT NULL,
  `tanggal_acara` date NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `id_jenis_acara` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL
) ;

--
-- Dumping data untuk tabel `acara`
--

INSERT INTO `acara` (`id_acara`, `judul_acara`, `deskripsi_acara`, `jumlah_kebutuhan`, `tanggal_batas_registrasi`, `tanggal_acara`, `lokasi`, `id_jenis_acara`, `id_organisasi`) VALUES
(13, 'Ngabdi di kampung rambutan', 'Mengabdi Di Kampung Rambutan Bersama Kami dari indonesia untuk indonesia.\r\nDibutuhkan \r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 30, '2000-12-12', '1222-12-12', 'Indramayu', 1, 2),
(14, 'Open Recruitment OGT Staff', 'Kami Membuka Open Recruitmen untuk berkontribusi dalam ikatan keluarga Kami dari indonesia untuk indonesia.\r\nDibutuhkan \r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 31, '2000-12-12', '1212-12-12', 'Indramayu', 16, 3),
(15, 'Proklamator Indonesia', 'Indonesia Merindukan sosok proklamator negeri. Kami disini akan mengadakan event agar masyarakat indonesia dapat menjadi pemimpin yang baik.\r\nDibutuhkan \r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 100, '1999-12-12', '1261-12-12', 'Cirebon', 14, 1),
(16, 'Open Recruitment OGT Staff', 'Indonesia Merindukan sosok proklamator negeri. Kami disini akan mengadakan event agar masyarakat indonesia dapat menjadi pemimpin yang baik.\r\nDibutuhkan \r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 31, '2010-12-12', '1242-12-12', 'Indramayu', 15, 3),
(17, 'Proklamator Malaysia Merdeka', 'Malaysia Merindukan sosok proklamator negeri. Kami disini akan mengadakan event agar masyarakat indonesia dapat menjadi pemimpin yang baik.\r\nDibutuhkan \r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 99, '1959-12-12', '1291-12-12', 'Cirebon', 17, 2),
(18, 'Open Bakat Anak Muda', 'Indonesia Mencari Bakat!!! \r\nDicari anak muda yang memiliki bakat setinggi langit dan keinginan tinggi untuk menjadi sosok idola.\r\nDibutuhkan \r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 51, '2010-12-12', '1242-12-12', 'Indramayu', 16, 3),
(19, 'Proklamator Thailand Merdeka', 'Thailand Darurat Keadilan!!!\r\nJadikan Thailand Merdeka, Merdeka atau banci!\r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 99, '1959-12-12', '1291-12-12', 'Cirebon', 16, 2),
(23, 'Bangun Desa Purworejo', 'Calling For Indonesian volunteer!!!\r\nJadikan Thailand Merdeka, Merdeka atau banci!\r\n2 Orang untuk menjadi bendahara,\r\n2 Orang untuk menjadi Sekretaris,\r\n4 Orang untuk menjadi Staff Acara\r\n10 Orang untuk menjadi Staff PDD.\r\nKonfirmasi Ke nomor 08986866877', 77, '2021-05-25', '2021-05-31', 'Purworejo', 16, 1),
(29, 'ISMKI Mengabdi Kepada Negeri', 'Mahasiswa Dokter Seluruh Indonesia Mengabdi Kepada Negeri dengan memberikan jasa gratis mereka kepada orang orang yang kurang mampu', 10, '2021-05-28', '2021-05-18', 'Indonesia', 22, 5),
(30, 'Pertamina Mengajar', 'Program Tahunan Pertamina Indonesia yang tahun ini diselenggarakan di Indramayu, Jawa Barat.\r\nDibutuhkan 10 Relawan Berpendidikan minimal D3 dengan mata pelajaran:\r\n2 Bahasa Inggris\r\n3 Bahasa Jepang\r\n1 Bahasa Indonesia\r\n2 Matematika\r\n2 Prakarya', 10, '2021-05-30', '2021-05-31', 'Indramayu', 2, 1),
(31, 'Ulang Tahun PT Paragon ke 16', 'Dibutuhkan Relawan', 50, '2021-05-30', '2021-05-31', 'Purbalingga', 16, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_acara`
--

CREATE TABLE `jenis_acara` (
  `id_jenis_acara` int(11) NOT NULL,
  `nama_jenis_acara` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_acara`
--

INSERT INTO `jenis_acara` (`id_jenis_acara`, `nama_jenis_acara`) VALUES
(1, 'Pengabdian Masyarakat'),
(2, 'Pendidikan'),
(3, 'Kesetaraan Gender'),
(4, 'Sains dan Teknologi'),
(12, 'Yatim Piatu'),
(13, 'Kegiatan Amal'),
(14, 'Kesehatan'),
(15, 'Olahraga'),
(16, 'Kepemimpinan dan Organisasi'),
(17, 'Hak Asasi Manusia'),
(18, 'Penanggulangan Bencana'),
(19, 'Pengembangan Masyarakat'),
(20, 'Pertanian'),
(21, 'Seni dan Budaya'),
(22, 'Kesehatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `organisasi`
--

CREATE TABLE `organisasi` (
  `id_organisasi` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` enum('organisasi') NOT NULL,
  `nama` varchar(50) NOT NULL,
  `deskripsi_organisasi` text DEFAULT NULL,
  `tahun_berdiri` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `organisasi`
--

INSERT INTO `organisasi` (`id_organisasi`, `email`, `password`, `role`, `nama`, `deskripsi_organisasi`, `tahun_berdiri`) VALUES
(1, 'pertamina@org.com', '93c5743c7af9b7072d604c70a941e028', 'organisasi', 'PT. Pertamina', 'Pertamina Persero Indramayu', 2009),
(2, 'paragon@org.com', '2137104e0cfc04e15c57faf3353b4549', 'organisasi', 'PT PARAGON Technology and Innovation', 'PT Paragon Technology and Innovation adalah perusahaan yang bergerak di bidang kosmetik manufaktur dan telah mendapat sertifikat GMP (Good Manufacturing Practice) dengan kapasitas produksi yang besar dan formulasi yang unggul.', 1999),
(3, 'sasi@org.com', '06415e5ff71e4aeff27f27103da5ff30', 'organisasi', 'SMAN 1 Sindang', 'Sekolah Bertaraf Internasional dari Indramayu Jawa Barat', 2012),
(5, 'ISMKI@org.com', '7d148309d6f8a1ac6058a993ea818fe9', 'organisasi', 'Ikatan Senat Mahasiswa Kedokteran Indonesia', 'ISMI adalah Ikatan Senat Mahasiswa Kedokteran Indonesia yakni perkumpulan mahasiswa kedokteran di indonesia.', 2021);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `role` enum('volunteer','admin') NOT NULL DEFAULT 'volunteer',
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `email`, `password`, `nama`, `role`, `jenis_kelamin`, `alamat`, `nomor_telepon`, `tanggal_lahir`) VALUES
(33, 'admin@admin.com', '29e78cb815d3d3534b8ad5382bf2c5db', 'Admin', 'admin', NULL, NULL, NULL, NULL),
(34, 'asdasd@asdasd.com', '54cc0e9a517ef5e47ca182ec83567483', 'Muhammad Pascal Rahmadi', 'volunteer', 'Perempuan', 'Griya Asri 1 Jalan Akasia Blok A2 No.16 RT 21 RW 09', '08986866875', '2001-05-16'),
(36, 'Pascalrahmadi@gmail.com', '06891d10f1f590c7436783c3770bb43a', 'Pascal Rahmadi', 'volunteer', 'Perempuan', NULL, NULL, '2000-12-12'),
(38, 'pascalpascal@gmail.com', '29e2498ddd7c21c4258382c99d8c8862', 'duarmekdi', 'volunteer', 'Laki-laki', 'pascalpascal', '123123123', '2021-05-06'),
(39, 'muhammad.rahmadi@mhs.unsoed.ac.id', 'c79c60f8d8611edcfb6560e990a98af8', 'Muhammad Pascal Rahmadi', 'volunteer', 'Laki-laki', 'Griya Asri 1 Jalan Akasia Blok A2 No.16 RT 21 RW 09', '+6289868686875', '1222-12-12'),
(41, 'cal@cal.com', '654345b85bb6e4f369ad901c13108c2d', 'Pascal Rahmadi', 'volunteer', 'Laki-laki', 'Griya Asri 1 Jalan Akasia Blok A2 No.16 RT 21 RW 09', '08986866875', '2001-12-31'),
(42, 'akuganteng@gmail.com', 'd040e4cd8f20a2141a796ba5b8455ad7', 'Aku Ganteng Banget gaes', 'volunteer', 'Laki-laki', 'Griya Asri 1 Jalan Akasia Blok A2 No.16 RT 21 RW 09', '08986866875', '2001-12-02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id_pengguna` int(11) NOT NULL,
  `id_acara` int(11) NOT NULL,
  `status` enum('menunggu','lolos','gagal') NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id_pengguna`, `id_acara`, `status`) VALUES
(36, 29, 'gagal'),
(38, 29, 'menunggu'),
(38, 31, 'gagal'),
(39, 13, 'menunggu'),
(41, 13, 'menunggu'),
(41, 14, 'menunggu'),
(41, 15, 'menunggu'),
(41, 23, 'menunggu');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`id_acara`),
  ADD KEY `fk_id_organisasi` (`id_organisasi`),
  ADD KEY `fk_id_jenis_acara` (`id_jenis_acara`);

--
-- Indeks untuk tabel `jenis_acara`
--
ALTER TABLE `jenis_acara`
  ADD PRIMARY KEY (`id_jenis_acara`);

--
-- Indeks untuk tabel `organisasi`
--
ALTER TABLE `organisasi`
  ADD PRIMARY KEY (`id_organisasi`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_pengguna`,`id_acara`),
  ADD KEY `fk_id_acara` (`id_acara`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `acara`
--
ALTER TABLE `acara`
  MODIFY `id_acara` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_acara`
--
ALTER TABLE `jenis_acara`
  MODIFY `id_jenis_acara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id_organisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `acara`
--
ALTER TABLE `acara`
  ADD CONSTRAINT `fk_id_jenis_acara` FOREIGN KEY (`id_jenis_acara`) REFERENCES `jenis_acara` (`id_jenis_acara`),
  ADD CONSTRAINT `fk_id_organisasi` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id_organisasi`),
  ADD CONSTRAINT `fk_jenis_acara` FOREIGN KEY (`id_jenis_acara`) REFERENCES `jenis_acara` (`id_jenis_acara`);

--
-- Ketidakleluasaan untuk tabel `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_id_acara` FOREIGN KEY (`id_acara`) REFERENCES `acara` (`id_acara`),
  ADD CONSTRAINT `fk_id_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
