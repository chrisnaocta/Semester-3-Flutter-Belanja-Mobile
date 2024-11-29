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
    $password = $_POST['password'] ?? null;
    $confirm = $_POST['confirm'] ?? null;

    // Cek apakah semua field terisi
    if (!empty($email) && !empty($password) && !empty($confirm)) {
        if ($password != $confirm) {
            $response['value'] = 0;
            $response['message'] = 'Passwords do not match';

            echo json_encode($response);
            exit(); 
        }
        // Mengecek apakah email sudah dipakai
        $stmt = $connect->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            $response['value'] = 0;
            $response['message'] = 'Gagal mencari akun: ' . $stmt->error;

            echo json_encode($response);
            exit(); 
        }
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        if (!$id) {
            $response['value'] = 0;
            $response['message'] = 'Akun tidak ditemukan';

            echo json_encode($response);
            exit(); 
        }
        // Hashing password sebelum menyimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $connect->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("ss", $hashed_password, $id);
        if (!$stmt->execute()) {
            $response['value'] = 0;
            $response['message'] = 'Gagal mencari akun: ' . $stmt->error;

            echo json_encode($response);
            exit(); 
        }
        $response['value'] = 1;
        $response['message'] = 'Password berhasil diubah';
    } else {
        $response['value'] = 0;
        $response['message'] = "One or more fields are empty";
    }
    echo json_encode($response);
    exit(); 
}
?>