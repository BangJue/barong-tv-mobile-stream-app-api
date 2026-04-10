<?php


require_once('koneksi.php');
require_once('helpers.php'); 

if (!$con) {
    sendResponse(false, 'Koneksi DB Gagal');
    exit();
}

$params = [];
$types = '';
$base_query = "
    SELECT 
        m.id, m.title, m.description, m.poster_url, m.banner_url, m.video_url, 
        m.rating, m.duration, m.view_count, m.is_vip, m.status_id, m.year_id,
        m.rating_count, -- <<< INI BAGIAN PENTING YANG HILANG
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
";

$where_clauses = [];


if (isset($_GET['id'])) {
    $where_clauses[] = "m.id = ?";
    $params[] = $_GET['id'];
    $types .= 'i';
}





if (!empty($where_clauses)) {
    $base_query .= " WHERE " . implode(' AND ', $where_clauses);
}


$base_query .= " LIMIT 25"; 

$stmt = mysqli_prepare($con, $base_query);

if ($stmt) {
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $movies = [];
    while ($row = mysqli_fetch_assoc($result)) {
        
        $row['id'] = (string)$row['id'];
        $row['rating'] = (float)$row['rating'];
        $row['rating_count'] = (int)$row['rating_count']; 
        $row['view_count'] = (int)$row['view_count'];
        $row['is_vip'] = (bool)$row['is_vip'];
        $movies[] = $row;
    }
    
    sendResponse(true, 'Data film berhasil dimuat', $movies);
    mysqli_stmt_close($stmt);
} else {
    sendResponse(false, 'Query gagal disiapkan: ' . mysqli_error($con));
}

mysqli_close($con);
?>
