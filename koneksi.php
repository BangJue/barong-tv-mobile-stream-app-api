<?php
// File: koneksi.php (Versi Final)
// Tugas file ini HANYA untuk membuat koneksi ke database dan menyediakannya
// dalam variabel $con. Tidak boleh ada output (echo/print) sama sekali di file ini.

$hostname = "localhost";
$username = "root";
$password = ""; // Di Laragon dan XAMPP default-nya kosong.
$database = "db_streaming"; // Pastikan nama database sudah benar.

// Membuat koneksi ke database MySQL
$con = mysqli_connect($hostname, $username, $password, $database);

// Opsi tambahan: atur charset ke utf8mb4 untuk mendukung emoji dan karakter internasional
if ($con) {
    mysqli_set_charset($con, "utf8mb4");
}

// Tidak perlu 'die()' atau 'echo' di sini.
// Pengecekan koneksi akan dilakukan di file yang memanggilnya jika diperlukan.
?>
