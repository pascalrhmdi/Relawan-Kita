-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2021 at 05:52 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteAcara` (IN `id` INT(11))  BEGIN
	START TRANSACTION;
	DELETE FROM relawan_kita.status WHERE id_acara = id;
    DELETE FROM relawan_kita.acara WHERE id_acara = id;
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteOrganisasi` (IN `idPengguna` INT(11))  BEGIN
	START TRANSACTION;
    DELETE FROM status WHERE id_acara IN (SELECT id_acara FROM acara WHERE id_pengguna = idPengguna);
    DELETE FROM acara WHERE id_pengguna = idPengguna;
	DELETE FROM organisasi WHERE id_pengguna = idPengguna;
    DELETE FROM pengguna WHERE id_pengguna = idPengguna;
    COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteRelawan` (IN `idPengguna` INT(11))  NO SQL
BEGIN
	START TRANSACTION;
    DELETE FROM status WHERE id_pengguna = idPengguna;
	DELETE FROM relawan WHERE id_pengguna = idPengguna;
    DELETE FROM pengguna WHERE id_pengguna = idPengguna;
    COMMIT;
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
-- Table structure for table `acara`
--

CREATE TABLE `acara` (
  `id_acara` int(11) NOT NULL,
  `judul_acara` varchar(50) NOT NULL,
  `deskripsi_acara` text NOT NULL,
  `jumlah_kebutuhan` tinyint(5) UNSIGNED NOT NULL,
  `tanggal_batas_registrasi` date NOT NULL,
  `tanggal_acara` date NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `id_jenis_acara` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acara`
--


