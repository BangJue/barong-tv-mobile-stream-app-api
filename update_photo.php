<?php

error_reporting(0);
ini_set('display_errors', 0);

include 'koneksi.php';
header('Content-Type: application/json');

$response = array();

$base_url = "http://(Your IP / HOST)/API_FILM_ULTIMATE/uploads/"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    
    if (isset($_FILES['profile_image']) && !empty($user_id)) {
        $file_name = $_FILES['profile_image']['name'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        
        // Buat nama unik
        $new_name = "profile_" . $user_id . "_" . time() . ".jpg";
        $target_dir = "uploads/";
        
        // Cek folder uploads
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $target_dir . $new_name)) {
            $full_url = $base_url . $new_name;
            
            // Update Database
            $sql = "UPDATE users SET photo_url = '$full_url' WHERE id = '$user_id'";
            if (mysqli_query($con, $sql)) {
                $response['status'] = 'success';
                $response['message'] = 'Foto berhasil diubah';
                $response['photo_url'] = $full_url;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Gagal update database';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal upload gambar ke folder';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'File atau User ID kosong';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid Request';
}

echo json_encode($response);
?>