<?php
session_start();
include "../connection.php";

// CEK LOGIN ADMIN
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Penerbangan</title>

<style>
    body {
        margin: 0;
        font-family: Arial;
        background: #f2f2f2;
    }

    /* HEADER SEPERTI PDF */
    .header {
        background: #4d6df3;
        color: white;
        padding: 18px 30px;
        font-size: 24px;
        font-weight: bold;
    }

    .back-link {
        float: right;
        color: white;
        font-size: 14px;
        text-decoration: none;
        margin-top: 5px;
        border-bottom: 1px solid white;
    }

    /* CARD FORM */
    .form-wrapper {
        width: 420px;
        background: white;
        margin: 40px auto;
        padding: 30px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .title {
        font-size: 20px;
        font-weight: bold;
        color: #4d6df3;
        margin-bottom: 10px;
    }

    .divider {
        width: 100%;
        height: 2px;
        background: #d4dcff;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .btn-save {
        background: #ffcc00;
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: none;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-back {
        display: block;
        text-align: center;
        color: #4d6df3;
        text-decoration: none;
        margin-top: 15px;
        font-size: 14px;
    }

    .btn-back:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>

<div class="header">
    Tambah Penerbangan
    <a href="../dashboard_admin.php" class="back-link">Kembali ke Dashboard</a>
</div>

<div class="form-wrapper">
    <div class="title">Tambah Data Penerbangan</div>
    <div class="divider"></div>

    <form action="save.php" method="POST">

        <label>Kode Penerbangan</label>
        <input type="text" name="flight_code" required>

        <label>Nama Maskapai</label>
        <input type="text" name="airline" required>

        <label>Kota Keberangkatan</label>
        <input type="text" name="origin" required>

        <label>Kota Kedatangan</label>
        <input type="text" name="destination" required>

        <label>Waktu Keberangkatan</label>
        <input type="datetime-local" name="depart_datetime" required>

        <label>Waktu Kedatangan</label>
        <input type="datetime-local" name="arrival_datetime" required>

        <label>Total Kursi</label>
        <input type="number" name="seats_total" required>

        <label>Harga Tiket (Rp)</label>
        <input type="number" name="price" required>

        <label>Status</label>
        <select name="status" required>
            <option value="Scheduled">Scheduled</option>
            <option value="Delayed">Delayed</option>
            <option value="Cancelled">Cancelled</option>
        </select>

        <button class="btn-save">Simpan Penerbangan</button>

        <a class="btn-back" href="../dashboard_admin.php">← Kembali</a>

    </form>
</div>

</body>
</html>
