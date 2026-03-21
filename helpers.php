<?php
// File: helpers.php
// Berisi kumpulan fungsi pembantu yang bisa digunakan di banyak file.

/**
 * Fungsi untuk mengirim respons dalam format JSON standar dan menghentikan skrip.
 * Fungsi ini memastikan output selalu konsisten dan aman.
 *
 * @param bool $status      - Status keberhasilan (true jika sukses, false jika gagal).
 * @param string $message   - Pesan yang menjelaskan hasil operasi.
 * @param mixed|null $data  - Data opsional yang ingin disertakan dalam respons (misal: data user, list film).
 */
function sendResponse($status, $message, $data = null) {
    // Siapkan array dasar untuk respons
    $response = [
        'status' => $status,
        'message' => $message
    ];

    // Hanya tambahkan key 'data' ke dalam respons jika $data tidak null.
    // Ini membuat output JSON lebih bersih jika tidak ada data yang dikirim.
    if ($data !== null) {
        $response['data'] = $data;
    }

    // Atur header untuk memberitahu klien bahwa ini adalah konten JSON.
    header('Content-Type: application/json');

    // Cetak array PHP yang telah diubah menjadi string JSON.
    echo json_encode($response);
    
    // Wajib: Hentikan eksekusi skrip agar tidak ada output lain (seperti pesan error PHP atau spasi)
    // yang ikut tercetak dan merusak format JSON.
    exit;
}

// Nanti jika ada fungsi lain yang sering dipakai (misal: fungsi untuk validasi input, upload gambar),
// bisa ditambahkan di sini agar tidak perlu menulis ulang kode.

?>
