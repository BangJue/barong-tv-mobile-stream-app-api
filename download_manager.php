<?php
error_reporting(0);
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

require_once('koneksi.php');

if (!$con) {
    echo json_encode(['status' => false, 'message' => 'DB Connection Failed']);
    exit();
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : '';



if ($action == 'get_all') {
    if (empty($user_id)) {
        echo json_encode(['status' => false, 'message' => 'User ID required']);
        exit();
    }

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
              FROM downloads d
              JOIN movies m ON d.movie_id = m.id 
              LEFT JOIN genres g ON m.genre_id = g.id
              LEFT JOIN categories c ON m.category_id = c.id
              LEFT JOIN years y ON m.year_id = y.id
              LEFT JOIN statuses s ON m.status_id = s.id
              WHERE d.user_id = '$user_id' 
              ORDER BY d.created_at DESC";
              
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $movies = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $movies[] = [
                'id' => (string)$row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                
                'posterUrl' => $row['poster_url'],
                'poster_url' => $row['poster_url'],
                'bannerUrl' => $row['banner_url'],
                'videoUrl' => $row['video_url'],
                'rating' => (double)$row['rating'],
                'viewCount' => (int)$row['view_count'],
                'duration' => $row['duration'],
                'isVip' => (bool)$row['is_vip'],
                'genreName' => $row['genre_name'],
                'categoryName' => $row['category_name'],
                'yearName' => $row['year_name'],
                'statusName' => $row['status_name']
            ];
        }
        echo json_encode(['status' => true, 'message' => 'Data found', 'data' => $movies]);
    } else {
        echo json_encode(['status' => false, 'message' => 'SQL Error: ' . mysqli_error($con)]);
    }
} 

elseif ($action == 'add') {
    if (empty($user_id) || empty($movie_id)) {
        echo json_encode(['status' => false, 'message' => 'Data incomplete']);
        exit();
    }
    
    
    $check = mysqli_query($con, "SELECT id FROM downloads WHERE user_id='$user_id' AND movie_id='$movie_id'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['status' => false, 'message' => 'Film ini sudah diunduh sebelumnya.']);
        exit();
    }

    $insert = mysqli_query($con, "INSERT INTO downloads (user_id, movie_id, created_at) VALUES ('$user_id', '$movie_id', NOW())");
    
    if ($insert) {
        echo json_encode(['status' => true, 'message' => 'Berhasil diunduh (Tersimpan di Akun)']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal DB: ' . mysqli_error($con)]);
    }
} 



elseif ($action == 'remove') {
    if (empty($user_id) || empty($movie_id)) {
        echo json_encode(['status' => false, 'message' => 'Data incomplete']);
        exit();
    }

    $delete = mysqli_query($con, "DELETE FROM downloads WHERE user_id='$user_id' AND movie_id='$movie_id'");
    
    if ($delete) {
        echo json_encode(['status' => true, 'message' => 'Unduhan dihapus']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal hapus DB']);
    }
}


else {
    echo json_encode(['status' => false, 'message' => 'Invalid action']);
}
?>