-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3303
-- Waktu pembuatan: 15 Nov 2025 pada 13.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airline_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `passenger_name` varchar(100) DEFAULT NULL,
  `passenger_id` varchar(50) DEFAULT NULL,
  `booked_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_penumpang` varchar(100) DEFAULT NULL,
  `idcard` varchar(100) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `kode_booking` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `flight_id`, `passenger_name`, `passenger_id`, `booked_at`, `nama_penumpang`, `idcard`, `deleted`, `kode_booking`) VALUES
(17, 7, 13, NULL, NULL, '2025-11-15 12:30:55', 'Puput', '081234567890', 0, 'BK-17-20251115133055');

-- --------------------------------------------------------

--
-- Struktur dari tabel `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `flight_code` varchar(20) DEFAULT NULL,
  `origin` varchar(50) DEFAULT NULL,
  `destination` varchar(50) DEFAULT NULL,
  `depart_datetime` datetime DEFAULT NULL,
  `arrive_datetime` datetime DEFAULT NULL,
  `price` int(11) DEFAULT 0,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
  `seats_total` int(11) DEFAULT 180,
  `seats_available` int(11) DEFAULT 180,
  `airline` varchar(100) NOT NULL,
  `airline_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `flights`
--

INSERT INTO `flights` (`id`, `flight_code`, `origin`, `destination`, `depart_datetime`, `arrive_datetime`, `price`, `status`, `seats_total`, `seats_available`, `airline`, `airline_name`) VALUES
(13, 'SJ303', 'Yogyakarta', 'Jakarta', '2024-11-22 14:15:00', '2024-11-22 16:15:00', 400000, 'Scheduled', 160, 144, '', 'Sriwijaya Air'),
(14, 'BA202', 'Bandung', 'Medan', '2024-11-21 10:30:00', '2024-11-21 13:30:00', 550000, 'Scheduled', 150, 118, '', 'Batik Air'),
(15, 'GA101', 'Jakarta', 'Surabaya', '2024-11-20 08:00:00', '2024-11-20 10:00:00', 450000, 'Scheduled', 180, 150, '', 'Garuda Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `role`, `created_at`) VALUES
(2, 'puput', '$2y$10$EIxFDX9rrg1nQMJCT.oF0uZT1LLqO.qyZ93eKfn28sPE0I4sKykyS', NULL, NULL, 'user', '2025-11-14 17:39:28'),
(4, 'puni', '$2y$10$5GMllGaj.iUabeVpqN5Dz.yhD4i1iInbUJinxNcVcAZwSsmFRotlu', 'Administrator', 'admin@gmail.com', 'admin', '2025-11-15 06:07:37'),
(7, 'puput09', '$2y$10$rCRSAheRvt1EbWWes8zK3ueF6wZYEIWdp1ZhwnfDvreqXdagS4Fx2', NULL, NULL, 'user', '2025-11-15 11:38:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indeks untuk tabel `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
