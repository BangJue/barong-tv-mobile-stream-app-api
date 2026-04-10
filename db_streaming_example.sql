-- =========================================
-- CLEAN DATABASE: db_streaming
-- Safe for Public Repository
-- =========================================

CREATE DATABASE IF NOT EXISTS db_streaming;
USE db_streaming;

-- ========================
-- USERS (SAFE)
-- ========================
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
name VARCHAR(100) NOT NULL,
photo_url VARCHAR(500) DEFAULT NULL,
is_premium TINYINT(1) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
is_vip INT DEFAULT 0
);

-- Dummy User (SAFE)
INSERT INTO users (email, password, name, photo_url, is_premium, is_vip)
VALUES (
'[demo@streaming.com](mailto:demo@streaming.com)',
'123456',
'Demo User',
'https://ui-avatars.com/api/?name=Demo+User',
0,
0
);

-- ========================
-- GENRES
-- ========================
CREATE TABLE genres (
id INT AUTO_INCREMENT PRIMARY KEY,
genre_name VARCHAR(50),
slug VARCHAR(50) NOT NULL
);

INSERT INTO genres (genre_name, slug) VALUES
('Action','action'),
('Drama','drama'),
('Horror','horror'),
('Comedy','comedy'),
('Sci-Fi','sci-fi');

-- ========================
-- CATEGORIES
-- ========================
CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
category_name VARCHAR(50) NOT NULL,
slug VARCHAR(50) NOT NULL
);

INSERT INTO categories (category_name, slug) VALUES
('Movies','movies'),
('TV Series','tv-series'),
('Anime','anime'),
('Shorts','shorts');

-- ========================
-- YEARS
-- ========================
CREATE TABLE years (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50) NOT NULL
);

INSERT INTO years (name) VALUES
('2025'),('2024'),('2023'),('2022'),('2021'),('2020'),('2019');

-- ========================
-- STATUS
-- ========================
CREATE TABLE statuses (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50) NOT NULL
);

INSERT INTO statuses (name) VALUES
('Ongoing'),
('Completed'),
('Hiatus');

-- ========================
-- MOVIES (DEMO DATA)
-- ========================
CREATE TABLE movies (
id INT AUTO_INCREMENT PRIMARY KEY,
genre_id INT,
category_id INT DEFAULT 1,
title VARCHAR(255) NOT NULL,
description TEXT NOT NULL,
poster_url VARCHAR(500) NOT NULL,
banner_url VARCHAR(500),
video_url VARCHAR(500) NOT NULL,
trailer_url VARCHAR(500),
rating DOUBLE DEFAULT 0,
duration VARCHAR(20),
view_count INT DEFAULT 0,
is_vip TINYINT(1) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
type ENUM('movie','series','anime') DEFAULT 'movie',
year_id INT,
status_id INT
);

INSERT INTO `movies` (`id`, `genre_id`, `category_id`, `title`, `description`, `poster_url`, `banner_url`, `video_url`, `trailer_url`, `rating`, `duration`, `view_count`, `is_vip`, `created_at`, `type`, `year_id`, `status_id`) VALUES
(1, 1, 1, 'Pelangi di Mars', 'Seekor kelinci raksasa berhati lembut yang membalas dendam pada hewan pengerat jahat.', 'https://upload.wikimedia.org/wikipedia/commons/c/c5/Big_buck_bunny_poster_big.jpg', 'https://peach.blender.org/wp-content/uploads/title_anouncement.jpg?x11217', 'https://litter.catbox.moe/6hwj4l4e01g59sek.mp4', NULL, 4.8, '10m', 15000, 0, '2025-12-13 17:54:02', 'movie', 7, 1),
(2, 5, 3, 'Sintel', 'Seorang gadis berkelana mencari naganya yang hilang.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Sintel_poster.jpg/800px-Sintel_poster.jpg', 'https://durian.blender.org/wp-content/themes/durian/images/void_header.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4', NULL, 4.5, '15m', 23000, 0, '2025-12-13 17:54:02', 'movie', 4, 1),
(3, 5, 1, 'Tears of Steel', 'Sekelompok pejuang di Amsterdam mencoba menyelamatkan dunia dari robot.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Tears_of_Steel_poster.jpg/800px-Tears_of_Steel_poster.jpg', 'https://mango.blender.org/wp-content/uploads/2012/08/mango_s1.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4', NULL, 4.2, '12m', 8500, 1, '2025-12-13 17:54:02', 'movie', 4, 2),
(4, 2, 2, 'Elephants Dream', 'Kisah aneh dua karakter yang menjelajahi mesin raksasa.', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Elephants_Dream_poster.jpg/800px-Elephants_Dream_poster.jpg', 'https://orange.blender.org/wp-content/themes/orange/images/media/gallery/s1_proog.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4', NULL, 3.9, '11m', 5000, 0, '2025-12-13 17:54:02', 'movie', 3, 2),
(5, 4, 4, 'For Bigger Blazes', 'Video pendek demonstrasi Chromecast.', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerBlazes.jpg', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerBlazes.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4', NULL, 4, '15s', 1200, 0, '2025-12-13 17:54:02', 'movie', 2, 3),
(6, 1, 4, 'For Bigger Escapes', 'Video pendek demonstrasi aksi.', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerEscapes.jpg', 'https://storage.googleapis.com/gtv-videos-bucket/sample/images/ForBiggerEscapes.jpg', 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4', NULL, 4.7, '15s', 3400, 0, '2025-12-13 17:54:02', 'movie', 2, 3);

-- ========================
-- REVIEWS
-- ========================
CREATE TABLE reviews (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
movie_id INT,
parent_id INT DEFAULT 0,
user_rating INT DEFAULT 0,
comment TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- BOOKMARKS
-- ========================
CREATE TABLE bookmarks (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
movie_id INT,
added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY user_movie_bookmark (user_id, movie_id)
);

-- ========================
-- DOWNLOADS
-- ========================
CREATE TABLE downloads (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
movie_id INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
UNIQUE KEY unique_download (user_id, movie_id)
);

-- ========================
-- WATCH HISTORY
-- ========================
CREATE TABLE watch_history (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
movie_id INT,
last_position INT DEFAULT 0,
total_duration INT DEFAULT 0,
last_watched TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================
-- FOREIGN KEYS
-- ========================
ALTER TABLE movies
ADD CONSTRAINT fk_movies_years FOREIGN KEY (year_id) REFERENCES years(id),
ADD CONSTRAINT fk_movies_statuses FOREIGN KEY (status_id) REFERENCES statuses(id);
