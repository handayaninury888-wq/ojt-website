<?php
// admin/includes/header.php
// Pastikan file ini dipanggil SETELAH session dimulai dan auth_check dilakukan di file utama
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CMS | <?php echo $page_title ?? 'Dashboard'; ?></title>
    
    <style>
        /* CSS Sederhana untuk Tampilan Admin */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5em;
        }
        .nav-admin a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .nav-admin a:hover {
            background-color: #555;
        }
        .content {
            padding: 20px;
            background-color: white;
            margin: 20px auto;
            width: 90%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h1>CMS Administration</h1>
        <div class="nav-admin">
            <a href="index.php">Dashboard</a>
            <a href="posts.php">Manajemen Post</a>
            <a href="../index.php" target="_blank">Lihat Web Publik</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="content">

    <?php
// admin/index.php (Contoh Penggunaan)

// Cek Otentikasi
require_once('includes/auth_check.php'); 
// ... logic lain ...

// 1. Definisikan Judul
$page_title = 'Dashboard Utama'; 

// 2. Sertakan Header
require_once('includes/header.php'); 
?>

<h2>Selamat Datang, Admin!</h2>
<?php
// 3. Sertakan Footer (akan dibuat di langkah berikutnya)
require_once('includes/footer.php'); 
?>