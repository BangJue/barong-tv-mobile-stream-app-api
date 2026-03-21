<?php
/*
 * File: reviews.php (VERSI FINAL DIPERBAIKI)
 * Fungsi: Mengambil komentar film & Posting komentar baru.
 * Ditingkatkan dengan Prepared Statements untuk keamanan.
 */

require_once('koneksi.php');
require_once('helpers.php'); // WAJIB: Memanggil file yang berisi fungsi sendResponse()

// Cek apakah koneksi database berhasil dibuat
if (!$con) {
    sendResponse(false, 'Koneksi ke database gagal. Periksa file koneksi.php');
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'get_reviews':
        if (!isset($_GET['movie_id'])) {
            sendResponse(false, 'Parameter movie_id dibutuhkan.');
        }
        $movie_id = $_GET['movie_id'];
        
        // Ambil data review & data user yang relevan menggunakan JOIN
        $query = "SELECT r.id, r.user_id, r.user_rating, r.comment, r.created_at, u.name, u.photo_url
                  FROM reviews r
                  JOIN users u ON r.user_id = u.id
                  WHERE r.movie_id = ?
                  ORDER BY r.created_at DESC";
        
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $movie_id); // 'i' untuk integer
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $reviews = [];
        while($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
        
        sendResponse(true, "List Reviews berhasil dimuat", $reviews);
        break;

    case 'post_review':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            sendResponse(false, 'Metode request salah, seharusnya POST.');
        }
        
        // Ambil dan validasi input dari POST
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
        $movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : null;
        $rating = isset($_POST['rating']) ? $_POST['rating'] : null;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        if ($user_id === null || $movie_id === null || $rating === null) {
            sendResponse(false, 'Parameter user_id, movie_id, dan rating dibutuhkan.');
        }

        // Masukkan review baru menggunakan Prepared Statements
        $query_insert = "INSERT INTO reviews (user_id, movie_id, user_rating, comment) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "iiis", $user_id, $movie_id, $rating, $comment);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            // Jika berhasil, update rating rata-rata di tabel movies (opsional tapi fitur bagus)
            $stmt_update = mysqli_prepare($con, "UPDATE movies SET rating = (SELECT AVG(user_rating) FROM reviews WHERE movie_id = ?) WHERE id = ?");
            mysqli_stmt_bind_param($stmt_update, "ii", $movie_id, $movie_id);
            mysqli_stmt_execute($stmt_update);
            
            sendResponse(true, "Review Anda berhasil dikirim!");
        } else {
            sendResponse(false, "Server gagal mengirim review: " . mysqli_error($con));
        }
        break;

    default:
        sendResponse(false, "Action tidak valid atau tidak diberikan. (Contoh: ?action=get_reviews)");
        break;
}

mysqli_close($con);
?>
