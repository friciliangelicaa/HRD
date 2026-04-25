-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 08:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lat_hrd`
--

-- --------------------------------------------------------

--
-- Table structure for table `cuti`
--

CREATE TABLE `cuti` (
  `id_cuti` varchar(11) NOT NULL,
  `idpeg` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `daritgl` date NOT NULL,
  `sampaitgl` date NOT NULL,
  `lamacuti` int(11) DEFAULT NULL,
  `alasan` varchar(1300) DEFAULT NULL,
  `ditetapkan` varchar(50) NOT NULL,
  `pembuat_surat` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuti`
--

INSERT INTO `cuti` (`id_cuti`, `idpeg`, `tanggal`, `daritgl`, `sampaitgl`, `lamacuti`, `alasan`, `ditetapkan`, `pembuat_surat`, `created_at`) VALUES
('C202410001', 'P202409002', '2024-10-01', '2024-10-02', '2024-10-08', 7, 'Liburan Keluarga', 'Jakarta', 'HRD', '2024-10-10 13:33:31');

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `iddep` varchar(4) NOT NULL,
  `departemen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`iddep`, `departemen`) VALUES
('D001', 'Company Administrative Function'),
('D002', 'Administrasi'),
('D003', 'Human Resource'),
('D004', 'Finance & Accounting'),
('D005', 'Marketing'),
('D006', 'Sales'),
('D007', 'Research & Development'),
('D008', 'IT'),
('D009', 'Customer Service'),
('D011', 'Production'),
('D012', 'Design');

-- --------------------------------------------------------

--
-- Table structure for table `departemen_jabatan`
--

CREATE TABLE `departemen_jabatan` (
  `iddep` varchar(4) NOT NULL,
  `idjab` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departemen_jabatan`
--

INSERT INTO `departemen_jabatan` (`iddep`, `idjab`) VALUES
('D001', 'J001'),
('D002', 'J002'),
('D002', 'J003'),
('D002', 'J004'),
('D002', 'J005'),
('D002', 'J006'),
('D003', 'J007'),
('D003', 'J008'),
('D003', 'J009'),
('D003', 'J010'),
('D004', 'J011'),
('D004', 'J012'),
('D004', 'J013'),
('D004', 'J014'),
('D005', 'J015'),
('D005', 'J016'),
('D005', 'J017'),
('D005', 'J018'),
('D005', 'J019'),
('D005', 'J020'),
('D005', 'J021'),
('D005', 'J022'),
('D005', 'J023'),
('D006', 'J024'),
('D006', 'J025'),
('D006', 'J026'),
('D006', 'J027'),
('D007', 'J028'),
('D007', 'J029'),
('D007', 'J030'),
('D008', 'J031'),
('D008', 'J032'),
('D008', 'J033'),
('D008', 'J034'),
('D008', 'J035'),
('D008', 'J036'),
('D008', 'J051'),
('D009', 'J037'),
('D009', 'J038'),
('D011', 'J040'),
('D011', 'J041'),
('D011', 'J042'),
('D011', 'J043'),
('D011', 'J044'),
('D012', 'J045'),
('D012', 'J046'),
('D012', 'J047'),
('D012', 'J048'),
('D012', 'J049'),
('D012', 'J050'),
('D012', 'J052');

-- --------------------------------------------------------

--
-- Table structure for table `izin`
--

