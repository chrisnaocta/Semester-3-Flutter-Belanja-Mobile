<?php
session_start();

//Mengatur header agar dapat diakses oleh berbagai sumber (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

//Menghubungkan ke database
require "connect.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $response = array(); //Inisialisasi array untuk menyimpan respons

    //Mengambil email dan password dari POST request
    $email = $_POST['email'];
    $password = $_POST['password']; //Password dari input form

    //Membuat query untuk mengambil data pengguna berdasarkan email
    $cek = "SELECT * FROM users WHERE email='$email'";
    
    //Menjalankan query
    $result = mysqli_query($connect, $cek);

    //Mengecek apakah hasil query valid
    if ($result && mysqli_num_rows($result) > 0){
        //Mengambil data dari pengguna database
        $row = mysqli_fetch_assoc($result);

        //Memverifikasi password dengan has yang tersimpan di database
        if(password_verify($password, $row['password'])){
            //Jika password cocok login berhasil
            $response['value'] = 1;
            $response['message'] = "Login Berhasil";

            // Store user ID in session
            $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the primary key for users
        }else{
            //Jika password tidak cocok
            $response['value'] = 0;
            $response['message'] = "Login gagal. Password salah";
        }
    }else{
        //Jika email tidak ditemukan di database
        $response['value'] = 0;
        $response['message'] = "Login gagal. Email tidak ditemukan";
    }

    //Mengembalikan respon dalam forman JSON
    echo json_encode($response);
}else{
    //Jika request method bukan POST
    $response['value'] = 0;
    $response['message'] = "Permintaan tidak valid";
    echo json_encode($response);
}
?>