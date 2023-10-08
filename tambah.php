<?php
session_start();

if(!isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}

require 'functions.php';

if(isset($_POST["submit"])){

    if(tambah($_POST)>0){
        echo"<script>
                alert('data berhasil ditambahkan');
                document.location.href = 'awal.php';
             </script>";
    }else{
        echo"gagal mang";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>halamat tambah</title>
</head>
<body>
    <h1>Tambahkan Data Mahasiwa</h1>

    <form action="" method="post" enctype="multipart/form-data">

        <ul>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" value="">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email">
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan">
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Masukan Data!</button>
            </li>
        </ul>
    </form>
</body>
</html>