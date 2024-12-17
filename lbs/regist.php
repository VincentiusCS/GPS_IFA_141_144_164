<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Welcome</title>

    <!-- local css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        .content {
            background-image: url('assets/img/BENGKEL2.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        .formulir {
            max-width: 450px;
            margin-top: 80px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8);
            /* Background hitam semi-transparan */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        #box {
            margin: auto;
            width: 40%;
            height: 100vh;
            background-color: rgba(255, 136, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            margin: 0 auto 20px auto;
            display: block;
            width: 60%;
            max-width: 200px;
            /* Logo lebih kecil */
        }

        h1,
        h2 {
            color: #FFD700;
            /* Kuning seperti alat bengkel */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .form-label {
            color: #fff;
        }

        .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .btn {
            background-color: #FF8800;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #cc6f00;
        }

        .putih {
            color: #FFD700;
        }

        .putih a {
            color: #FF8800;
            text-decoration: none;
        }

        .putih a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="content d-flex justify-content-center">
    <div class="container">
        <div id="box">
            <div class="formulir container">
                <div class="col align-self-center">
                    <h1 class="text-center fw-bold">BENGKELKU</h1>
                    <h2 class="text-center fw-bold">DAFTAR</h2>
                    <form method="POST" action="cekdaftar.php">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" placeholder="Masukkan Username" name="username">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan password" name="password">
                        </div>
                        <center>
                            <button type="submit" class="btn">Daftar</button> <br>
                        </center>
                    </form>
                    <br>
                    <center>
                        <p class="putih">Sudah punya akun? <a href="login.php" class="putih fw-bold">Login</a></p>
                    </center>
                </div>
            </div>
        </div>
    </div>
</body>

</html>