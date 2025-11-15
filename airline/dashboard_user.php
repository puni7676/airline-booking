<?php
session_start();
include "connection.php";

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user'){
    header("Location: index.php");
    exit;
}
$uid = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard User</title>

<style>
    body {
        margin:0;
        font-family: Arial;
        background:#eeeeee;
    }

    .navbar {
        background:#4b6ef5;
        padding:14px 30px;
        color:white;
        font-size:20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        font-weight:bold;
    }

    .logout-btn {
        background:white;
        padding:7px 15px;
        border-radius:6px;
        text-decoration:none;
        color:#4b6ef5;
        font-weight:bold;
    }

    .container {
        width:90%;
        max-width:1200px;
        margin:25px auto;
    }

    .section-box {
        background:white;
        padding:25px;
        border-radius:12px;
        border:1px solid #dcdcdc;
        margin-bottom:35px;
    }

    .title {
        font-size:22px;
        font-weight:bold;
        color:#4b6ef5;
        margin-bottom:10px;
    }

    .divider {
        width:100%;
        height:3px;
        background:#d0d7ff;
        margin-bottom:20px;
    }

    .flight-flex {
        display:flex;
        gap:20px;
        justify-content:space-between;
    }

    .flight-card {
        flex:1;
        background:white;
        border:1px solid #dcdcdc;
        border-radius:10px;
        padding:15px;
    }

    .flight-title {
        font-size:16px;
        font-weight:bold;
        margin-bottom:8px;
    }

    .blue-text { color:#4b6ef5; }

    .btn-blue {
        width:100%;
        background:#4b6ef5;
        color:white;
        border:none;
        padding:10px 0;
        border-radius:6px;
        cursor:pointer;
        margin-top:12px;
    }

    table {
        width:100%;
        border-collapse: collapse;
    }

    th {
        background:#4b6ef5;
        color:white;
        padding:10px;
        text-align:left;
    }

    td {
        padding:10px;
        border-bottom:1px solid #dcdcdc;
        background:white;
    }

    .status {
        background:#b8f5c2;
        color:green;
        padding:5px 10px;
        border-radius:5px;
        font-size:13px;
    }
</style>

</head>
<body>

<div class="navbar">
    Airline Booking System
    <div>
        Selamat datang, <?= $_SESSION['user']['username'] ?> (User)
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <!-- PESAN TIKET -->
    <div class="section-box">
        <div class="title">Pesan Tiket Pesawat</div>
        <div class="divider"></div>

        <div class="flight-flex">

            <?php
            $q = $koneksi->query("SELECT * FROM flights");
            while($f = $q->fetch_assoc()):
            ?>
            
            <div class="flight-card">

                <div class="flight-title"><?= $f['flight_code'] ?> - <?= $f['airline_name'] ?></div>

                <div><span class="blue-text">Rute:</span> <?= $f['origin'] ?> → <?= $f['destination'] ?></div>
                <div><span class="blue-text">Keberangkatan:</span> <?= $f['depart_datetime'] ?></div>
                <div><span class="blue-text">Kedatangan:</span> <?= $f['arrive_datetime'] ?></div>
                <div><span class="blue-text">Kursi Tersedia:</span> <?= $f['seats_available'] ?>/<?= $f['seats_total'] ?></div>
                <div><span class="blue-text">Harga:</span> Rp <?= number_format($f['price']) ?></div>

                <a href="booking/book_ticket.php?id=<?= $f['id'] ?>">
                    <button class="btn-blue">Pesan Tiket</button>
                </a>

            </div>

            <?php endwhile; ?>
        </div>
    </div>

<!-- PESANAN SAYA -->
<div class="section-box">
    <div class="title">Pemesanan Saya</div>
    <div class="divider"></div>

<?php
$book = $koneksi->query("
    SELECT 
        b.*, 
        f.flight_code, 
        f.origin, 
        f.destination,
        f.price AS harga
    FROM bookings b 
    JOIN flights f ON f.id = b.flight_id
    WHERE b.user_id = $uid
    ORDER BY b.id DESC
");

// Jika tidak ada pesanan
if ($book->num_rows == 0) {
    echo "
        <p style='
            padding:15px; 
            font-size:16px; 
            background:#f4f6ff; 
            border-left:5px solid #4b6ef5;
            border-radius:6px;
        '>
            Anda belum melakukan pemesanan apapun.
        </p>
    ";
} else {

    echo '
    <table>
        <tr>
            <th>Kode Booking</th>
            <th>Penerbangan</th>
            <th>Rute</th>
            <th>Nama Penumpang</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    ';

    while ($b = $book->fetch_assoc()) {
        echo "
        <tr>
            <td>{$b['kode_booking']}</td>
            <td>{$b['flight_code']}</td>
            <td>{$b['origin']} → {$b['destination']}</td>
            <td>{$b['nama_penumpang']}</td>
            <td>Rp " . number_format($b['harga'], 0, ',', '.') . "</td>
            <td><span class='status'>Confirmed</span></td>
            <td>" . ($b['tanggal'] ?? date('Y-m-d H:i')) . "</td>
        </tr>";
    }

    echo "</table>";
}
?>

</div>

</body>
</html>