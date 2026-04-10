<?php

error_reporting(0); 
ini_set('display_errors', 0);

require_once('koneksi.php');
header('Content-Type: application/json');

$response = array();


if (!$con) {
    echo json_encode(['status' => false, 'message' => 'Koneksi Database Gagal']);
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'register') {
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(['status' => false, 'message' => 'Data tidak boleh kosong']);
        exit();
    }

    
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['status' => false, 'message' => 'Email sudah terdaftar!']);
    } else {
        
        $query = "INSERT INTO users (name, email, password, photo_url, is_vip) VALUES ('$name', '$email', '$password', '', 0)";
        
        if (mysqli_query($con, $query)) {
            echo json_encode(['status' => true, 'message' => 'Daftar Berhasil! Silakan Login.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal Mendaftar']);
        }
    }

} else if ($action == 'login') {
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => false, 'message' => 'Email dan Password wajib diisi']);
        exit();
    }

    
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        
        
        if ($password == $user['password']) {
            
            
            echo json_encode([
                'status' => true,
                'message' => 'Login Berhasil',
                'data' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'photo_url' => $user['photo_url'],
                    'is_vip' => $user['is_vip']
                ]
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Kata sandi salah!']);
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Email tidak ditemukan!']);
    }

} else {
    echo json_encode(['status' => false, 'message' => 'Action tidak valid']);
}
?>