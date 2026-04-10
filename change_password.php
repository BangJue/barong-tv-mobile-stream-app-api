<?php

error_reporting(0);
ini_set('display_errors', 0);

require_once('koneksi.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (empty($user_id) || empty($old_password) || empty($new_password)) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
        exit();
    }

    $cek = mysqli_query($con, "SELECT password FROM users WHERE id = '$user_id'");
    $row = mysqli_fetch_assoc($cek);

    if ($row) {
        if ($old_password == $row['password']) {
            
            $update = mysqli_query($con, "UPDATE users SET password = '$new_password' WHERE id = '$user_id'");
            
            if ($update) {
                echo json_encode(['status' => 'success', 'message' => 'Sandi berhasil diubah']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal update database']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sandi lama salah!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
}
?>