<?php
session_start();

if(!isset($_SESSION["login"])){
    header("location: login.php");
    exit;
}

require 'functions.php';

// ambil dari table mahasiswa
$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");


if(isset($_POST["cari"])){
    $mahasiswa = cari($_POST["kunci"]);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        .add a{
            font-style:italic;
            color:red;
            text-decoration:none;
        }

        .add a:hover{
            color:green;
        }
    </style>
</head>
<body>

    <h1>Daftar Mahasiswa</h1>
        <a href="logout.php">keluar</a>
    <form action="" method="post">

        <input type="text" name="kunci" size="30" 
        placeholder="cari data mahasiwa" 
        autocomplete="off" id="keyword"> 

        <button type="submit" name="cari" id="tombol-cari">cari</button>
    </form>
  
    <br><br>
    
    <div id="container">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        <?php $i = 1;?>
        <?php foreach( $mahasiswa as $row ):?>
        <tr>
            <td><?= $i?></td>
            <td>
                <a href="ubah.php?id=<?= $row ["id"];?>">Ubah</a> |
                <a href="hapus.php?id=<?= $row["id"];?>" onclick="return confirm('Apakan anda yakin ingin menghapus?');">
                Hapus</a>
            </td>
            <td><img src="img/<?= $row["gambar"]?>" width="75"></td>
            <td><?= $row["nrp"]?></td>
            <td><?= $row["nama"]?></td>
            <td><?= $row["email"]?></td>
            <td><?= $row["jurusan"]?></td>
        </tr>
      
        <?php $i++;?>
        <?php endforeach; ?>
        <tr>
        <th colspan="7"> 
            <div class="add">
                <a href="tambah.php">Tambahkan Data Mahasiwa</a>
            </div>
        </th>
        </tr>
    </table>
    </div>

    <script src="js/script.js"></script>
</body>
</html>