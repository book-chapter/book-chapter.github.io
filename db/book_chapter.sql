-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Des 2024 pada 10.54
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
-- Database: `book_chapter`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`, `full_name`, `created_at`) VALUES
(1, 'admin', '$2y$10$srQ6L6Y7GWrtrX1FeKSh1eEb8mAaKDw8znlNdGaY3Xri33tsv4Egu', 'admin@gmail.com', 'Admin Book Chapter', '2024-11-12 19:04:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `book_details`
--

CREATE TABLE `book_details` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `book_details`
--

INSERT INTO `book_details` (`id`, `category`, `title`, `image_path`, `description`) VALUES
(5, 'IT', 'TUTORIAL MEMBUAT GAME OBBY \"TOWER OF HELL\"', 'uploads/images/67595da549db8.png', 'Pada era perkembangan digital dan\r\nteknologi yang saat ini begitu pesat,\r\nhingga bermunculan game terbaru\r\ndan terpopuler di kalangan remaja\r\nmaupun anak anak. terdapat ilmu\r\npengetahuan bagi sang anak untuk\r\nmembantu pengembangan dari segi\r\nmemahami materi dan langsung bisa\r\nmempraktekkan. Materi yang mudah\r\nmengerti berhasil mengiris iris hatiku');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chapters`
--

CREATE TABLE `chapters` (
  `chapter_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `chapters`
--

INSERT INTO `chapters` (`chapter_id`, `book_id`, `title`, `description`, `price`, `file_path`, `created_at`) VALUES
(11, 5, 'Bab 1 INTRODUCTION ROBLOX', 'Pada Bab 1 membahas tentang: Introduction Roblox yang terdiri dari, Pengenalan Roblox dan Bahasa Pemrograman Lua.\r\n', 27950.00, 'uploads/chapters/Tutorial_Membuat_Game_Obby_Tower_Of_Hell.docx', '2024-12-11 09:43:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `status` enum('pending','waiting_confirmation','approved','rejected') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_proof_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `chapter_id`, `status`, `order_date`, `payment_proof_path`) VALUES
(36, 9, 11, 'approved', '2024-12-11 09:47:44', 'uploads/2.PNG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `uploads`
--

CREATE TABLE `uploads` (
  `upload_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `uploads`
--

INSERT INTO `uploads` (`upload_id`, `order_id`, `file_path`, `uploaded_at`) VALUES
(13, 36, 'uploads/completed/Tutorial_Membuat_Game_Obby_Tower_Of_Hell (1).docx', '2024-12-11 09:48:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `created_at`) VALUES
(1, 'farhan', '$2y$10$jNMzuEDAhl/QOQPuFKrf2OToYeIQ5LO2hea2fySDcWsPwPixXH24i', 'farhan@gmail.com', 'Farhan Rizki Maulana', '2024-11-12 19:03:28'),
(2, 'riziq', '$2y$10$..sEMmvrOSSel1NWXfKUu.yROmAXbaUNcqgTa50Aj2q3KjGRVoGRW', 'farhanriziq@gmail.com', 'Farhan Riziq', '2024-11-13 03:43:42'),
(3, 'fahad', '$2y$10$rz40f1RctFtRNh4BXp7uWuXVEOcTtyo1jyy18QrBIh17PAJB0176C', 'fahad@gmail.com', 'Fahad Abdul Aziz', '2024-11-13 03:56:59'),
(4, 'test', '$2y$10$0uOdz8dSkyZqgnplpzY7OeSHGZbNmo2gto1gaUh9kPli.k.o3BtQC', 'test@gmail.com', 'testing', '2024-11-13 19:53:55'),
(5, 'wawan ', '$2y$10$.jjDeMgoSf1qF.24LmsH/e8j3mY9XTs6h1fPfjlQeuo9WS1VX.Jd2', 'wawan@gmail.com', 'Pure Name', '2024-11-13 20:12:07'),
(6, 'kobal kobel', '$2y$10$HbWbJJgNB59hrUKc3Deq4.xNifydJcmNW1ab.042ZXxf7jtnKBnC.', 'kobel@gmail.com', 'kobel', '2024-11-14 07:17:45'),
(7, 'wawans', '$2y$10$u7ika6eFvrXQNrEfnoi7aOQPRVdt4ZXicK3idxDBMPnYhoxes5et6', 'waw@gmail.com', 'waw', '2024-11-14 07:33:40'),
(8, 'maul', '$2y$10$BmdnAUqWS49DDDSaqwxTLugp9t9P9aP/EIOfK1CbJVVSWbCfdqq3G', 'maulana@gmail.com', 'Maulana', '2024-11-15 06:26:18'),
(9, 'isky', '$2y$10$JDtYvIpQC0mToyXl.0olqOTIwOvWmbhsTR0a7vKnzwl.ayPowkixS', 'isky@gmail.com', 'isky', '2024-12-10 07:23:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `book_details`
--
ALTER TABLE `book_details`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`chapter_id`),
  ADD KEY `fk_book_details` (`book_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chapter_id` (`chapter_id`);

--
-- Indeks untuk tabel `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`upload_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `book_details`
--
ALTER TABLE `book_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `chapters`
--
ALTER TABLE `chapters`
  MODIFY `chapter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `uploads`
--
ALTER TABLE `uploads`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `fk_book_details` FOREIGN KEY (`book_id`) REFERENCES `book_details` (`id`);

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`chapter_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
