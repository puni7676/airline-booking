<?php
session_start();
include "../connection.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: ../index.php");
    exit;
}

$id = $_GET['id'];
$f = $koneksi->query("SELECT * FROM flights WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Penerbangan</title>

<style>
    body{
        margin:0;
        font-family:Arial;
        background:#f1f1f1;
    }

    /* HEADER BIRU */
    .header{
        background:#4169E1;   /* warna biru seperti PDF */
        padding:15px 30px;
        color:white;
        font-size:26px;
        font-weight:bold;
    }

    .header-right{
        float:right;
        font-size:14px;
        margin-top:5px;
    }

    .header-right a{
        color:white;
        text-decoration:none;
    }

    /* CARD */
    .container{
        width:100%;
        display:flex;
        justify-content:center;
        margin-top:40px;
    }

    .card{
        width:450px;
        background:white;
        padding:25px;
        border-radius:10px;
        box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }

    /* TITLE DALAM CARD */
    .title{
        font-size:20px;
        font-weight:bold;
        color:#4c6ef5;
        margin-bottom:8px;
    }

    .divider{
        width:100%;
        height:3px;
        background:#d8e0ff;
        margin-bottom:20px;
    }

    label{
        font-weight:bold;
        font-size:14px;
    }

    input, select{
        width:100%;
        padding:10px;
        margin:7px 0 15px 0;
        border-radius:6px;
        border:1px solid #ccc;
        font-size:14px;
    }

    input[readonly]{
        background:#f2f2f2;
    }

    /* TOMBOL KUNING */
    .btn-save{
        width:100%;
        background:#FFC000;
        padding:12px;
        border:none;
        border-radius:6px;
        font-size:16px;
        font-weight:bold;
        cursor:pointer;
    }

    .back{
        text-align:center;
        margin-top:10px;
    }

    .back a{
        color:#6c6cdd;
        text-decoration:none;
        font-size:14px;
    }
</style>

</head>
<body>

<div class="header">
    Edit Penerbangan

    <div class="header-right">
        <a href="../dashboard_admin.php">Kembali ke Dashboard</a>
    </div>
</div>

<div class="container">

    <div class="card">

        <div class="title">Edit Data Penerbangan</div>
        <div class="divider"></div>

        <form method="POST" action="update.php">

            <input type="hidden" name="id" value="<?= $f['id'] ?>">

            <label>Kode Penerbangan (Read-only)</label>
            <input type="text" value="<?= $f['flight_code'] ?>" readonly>

            <label>Nama Maskapai</label>
            <input type="text" name="airline" value="<?= $f['airline'] ?>">

            <label>Kota Keberangkatan</label>
            <input type="text" name="origin" value="<?= $f['origin'] ?>">

            <label>Kota Kedatangan</label>
            <input type="text" name="destination" value="<?= $f['destination'] ?>">

            <label>Waktu Keberangkatan</label>
            <input type="datetime-local" name="depart_datetime" value="<?= date('Y-m-d\TH:i', strtotime($f['depart_datetime'])) ?>">

            <label>Waktu Kedatangan</label>
            <input type="datetime-local" name="arrive_datetime" value="<?= date('Y-m-d\TH:i', strtotime($f['arrive_datetime'])) ?>">

            <label>Total Kursi</label>
            <input type="number" name="seats_total" value="<?= $f['seats_total'] ?>">

            <label>Harga Tiket (Rp)</label>
            <input type="number" name="price" value="<?= $f['price'] ?>">

            <label>Status</label>
            <select name="status">
                <option value="Scheduled" <?= ($f['status']=='Scheduled'?'selected':'') ?>>Scheduled</option>
                <option value="Delayed" <?= ($f['status']=='Delayed'?'selected':'') ?>>Delayed</option>
                <option value="Cancelled" <?= ($f['status']=='Cancelled'?'selected':'') ?>>Cancelled</option>
            </select>

            <button class="btn-save">Simpan Perubahan</button>
        </form>

        <div class="back">
            <a href="../dashboard_admin.php">← Kembali</a>
        </div>

    </div>

</div>

</body>
</html>