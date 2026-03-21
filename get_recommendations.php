<?php
// File: get_recommendations.php
header('Content-Type: application/json');
require_once('koneksi.php');

if (!$con) {
    http_response_code(500);
    echo json_encode(['status' => false, 'message' => 'Koneksi Gagal']);
    exit();
}

// Ambil ID dan genre/kategori dari film yang sedang ditonton
$current_movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
$genre_id = isset($_GET['genre_id']) ? (int)$_GET['genre_id'] : 0;
// Anda bisa tambahkan category_id juga jika mau

if ($current_movie_id === 0 || $genre_id === 0) {
    echo json_encode(['status' => true, 'data' => []]); // Kembalikan array kosong jika data tidak valid
    exit();
}

// Query untuk mengambil film dengan genre_id yang sama,
// KECUALI film yang sedang ditonton, dan batasi hasilnya (misal: 10 film)
$query = "SELECT * FROM movies 
          WHERE genre_id = ? AND id != ? 
          ORDER BY rating DESC 
          LIMIT 10";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ii", $genre_id, $current_movie_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$movies = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Konversi tipe data agar konsisten
    $row['id'] = (int)$row['id'];
    $row['genre_id'] = (int)$row['genre_id'];
    $row['category_id'] = (int)$row['category_id'];
    $row['rating'] = (float)$row['rating'];
    $movies[] = $row;
}

mysqli_close($con);
echo json_encode(['status' => true, 'message' => 'Rekomendasi dimuat', 'data' => $movies]);

?>
