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

        // Mengecek apakah email sudah dipakai
        $stmt = $connect->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            $response['value'] = 0;
            $response['message'] = 'Gagal mencari email: ' . $stmt->error;

            echo json_encode($response);
            exit(); 
        }
        $stmt->bind_result($account);
        $stmt->fetch();
        if ($account != null) {
            $response['value'] = 0;
            $response['message'] = 'Email yang Anda pilih sudah dipakai';

            echo json_encode($response);
            exit(); 
        }

        // Mengecek apakah no telp sudah dipakai
        $stmt = $connect->prepare("SELECT email FROM users WHERE telepon = ?");
        $stmt->bind_param("s", $telepon);
        if (!$stmt->execute()) {
            $response['value'] = 0;
            $response['message'] = 'Gagal mencari no telepon: ' . $stmt->error;

            echo json_encode($response);
            exit(); 
        }
        $stmt->bind_result($account);
        $stmt->fetch();
        if ($account) {
            $response['value'] = 0;
            $response['message'] = 'No. telepon yang Anda pilih sudah dipakai';

            echo json_encode($response);
            exit(); 
        }

        // Menggunakan prepared statement untuk menghindari SQL injection
        // Menambahkan field 'createdDate' dengan nilai default dari fungsi NOW() MySQL
        $stmt = $connect->prepare("INSERT INTO users (email, password, nama, alamat, telepon, foto, createdDate) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $email, $hashed_password, $nama, $alamat, $telepon, $fotoFileName); // "s" = string

         // Menjalankan query
        if ($stmt->execute()) {
            // Jika penyimpanan berhasil, ambil ID yang baru saja dimasukkan
            $userId = $stmt->insert_id; // Ambil ID auto increment dari pengguna yang baru ditambahkan

            // Handling file upload
            $uploadDir = 'uploads/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            // Mengamankan nama file
            $fotoFileName = null;
            if (isset($_FILES['foto'])) {
                $profileFoto = $_FILES['foto'];
                $fileName = $profileFoto['name'];
                $fileTmp = $profileFoto['tmp_name'];
                $fileSize = $profileFoto['size'];
                $fileType = mime_content_type($fileTmp);

                // Check if the file is an image and within size limits (2MB in this example)
                if (in_array($fileType, $allowedTypes) && $fileSize <= 2 * 1024 * 1024) {
                    // Create the destination path for the file (save with userId as the filename)
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // Get the file extension (jpg, png, jpeg)
                    $fotoFileName = $userId . '.' . $fileExtension; // Format nama file <id_user>.<ext>
                    $uploadPath = $uploadDir . $fotoFileName;

                    // Pindahkan file ke folder uploads
                    if (move_uploaded_file($fileTmp, $uploadPath)) {
                        // Update database dengan nama file foto
                        $stmt = $connect->prepare("UPDATE users SET foto = ? WHERE id = ?");
                        $stmt->bind_param("si", $fotoFileName, $userId);
                        $stmt->execute();
                    } else {
                        $response['value'] = 0;
                        $response['message'] = 'Gagal mengunggah file foto';
                        echo json_encode($response);
                        exit(); // Hentikan eksekusi jika gagal upload
                    }
                } else {
                    $response['value'] = 0;
                    $response['message'] = 'File yang diupload harus berupa gambar JPG/PNG/JPEG dan maksimal 2MB.';
                    echo json_encode($response);
                    exit();
                }
            }

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
        $response['message'] = "One or more fields are empty";
    }

     // Always return a JSON response
     echo json_encode($response);
     exit(); // Ensure the script stops executing after output
}