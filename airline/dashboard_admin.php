<?php
session_start();
include "connection.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

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

    .logout-btn{
        background:white;
        padding:7px 15px;
        border-radius:6px;
        color:#4b6ef5;
        font-weight:bold;
        text-decoration:none;
    }

    /* CONTAINER */
    .container{
        width:90%;
        max-width:1250px;
        margin:30px auto;
    }

    .section-box{
        background:white;
        padding:25px;
        border-radius:12px;
        border:1px solid #dcdcdc;
        margin-bottom:35px;
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

    /* FLIGHT CARDS */
    .flight-flex{
        display:flex;
        gap:20px;
        justify-content:space-between;
    }

    .flight-card{
        background:white;
        border:1px solid #dcdcdc;
        border-radius:10px;
        padding:15px;
        flex:1;
    }

    .flight-title{
        font-weight:bold;
        margin-bottom:8px;
    }

    .blue-text{ color:#4b6ef5; font-weight:bold; }

    .btn-edit{
        background:#4b6ef5;
        border:none;
        padding:7px 12px;
        color:white;
        border-radius:6px;
        cursor:pointer;
    }

    .btn-delete{
        background:#e74c3c;
        border:none;
        padding:7px 12px;
        color:white;
        border-radius:6px;
        cursor:pointer;
        margin-left:5px;
    }

    .btn-add{
        background:#2ecc71;
        padding:8px 14px;
        border-radius:6px;
        color:white;
        border:none;
        cursor:pointer;
        font-weight:bold;
    }

    /* TABLE */
    table{
        width:100%;
        border-collapse:collapse;
    }

    th{
        background:#4b6ef5;
        color:white;
        padding:10px;
        text-align:left;
    }

    td{
        padding:10px;
        background:white;
        border-bottom:1px solid #ccc;
    }

    .status{
        background:#b8f5c2;
        color:green;
        padding:5px 10px;
        border-radius:6px;
        font-size:13px;
    }
</style>

</head>
<body>

<div class="navbar">
    Airline Booking System
    <div>
        Selamat datang, <?= $user['username'] ?> (Admin)
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">

    <!-- MANAJEMEN PENERBANGAN -->
    <div class="section-box">
        <div class="title">Manajemen Penerbangan</div>
        <div class="divider"></div>

        <a href="flights/add.php"><button class="btn-add">+ Tambah Penerbangan</button></a>
        <br><br>

        <div class="flight-flex">

            <?php
            $q = $koneksi->query("SELECT * FROM flights ORDER BY id ASC");
            while($f = $q->fetch_assoc()):
            ?>
            
            <div class="flight-card">
                <div class="flight-title"><?= $f['flight_code'] ?> - <?= $f['airline_name'] ?></div>

                <div><span class="blue-text">Rute:</span> <?= $f['origin'] ?> → <?= $f['destination'] ?></div>
                <div><span class="blue-text">Waktu:</span> <?= date('d/m/Y H:i', strtotime($f['depart_datetime'])) ?></div>
                <div><span class="blue-text">Kursi:</span> <?= $f['seats_available'] ?>/<?= $f['seats_total'] ?> tersedia</div>
                <div><span class="blue-text">Harga:</span> Rp <?= number_format($f['price'], 0, ',', '.') ?></div>
                <div><span class="blue-text">Status:</span> <span class="status">Scheduled</span></div>

                <br>
                <a href="flights/edit.php?id=<?= $f['id'] ?>"><button class="btn-edit">Edit</button></a>
                <a href="flights/delete.php?id=<?= $f['id'] ?>" onclick="return confirm('Hapus penerbangan ini?')">
                    <button class="btn-delete">Hapus</button>
                </a>
            </div>

            <?php endwhile; ?>

        </div>
    </div>

    <!-- SEMUA PEMESANAN -->
    <div class="section-box">
        <div class="title">Semua Pemesanan</div>
        <div class="divider"></div>

        <table>
            <tr>
                <th>Kode Booking</th>
                <th>Penerbangan</th>
                <th>Nama Pemesan</th>
                <th>Nama Penumpang</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>

            <?php
            $book = $koneksi->query("
                SELECT b.*, u.username, f.flight_code, f.price
                FROM bookings b
                JOIN users u ON u.id = b.user_id
                JOIN flights f ON f.id = b.flight_id
                ORDER BY b.id DESC
            ");

            while ($b = $book->fetch_assoc()):
            ?>
            <tr>
                <td><?= $b['kode_booking'] ?></td>
                <td><?= $b['flight_code'] ?></td>
                <td><?= $b['username'] ?></td>
                <td><?= $b['nama_penumpang'] ?></td>
                <td>Rp <?= number_format($b['price'], 0, ',', '.') ?></td>
                <td><span class="status">Confirmed</span></td>
                <td><?= date('d/m/Y H:i', strtotime($b['booked_at'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>