INSERT INTO `acara` (`id_acara`, `judul_acara`, `deskripsi_acara`, `jumlah_kebutuhan`, `tanggal_batas_registrasi`, `tanggal_acara`, `lokasi`, `cover`, `id_jenis_acara`, `id_pengguna`) VALUES
(1, 'Pilah sampahmu bersama Zero Hero', 'Nama Pekerjaan : Zero Hero\r\nRelawan Dibutuhkan : 100 orang\r\nTotal Jam Kerja : 2 jam\r\nTugas Relawan :\r\nMemfasilitasi masyarakat untuk memberikan informasi mengenai pemilahan sampah yang benar dan bank sampah terdekat diregionalnya.\r\n\r\nSarana yang digunakan : media sosial dan whatsap\r\nKriteria Relawan : \r\n- berjiwa muda\r\n- aktif\r\n- punya jiwa sosial dan kepedulian terhadap lingkungan hidup\r\n- bersedia untuk menjadi inisiator didaerahnya \r\nPerlengkapan Relawan : \r\n- handphone\r\n- media sosial aktif\r\n- whatsapp\r\n\r\nInformasi Tambahan :\r\nhanya sebagai fasilitator terkait pemberian informasi kepada masyarakat tentang bank sampah terdekat dan proses pemilahan sampah yang benar dengan memaksimalkan media sosial.', 100, '2021-07-15', '2021-07-18', 'Regional Masing - Masing', '60d069ee02f17.jpg', 25, 2),
(2, 'Renovasi Fasilitas Masjid Pedalaman', 'Assesment Masjid Pedalaman\r\nRelawan Dibutuhkan : 8 orang\r\nTotal Jam Kerja : 100 jam\r\nTugas Relawan :\r\n- Menemukan masjid-masjid di pedalaman yang layak dibantu untuk renovasi atau perbaikan fasilitas penunjang\r\n- Mengumpulkan dokumentasi\r\n- membuat profil wilayah lokasi\r\nKriteria Relawan :\r\n- Berada di provinsi wilayah yang diusulkan\r\n- bersedia mendampingi project hingga selesai\r\n- tidak terikat dengan lembaga lain\r\nPerlengkapan Relawan :\r\n- Hp android\r\n- Sepeda motor\r\nDomisili : Riau', 8, '2021-06-26', '2021-06-29', 'Pedalaman Riau', '60d06822174fc.jpg', 13, 3),
(3, 'Katalisator Muda Indonesia Team 2021-2022', 'Nama Pekerjaan : Katalisator Muda Indonesia Team 2021 - 2022\r\nRelawan Dibutuhkan : 14 orang\r\nTotal Jam Kerja : 114 jam\r\nTugas Relawan: \r\nMengurus organisasi Katalisatro Muda Indonoesia dalam menjalankan visi misinya selama periode 2021 - 2022\r\nKriteria Relawan :\r\n1. Berusia 17 - 25 tahun\r\n2. Berdomisili di area Jabodetabek\r\n3. Aktif Responsif, dan flexilitas terhadap waktu\r\n4. Mengikuti proses pendaftaran\r\n5. Mengikuti dan lulus \"Trainee Program\" selama 2 minggu di KaMu Indonesia.\r\n6. Berkomitmen aktif selama 1 tahun setelah dinyatakan lulus.\r\nPerlengkapan Relawan : \r\n- Laptop dan kuota\r\nDomisili : DKI Jakarta\r\n\r\nInformasi Tambahan :\r\nKalian juga bisa mengisi formulir pendaftaran di Bit.ly/KaMuOprec2021', 14, '2021-06-23', '2021-07-25', 'Aktivitas Virtual', '60d0679913cd3.png', 16, 4),
(4, 'SUMBER DAYA ALAM LAUT KITA', 'Nama Pekerjaan : AKTIVIS LINGKUNGAN LAUT\r\nRelawan Dibutuhkan : 2000 orang\r\nTotal Jam Kerja : 8 jam\r\nTugas Relawan :\r\nMENJAGA, MEMBERSIHKAN, MELESTARIKAN SUMBER DAYA ALAM (SDA) LAUT, DAN DOKUMENTASI KEGIATAN\r\nKriteria Relawan :\r\n1. LAKI-LAKI/PEREMPUAN\r\n2. USIA 5 TAHUN KEATAS\r\n3. BERBADAN SEHAT DAN BUGAR\r\nPerlengkapan Relawan :\r\nSAPU, TEMPAT SAMPAH, DLL\r\nInformasi Tambahan :\r\nMASING-MASING RELAWAN MENDOKUMENTASIKAN KEGIATAN DI LINGKUNGAN LAUT', 255, '2021-07-25', '2021-08-08', 'Aktivitas Virtual', '60d0691a25e36.jpg', 25, 5),
(5, 'Menjadi Tutor Inspirasi Anak Indonesia', 'Inspiration Factory Foundation lagi cari orang yang tertarik menginspirasi anak-anak sambil dapat teman baru nih, kamu kah orangnya? Di kegiatan ini teman-teman bisa menginspirasi anak-anak secara online dan bisa kenalan sama volunteers dari berbagai kota di Indonesia.. seru kan? Kapan lagi bisa dapat banyak teman baru dan menginspirasi saat di rumah aja.\r\n \r\nKalau kamu: \r\n- Minimal 18 tahun\r\n- Suka dengan anak-anak\r\n- Mau ubah weekend-nya lebih berfaedah \r\n \r\nYuk teman-teman buruan daftar kegiatan ini. Karena di tanggal 29 Mei 2021 akan ada InspiraLearn Training yang menarik untuk teman-teman ikuti sebelum ikut menginspirasi anak-anak 😁\r\n \r\nLesgooow!~\r\n \r\nFor more information:\r\nIG: @inspirationfactoryfoundation\r\nWA: 081317661488 (chat only)', 100, '2021-06-18', '2021-07-20', 'Kegiatan via Zoom', '60d066146fcd4.png', 2, 6),
(6, 'Ekspedisi Bakti Milenial - Lombok', 'Halo Sobat Milenial,\r\nKalian mau ikutan pengabdian masyarakat sekaligus jalan-jalan ke Gili Asahan, Lombok?\r\nIya Lombok, surga wisata laut di Nusa Tenggara Barat dengan kekayaan dan keindahan biota laut yang sangat luar biasa.\r\n\r\nBakti Milenial merupakan sebuah program yang dirancang untuk mengajak kaum muda untuk berbagi pengalaman, mengembangkan inovasi dan gagasan ide guna memberikan solusi yang berkelanjutan. Melalui kegiatan pengabdian lintas disiplin ilmu yang terbuka untuk masyarakat umum. \r\n\r\nBentuk kegiatan :\r\n🔰 Local Potential Development\r\n🔰 Environment Optimization\r\n🔰 Milenial Mengajar\r\n🔰 Health and Nutrition Care\r\n🔰 Explore trip gratis di Lombok, Nusa Tenggara Barat\r\n\r\nLokasi kegiatan :  Gili Asahan, Lombok Barat, NTB (13 - 23 Agustus 2021)\r\n\r\n\r\nFASILITAS RELAWAN TERPILIH\r\nRelawan terbaik mendapatkan fasilitas berikut yang dibiayai oleh Panitia (Fully Funded)\r\n✅Transportasi PP dari Kota asal ke meeting point\r\n✅Transportasi PP dari meeting point (Surabaya) – Lombok\r\n✅Transportasi lokal \r\n✅Program Pemberdayaan Masyarakat Lintas Bidang di Lombok\r\n✅Konsumsi selama pengabdian\r\n✅Tempat tinggal selama pengabdian\r\n✅Wisata sekitar Gili Asahan, Desa Sade, Pantai Kuta Mandalika (rekreasi, snorkeling, dll)\r\n✅Sarana prasarana program\r\n✅Sertifikat\r\n✅Kaos & Atribut Kegiatan\r\n✅Pendampingan pembuatan program\r\n✅Perizinan ke instansi\r\n\r\n\r\nInilah saatnya, untuk menempa integritas diri melalui pengabdian di tapal batas Negeri.\r\nMari kawan, kita beraksi !! Secuil kontribusi dari kita adalah bekal awal untuk membangun dan menata kembali negeri ini. Karena masa depan Indonesia ada di tangan aku, kamu, dan kita semua.\r\nTanpamu, semua akan biasa-biasa saja.\r\n\r\n\r\n📝Info Pendaftaran :\r\nhttp://bit.ly/daftarbaktimilenial2\r\n📝Buku Panduan dan Berkas :\r\nhttp://bit.ly/berkasbaktimilenial2\r\n\r\n📞 For more information please contact us :\r\nImelda : +6281572970680', 40, '2021-06-15', '2021-07-30', 'Desa Gili Asahan Kabupaten Lombok Barat, Nusa Teng', '60d066c3804ab.jpg', 19, 7),
(8, 'Relawan Medis - Perawat (Profesi Ners)', 'Nama Pekerjaan : Relawan Medis - Perawat (Profesi Ners)\r\nRelawan Dibutuhkan : 21 orang\r\nTotal Jam Kerja : 8 jam\r\nTugas Relawan :\r\nMelakukan penanganan COVID-19 di berbagai fasilitas isolasi COVID-19, laboratorium kesehatan maupun rumah sakit.\r\nKriteria Relawan :\r\n1. Relawan berasal dari lulusan S1 Keperawatan Profesi Ners\r\n2. Memiliki KTP\r\n3. Memiliki ijazah\r\n4. Memiliki STR aktif/ sertifikat uji kompetensi/bukti pengumuman lulus uji kompetensi\r\n5. Memiliki BPJS Kesehatan aktif/bukti proses pengurusan BPJS Kesehatan\r\n6. Relawan berusia kurang dari  35 tahun\r\n7. Relawan dalam keadaan sehat (tidak ada riwayat penyakit pernapasan dan penyakit kronis lainnya) yang dibuktikan dengan surat keterangan sehat\r\n8. Tidak sedang hamil dan bersedia tidak hamil selama menjadi relawan\r\n9. Relawan sadar akan resiko yang mungkin dihadapi dibuktikan dengan surat sadar akan resiko\r\n10.Relawan mendapatkan izin dari orang tua atau suami/istri apabila sudah menikah dibuktikan dengan surat izin dari  orang tua/pasangan yang bersangkutan\r\n11.Tidak sedang terikat kontrak kerja pada instansi lain dan tidak sedang menjalani pendidikan formal\r\nPerlengkapan Relawan :\r\n- Handphone dengan koneksi internet.\r\nDomisili : Jawa Barat\r\n\r\nInformasi Tambahan :\r\nLokasi penempatan relawan: \r\n1. Rumah Sakit Hasan Sadikin Bandung (Kota Bandung)\r\n2. RSUD Cililin (Kab. Bandung Barat)\r\n3. RSUD Cikalong Wetan (Kab. Bandung Barat)\r\n4. RSUD Lembang (Kab. Bandung Barat)\r\n5. RSUD Soreang (Kab. Bandung)\r\n\r\n*Relawan diutamakan yang berdomisili di wilayah sekitar penempatan', 21, '2021-07-10', '2021-07-15', 'Jl. Pasteur No.38, Pasteur, Kec. Sukajadi Kota Ban', '60d06561500b3.png', 14, 8),
(9, 'Relawan Lapangan Papua', 'Nama Pekerjaan : Relawan Lapangan\r\nRelawan Dibutuhkan : 5 orang\r\nTotal Jam Kerja: 2 jam\r\nTugas Relawan :\r\nRelawan bertugas mencari permasalahan yang ada di lingkungan sekitarnya (kesehatan, lingkungan, pendidikan, dan lain sebagainya), mengumpulkan data serta mendokumentasikan, lalu mendampingi proses kegiatan dari awal hingga akhir. \r\nKriteria Relawan :\r\n- Sedang tinggal atau berada di Provinsi Papua atau Papua Barat\r\n- Memiliki jiwa sosial yang tinggi\r\n- Aktif serta punya kendaraan pribadi\r\n- Bisa fotografi lebih diutamakan (opsional)\r\n- Berkomitmen menjadi relawan lapangan Sahabat Pedalaman\r\nPerlengkapan Relawan :\r\n- Kamera/HP\r\n- Alat tulis\r\n- Kendaraan pribadi\r\nDomisili : Papua', 5, '2021-06-03', '2021-07-10', 'Provinsi Papua Barat atau Provinsi Papua', '60d061ebdcdf5.jpg', 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_acara`
--

CREATE TABLE `jenis_acara` (
  `id_jenis_acara` int(11) NOT NULL,
  `nama_jenis_acara` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_acara`
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
(22, 'Kesehatan'),
(25, 'Lingkungan');


-- --------------------------------------------------------

--
-- Table structure for table `organisasi`
--

CREATE TABLE `organisasi` (
  `id_pengguna` int(11) NOT NULL,
  `deskripsi_organisasi` text DEFAULT NULL,
  `tahun_berdiri` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organisasi`
--


INSERT INTO `organisasi` (`id_pengguna`, `deskripsi_organisasi`, `tahun_berdiri`) VALUES
(2, 'Sahabat Pedalaman adalah lembaga filantropi yang berfokus membantu masyarakat di daerah pedalaman dan juga 3T (Tertinggal, Terdepan, dan Terluar) di Indonesia.  Adapun bidang yang menjadi fokusk mai adalah bidang lingkungan, pendidikan, kesehatan, dan pemberdayaan masyarakat di daerah pelosok.\r\n\r\nLokasi : Marombok RT 05/RW 03 Golo Bilas, Kecamatan Komodo, Kabupaten Manggarai Barat, Nusa Tenggara Timur\r\nTelepon : 08112020222\r\nWebsite : http://www.sahabatpedalaman.org', 2018),
(3, 'Pusat Koordinasi dan Informasi COVID-19 Jawa Barat (Pikobar) merupakan sebuah sistem yang dibentuk Pemerintah Daerah Provinsi Jawa Barat (Pemdaprov Jabar) untuk menyajikan informasi, data, dan visualisasi tentang penyebaran, pencegahan, dan penanggulangan COVID-19 di Jawa Barat. Informasi yang ditampilkan melalui situs web dan aplikasi mobile Pikobar tersebut meliputi perkembangan jumlah kasus, peta sebaran kasus dan lokasi fasilitas kesehatan, daftar pusat panggilan se-Jawa Barat, dan grafik data kasus COVID-19. \r\n\r\nPikobar diresmikan oleh Gubernur Jawa Barat Ridwan Kamil pada tanggal 4 Maret 2020 di Jabar Command Center, menyusul penetapan status Siaga-1 COVID-19 di wilayah Jawa Barat.', 2019),
(4, 'The Inspiration Factory Foundation is established by two creatives Georges Hilaul and Jenny Tjoa who started off as acts of compassion to make a change, but have grown professionally while keeping its soul alive. Our vision is to inspire a generation of underprivileged children to fulfill their dreams and influence the world with this legacy. In doing this, we hope to inspire any other beings out there who are connected with us.', 2014),
(5, 'Indonesia Millennial Connect merupakan organisasi nirlaba pengembangan diri bagi pemuda pemudi di seluruh Indonesia, berkolaborasi dengan komunitas dan organisasi lain yang berfokus kepada tiga bidang yaitu pendidikan, sosial, dan ekonomi.', 2020),
(6, 'Perspektif di mana setiap konflik dapat diselesaikan dengan kekerasan adalah sebuah dilema yang terus di doktrinisasi dan diimplementasikan dengan para pemuda dalam kehidupan sehari-hari mereka. Pada tahun 2019, terdapat 431.471 kasus kekerasan yang melibatkan pemuda sebagai korban dan pelaku, kasus-kasus tersebut sebagian besar terdiri dari intimidasi, kekerasan rumah tangga, kekerasan seksual, perkelahian siswa, bahkan kekerasan ekstremisme.   Katalisator Muda (KaMu) Indonesia adalah organisasi pemuda yang membantu mewujudkan lingkungan di mana setiap pemuda bisa bebas dari segala bentuk kekerasan dan dapat menyelesaikan konflik tanpa kekerasan. Dalam melakukan hal itu, KaMu berupaya mengubah perspektif bahwa kekerasan bukanlah jawaban dan mempersiapkan pemuda untuk menjadi katalis perdamaian di masyarakat meraka masing-masing melalui forum (Forum X), kampanye media (Media Y), dan pembangunan kapasitas (Hero Z).', 2018),
(7, 'Relawan pendamping program-program peningkatan kualitas SDM Masyarakat Desa. Mencari sebanyak-banyaknya relawan untuk dapat berkontribusi di sebanyak-banyaknya desa se-Indonesia', 2020),
(8, 'Ikatan Pelaut Maluku Tenggara dan Kota Tual (IPMTKT), didirikan di Tual Maluku Tenggara, pada tanggal 3 April 2017, dengan berlandaskan nilai-nilai Pancasila dan UUD 1945 serta semangat Sumpah Pemuda. Pendiri ABDUL QADIR WEAR mengharapkan Putra/I Bangsa dapat menjadikan laut sebagai sumber kehidupan, dan turut serta menjadikan Indonesia sebagai \"Poros Maritim Dunia\"', 2017),
(9, 'sebuah pacemaker untuk menggerakan banyak nyawa agar lebih mencintai lingkungan hidup. Kami fokus pada 3 divisi: 1. Memberikan edukasi tentang environmental issues 2. Memberikan edukasi tentang dampak kerusakan lingkungan terhadap medis 3. Memberikan edukasi tentang eco friendly lifestyle', 2021);


-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(15) DEFAULT NULL,
  `role` enum('volunteer','admin','organisasi') NOT NULL DEFAULT 'volunteer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `email`, `password`, `nama`, `alamat`, `nomor_telepon`, `role`) VALUES
(1, 'admin@admin.com', '29e78cb815d3d3534b8ad5382bf2c5db', 'Admin',null,null, 'admin'),
(2, 'sahabatpedalaman@gmail.com', 'edce01270d559346efb037919ee6fd04', 'Sahabat Pedalaman',null,null, 'organisasi'),
(3, 'pikobar@gmail.com', '1f53784e09e6594e576d0f35a5b97377', 'Pikobar', null,null, 'organisasi'),
(4, 'inspirationfactoryfoundation@gmail.com', '87ad24ee0cfc2ce6be99855c39826a4b', 'Inspiration Factory Foundation', null,null, 'organisasi'),
(5, 'oimc@gmail.com', 'c31cefc4eb7ab842438d5e3f77ba4051', 'Organisasi Indonesia Millennial Connect', null,null, 'organisasi'),
(6, 'katalisatormudaindonesia@gmail.com', '7f206e777a12ee5150be7f33441d3890', 'Katalisator Muda Indonesia', null,null, 'organisasi'),
(7, 'relawankebaikandesa@gmail.com', '4e442c45ef7b6a49a5e98668757d4443', 'Relawan Kebaikan Desa', null,null, 'organisasi'),
(8, 'ipmtkt@gmail.com', '2c184781ba9fe71ee5bc6901c07f8f4f', 'IKATAN PELAUT MALUKU TENGGARA DAN KOTA TUAL (IPMTK)', null,null, 'organisasi'),
(9, 'menolakpoenah@gmail.com', 'b4b20e005fee08f9320609b45c692b2f', 'Menolak Poenah', null,null, 'organisasi');

-- --------------------------------------------------------

--
-- Table structure for table `relawan`
--

CREATE TABLE `relawan` (
  `id_pengguna` int(11) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_pengguna` int(11) NOT NULL,
  `id_acara` int(11) NOT NULL,
  `status` enum('menunggu','lolos','gagal') NOT NULL DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acara`
--
ALTER TABLE `acara`
  ADD PRIMARY KEY (`id_acara`),
  ADD KEY `fk_id_jenis_acara` (`id_jenis_acara`),
  ADD KEY `fk_id_pengguna_acara` (`id_pengguna`);

--
-- Indexes for table `jenis_acara`
--
ALTER TABLE `jenis_acara`
  ADD PRIMARY KEY (`id_jenis_acara`);

--
-- Indexes for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD KEY `fk_id_pengguna_organisasi` (`id_pengguna`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `relawan`
--
ALTER TABLE `relawan`
  ADD KEY `fk_id_pengguna_relawan` (`id_pengguna`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_pengguna`,`id_acara`),
  ADD KEY `fk_id_acara` (`id_acara`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acara`
--
ALTER TABLE `acara`
  MODIFY `id_acara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jenis_acara`
--
ALTER TABLE `jenis_acara`
  MODIFY `id_jenis_acara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `acara`
--
ALTER TABLE `acara`
  ADD CONSTRAINT `fk_id_jenis_acara` FOREIGN KEY (`id_jenis_acara`) REFERENCES `jenis_acara` (`id_jenis_acara`),
  ADD CONSTRAINT `fk_id_pengguna_acara` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD CONSTRAINT `fk_id_pengguna_organisasi` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `relawan`
--
ALTER TABLE `relawan`
  ADD CONSTRAINT `fk_id_pengguna_relawan` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_id_acara` FOREIGN KEY (`id_acara`) REFERENCES `acara` (`id_acara`),
  ADD CONSTRAINT `fk_id_pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
