<?php
    session_start();
    include "config.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $query = mysqli_query($connection, "SELECT * FROM account WHERE username='$username'") or die (mysqli_error($connection));

    $cek = mysqli_num_rows($query);

    if($cek>0)
    {
        $_SESSION['username'] = $username;
        // $_SESSION['password'] = $password;
        if($username == "admin") {
            $row = mysqli_fetch_assoc($query);
        
            //if (password_verify($password, $row['password'])) {
            if (md5($password, $row['password'])) {
                header("location:index.php");
                
            }
            else{
                echo "
                    <script>
                        alert('Login gagal! Username atau password Anda salah.');
                        document.location.href = 'login.php';
                    </script>
                ";
            }
            
        }
        else {
            $row = mysqli_fetch_assoc($query);
        
            if (md5($password, $row['password'])) {
                header("location:index.php");
                
            }
            else{
                echo "
                    <script>
                        alert('Login gagal! Username atau password Anda salah.');
                        document.location.href = 'login.php';
                    </script>
                ";
            }
        }
        
        
    }
    else{
        echo "
            <script>
                alert('Login gagal! Username atau password Anda salah.');
                document.location.href = 'login.php';
            </script>
        ";
    }
?>