<?php
// Mengatur header agar dapat diakses oleh berbagai sumber (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Menghubungkan ke database
require "connect.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = array(); // Inisialisasi array untuk respon

    // Mengambil data dari POPST request
    $email = $_POST['email'] ?? null;
    $telepon = $_POST['telepon'] ?? null;

    // Cek apakah semua field terisi
    if (!empty($email) && !empty($telepon)) {
        // Mengecek apakah email ada
        $stmt = $connect->prepare("SELECT telepon FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            $response['value'] = 0;
            $response['message'] = 'Gagal mencari akun: ' . $stmt->error;

            echo json_encode($response);
            exit(); 
        }
        $stmt->bind_result($telp_user);
        $stmt->fetch();
        if (!$telp_user) {
            $response['value'] = 0;
            $response['message'] = 'Akun tidak ditemukan';

            echo json_encode($response);
            exit(); 
        }
        if ($telp_user != $telepon) {
            $response['value'] = 0;
            $response['message'] = 'No telepon yang Anda masukan tidak dapat ditemukan';

            echo json_encode($response);
            exit(); 
        }
        $response['value'] = 1;
        $response['email'] = $email;
        $response['message'] = 'Redirect ke halaman forget password';
    } else {
        $response['value'] = 0;
        $response['message'] = "One or more fields are empty";
    }
    echo json_encode($response);
    exit(); 
}
?>