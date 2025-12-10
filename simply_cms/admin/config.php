<?php
/**
 * File Konfigurasi Database untuk CMS BMWI
 * Lokasi: /simply_cms/config.php
 */

// Pengaturan koneksi database
$host     = 'localhost';      // Host database (default: localhost)
$username = 'root';           // Username MySQL (ubah jika berbeda)
$password = '';               // Password MySQL (kosong untuk XAMPP/Laragon default)
$database = 'simply_cms';     // Nama database Anda

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    // Opsional: Tampilkan error hanya di lingkungan development
    die("❌ Koneksi database gagal: " . mysqli_connect_error());
}

// Atur charset ke utf8mb4 untuk mendukung emoji & karakter internasional
mysqli_set_charset($conn, "utf8mb4");

// Nonaktifkan error reporting di production (opsional)
// error_reporting(0);
// ini_set('display_errors', 0);
?>