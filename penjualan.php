<?php
// Mengatur header agar dapat diakses oleh berbagai sumber (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Menghubungkan ke database
require "connect.php";

function generateCustomId($connect) {
    // Dapatkan tanggal hari ini
    $tanggal = date('Ymd');
    
    // Prefix ID
    $prefix = 'JP-' . $tanggal;
    
    // Cari nomor urut terakhir hari ini
    $stmt = $connect->prepare("SELECT MAX(SUBSTRING(idjual, -4)) as max_urut 
                                FROM jual 
                                WHERE idjual LIKE ?");
    $like_pattern = $prefix . '%';
    $stmt->bind_param("s", $like_pattern);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Tentukan nomor urut
    $urut = $row['max_urut'] ? intval($row['max_urut']) + 1 : 1;
    
    // Format nomor urut dengan padding
    $nomor_urut = sprintf("%04d", $urut);
    
    // Gabungkan menjadi ID lengkap
    return $prefix . $nomor_urut;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $response = array(); // Inisialisasi array untuk respon

    // Mengambil data dari POST
    $id_produk = $_POST['id_produk'] ?? null;
    $harga_produk = $_POST['harga_produk'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;
    $tanggal = date('Y-m-d');

    // Cek apakah field harga_produk dan id_produk terisi
    if (!empty($harga_produk) && !empty($id_produk)) {
        // Konversi harga menjadi float dan bagi 100 untuk mengurangi dua digit
        $harga_produk = floatval($harga_produk) / 100;

        // Generate custom ID
        $custom_id = generateCustomId($connect);

        // Menggunakan prepared statement 
        $stmt = $connect->prepare("INSERT INTO jual (idjual, tgljual, idproduct, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdi", $custom_id, $tanggal, $id_produk, $harga_produk, $quantity);
        // 's' = string, 'd' = double

        // Menjalankan query
        if ($stmt->execute()) {
            // Jika penyimpanan berhasil
            $response['value'] = 1;
            $response['message'] = 'Pembelian berhasil diproses';
            $response['idjual'] = $custom_id; // Tambahkan ID yang baru dibuat
        } else {
            // Jika terjadi kesalahan saat menyimpan
            $response['value'] = 0;
            $response['message'] = 'Gagal saat menyimpan data:' . $stmt->error;
        }

        $stmt->close(); // Menutup statement
    } else {
        // Jika field harga_produk atau id_produk kosong
        $response['value'] = 0;
        $response['message'] = 'Field harga_produk dan id_produk tidak boleh kosong.';
    }

    // Mengembalikan respons dalam format JSON
    echo json_encode($response);
} else {
    // Jika request method bukan POSt
    $response['value'] = 0;
    $response['message'] = 'Permintaan tidak valid.';
    echo json_encode($response);
}
?>