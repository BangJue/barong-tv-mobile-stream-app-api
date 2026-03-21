<?php
header('Content-Type: application/json');
require_once('koneksi.php');

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

$query = "SELECT m.*, h.last_position, h.total_duration 
          FROM watch_history h 
          JOIN movies m ON h.movie_id = m.id 
          WHERE h.user_id = '$user_id' 
          ORDER BY h.last_watched DESC";

$sql = mysqli_query($con, $query);
$result = array();

if ($sql) {
    while ($row = mysqli_fetch_assoc($sql)) {
        $result[] = $row;
    }
    echo json_encode(array('status' => true, 'data' => $result));
} else {
    echo json_encode(array('status' => false, 'message' => 'Failed'));
}
mysqli_close($con);
?>