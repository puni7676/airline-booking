<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST['flight_id'])) {
    echo "Flight ID tidak ditemukan.";
    exit;
}

$flight_id = $_POST['flight_id'];
$nama = $_POST['nama'];
$idcard = $_POST['idcard'];
$user_id = $_SESSION['user']['id'];

// Cek flight valid
$cek = $koneksi->query("SELECT * FROM flights WHERE id = $flight_id");
if ($cek->num_rows == 0) {
    echo "Penerbangan tidak ditemukan.";
    exit;
}

$f = $cek->fetch_assoc();

// Kurangi kursi otomatis
if ($f['seats_available'] <= 0) {
    echo "Maaf, kursi sudah habis.";
    exit;
}

$new_seat = $f['seats_available'] - 1;

// Update kursi
$koneksi->query("UPDATE flights SET seats_available = $new_seat WHERE id = $flight_id");

// ===== SIMPAN PEMESANAN =====
$koneksi->query("
    INSERT INTO bookings (user_id, flight_id, nama_penumpang, idcard)
    VALUES ('$user_id', '$flight_id', '$nama', '$idcard')
");

// AMBIL ID BOOKING TERBARU
$booking_id = $koneksi->insert_id;

// ===== BUAT KODE BOOKING =====
$kode_booking = "BK-" . $booking_id . "-" . date("YmdHis");

// SIMPAN KODE BOOKING KE DATABASE
$koneksi->query("UPDATE bookings SET kode_booking='$kode_booking' WHERE id=$booking_id");

// Redirect kembali ke dashboard user
header("Location: ../dashboard_user.php?success=1");
exit;

?>