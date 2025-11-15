<?php
session_start();
include "../connection.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ambil post
    $id = intval($_POST['id']);
    $airline = trim($_POST['airline']);
    $origin = trim($_POST['origin']);
    $destination = trim($_POST['destination']);
    $depart = $_POST['depart_datetime'];
    $arrive = $_POST['arrive_datetime'];
    $seats_total = intval($_POST['seats_total']);
    $price = floatval($_POST['price']);
    $status = $_POST['status'];

    // ambil data lama untuk menyesuaikan seats_available
    $oldQ = $koneksi->prepare("SELECT seats_total, seats_available FROM flights WHERE id = ?");
    $oldQ->bind_param("i", $id);
    $oldQ->execute();
    $oldR = $oldQ->get_result();
    if ($oldR->num_rows === 0) {
        echo "Flight tidak ditemukan.";
        exit;
    }
    $old = $oldR->fetch_assoc();
    $old_total = intval($old['seats_total']);
    $old_available = intval($old['seats_available']);

    // Jika admin mengubah total kursi, sesuaikan available:
    // new_available = old_available + (new_total - old_total)
    // tapi jangan kurang dari 0 dan tidak boleh lebih dari new_total
    $delta = $seats_total - $old_total;
    $new_available = $old_available + $delta;
    if ($new_available < 0) $new_available = 0;
    if ($new_available > $seats_total) $new_available = $seats_total;

    // siapkan statement update (perhatikan nama kolom sesuai DB)
    $sql = "UPDATE flights SET 
                airline = ?, 
                origin = ?, 
                destination = ?, 
                depart_datetime = ?, 
                arrive_datetime = ?, 
                seats_total = ?, 
                seats_available = ?, 
                price = ?, 
                status = ?
            WHERE id = ?";

    $update = $koneksi->prepare($sql);

    if (!$update) {
        // tampilkan error mysql agar mudah debug (hapus/koment saat di produksi)
        echo "Prepare failed: (" . $koneksi->errno . ") " . $koneksi->error;
        exit;
    }

    // tipe parameter:
    // airline(s), origin(s), destination(s), depart(s), arrive(s), seats_total(i), seats_available(i), price(d), status(s), id(i)
    $types = "sssss i i d s i"; // visual helper (spaces ignored below)
    // sebenarnya harus tanpa spasi:
    $types_clean = "sssssiidsi";

    $update->bind_param(
        $types_clean,
        $airline,
        $origin,
        $destination,
        $depart,
        $arrive,
        $seats_total,
        $new_available,
        $price,
        $status,
        $id
    );

    if ($update->execute()) {
        header("Location: ../dashboard_admin.php?update=success");
        exit;
    } else {
        echo "Gagal update data: (" . $update->errno . ") " . $update->error;
    }
}
?>