CREATE TABLE `izin` (
  `id_izin` varchar(11) NOT NULL,
  `idpeg` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `alasan` varchar(1300) DEFAULT NULL,
  `ditetapkan` varchar(50) NOT NULL,
  `pembuat_surat` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `izin`
--

INSERT INTO `izin` (`id_izin`, `idpeg`, `tanggal`, `jam`, `alasan`, `ditetapkan`, `pembuat_surat`, `created_at`) VALUES
('I202410001', 'P202409002', '2024-10-10', '10:05:00', 'Ke Apotek ambil obat', 'Jakarta', 'HRD', '2024-10-10 15:08:55');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `idjab` varchar(4) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `iddep` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`idjab`, `jabatan`, `iddep`) VALUES
('J001', 'CEO', NULL),
('J002', 'Asisten Kantor', NULL),
('J003', 'Administrator Kantor', NULL),
('J004', 'Asisten Eksekutif', NULL),
('J005', 'Asisten Eksekutif Senior', NULL),
('J006', 'Resepsionis', NULL),
('J007', 'HR Manager', NULL),
('J008', 'HR Specialist', NULL),
('J009', 'HR Training and Development', NULL),
('J010', 'HRD Recruiter', NULL),
('J011', 'Kepala Keuangan', NULL),
('J012', 'Manajer Keuangan', NULL),
('J013', 'Senior Staf Keuangan', NULL),
('J014', 'Junior Staf Keuangan', NULL),
('J015', 'Manager', NULL),
('J016', 'Brand Management', NULL),
('J017', 'CRM Specialist', NULL),
('J018', 'SEO Specialist', NULL),
('J019', 'SEM Strategist ', NULL),
('J020', 'Digital Marketing', NULL),
('J021', 'Public Relation', NULL),
('J022', 'Event Marketing', NULL),
('J023', 'Marketing Analyst', NULL),
('J024', 'Sales Representative', NULL),
('J025', 'Sales Management', NULL),
('J026', 'Sales Administrative', NULL),
('J027', 'Account Executive', NULL),
('J028', 'Direktur R&D', NULL),
('J029', 'Manager R&D', NULL),
('J030', 'Staff R&D', NULL),
('J031', 'Network Administrator', NULL),
('J032', 'Website Developer', NULL),
('J033', 'Software Developer', NULL),
('J034', 'IT Support', NULL),
('J035', 'Data Analyst', NULL),
('J036', 'IT Project Manager', NULL),
('J037', 'Customer Service Representative', NULL),
('J038', 'Customer Success Manager', NULL),
('J039', 'Legal Staff', NULL),
('J040', 'Logistik', NULL),
('J041', 'Quality Control ', NULL),
('J042', 'Production Planning', NULL),
('J043', 'Assembly', NULL),
('J044', 'Manufacturing Engineering', NULL),
('J045', 'Graphic Designer', NULL),
('J046', 'Creative director', NULL),
('J047', 'Ilustrator', NULL),
('J048', 'UX Designer', NULL),
('J049', 'UI Designer', NULL),
('J050', 'Product Developer', NULL),
('J051', 'IT Junior', NULL),
('J052', 'Content Creator', NULL),
('J053', 'Hukum', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `username`) VALUES
(111222, 'fricilia2515@gmail.com', 'fricilia');

-- --------------------------------------------------------

--
-- Table structure for table `namausaha`
--

