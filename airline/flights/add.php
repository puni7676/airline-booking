<?php
session_start();
include "../connection.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin'){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Penerbangan</title>

<style>
    body{
        margin:0;
        font-family:Arial;
        background:#eeeeee;
    }

    /* NAVBAR */
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

    .back-btn{
        color:white;
        text-decoration:none;
        font-size:14px;
    }

    /* CONTAINER */
    .container{
        width:500px;
        margin:35px auto;
    }

    .card{
        background:white;
        padding:25px;
        border-radius:12px;
        border:1px solid #dcdcdc;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
    }

    .title{
        font-size:22px;
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

    label{
        font-weight:bold;
        font-size:14px;
    }

    input, select{
        width:100%;
        padding:10px;
        margin:8px 0 15px 0;
        border:1px solid #ccc;
        border-radius:6px;
        font-size:14px;
    }

    .btn-yellow{
        background:#f4c430;
        width:100%;
        border:none;
        padding:12px;
        border-radius:6px;
        color:white;
        cursor:pointer;
        margin-top:5px;
        font-size:15px;
        font-weight:bold;
    }

    .link-kembali{
        display:block;
        text-align:center;
        margin-top:15px;
        color:#4b6ef5;
        text-decoration:none;
        font-size:14px;
    }
</style>

</head>

<body>

<div class="navbar">
    Edit Penerbangan
    <a href="../dashboard_admin.php" class="back-btn">Kembali ke Dashboard</a>
</div>

<div class="container">
    <div class="card">
        <div class="title">Tambah Data Penerbangan</div>
        <div class="divider"></div>

        <form method="POST" action="save.php">

            <label>Kode Penerbangan</label>
            <input type="text" name="flight_code" required>

            <label>Nama Maskapai</label>
            <input type="text" name="airline_name" required>

            <label>Kota Keberangkatan</label>
            <input type="text" name="origin" required>

            <label>Kota Kedatangan</label>
            <input type="text" name="destination" required>

            <label>Waktu Keberangkatan</label>
            <input type="datetime-local" name="depart_datetime" required>

            <label>Waktu Kedatangan</label>
            <input type="datetime-local" name="arrive_datetime" required>

            <label>Total Kursi</label>
            <input type="number" name="seats_total" required>

            <label>Harga Tiket (Rp)</label>
            <input type="number" name="price" required>

            <label>Status</label>
            <select name="status">
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>

            <button class="btn-yellow">Simpan Penerbangan</button>
        </form>

        <a href="../dashboard_admin.php" class="link-kembali">← Kembali</a>

    </div>
</div>

</body>
</html>
