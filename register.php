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
    $nama = $_POST['nama'] ?? null;
    $alamat = $_POST['alamat'] ?? null;
    $telepon = $_POST['telepon'] ?? null;

    // Cek apakah semua field terisi
    if (!empty($email) && !empty($nama) && !empty($alamat) && !empty($telepon)) {
        // Hashing password sebelum menyimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

         // Handling file upload
         $fotoFileName = null;
         if (isset($_FILES['foto'])) {
             $uploadDir = 'uploads/';

            // Mengamankan nama file
            $safeName = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '', $nama)); // Hapus karakter tidak valid
            $fotoFileName = $safeName . '.png'; // Format nama file <nama_user>.png
            $uploadPath = $uploadDir . $fotoFileName;
 
             // Pindahkan file ke folder uploads
             if (!move_uploaded_file($_FILES['foto']['tmp_name'], $uploadPath)) {
                 $response['value'] = 0;
                 $response['message'] = 'Gagal mengunggah file foto';
                 echo json_encode($response);
                 exit(); // Hentikan eksekusi jika gagal upload
             }
         }

        // Menggunakan prepared statement untuk menghindari SQL injection
        // Menambahkan field 'createdDate' dengan nilai default dari fungsi NOW() MySQL
        $stmt = $connect->prepare("INSERT INTO users (email, password, nama, alamat, telepon, foto, createdDate) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $email, $hashed_password, $nama, $alamat, $telepon, $fotoFileName); // "s" = string

        // Menjalankan query
        if ($stmt->execute()) {
            // Jika penyimpanan berhasil
            $response['value'] = 1;
            $response['message'] = 'Registrasi berhasil diproses';
        } else {
            // Jika terjadi kesalahan saat menyimpan
            $response['value'] = 0;
            $response['message'] = 'Gagal menyimpan data: ' . $stmt->error;
        }

        $stmt->close(); // Menutup statement
    } else {
        // Jika ada field yang kosong
        $response['value'] = 0;
        $response['message'] = "Permintaan tidak valid";
    }

     // Always return a JSON response
     echo json_encode($response);
     exit(); // Ensure the script stops executing after output
}