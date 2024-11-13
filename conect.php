<?php

$connect = new
mysqli("localhost", "root", "", "db_latihan");
if($connect){
    }else{
        echo "Koneksi gagal";
        exit();
    }

?>