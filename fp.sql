-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Des 2025 pada 14.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `makanan`
--

CREATE TABLE `makanan` (
  `id` int(11) NOT NULL,
  `nama_makanan` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `kalori` float DEFAULT NULL,
  `protein` float DEFAULT NULL,
  `lemak` float DEFAULT NULL,
  `karbo` float DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meal_logs`
--

CREATE TABLE `meal_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_makan` varchar(50) NOT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `calories` float DEFAULT 0,
  `protein` float DEFAULT 0,
  `fat` float DEFAULT 0,
  `carbs` float DEFAULT 0,
  `porsi` int(11) NOT NULL,
  `status` enum('planned','eaten') DEFAULT 'planned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meal_logs`
--

INSERT INTO `meal_logs` (`id`, `user_id`, `tanggal`, `waktu_makan`, `food_name`, `calories`, `protein`, `fat`, `carbs`, `porsi`, `status`) VALUES
(1, 0, '2025-12-14', 'pagi', 'Nasi Sambal Ayam', 100, 100, 100, 100, 1, 'planned'),
(2, 1, '2025-12-14', 'siang', 'Nasi Sambal Ayam', 100, 100, 100, 100, 1, 'planned'),
(3, 1, '2025-12-15', 'malam', 'Burger', 183, 14.2, 9, 11.5, 1, 'planned'),
(4, 1, '2025-12-15', 'pagi', 'Nasi Uduk + telor balado', 100, 100, 100, 100, 1, 'planned');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('push','email') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('sent','failed','pending') DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `status`, `error_message`, `sent_at`, `created_at`) VALUES
(1, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:24:04'),
(2, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'Email failed: SMTP Error: Could not authenticate.', NULL, '2025-12-16 15:24:06'),
(3, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:24:06'),
(4, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'Email failed: SMTP Error: Could not authenticate.', NULL, '2025-12-16 15:24:09'),
(5, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:24:29'),
(6, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'Email failed: SMTP Error: Could not authenticate.', NULL, '2025-12-16 15:24:31'),
(7, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:26:01'),
(8, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'Email failed: SMTP Error: Could not authenticate.', NULL, '2025-12-16 15:26:03'),
(9, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:28:23'),
(10, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'Email failed: SMTP Error: Could not authenticate.', NULL, '2025-12-16 15:28:25'),
(11, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:31:09'),
(12, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-16 09:31:13', '2025-12-16 15:31:13'),
(13, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:31:58'),
(14, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-16 09:32:02', '2025-12-16 15:32:02'),
(15, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:32:32'),
(16, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-16 09:32:35', '2025-12-16 15:32:35'),
(17, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:34:40'),
(18, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-16 09:34:44', '2025-12-16 15:34:44'),
(19, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:38:05'),
(20, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-16 09:38:09', '2025-12-16 15:38:09'),
(21, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-16 15:40:02'),
(22, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-16 09:40:06', '2025-12-16 15:40:06'),
(23, 1, 'push', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'failed', 'No push subscriptions found', NULL, '2025-12-17 13:31:08'),
(24, 1, 'email', 'Test Notification 🔔', 'Ini adalah test notification dari Healthy App. Notifikasi Anda berfungsi dengan baik!', 'sent', NULL, '2025-12-17 07:31:12', '2025-12-17 13:31:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `push_enabled` tinyint(1) DEFAULT 1,
  `email_enabled` tinyint(1) DEFAULT 1,
  `reminder_breakfast` tinyint(1) DEFAULT 1,
  `reminder_lunch` tinyint(1) DEFAULT 1,
  `reminder_dinner` tinyint(1) DEFAULT 1,
  `reminder_time_breakfast` time DEFAULT '07:00:00',
  `reminder_time_lunch` time DEFAULT '12:00:00',
  `reminder_time_dinner` time DEFAULT '18:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `user_id`, `push_enabled`, `email_enabled`, `reminder_breakfast`, `reminder_lunch`, `reminder_dinner`, `reminder_time_breakfast`, `reminder_time_lunch`, `reminder_time_dinner`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, '07:00:00', '12:00:00', '20:32:00', '2025-12-16 15:21:12', '2025-12-17 13:31:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `endpoint` text NOT NULL,
  `p256dh` varchar(255) NOT NULL,
  `auth` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekomendasi`
--

CREATE TABLE `rekomendasi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `makanan_id` int(11) DEFAULT NULL,
  `waktu_makan` enum('pagi','siang','malam') DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `tinggi` float DEFAULT NULL,
  `berat` float DEFAULT NULL,
  `aktivitas` varchar(50) DEFAULT NULL,
  `alergi` varchar(255) DEFAULT NULL,
  `target_kalori` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `nama`, `umur`, `tinggi`, `berat`, `aktivitas`, `alergi`, `target_kalori`) VALUES
(1, 'arifkurniawan1424@gmail.com', 'Rivan wahyu risalah', '$2y$10$dB0ReDhZ1zUkXXueMjHXdOTyL2jrYCPgdEXHy7hYB.ptHTSURYDI2', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `makanan`
--
ALTER TABLE `makanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meal_logs`
--
ALTER TABLE `meal_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `makanan_id` (`makanan_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `makanan`
--
ALTER TABLE `makanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meal_logs`
--
ALTER TABLE `meal_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD CONSTRAINT `notification_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD CONSTRAINT `push_subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD CONSTRAINT `rekomendasi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `rekomendasi_ibfk_2` FOREIGN KEY (`makanan_id`) REFERENCES `makanan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