CREATE TABLE `namausaha` (
  `nama` varchar(35) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `notelepon` varchar(14) NOT NULL,
  `fax` varchar(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `npwp` varchar(50) NOT NULL,
  `bank` varchar(35) NOT NULL,
  `noaccount` varchar(25) NOT NULL,
  `atasnama` varchar(35) NOT NULL,
  `pimpinan` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `namausaha`
--

INSERT INTO `namausaha` (`nama`, `alamat`, `notelepon`, `fax`, `email`, `npwp`, `bank`, `noaccount`, `atasnama`, `pimpinan`) VALUES
('PT. Sinergi Nusantara Gemilang', 'Jl. Danau Sunter Utara Blok A No. 15, Jakarta Utara, DKI Jakarta 14350.', '021-69696969', '021-77777777', 'anginpunyaktp@gmail.com', '123-456-7890-50000', 'Bank Tidak Mandiri', '0000000000000', 'Christianto', 'William Halim');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `foto` varchar(11) NOT NULL,
  `idpeg` varchar(10) NOT NULL,
  `iddep` varchar(4) NOT NULL,
  `idjab` varchar(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gaji` int(11) DEFAULT NULL,
  `status` enum('Belum Menikah','Menikah') DEFAULT NULL,
  `jkelamin` enum('Laki-Laki','Perempuan') DEFAULT NULL,
  `skerja` enum('Internship','Tetap') DEFAULT NULL,
  `cuti` int(11) DEFAULT NULL,
  `jenjangpendidikan` enum('SMA/SMK Sederajat','D3','S1','S2','S3') DEFAULT NULL,
  `tglkerja` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`foto`, `idpeg`, `iddep`, `idjab`, `nama`, `alamat`, `telepon`, `email`, `gaji`, `status`, `jkelamin`, `skerja`, `cuti`, `jenjangpendidikan`, `tglkerja`, `created_at`) VALUES
('foto/P20240', 'P202409001', 'D011', 'J043', 'Glenn Austin Ardian', 'Ciledug', '0812', 'glenn@gmail.com', 10000000, 'Belum Menikah', 'Laki-Laki', 'Tetap', NULL, 'S1', '2024-09-02', '2024-09-24 18:31:41'),
('foto/P20240', 'P202409002', 'D008', 'J051', 'Fricilia Angelica ', 'Angsana Raya', '012', 'fricilia2515@gmail.com', 8000000, 'Belum Menikah', 'Perempuan', 'Internship', NULL, 'S1', '2024-09-02', '2024-09-24 18:33:18'),
('foto/P20240', 'P202409003', 'D004', 'J011', 'Cha Eun Woo', 'Jakarta', '0877', 'eunwoo@gmail.com', 200000000, 'Menikah', 'Laki-Laki', 'Tetap', NULL, 'S2', '2024-09-26', '2024-09-26 02:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `penghargaan`
--

CREATE TABLE `penghargaan` (
  `id_penghargaan` varchar(11) NOT NULL,
  `idpeg` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `alasan` varchar(1300) DEFAULT NULL,
  `ditetapkan` varchar(50) NOT NULL,
  `pembuat_surat` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penghargaan`
--

INSERT INTO `penghargaan` (`id_penghargaan`, `idpeg`, `tanggal`, `alasan`, `ditetapkan`, `pembuat_surat`, `created_at`) VALUES
('Achivement2', 'P202409001', '2024-10-10', 'Karyawan Terbaik bulan September', 'Jakarta', 'HRD', '2024-10-10 13:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `peringatan`
--

CREATE TABLE `peringatan` (
  `id_peringatan` varchar(11) NOT NULL,
  `idpeg` varchar(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `alasan` varchar(1300) DEFAULT NULL,
  `ditetapkan` varchar(50) NOT NULL,
  `pembuat_surat` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `daritgl` date DEFAULT NULL,
  `sampaitgl` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peringatan`
--

INSERT INTO `peringatan` (`id_peringatan`, `idpeg`, `tanggal`, `alasan`, `ditetapkan`, `pembuat_surat`, `created_at`, `daritgl`, `sampaitgl`) VALUES
('SP202410001', 'P202409003', '2024-10-10', 'Sering Terlambat datang ke kantor', 'Jakarta', 'HRD', '2024-10-10 13:40:24', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cuti`
--
ALTER TABLE `cuti`
  ADD PRIMARY KEY (`id_cuti`),
  ADD KEY `idpeg` (`idpeg`);

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`iddep`);

--
-- Indexes for table `departemen_jabatan`
--
ALTER TABLE `departemen_jabatan`
  ADD PRIMARY KEY (`iddep`,`idjab`),
  ADD KEY `idjab` (`idjab`);

--
-- Indexes for table `izin`
--
ALTER TABLE `izin`
  ADD PRIMARY KEY (`id_izin`),
  ADD KEY `idpeg` (`idpeg`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`idjab`),
  ADD UNIQUE KEY `iddep` (`iddep`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`idpeg`),
  ADD KEY `iddep` (`iddep`,`idjab`);

--
-- Indexes for table `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD PRIMARY KEY (`id_penghargaan`),
  ADD KEY `idpeg` (`idpeg`);

--
-- Indexes for table `peringatan`
--
ALTER TABLE `peringatan`
  ADD PRIMARY KEY (`id_peringatan`),
  ADD KEY `idpeg` (`idpeg`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuti`
--
ALTER TABLE `cuti`
  ADD CONSTRAINT `cuti_ibfk_1` FOREIGN KEY (`idpeg`) REFERENCES `pegawai` (`idpeg`);

--
-- Constraints for table `departemen_jabatan`
--
ALTER TABLE `departemen_jabatan`
  ADD CONSTRAINT `departemen_jabatan_ibfk_1` FOREIGN KEY (`iddep`) REFERENCES `departemen` (`iddep`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `departemen_jabatan_ibfk_2` FOREIGN KEY (`idjab`) REFERENCES `jabatan` (`idjab`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `izin`
--
ALTER TABLE `izin`
  ADD CONSTRAINT `izin_ibfk_1` FOREIGN KEY (`idpeg`) REFERENCES `pegawai` (`idpeg`);

--
-- Constraints for table `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD CONSTRAINT `penghargaan_ibfk_1` FOREIGN KEY (`idpeg`) REFERENCES `pegawai` (`idpeg`);

--
-- Constraints for table `peringatan`
--
ALTER TABLE `peringatan`
  ADD CONSTRAINT `peringatan_ibfk_1` FOREIGN KEY (`idpeg`) REFERENCES `pegawai` (`idpeg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
