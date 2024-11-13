<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF8");

require "connect.php"; //Koneksi ke database

$query = "SELECT * FROM namaproduct";
$result = mysqli_query($connect, $query);

$products = array();

while ($row = mysqli_fetch_assoc($result)){
    $products[] = $row;
}

echo json_encode($products);
?>