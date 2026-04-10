<?php

error_reporting(0);
ini_set('display_errors', 0);

require_once 'koneksi.php';
header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($user_id) && !empty($name) && !empty($email)) {
        
        
        $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$user_id'";
        
        if (mysqli_query($con, $sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Profil berhasil diperbarui';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal update: ' . mysqli_error($con);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Form tidak boleh kosong';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid Request';
}

echo json_encode($response);
?>