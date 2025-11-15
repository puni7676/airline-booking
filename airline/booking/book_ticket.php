<?php
session_start();
include "../connection.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user'){
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$f = $koneksi->query("SELECT * FROM flights WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Pemesanan Tiket</title>

<style>
    body{
        margin:0;
        font-family:Arial;
        background:#eef1ff;
    }

    .navbar{
        background:#4b6ef5;
        padding:14px 30px;
        color:white;
        font-size:20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        font-weight:bold;
    }

    .container{
        width:450px;
        margin:40px auto;
    }

    .card{
        background:white;
        border:1px solid #dcdcdc;
        border-radius:12px;
        padding:25px;
    }

    .title{
        font-size:20px;
        font-weight:bold;
        color:#4b6ef5;
        margin-bottom:10px;
    }

    .divider{
        width:100%;
        height:3px;
        background:#d0d7ff;
        margin-bottom:20px;
    }

    .flight-box{
        background:#f8f8ff;
        border:1px solid #dcdcdc;
        border-radius:10px;
        padding:15px;
        margin-bottom:20px;
    }

    .flight-title{
        font-size:16px;
        font-weight:bold;
    }

    .blue-text{ color:#4b6ef5; font-size:14px; }

    input{
        width:100%;
        padding:10px;
        border-radius:6px;
        border:1px solid #ccc;
        margin-bottom:12px;
    }

    .btn-green{
        width:100%;
        padding:12px;
        background:#28a745;
        color:white;
        border:none;
        font-weight:bold;
        border-radius:6px;
        cursor:pointer;
        margin-top:5px;
    }

    .back{
        display:block;
        margin-top:15px;
        text-align:center;
        text-decoration:none;
        color:#4b6ef5;
        font-size:14px;
    }
</style>

</head>
<body>

<div class="navbar">
    Airline Booking System
    <a href="../dashboard_user.php" style="color:white;">Kembali ke Dashboard</a>
</div>

<div class="container">

    <div class="card">
        <div class="title">Pesan Tiket Pesawat</div>
        <div class="divider"></div>

        <div class="flight-box">

            <div class="flight-title"><?= $f['flight_code'] ?> - <?= $f['airline'] ?></div>

            <div class="blue-text">Rute:</div>
            <?= $f['origin'] ?> → <?= $f['destination'] ?><br>

            <div class="blue-text">Keberangkatan:</div>
            <?= date("d/m/Y H:i", strtotime($f['depart_datetime'])) ?><br>

            <div class="blue-text">Kedatangan:</div>
            <?= date("d/m/Y H:i", strtotime($f['arrive_datetime'])) ?><br>

            <div class="blue-text">Harga:</div>
            Rp <?= number_format($f['price'],0,',','.') ?><br>

            <div class="blue-text">Kursi Tersedia:</div>
            <?= $f['seats_available'] ?><br>

        </div>

        <form method="POST" action="submit_order.php">
            <input type="hidden" name="flight_id" value="<?= $f['id'] ?>">

            <label>Nama Penumpang</label>
            <input type="text" name="nama" required>

            <label>Nomor ID (KTP/Passport)</label>
            <input type="text" name="idcard" required>

            <button class="btn-green">Konfirmasi Pemesanan</button>
        </form>

        <a class="back" href="../dashboard_user.php">← Kembali ke Dashboard</a>

    </div>

</div>

</body>
</html>