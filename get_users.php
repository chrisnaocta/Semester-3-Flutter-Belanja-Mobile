<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require "connect.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    error_log("User  ID: " . $user_id); // Log user ID

    $query = "SELECT id, nama, email FROM users WHERE id = '$user_id'";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $response = ['status' => 'success', 'data' => $user];
    } else {
        $response = ['status' => 'error', 'message' => 'Pengguna tidak ditemukan'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Pengguna belum login'];
}

echo json_encode($response);
?>