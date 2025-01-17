<?php

$connect = new
mysqli("localhost", "root", "", "db_quickshop");
if($connect){
    }else{
        echo "Koneksi gagal";
        exit();
    }

?>