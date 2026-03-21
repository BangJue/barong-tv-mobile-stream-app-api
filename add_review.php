<?php
// File: add_review.php (VERSI BARU UNTUK KOMENTAR & BALASAN)
header('Content-Type: application/json');
require_once('koneksi.php');

if (!$con) {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Koneksi Database Gagal']);
    exit();
}

// parent_id bersifat opsional. Jika tidak ada, default-nya 0 (komentar utama)
$parent_id = isset($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0; 
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$movie_id = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($user_id === 0 || $movie_id === 0 || empty($comment)) {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Komentar tidak boleh kosong.']);
    exit();
}

// Masukkan komentar baru. Rating tidak diurus di sini lagi.
// Jika parent_id = 0, ini adalah komentar utama. Jika > 0, ini adalah balasan.
$query = "INSERT INTO reviews (user_id, movie_id, parent_id, comment, user_rating) VALUES (?, ?, ?, ?, 0)";

$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "iiis", $user_id, $movie_id, $parent_id, $comment);
    if(mysqli_stmt_execute($stmt)){
        echo json_encode(['status' => true, 'message' => 'Komentar berhasil dikirim']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => false, 'message' => 'Gagal mengirim komentar']);
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Query Gagal Disiapkan']);
}

mysqli_close($con);
?>
