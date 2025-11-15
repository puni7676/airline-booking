<?php
session_start();
include "connection.php";

$msg = "";
if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $q = $koneksi->query("SELECT * FROM users WHERE username='$u'");
    if ($q->num_rows > 0) {
        $d = $q->fetch_assoc();
        if (password_verify($p, $d['password'])) {
            $_SESSION['user'] = $d;
            
            // CEK ROLE
            if ($d['role'] == 'admin') {
                header("Location: dashboard_admin.php");
                exit;
            } else {
                header("Location: dashboard_user.php");
                exit;
            }

        } else $msg = "Password salah!";
    } else $msg = "User tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * { margin:0; padding:0; font-family:Arial; }
        body {
            height: 100vh;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .card {
            background:#fff;
            width:320px;
            padding:25px;
            border-radius:10px;
            box-shadow:0 4px 15px rgba(0,0,0,0.2);
        }
        .card h2 { text-align:center; margin-bottom:20px; }
        input {
            width:100%; padding:10px; margin:7px 0;
            border:1px solid #ccc; border-radius:5px;
        }
        button {
            width:100%; padding:10px;
            background:#2575fc; border:none;
            color:white; border-radius:5px;
            cursor:pointer; font-size:16px;
        }
        .text-center { text-align:center; margin-top:10px; font-size:14px; }
        a { color:#2575fc; text-decoration:none; }
    </style>
</head>

<body>
<div class="card">
    <h2>LOGIN</h2>

    <?php if($msg != "") echo "<p style='color:red; text-align:center;'>$msg</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button name="login">Login</button>
    </form>

    <p class="text-center">
        Belum punya akun? <a href="register.php">Daftar di sini</a>
    </p>
</div>
</body>
</html>