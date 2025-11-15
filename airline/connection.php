<?php
$koneksi = new mysqli("localhost:3303", "root", "", "airline_db");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>