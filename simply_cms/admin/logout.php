<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
$_SESSION = array();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman utama (index.php di root)
header('Location: ../index.php');
exit;
?>