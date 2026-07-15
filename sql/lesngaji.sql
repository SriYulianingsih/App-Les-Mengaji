-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 03:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lesngaji`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `santri_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','alpha') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `santri_id`, `jadwal_id`, `tanggal`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 6, 5, '2026-04-10', 'hadir', 'Ada Kemajuan', '2026-04-10 05:58:01', '2026-04-10 12:18:16'),
(5, 7, 5, '2026-04-10', 'hadir', 'Siswa Pinter ini', '2026-04-10 05:58:01', '2026-04-10 12:18:16'),
(6, 8, 6, '2026-04-10', 'izin', '', '2026-04-10 06:40:37', '2026-04-10 06:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nip` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `pendidikan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `user_id`, `nip`, `nama`, `jenis_kelamin`, `no_hp`, `alamat`, `pendidikan`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '13578905432221', 'Bu Nuri', 'P', '082316875177', 'Garut', 'S1 Pendidikan', '1775803649_49181c5ab485a31528e5.png', 'aktif', '2026-04-08 03:24:37', '2026-04-10 06:47:29'),
(2, 4, '135789054356', 'Pak Pur', 'L', '08231686574', 'Bandung', 'S1 AGAMA', NULL, 'aktif', '2026-04-08 03:48:42', '2026-04-08 03:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `guru_id` int(11) NOT NULL,
  `mapel_id` int(11) UNSIGNED DEFAULT NULL,
  `kelas_id` int(11) UNSIGNED DEFAULT NULL,
  `hari` varchar(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `guru_id`, `mapel_id`, `kelas_id`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 1, 'Jumat', '12:30:00', '14:00:00', '2026-04-10 05:05:34', '2026-04-10 05:05:34'),
(6, 1, 1, 2, 'Jumat', '15:00:00', '16:30:00', '2026-04-10 06:39:47', '2026-04-10 06:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pembayaran`
--

CREATE TABLE `kategori_pembayaran` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `nominal_std` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_pembayaran`
--

INSERT INTO `kategori_pembayaran` (`id`, `nama_kategori`, `nominal_std`) VALUES
(1, 'SPP Bulanan', 150000.00),
(2, 'Zakat Mingguan', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `tingkat`) VALUES
(1, '3A', 'Iqra'),
(2, '3B', 'Awaliyah');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori_id` int(11) UNSIGNED DEFAULT NULL,
  `jadwal_id` int(11) DEFAULT NULL,
  `absensi_id` int(11) DEFAULT NULL,
  `periode_bulan` int(11) NOT NULL,
  `periode_tahun` int(11) NOT NULL,
  `tanggal_cetak` date NOT NULL,
  `tipe_laporan` enum('absensi','pembayaran') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id`, `user_id`, `kategori_id`, `jadwal_id`, `absensi_id`, `periode_bulan`, `periode_tahun`, `tanggal_cetak`, `tipe_laporan`, `keterangan`, `file_pdf`, `created_at`, `updated_at`) VALUES
(17, 1, 1, NULL, NULL, 4, 2026, '2026-04-10', 'pembayaran', 'Laporan digenerate otomatis.', NULL, '2026-04-10 12:15:53', '2026-04-10 12:15:53');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `nama_mapel`, `keterangan`) VALUES
(1, 'Fiqih Ibadah', 'Bahas Agama'),
(2, 'Ilmu Agama', '');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-04-04-025901', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1775616564, 1),
(2, '2026-04-04-025919', 'App\\Database\\Migrations\\CreateOrangtuaTable', 'default', 'App', 1775616564, 1),
(3, '2026-04-04-025952', 'App\\Database\\Migrations\\CreateSantriTable', 'default', 'App', 1775616564, 1),
(4, '2026-04-04-030018', 'App\\Database\\Migrations\\CreateGuruTable', 'default', 'App', 1775616564, 1),
(5, '2026-04-04-030039', 'App\\Database\\Migrations\\CreateJadwalTable', 'default', 'App', 1775616564, 1),
(6, '2026-04-04-030100', 'App\\Database\\Migrations\\CreateAbsensiTable', 'default', 'App', 1775616564, 1),
(7, '2026-04-04-030119', 'App\\Database\\Migrations\\CreatePembayaranTable', 'default', 'App', 1775616564, 1),
(8, '2026-04-04-030135', 'App\\Database\\Migrations\\CreateLaporanTable', 'default', 'App', 1775616564, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orangtua`
--

CREATE TABLE `orangtua` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_ayah` varchar(100) NOT NULL,
  `nama_ibu` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) DEFAULT NULL,
  `alamat` text NOT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kabupaten` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orangtua`
--

INSERT INTO `orangtua` (`id`, `user_id`, `nama_ayah`, `nama_ibu`, `no_hp`, `email`, `pekerjaan_ayah`, `pekerjaan_ibu`, `alamat`, `rt`, `rw`, `kelurahan`, `kecamatan`, `kabupaten`, `provinsi`, `kode_pos`, `created_at`, `updated_at`) VALUES
(6, 7, 'Brista', 'Megawati', '089672253434', 'brista@gmail.com', 'swasta', 'IRT', 'Garut', '004', '002', 'RANCABANGO', 'TAROGONG KALER', 'KABUPATEN GARUT', 'JAWA BARAT', '44151', '2026-04-10 04:49:17', '2026-04-10 09:36:28');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `santri_id` int(11) NOT NULL,
  `kategori_id` int(11) UNSIGNED DEFAULT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah_bayar` decimal(10,2) NOT NULL,
  `status` enum('lunas','belum') NOT NULL,
  `metode_pembayaran` enum('cash','transfer') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `santri_id`, `kategori_id`, `bulan`, `tahun`, `jumlah_bayar`, `status`, `metode_pembayaran`, `keterangan`, `tanggal_bayar`, `bukti_pembayaran`, `created_at`, `updated_at`) VALUES
(7, 6, 1, 4, 2026, 500000.00, 'lunas', 'cash', 'Lunas ', '2026-04-10', NULL, '2026-04-10 05:51:22', '2026-04-10 05:55:11'),
(18, 7, 1, 4, 2026, 150000.00, 'lunas', '', 'Tagihan otomatis sistem: SPP Bulanan', '2026-04-10', '1775825511_cd0c94e9d40288042780.png', '2026-04-10 12:45:56', '2026-04-10 12:51:51'),
(19, 8, 1, 4, 2026, 150000.00, 'belum', '', 'Tagihan otomatis sistem: SPP Bulanan', NULL, NULL, '2026-04-10 12:45:56', '2026-04-10 12:45:56');

-- --------------------------------------------------------

--
-- Table structure for table `presensi_materi`
--

CREATE TABLE `presensi_materi` (
  `id` int(11) UNSIGNED NOT NULL,
  `absensi_id` int(11) NOT NULL,
  `materi_mulai` varchar(255) DEFAULT NULL,
  `materi_selesai` varchar(255) DEFAULT NULL,
  `catatan_guru` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi_materi`
--

INSERT INTO `presensi_materi` (`id`, `absensi_id`, `materi_mulai`, `materi_selesai`, `catatan_guru`, `created_at`, `updated_at`) VALUES
(4, 4, 'Albaqarah ayat 102', 'Albaqarah ayat 106', 'Keren banget', '2026-04-10 05:58:01', '2026-04-10 12:18:16'),
(5, 5, 'Bukhari 1 Bab', 'Bukhari 2 Bab', 'Mumtaz', '2026-04-10 12:18:16', '2026-04-10 12:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id` int(11) NOT NULL,
  `orangtua_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) UNSIGNED DEFAULT NULL,
  `nis` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `pendidikan_terakhir` varchar(100) NOT NULL,
  `tanggal_daftar` date NOT NULL,
  `status` enum('aktif','nonaktif','lulus') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id`, `orangtua_id`, `kelas_id`, `nis`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `pendidikan_terakhir`, `tanggal_daftar`, `status`, `foto`, `created_at`, `updated_at`) VALUES
(6, 6, 1, '785328563521', 'Isaq', 'L', 'Garut', '2025-11-11', 'Garut', 'SMP', '2026-04-10', 'aktif', '1775796975_0ae15b87e99e152a9154.jpeg', '2026-04-10 04:56:15', '2026-04-10 04:56:15'),
(7, 6, 1, '1092378347823647', 'Rizki MS', 'L', 'Garut', '2004-04-10', 'Garut', 'SD', '2026-04-10', 'aktif', '1775811325_8d68abd14fa2043de990.jpeg', '2026-04-10 05:03:23', '2026-04-10 08:55:25'),
(8, 6, 2, '10923783472222', 'Sri', 'P', 'Garut', '2004-04-10', 'Garut', 'SD', '2026-04-10', 'aktif', NULL, '2026-04-10 06:39:04', '2026-04-10 06:39:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','orangtua') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin@cahayahidayah', '$2y$10$NrN/uSRJOk8u5AupjYxjxO0.Q7y8Rd1e.pKJrTR6C183mKF9PB1ZG', 'admin', '2026-04-08 03:11:13', '2026-04-08 03:11:13'),
(2, 'bunuri', '$2y$10$HAzugtHwuClrKA0VsaW4xeTfZB814Rep3Bc.er9BT.927l1jEOfHy', 'guru', '2026-04-08 04:35:50', '2026-04-08 04:35:50'),
(4, 'purnomo', '$2y$10$.1517mz6VXZN6kTHwXoJle9nve6qhOvp8mOli/13PAo8Vb9QT/AAy', 'guru', '2026-04-08 05:16:02', '2026-04-08 05:16:02'),
(7, 'brista', '$2y$10$UwrpzuPtXZRch45CzaiggunP6ty7fW.cuUf9DS3gkt5r423.3B7km', 'orangtua', '2026-04-10 04:50:20', '2026-04-10 04:50:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `santri_id_jadwal_id_tanggal` (`santri_id`,`jadwal_id`,`tanggal`),
  ADD KEY `absensi_jadwal_id_foreign` (`jadwal_id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `guru_user_id_foreign` (`user_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `kategori_pembayaran`
--
ALTER TABLE `kategori_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lp_user` (`user_id`),
  ADD KEY `fk_lp_kategori` (`kategori_id`),
  ADD KEY `fk_lp_jadwal` (`jadwal_id`),
  ADD KEY `fk_lp_absensi` (`absensi_id`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orangtua`
--
ALTER TABLE `orangtua`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `santri_kategori_periode` (`santri_id`,`kategori_id`,`bulan`,`tahun`);

--
-- Indexes for table `presensi_materi`
--
ALTER TABLE `presensi_materi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_presensi_absensi` (`absensi_id`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `fk_santri_orangtua` (`orangtua_id`),
  ADD KEY `fk_santri_kelas` (`kelas_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori_pembayaran`
--
ALTER TABLE `kategori_pembayaran`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orangtua`
--
ALTER TABLE `orangtua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `presensi_materi`
--
ALTER TABLE `presensi_materi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `absensi_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `fk_laporan_admin` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_laporan_kat` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_lp_absensi` FOREIGN KEY (`absensi_id`) REFERENCES `absensi` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_lp_jadwal` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_lp_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pembayaran` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_lp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orangtua`
--
ALTER TABLE `orangtua`
  ADD CONSTRAINT `orangtua_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_santri_id_foreign` FOREIGN KEY (`santri_id`) REFERENCES `santri` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `presensi_materi`
--
ALTER TABLE `presensi_materi`
  ADD CONSTRAINT `fk_presensi_absensi` FOREIGN KEY (`absensi_id`) REFERENCES `absensi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `fk_santri_kelas` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_santri_orangtua` FOREIGN KEY (`orangtua_id`) REFERENCES `orangtua` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
