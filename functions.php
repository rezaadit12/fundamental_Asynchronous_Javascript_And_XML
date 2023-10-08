<?php

// koneksi ke database
$conn = mysqli_connect("localhost", "root","","phpdasar");


function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}


function tambah($data){
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    

    // kode: 123
    // jika gambar berhasil di upload isi dari $gambar adalah nama filenya
    $gambar = upload();
    if(!$gambar){
        return false;
    }


    $query = "INSERT INTO mahasiswa 
    VALUES
    ('','$nama', '$nrp', '$email', '$jurusan', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// for image
function upload(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo"<script>
                alert('pilih gambar terlebih dahulu');
             </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar =  strtolower(end($ekstensiGambar));

    if( !in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo"<script>
                alert('yang anda upload bukan gambar!');
            </script>";
        return false;
    }


    // cek jika ukurannya terlalu besar
    if($ukuranFile > 3000000){
        echo"<script>
        alert('ukuran gambar terlau besar');
        </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru

    // menit 36.15
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);


    // untuk kode:123
    return $namaFileBaru;

}

function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id =$id");

    return mysqli_affected_rows($conn);
}


function ubah($data){
    global $conn;
    $id= $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4 ){
        $gambar = $gambarLama;
    }else{
        $gambar = upload();
    }
    


    $mhs = "UPDATE mahasiswa SET
            nama = '$nama',
            nrp = '$nrp',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar' 
            WHERE id = $id
            ";   
    mysqli_query($conn, $mhs);
    return mysqli_affected_rows($conn);


}

function cari($kuncinya){
    $query = "SELECT * FROM mahasiswa
                WHERE 
                nama LIKE '%$kuncinya%' OR
                nrp LIKE '%$kuncinya%' OR
                email LIKE '%$kuncinya%' OR
                jurusan LIKE '%$kuncinya%' 
                ";

    return query($query);
}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($_POST["username"]));
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $password2 = mysqli_real_escape_string($conn, $_POST["password2"]);

        // cek username sudah ada apa belum
        $result = mysqli_query($conn, "SELECT username FROM user  WHERE username = '$username'");

        if(mysqli_num_rows($result) > 0){
            echo"   <script>
                        alert('data sudah ada!')
                    </script>";
            return false;
        }


    // konfirmasi password
    if( $password !== $password2){
        echo"   <script>
                    alert('password tidak sesuai')
                </script>";
        return false;
    }
    
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password')");


    return mysqli_affected_rows($conn);
}



?>