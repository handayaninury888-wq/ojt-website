<?php
$host = 'localhost';
$username = 'root'; // ganti jika pakai user lain
$password = '';     // ganti jika punya password
$dbname = 'simply_cms'; // ganti sesuai nama database Anda

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset agar tidak error karakter khusus
mysqli_set_charset($conn, "utf8");
?>