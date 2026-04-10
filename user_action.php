<?php


header('Content-Type: application/json');
require_once('koneksi.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($action == 'add_bookmark') {
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];

    
    $check = mysqli_query($con, "SELECT id FROM bookmarks WHERE user_id='$user_id' AND movie_id='$movie_id'");
    if (mysqli_num_rows($check) > 0) {
        sendResponse(false, "Film sudah ada di My List");
    } else {
        $insert = mysqli_query($con, "INSERT INTO bookmarks (user_id, movie_id) VALUES ('$user_id', '$movie_id')");
        if ($insert) sendResponse(true, "Berhasil ditambahkan ke My List");
        else sendResponse(false, "Gagal menambahkan");
    }
}


elseif ($action == 'get_bookmarks') {
    $user_id = $_GET['user_id'];
    $query = "SELECT m.* FROM bookmarks b 
              JOIN movies m ON b.movie_id = m.id 
              WHERE b.user_id = '$user_id' 
              ORDER BY b.id DESC";
    
    $sql = mysqli_query($con, $query);
    $data = [];
    while($row = mysqli_fetch_assoc($sql)) {
        $data[] = $row;
    }
    sendResponse(true, "List Bookmark", $data);
}



elseif ($action == 'save_history') {
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];
    $last_pos = $_POST['last_position']; 
    $duration = $_POST['total_duration'];

    
    $check = mysqli_query($con, "SELECT id FROM watch_history WHERE user_id='$user_id' AND movie_id='$movie_id'");
    
    if (mysqli_num_rows($check) > 0) {
        
        $query = "UPDATE watch_history SET last_position='$last_pos', last_watched=NOW() 
                  WHERE user_id='$user_id' AND movie_id='$movie_id'";
    } else {
        
        $query = "INSERT INTO watch_history (user_id, movie_id, last_position, total_duration) 
                  VALUES ('$user_id', '$movie_id', '$last_pos', '$duration')";
    }
    
    if (mysqli_query($con, $query)) sendResponse(true, "Progress disimpan");
    else sendResponse(false, "Gagal simpan progress");
}


elseif ($action == 'add_view') {
    $movie_id = $_POST['movie_id'];
    mysqli_query($con, "UPDATE movies SET view_count = view_count + 1 WHERE id = '$movie_id'");
    sendResponse(true, "View count bertambah");
}

else {
    sendResponse(false, "Action tidak valid");
}
?>