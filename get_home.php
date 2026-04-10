<?php


require_once('koneksi.php');
require_once('helpers.php');

if (!$con) {
    sendResponse(false, 'Koneksi database gagal.');
}


function getMasterData($connection, $tableName, $columnName, $orderBy = 'name ASC') {
    $data = [];
    $query = "SELECT id, $columnName AS name FROM $tableName ORDER BY $orderBy";
    $result = mysqli_query($connection, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row['id'] = (string)$row['id'];
            $data[] = $row;
        }
    }
    return $data;
}

$genres = getMasterData($con, 'genres', 'genre_name');
$categories = getMasterData($con, 'categories', 'category_name');
$years = getMasterData($con, 'years', 'name', 'name DESC');
$statuses = getMasterData($con, 'statuses', 'name');



$base_movie_query = "
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
";


$slides = [];
$result_slides = mysqli_query($con, $base_movie_query . " ORDER BY m.created_at DESC LIMIT 5");
if ($result_slides) {
    while($row = mysqli_fetch_assoc($result_slides)) {
        $slides[] = $row;
    }
}




$hot_movies = [];
$result_hot = mysqli_query($con, $base_movie_query . " ORDER BY m.rating DESC LIMIT 10");
if ($result_hot) {
    while($row = mysqli_fetch_assoc($result_hot)) { $hot_movies[] = $row; }
}


$popular_movies = [];
$result_popular = mysqli_query($con, $base_movie_query . " ORDER BY m.view_count DESC LIMIT 10");
if ($result_popular) {
    while($row = mysqli_fetch_assoc($result_popular)) { $popular_movies[] = $row; }
}


$latest_movies = [];
$result_latest = mysqli_query($con, $base_movie_query . " ORDER BY m.created_at DESC LIMIT 10");
if ($result_latest) {
    while($row = mysqli_fetch_assoc($result_latest)) { $latest_movies[] = $row; }
}


$vip_movies = [];
$result_vip = mysqli_query($con, $base_movie_query . " WHERE m.is_vip = 1 ORDER BY m.created_at DESC LIMIT 10");
if ($result_vip) {
    while($row = mysqli_fetch_assoc($result_vip)) { $vip_movies[] = $row; }
}


$special_recommendations = [];
$result_recs = mysqli_query($con, $base_movie_query . " ORDER BY m.rating DESC LIMIT 5");
if ($result_recs) {
    while($row = mysqli_fetch_assoc($result_recs)) { $special_recommendations[] = $row; }
}



$response_data = [
    
    'slides' => $slides,                                   
    'hot_movies' => $hot_movies,
    'popular_movies' => $popular_movies,
    'latest_movies' => $latest_movies,
    'vip_movies' => $vip_movies,
    'special_recommendations' => $special_recommendations,

    
    'genres' => $genres,
    'categories' => $categories,
    'years' => $years,
    'statuses' => $statuses
];

sendResponse(true, "Data home berhasil dimuat", $response_data);

mysqli_close($con);
?>

