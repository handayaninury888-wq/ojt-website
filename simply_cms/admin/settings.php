<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// Halaman dummy untuk pengaturan situs
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Situs - BMWI Admin</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
        .container { max-width: 800px; margin: auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #1a73e8; }
        .back-link { display: inline-block; margin-top: 1rem; color: #1a73e8; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ Pengaturan Umum Situs</h1>
        <p>Saat ini fitur ini masih dalam pengembangan.</p>
        <p><a href="dashboard.php" class="back-link">← Kembali ke Dashboard</a></p>
    </div>
</body>
</html>