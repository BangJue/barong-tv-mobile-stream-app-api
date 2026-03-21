-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 01:37 AM
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
-- Database: `db_streaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `user_id`, `movie_id`, `added_at`) VALUES
(7, 3, 1, '2025-12-16 14:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `slug`) VALUES
(1, 'Movies', 'movies'),
(2, 'TV Series', 'tv-series'),
(3, 'Anime', 'anime'),
(4, 'Shorts', 'shorts');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `user_id`, `movie_id`, `created_at`) VALUES
(1, 3, 1, '2025-12-15 23:42:23');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(50) DEFAULT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `genre_name`, `slug`) VALUES
(1, 'Action', 'action'),
(2, 'Drama', 'drama'),
(3, 'Horror', 'horror'),
(4, 'Comedy', 'comedy'),
(5, 'Sci-Fi', 'sci-fi');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `poster_url` varchar(500) NOT NULL,
  `banner_url` varchar(500) DEFAULT NULL,
  `video_url` varchar(500) NOT NULL,
  `trailer_url` varchar(500) DEFAULT NULL,
  `rating` double DEFAULT 0,
  `duration` varchar(20) DEFAULT NULL,
  `view_count` int(11) DEFAULT 0,
  `is_vip` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('movie','series','anime') DEFAULT 'movie',
  `year_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `genre_id`, `category_id`, `title`, `description`, `poster_url`, `banner_url`, `video_url`, `trailer_url`, `rating`, `duration`, `view_count`, `is_vip`, `created_at`, `type`, `year_id`, `status_id`) VALUES
(1, 1, 1, 'Pelangi di Mars', 'Seekor kelinci raksasa berhati lembut yang membalas dendam pada hewan pengerat jahat.', 'https://upload.wikimedia.org/wikipedia/commons/c/c5/Big_buck_bunny_poster_big.jpg', 'https://peach.blender.org/wp-content/uploads/title_anouncement.jpg?x11217', 'https://litter.catbox.moe/6hwj4l4e01g59sek.mp4', NULL, 4.8, '10m', 15000, 0, '2025-12-13 17:54:02', 'movie', 7, 1),
(2, 5, 3, 'Sintel', 'Seorang gadis berkelana mencari naganya yang hilang.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Sintel_poster.jpg/800px-Sintel_poster.jpg', 'https://durian.blender.org/wp-content/themes/durian/images/void_header.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4', NULL, 4.5, '15m', 23000, 0, '2025-12-13 17:54:02', 'movie', 4, 1),
(3, 5, 1, 'Tears of Steel', 'Sekelompok pejuang di Amsterdam mencoba menyelamatkan dunia dari robot.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Tears_of_Steel_poster.jpg/800px-Tears_of_Steel_poster.jpg', 'https://mango.blender.org/wp-content/uploads/2012/08/mango_s1.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4', NULL, 4.2, '12m', 8500, 1, '2025-12-13 17:54:02', 'movie', 4, 2),
(4, 2, 2, 'Elephants Dream', 'Kisah aneh dua karakter yang menjelajahi mesin raksasa.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Elephants_Dream_poster.jpg/800px-Elephants_Dream_poster.jpg', 'https://orange.blender.org/wp-content/themes/orange/images/media/gallery/s1_proog.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', NULL, 3.9, '11m', 5000, 0, '2025-12-13 17:54:02', 'movie', 3, 2),
(5, 4, 4, 'For Bigger Blazes', 'Video pendek demonstrasi Chromecast.', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerBlazes.jpg', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerBlazes.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', NULL, 4, '15s', 1200, 0, '2025-12-13 17:54:02', 'movie', 2, 3),
(6, 1, 4, 'For Bigger Escapes', 'Video pendek demonstrasi aksi.', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerEscapes.jpg', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerEscapes.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4', NULL, 4.7, '15s', 3400, 0, '2025-12-13 17:54:02', 'movie', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `user_rating` int(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `movie_id`, `parent_id`, `user_rating`, `comment`, `created_at`) VALUES
(1, 3, 1, 0, 4, 'aaa', '2025-12-15 03:34:28'),
(2, 3, 1, 1, 0, 'aa', '2025-12-15 03:34:36'),
(3, 3, 1, 0, 0, 'aaa', '2025-12-15 15:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Ongoing'),
(2, 'Tamat'),
(3, 'Hiatus');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo_url` varchar(500) DEFAULT NULL,
  `is_premium` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_vip` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `photo_url`, `is_premium`, `created_at`, `is_vip`) VALUES
(1, 'user@barong.com', 'e10adc3949ba59abbe56e057f20f883e', 'Barong User', 'https://ui-avatars.com/api/?name=Barong+User&background=random', 0, '2025-12-13 17:54:02', 0),
(2, 'vip@barong.com', '123', 'Sultan VIP', 'https://ui-avatars.com/api/?name=Sultan+VIP&background=FFD700&color=000000', 1, '2025-12-13 17:54:02', 1),
(5, 'barong@gmail.com', '123456', 'barong', 'https://litter.catbox.moe/rzgaqqq3w9z9w8rt.jpg', 0, '2025-12-16 15:58:43', 0);

-- --------------------------------------------------------

--
-- Table structure for table `watch_history`
--

CREATE TABLE `watch_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `last_position` int(11) DEFAULT 0,
  `total_duration` int(11) DEFAULT 0,
  `last_watched` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `name`) VALUES
(1, '2025'),
(2, '2024'),
(3, '2023'),
(4, '2022'),
(5, '2021'),
(6, '2020'),
(7, '2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_movie_bookmark` (`user_id`,`movie_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_download` (`user_id`,`movie_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`genre_id`),
  ADD KEY `fk_movies_years` (`year_id`),
  ADD KEY `fk_movies_statuses` (`status_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `watch_history`
--
ALTER TABLE `watch_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `watch_history`
--
ALTER TABLE `watch_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `fk_movies_statuses` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `fk_movies_years` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
