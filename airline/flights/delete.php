<?php
include "../connection.php";
$id = $_GET['id'];

$koneksi->query("UPDATE bookings SET deleted = 1 WHERE id = $id");

header("Location: ../dashboard_admin.php");
exit;
?>
