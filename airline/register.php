<?php
include "connection.php";
$msg = "";

if(isset($_POST['reg'])){
    $nama = $_POST['nama'];
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $pass2 = $_POST['password2'];

    if($pass != $pass2){
        $msg = "Konfirmasi password tidak cocok!";
    } else {
        $passwordHash = password_hash($pass, PASSWORD_DEFAULT);

        $koneksi->query("INSERT INTO users(username,password,role) 
                         VALUES('$user','$passwordHash','user')");

        $msg = "Pendaftaran berhasil!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial; }

        body {
            height:100vh;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card {
            background:#fff;
            width:360px;
            padding:30px 28px;
            border-radius:15px;
            box-shadow:0 4px 20px rgba(0,0,0,0.25);
        }

        h2 {
            text-align:center;
            margin-bottom:25px;
            font-size:22px;
            letter-spacing:1px;
        }

        label {
            font-size:14px;
            font-weight:bold;
            margin-bottom:5px;
            display:block;
            color:#333;
        }

        input {
            width:100%;
            padding:10px;
            margin-bottom:15px;
            border:1px solid #ccc;
            border-radius:6px;
            font-size:14px;
        }

        button {
            width:100%;
            background:#5b7bfa;
            border:none;
            color:white;
            padding:12px;
            border-radius:6px;
            font-size:15px;
            cursor:pointer;
            margin-top:5px;
        }

        .text {
            text-align:center;
            margin-top:15px;
            font-size:14px;
            color:#666;
        }

        .text a {
            color:#4a6cf7;
            text-decoration:none;
        }
    </style>
</head>

<body>
<div class="card">

    <h2>REGISTER</h2>

    <?php if($msg != "") echo "<p style='color:red;text-align:center;margin-bottom:10px;'>$msg</p>"; ?>

    <form method="POST">

        <label>Nama Lengkap</label>
        <input type="text" name="nama" placeholder="Nama Lengkap">

        <label>Username</label>
        <input type="text" name="username" placeholder="Username">

        <label>Email</label>
        <input type="email" name="email" placeholder="Email">

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">

        <label>Konfirmasi Password</label>
        <input type="password" name="password2" placeholder="Konfirmasi Password">

        <button name="reg">Daftar</button>
    </form>

    <p class="text">
        Sudah punya akun? <a href="index.php">Login di sini</a>
    </p>

</div>
</body>
</html>