<?php

require_once('koneksi.php');
require_once('helpers.php');

if (!$con) {
    sendResponse(false, 'Koneksi database gagal.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Metode request salah, seharusnya POST.');
}

$query = "
    SELECT
        m.*,
        g.genre_name,
        c.category_name,
        y.name AS year_name,
        s.name AS status_name
    FROM
        movies m
    LEFT JOIN genres g ON m.genre_id = g.id
    LEFT JOIN categories c ON m.category_id = c.id
    LEFT JOIN years y ON m.year_id = y.id
    LEFT JOIN statuses s ON m.status_id = s.id
    WHERE 1
";

$params = [];
$types = "";


if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search_term = '%' . $_POST['search'] . '%';
    $query .= " AND m.title LIKE ?";
    $params[] = $search_term;
    $types .= "s";
}
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $query .= " AND m.id = ?";
    $params[] = $_POST['id'];
    $types .= "i";
}
if (isset($_POST['genre_id']) && !empty($_POST['genre_id'])) {
    $query .= " AND m.genre_id = ?";
    $params[] = $_POST['genre_id'];
    $types .= "i";
}
if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
    $query .= " AND m.category_id = ?";
    $params[] = $_POST['category_id'];
    $types .= "i";
}
if (isset($_POST['year_id']) && !empty($_POST['year_id'])) {
    $query .= " AND m.year_id = ?";
    $params[] = $_POST['year_id'];
    $types .= "i";
}
if (isset($_POST['status_id']) && !empty($_POST['status_id'])) {
    $query .= " AND m.status_id = ?";
    $params[] = $_POST['status_id'];
    $types .= "i";
}
if (isset($_POST['is_vip']) && $_POST['is_vip'] == '1') {
    $query .= " AND m.is_vip = 1";
}


$orderBy = " ORDER BY m.created_at DESC";
if (isset($_POST['sort'])) {
    switch ($_POST['sort']) {
        case 'rating':
            $orderBy = " ORDER BY m.rating DESC";
            break;
        case 'views':
            $orderBy = " ORDER BY m.view_count DESC"; 
            break;
        case 'latest':
            break;
    }
}
$query .= $orderBy;


$stmt = mysqli_prepare($con, $query);
if (!$stmt) { sendResponse(false, "Query prepare gagal: " . mysqli_error($con)); }
if (!empty($params)) { mysqli_stmt_bind_param($stmt, $types, ...$params); }
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (!$result) { sendResponse(false, "Eksekusi query gagal: " . mysqli_error($con)); }

$movies = [];
while ($row = mysqli_fetch_assoc($result)) {
    $current_movie_id = $row['id'];

    
    
    
    $rating_query = "SELECT AVG(user_rating) as rating, COUNT(user_rating) as rating_count FROM reviews WHERE movie_id = ? AND user_rating > 0";
    $rating_stmt = mysqli_prepare($con, $rating_query);
    mysqli_stmt_bind_param($rating_stmt, "i", $current_movie_id);
    mysqli_stmt_execute($rating_stmt);
    $rating_result = mysqli_stmt_get_result($rating_stmt);
    $rating_data = mysqli_fetch_assoc($rating_result);
    mysqli_stmt_close($rating_stmt);

    
    $row['rating'] = (float)($rating_data['rating'] ?? 0); 
    $row['rating_count'] = (int)($rating_data['rating_count'] ?? 0);
    

    $movies[] = $row;
}
sendResponse(true, "Data film berhasil dimuat", $movies);

mysqli_close($con);
?>
