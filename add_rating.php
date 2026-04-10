<?php

header('Content-Type: application/json');
require_once('koneksi.php');

if (!$con) {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Koneksi Gagal']);
    exit();
}

$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$movie_id = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

if ($user_id === 0 || $movie_id === 0 || $rating < 1 || $rating > 5) {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Data tidak valid.']);
    exit();
}


$query = "INSERT INTO reviews (user_id, movie_id, user_rating, comment) VALUES (?, ?, ?, '') 
          ON DUPLICATE KEY UPDATE user_rating = VALUES(user_rating)";


$check_query = "SELECT id FROM reviews WHERE user_id = ? AND movie_id = ?";
$stmt_check = mysqli_prepare($con, $check_query);
mysqli_stmt_bind_param($stmt_check, "ii", $user_id, $movie_id);
mysqli_stmt_execute($stmt_check);
$result = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result) > 0) {
    
    $row = mysqli_fetch_assoc($result);
    $review_id = $row['id'];
    $update_query = "UPDATE reviews SET user_rating = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt_update, "ii", $rating, $review_id);
    $success = mysqli_stmt_execute($stmt_update);
} else {
    
    $insert_query = "INSERT INTO reviews (user_id, movie_id, user_rating, comment) VALUES (?, ?, ?, NULL)";
    $stmt_insert = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $movie_id, $rating);
    $success = mysqli_stmt_execute($stmt_insert);
}

if($success){
    echo json_encode(['status' => true, 'message' => 'Rating berhasil disimpan']);
} else {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Gagal menyimpan rating']);
}

mysqli_close($con);
?>
