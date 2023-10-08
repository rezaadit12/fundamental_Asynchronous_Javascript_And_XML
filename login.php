<?php
session_start();
require 'functions.php';

if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if($key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if(isset($_SESSION["login"])){
    header("location: awal.php");
}



if(isset($_POST["submit"])){

    $username = $_POST["usern"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' ");

    if(mysqli_num_rows($result) === 1){

        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row["password"])){
            
            $_SESSION["login"] = true;

            // remember me
            if(isset($_POST["remember"])){
                // buat cookie
                setcookie('id', $row["id"] , time() + 60);
                setcookie('key', hash('sha256', $row["username"]), time() + 60);
            }

            header("location: awal.php");
            exit;
        }

    }$error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        label{
            display:block;
        }

        .remember label{
            display: inline;
        }
        
    </style>
</head>
<body>
    <h2>HALAMAN LOGIN</h2>

    <?php if(isset($error)):?>
        <p>username/password salah</p>
    <?php endif; ?>
    <form action="" method="post">
        <ul>
            <li>
                <label for="usern">Username</label>
                <input type="text" name="usern" id="usern">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="text" name="password" id="password">
            </li>
            <div class="remember">
                <li>
                    <input type="checkbox"name="remember" id="remember">
                    <label for="remember">remember</label>
                </li><br>
            </div>
            <li>
                <button type="submit" name="submit">LOGIN</button>
            </li>
        </ul>
            <p>belum punya akun? <a href="register.php">daftar</a></p>
    </form>
</body>
</html>





