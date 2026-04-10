<?php



/**
 *
 * @param bool $status      - Status keberhasilan (true jika sukses, false jika gagal).
 * @param string $message   - Pesan yang menjelaskan hasil operasi.
 * @param mixed|null $data  - Data opsional yang ingin disertakan dalam respons (misal: data user, list film).
 */
function sendResponse($status, $message, $data = null) {
    
    $response = [
        'status' => $status,
        'message' => $message
    ];

    if ($data !== null) {
        $response['data'] = $data;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

?>
