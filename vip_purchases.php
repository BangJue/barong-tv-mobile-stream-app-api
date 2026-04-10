<?php
require_once 'db_connect.php'; 
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $user_id = $_POST['user_id'];

    if (empty($user_id)) {
        echo json_encode(['status' => false, 'message' => 'User ID required']);
        exit();
    }

    
    $query = "UPDATE users SET is_vip = 1 WHERE id = '$user_id'";
    
    if (mysqli_query($con, $query)) {
        echo json_encode([
            'status' => true, 
            'message' => 'Selamat! Anda sekarang Premium VIP.',
            'is_vip' => true
        ]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal update database']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Invalid Request']);
}
?>