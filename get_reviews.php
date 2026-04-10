<?php

header('Content-Type: application/json');
require_once('koneksi.php');

if (!$con) {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Koneksi Database Gagal', 'data' => []]);
    exit();
}

$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
if ($movie_id === 0) {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Movie ID tidak valid', 'data' => []]);
    exit();
}

$query_main = "SELECT r.id, r.user_rating, r.comment, r.created_at, u.name as user_name, u.photo_url as user_photo 
               FROM reviews r 
               JOIN users u ON r.user_id = u.id 
               WHERE r.movie_id = ? AND r.parent_id = 0 AND r.comment IS NOT NULL
               ORDER BY r.created_at DESC";

$stmt_main = mysqli_prepare($con, $query_main);
mysqli_stmt_bind_param($stmt_main, "i", $movie_id);
mysqli_stmt_execute($stmt_main);
$result_main = mysqli_stmt_get_result($stmt_main);

$reviews = [];
while ($row_main = mysqli_fetch_assoc($result_main)) {
    $comment_id = $row_main['id'];
    
    
    $query_replies = "SELECT r.id, r.comment, r.created_at, u.name as user_name, u.photo_url as user_photo 
                      FROM reviews r 
                      JOIN users u ON r.user_id = u.id 
                      WHERE r.parent_id = ?
                      ORDER BY r.created_at ASC"; 

    $stmt_replies = mysqli_prepare($con, $query_replies);
    mysqli_stmt_bind_param($stmt_replies, "i", $comment_id);
    mysqli_stmt_execute($stmt_replies);
    $result_replies = mysqli_stmt_get_result($stmt_replies);

    $replies = [];
    while ($row_reply = mysqli_fetch_assoc($result_replies)) {
        $replies[] = $row_reply;
    }
    
    
    $row_main['replies'] = $replies;
    $reviews[] = $row_main;
}

echo json_encode(['status' => true, 'message' => 'Review berhasil dimuat', 'data' => $reviews]);

mysqli_stmt_close($stmt_main);
mysqli_close($con);
?>
