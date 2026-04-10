<?php

require_once('koneksi.php');
header('Content-Type: application/json');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($con, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        
        $is_vip = intval($row['is_vip']);
        
        echo json_encode([
            'status' => true,
            'data' => [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'photo_url' => $row['photo_url'],
                'is_vip' => $is_vip 
            ]
        ]);
    } else {
        echo json_encode(['status' => false, 'message' => 'User tidak ditemukan']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'User ID diperlukan']);
}
?>