-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 01:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hnsmstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(2, 'Clothes', '2025-12-17 10:32:25', '2025-12-17 10:32:25'),
(3, 'T-Shirt', '2025-12-17 10:34:31', '2025-12-17 10:34:31'),
(9, 'Shoe', '2026-01-06 11:17:26', '2026-01-06 11:17:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_06_173213_create_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `opname_detail`
--

CREATE TABLE `opname_detail` (
  `id` int(11) NOT NULL,
  `stok_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `stok_sistem` int(11) NOT NULL,
  `stok_fisik` int(11) NOT NULL,
  `terjual` int(11) NOT NULL,
  `rusak` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opname_detail`
--

INSERT INTO `opname_detail` (`id`, `stok_id`, `produk_id`, `stok_sistem`, `stok_fisik`, `terjual`, `rusak`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 50, 43, 0, 7, '2025-12-23 10:19:22', '2025-12-23 10:19:22'),
(2, 1, 11, 18, 18, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(3, 1, 12, 34, 34, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(4, 1, 13, 35, 35, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(5, 1, 14, 38, 38, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(6, 1, 15, 16, 6, 0, 10, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(7, 1, 16, 18, 18, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(8, 1, 19, 46, 46, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(9, 1, 20, 46, 46, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(10, 1, 21, 47, 47, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23'),
(11, 1, 22, 42, 42, 0, 0, '2025-12-23 10:19:23', '2025-12-23 10:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penyesuaian_stok`
--

CREATE TABLE `penyesuaian_stok` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `stok_sistem` int(11) NOT NULL,
  `stok_fisik` int(11) NOT NULL,
  `selisih` int(11) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(20) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `harga_modal` decimal(10,0) NOT NULL,
  `harga_jual` decimal(10,0) NOT NULL,
  `stok` bigint(20) NOT NULL,
  `ukuran` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `gambar`, `nama_produk`, `kategori_id`, `warna`, `harga_modal`, `harga_jual`, `stok`, `ukuran`, `deskripsi`, `created_at`, `updated_at`) VALUES
(28, '1768990791_23692469_53581834_1000.webp', 'Spezial', 9, 'Green Pink', 1000000, 1200000, 3, '41', 'Adidas Spezial Green Pink  Size 41 1/3   Used Baik   Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:19:52', '2026-01-21 04:36:36'),
(29, '1768990985_id-11134207-7r98p-m07cj0ch9nvk58.jpeg', 'Spezial', 9, 'Blue Paradise', 1500000, 1850000, 22, '41', 'Adidas Spezial Blue Paradise  Size 41 1/3   Used Baik   Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:23:05', '2026-01-21 03:23:05'),
(30, '1768991097_button down.webp', 'Shirt Button Down', 3, 'Button Down', 100000, 150000, 18, 'L', 'Button Down', '2026-01-21 03:24:57', '2026-01-21 03:24:57'),
(31, '1768991222_sandy pink.jpeg', 'Gazelle', 9, 'Sandy Pink', 1550000, 1850000, 21, '42', 'Adidas Gazelle Sandy Pink Size 42 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:27:02', '2026-01-21 03:27:02'),
(35, '1768991472_brmuda pink.jpeg', 'Bermuda Pink', 9, 'Bermuda Pink', 1850000, 1950000, 12, '42', 'Adidas Bermuda Pink Size 41 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:31:12', '2026-01-21 03:31:12'),
(36, '1768991548_spezial green.webp', 'Spezial', 9, 'Green', 1750000, 1900000, 10, '40', 'Adidas Spezial Green Size 41 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:32:28', '2026-01-21 03:32:28'),
(37, '1768991670_birmingha,.webp', 'Birmingham', 9, 'Birmingham', 2000000, 2200000, 9, '37', 'Adidas Birmingham Size 37 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:34:30', '2026-01-21 03:34:30'),
(38, '1768991757_mc.jpeg', 'Hamburg', 9, 'Hamburg', 1450000, 1550000, 13, '39', 'Adidas Hamburg Manchester Size 41 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:35:57', '2026-01-21 03:35:57'),
(39, '1768991863_ice blue.jpg', 'Spezial', 9, 'Ice Blue', 1560000, 1400000, 7, '40', 'Adidas Spezial Ice Blue 40 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 03:37:43', '2026-01-21 03:37:43'),
(40, '1768995029_london purple.jpeg', 'London', 9, 'Purple', 2000000, 2200000, 5, '40', 'Adidas London Purple 40 1/3 Used Baik Detail dan minus sudah dijelasin di wa NO RETURN AND REFOUND', '2026-01-21 04:30:29', '2026-01-21 04:30:29');

-- --------------------------------------------------------

--
-- Table structure for table `retur`
--

CREATE TABLE `retur` (
  `id` int(11) NOT NULL,
  `transaksi_detail_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nama_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4h4kxpPH5xw602dvSw6AWUdhQGDmW110sy68LjsQ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWENXOXdPRjR0c2czdGhtdjZ4aklYSW9jWUVUT2tXY0ZYWDdMSUg4eiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdG9rL3ByZWRpa3NpP3BlcmlvZGU9NyZwcm9kdWtfaWQ9MjgiO3M6NToicm91dGUiO3M6MTM6InN0b2sucHJlZGlrc2kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1768995405);

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `nama_sesi` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `input_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id`, `tanggal`, `nama_sesi`, `user_id`, `updated_at`, `input_type`, `created_at`) VALUES
(1, '2025-12-23 00:00:00', 'SO AKHIR BULAN', 1, '2025-12-23 10:18:58', 'excel', '2025-12-23 10:18:58');

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_keluar`
--

INSERT INTO `stok_keluar` (`id`, `produk_id`, `sku`, `jumlah`, `alasan`, `satuan`, `user_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(7, 28, 'jcsbd', 1, 'Penjualan', 'PCS', 1, NULL, '2026-01-21 04:32:29', '2026-01-21 04:32:29'),
(8, 28, 'jcsbd', 1, 'Penjualan', 'PCS', 1, NULL, '2026-01-21 04:32:56', '2026-01-21 04:32:56'),
(9, 28, 'jcsbd', 1, 'Penjualan', 'PCS', 1, NULL, '2026-01-21 04:33:10', '2026-01-21 04:33:10'),
(10, 28, 'jcsbd', 1, 'Penjualan', 'PCS', 1, NULL, '2026-01-21 04:33:22', '2026-01-21 04:33:22'),
(11, 28, 'jcsbd', 1, 'Penjualan', 'PCS', 1, NULL, '2026-01-21 04:33:35', '2026-01-21 04:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `harga_beli` decimal(10,0) NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `catatan` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `alamat`, `telepon`) VALUES
(1, 'Supplier A', 'A', 123),
(2, 'Supplier B', 'B', 123);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `bayar` decimal(10,0) DEFAULT NULL,
  `kembalian` decimal(10,0) DEFAULT NULL,
  `metode` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Gagal','Selesai') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `total`, `bayar`, `kembalian`, `metode`, `status`, `created_at`, `updated_at`) VALUES
(30, 1, 1200000, 1200000, 0, 'Cash', 'Selesai', '2026-01-21 04:32:29', '2026-01-21 04:32:29'),
(31, 1, 1200000, 1200000, 0, 'Cash', 'Selesai', '2026-01-21 04:32:56', '2026-01-21 04:32:56'),
(32, 1, 1200000, 1200000, 0, 'Cash', 'Selesai', '2026-01-21 04:33:10', '2026-01-21 04:33:10'),
(33, 1, 1200000, 1200000, 0, 'Cash', 'Selesai', '2026-01-21 04:33:22', '2026-01-21 04:33:22'),
(34, 1, 1200000, 1200000, 0, 'Cash', 'Selesai', '2026-01-21 04:33:35', '2026-01-21 04:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `no_invoice` varchar(255) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` decimal(10,0) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `status` enum('Pending','Gagal','Berhasil') NOT NULL,
  `struk` enum('Ya','Tidak') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `transaksi_id`, `no_invoice`, `produk_id`, `qty`, `harga_jual`, `sub_total`, `status`, `struk`, `created_at`, `updated_at`) VALUES
(25, 30, 'INV-21012026-0030', 28, 1, 1200000, 1200000, 'Pending', 'Tidak', '2026-01-21 04:32:29', '2026-01-21 04:32:29'),
(26, 31, 'INV-21012026-0031', 28, 1, 1200000, 1200000, 'Pending', 'Tidak', '2026-01-21 04:32:56', '2026-01-21 04:32:56'),
(27, 32, 'INV-21012026-0032', 28, 1, 1200000, 1200000, 'Pending', 'Tidak', '2026-01-21 04:33:10', '2026-01-21 04:33:10'),
(28, 33, 'INV-21012026-0033', 28, 1, 1200000, 1200000, 'Pending', 'Tidak', '2026-01-21 04:33:22', '2026-01-21 04:33:22'),
(29, 34, 'INV-21012026-0034', 28, 1, 1200000, 1200000, 'Pending', 'Ya', '2026-01-21 04:33:35', '2026-01-21 04:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `email_verified_at`, `password`, `role_id`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin HNSM', 'admin', 'admin@hnsmstore.com', NULL, '$2y$12$/9KL6mOUfxCJ9R0OIFHux.cSZgLvGHIoffZ53KIzsMsCMWipXZ5RG', 1, 'Aktif', NULL, '2025-12-16 07:45:16', '2025-12-16 07:45:16'),
(2, 'Andika Saputra', 'andyas', 'andyas2003@gmail.com', NULL, '$2y$12$UkiwvL9NkgQvwq2QTod5DersYrLNzZrN.RvoCtP24APUczJeALqc6', 2, 'Aktif', NULL, '2025-12-16 08:45:35', '2025-12-16 09:04:09'),
(3, 'Adiva Anas', 'adiva', 'adiva@gmail.com', NULL, '$2y$12$6DD7/BcI2F0yYZSynsP4gOdggvc8bqV8L7Z3sqCPImlMJ7D3GHzW6', 2, 'Aktif', NULL, '2025-12-16 08:55:05', '2025-12-16 08:55:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opname_detail`
--
ALTER TABLE `opname_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_id` (`stok_id`,`produk_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penyesuaian_stok`
--
ALTER TABLE `penyesuaian_stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`,`user_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `retur`
--
ALTER TABLE `retur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_detail_id` (`transaksi_detail_id`,`produk_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`,`user_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id` (`produk_id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `opname_detail`
--
ALTER TABLE `opname_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penyesuaian_stok`
--
ALTER TABLE `penyesuaian_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `retur`
--
ALTER TABLE `retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD CONSTRAINT `stok_masuk_ibfk_1` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`),
  ADD CONSTRAINT `stok_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`),
  ADD CONSTRAINT `stok_masuk_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_3` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
