<?php
// 1. SETTING ERROR HANDLING & HEADER
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

// 2. KONEKSI DATABASE
require_once('koneksi.php');

if (!$con) {
    echo json_encode(['status' => false, 'message' => 'DB Connection Failed']);
    exit();
}

// 3. AMBIL PARAMETER (Prioritas POST)
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : (isset($_GET['user_id']) ? $_GET['user_id'] : '');
$movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : (isset($_GET['movie_id']) ? $_GET['movie_id'] : '');

// --- LOGIKA UTAMA ---

if ($action == 'get_all') {
    if (empty($user_id)) {
        echo json_encode(['status' => false, 'message' => 'User ID kosong']);
        exit();
    }

    // PERBAIKAN: 
    // 1. Menggunakan 'b.added_at' (sesuai DB), bukan 'created_at'.
    // 2. Melakukan LEFT JOIN ke tabel genres, categories, years, statuses agar data lengkap.
    
    $query = "SELECT 
                m.id, 
                m.title, 
                m.description,
                m.poster_url, 
                m.banner_url, 
                m.video_url,
                m.rating, 
                m.view_count,
                m.duration,
                m.is_vip,
                g.genre_name,
                c.category_name,
                y.name AS year_name,
                s.name AS status_name
              FROM bookmarks b 
              JOIN movies m ON b.movie_id = m.id 
              LEFT JOIN genres g ON m.genre_id = g.id
              LEFT JOIN categories c ON m.category_id = c.id
              LEFT JOIN years y ON m.year_id = y.id
              LEFT JOIN statuses s ON m.status_id = s.id
              WHERE b.user_id = '$user_id' 
              ORDER BY b.added_at DESC"; // <--- INI KUNCI PERBAIKANNYA (added_at)
              
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $movies = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Kita kirim DUA format nama agar Android pasti bisa baca salah satunya
            $movies[] = [
                'id' => (string)$row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                
                // VERSI 1: CamelCase (posterUrl)
                'posterUrl' => $row['poster_url'],
                'bannerUrl' => $row['banner_url'],
                'videoUrl' => $row['video_url'],
                
                // VERSI 2: Snake Case (poster_url) - Sesuai Database
                'poster_url' => $row['poster_url'],
                'banner_url' => $row['banner_url'],
                'video_url' => $row['video_url'],

                'rating' => (double)$row['rating'],
                'viewCount' => (int)$row['view_count'], // CamelCase
                'view_count' => (int)$row['view_count'], // Snake Case
                
                'duration' => $row['duration'],
                'isVip' => (bool)$row['is_vip'],
                'genreName' => $row['genre_name'],
                'categoryName' => $row['category_name'],
                'yearName' => $row['year_name'],
                'statusName' => $row['status_name']
            ];
        }

        echo json_encode(['status' => true, 'message' => 'Data ditemukan', 'data' => $movies]);
    } else {
        // Tampilkan error SQL jika ada
        echo json_encode(['status' => false, 'message' => 'SQL Error: ' . mysqli_error($con)]);
    }
} 

elseif ($action == 'add') {
    if (empty($user_id) || empty($movie_id)) {
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        exit();
    }
    
    // Cek duplikat
    $check = mysqli_query($con, "SELECT id FROM bookmarks WHERE user_id='$user_id' AND movie_id='$movie_id'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['status' => false, 'message' => 'Sudah ada di koleksi']);
        exit();
    }

    // PERBAIKAN: Ganti 'created_at' menjadi 'added_at'
    $insert = mysqli_query($con, "INSERT INTO bookmarks (user_id, movie_id, added_at) VALUES ('$user_id', '$movie_id', NOW())");
    
    if ($insert) {
        echo json_encode(['status' => true, 'message' => 'Berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal DB: ' . mysqli_error($con)]);
    }
} 

elseif ($action == 'remove') {
    $delete = mysqli_query($con, "DELETE FROM bookmarks WHERE user_id='$user_id' AND movie_id='$movie_id'");
    if ($delete) {
        echo json_encode(['status' => true, 'message' => 'Dihapus dari koleksi']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal hapus']);
    }
}

elseif ($action == 'check') {
    $check = mysqli_query($con, "SELECT id FROM bookmarks WHERE user_id='$user_id' AND movie_id='$movie_id'");
    $isBookmarked = mysqli_num_rows($check) > 0;
    echo json_encode(['status' => true, 'is_bookmarked' => $isBookmarked]);
}

else {
    echo json_encode(['status' => false, 'message' => 'Action tidak valid: ' . $action]);
}
?>