<?php
header('Content-Type: application/json');
require_once('koneksi.php');

$query = "SELECT * FROM movies ORDER BY RAND() LIMIT 10";
$sql = mysqli_query($con, $query);
$result = array();
if ($sql) {
    while ($row = mysqli_fetch_assoc($sql)) { $result[] = $row; }
    echo json_encode(array('status' => true, 'data' => $result));
} else {
    echo json_encode(array('status' => false, 'message' => 'Failed'));
}
mysqli_close($con);
?>