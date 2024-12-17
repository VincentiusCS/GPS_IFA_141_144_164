<?php
    session_start();
    include "config.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    // enkripsi password
    //$password = password_hash($password, PASSWORD_DEFAULT);
    $password = md5($password);

    // masukin data ke database
    $query = mysqli_query($connection, "INSERT INTO account VALUES ('','$username','$password')") or die (mysqli_error($connection));

    // $cek = mysqli_num_rows($query);

    if($query){
        echo "
            <script>
                alert('Pendaftaran berhasil, silakan login');
                document.location.href = 'login.php';
            </script>
        ";

        }
    else {
            echo "proses gagal";
        }
?>