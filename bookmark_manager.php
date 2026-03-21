<?php
/*
 * File: bookmark_manager.php
 * Fungsi: Pusat untuk semua aksi terkait bookmark (koleksi).
 * Actions: "add", "remove", "check", "get_all".
 * PERBAIKAN FINAL: Menggunakan metode POST untuk semua aksi demi konsistensi.
 */

require_once('koneksi.php');
require_once('helpers.php'); // WAJIB

// Cek koneksi ke database terlebih dahulu
if (!$con) {
    sendResponse(false, 'Koneksi ke database gagal. Periksa file koneksi.php.');
}

// Hanya terima request dengan metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Metode request salah, seharusnya POST.');
}

// Ambil 'action' dari parameter URL (misal: bookmark_manager.php?action=add)
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Validasi dasar: user_id dan movie_id dibutuhkan untuk hampir semua aksi
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$movie_id = isset($_POST['movie_id']) ? $_POST['movie_id'] : null;

if (in_array($action, ['add', 'remove', 'check', 'get_all']) && !$user_id) {
    sendResponse(false, 'Parameter user_id dibutuhkan.');
}
if (in_array($action, ['add', 'remove', 'check']) && !$movie_id) {
    sendResponse(false, 'Parameter movie_id dibutuhkan.');
}


switch ($action) {

    // ===============================================
    // ACTION: Menambah film ke koleksi
    // ===============================================
    case 'add':
        // Cek dulu apakah sudah ada, agar tidak duplikat
        $check_stmt = mysqli_prepare($con, "SELECT id FROM bookmarks WHERE user_id = ? AND movie_id = ?");
        mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $movie_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            sendResponse(false, "Film ini sudah ada di koleksi Anda.");
        } else {
            // Jika belum ada, masukkan data baru
            $insert_stmt = mysqli_prepare($con, "INSERT INTO bookmarks (user_id, movie_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $movie_id);
            if (mysqli_stmt_execute($insert_stmt)) {
                sendResponse(true, "Berhasil ditambahkan ke koleksi!");
            } else {
                sendResponse(false, "Gagal menambahkan ke koleksi: " . mysqli_error($con));
            }
        }
        break;

    // ===============================================
    // ACTION: Menghapus film dari koleksi
    // ===============================================
    case 'remove':
        $delete_stmt = mysqli_prepare($con, "DELETE FROM bookmarks WHERE user_id = ? AND movie_id = ?");
        mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $movie_id);
        if (mysqli_stmt_execute($delete_stmt)) {
            sendResponse(true, "Berhasil dihapus dari koleksi.");
        } else {
            sendResponse(false, "Gagal menghapus dari koleksi: " . mysqli_error($con));
        }
        break;

    // ===============================================
    // ACTION: Memeriksa status satu film
    // ===============================================
    case 'check':
        $check_stmt = mysqli_prepare($con, "SELECT id FROM bookmarks WHERE user_id = ? AND movie_id = ?");
        mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $movie_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        $is_bookmarked = (mysqli_stmt_num_rows($check_stmt) > 0);

        // Kirim respons dalam format yang berbeda sedikit, khusus untuk 'check'
        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'is_bookmarked' => $is_bookmarked]);
        exit; // Hentikan skrip setelah mengirim respons
        break;

    // ===============================================
    // ACTION: Mengambil semua film dalam koleksi
    // ===============================================
    case 'get_all':
        // Query untuk mengambil SEMUA film yang di-bookmark oleh user
        // Menggunakan JOIN antara tabel 'bookmarks' dan 'movies'
        $query = "SELECT m.* FROM movies m 
                  JOIN bookmarks b ON m.id = b.movie_id 
                  WHERE b.user_id = ? 
                  ORDER BY b.created_at DESC";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            sendResponse(false, "Query gagal: " . mysqli_error($con));
        }

        $bookmarked_movies = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $bookmarked_movies[] = $row;
        }

        sendResponse(true, "Data koleksi berhasil dimuat", $bookmarked_movies);
        break;

    // ===============================================
    // Jika action tidak dikenali
    // ===============================================
    default:
        sendResponse(false, "Action tidak valid. Gunakan 'add', 'remove', 'check', atau 'get_all'.");
        break;
}

mysqli_close($con);
?>
