<?php
session_start();

// Jika belum login, redirect ke login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Ambil nama user dari session
$username = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BMWI</title>
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #f8fbff, #eef5ff);
            color: #2c3e50;
            line-height: 1.6;
            position: relative;
        }

        /* Header dengan Logo */
        header {
            background: linear-gradient(135deg, #7dff93, #1a73e8);
            color: white;
            text-align: center;
            padding: 2rem 1.5rem;
            box-shadow: 0 4px 12px rgba(13, 74, 127, 0.2);
            position: relative;
        }

        .logo-container {
            margin-bottom: 1.2rem;
        }

        .logo-container img {
            height: 70px;
            max-width: 100%;
            object-fit: contain;
        }

        header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        header h2 {
            font-weight: 400;
            font-size: 1.2rem;
            opacity: 0.95;
        }

        /* Tombol Logout di Header (opsional) */
        .logout-btn {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        /* Banner Promosi */
        .promo-banner {
            background: linear-gradient(to right, #00c853, #00a126);
            color: white;
            text-align: center;
            padding: 1.2rem;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 1.8rem 0;
            border-radius: 8px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 200, 83, 0.4);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(0, 200, 83, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 200, 83, 0);
            }
        }

        .container {
            max-width: 900px;
            margin: 1.5rem auto;
            padding: 0 1.5rem;
        }

        /* Card untuk Statistik & Mulai Sekarang */
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.8rem;
        }

        .card h3 {
            margin-bottom: 0.8rem;
            color: #0d4a7f;
            font-family: 'Poppins', sans-serif;
            font-size: 1.3rem;
        }

        .card p {
            margin-bottom: 0.8rem;
            color: #444;
        }

        .card ul {
            padding-left: 1.5rem;
            margin: 0.8rem 0;
            color: #555;
        }

        .card a {
            color: #1a73e8;
            text-decoration: none;
            font-weight: 600;
        }

        .card a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 1.8rem;
            color: #666;
            font-size: 0.95rem;
            background: #f8fbff;
            margin-top: 2rem;
            border-top: 1px solid #eef5ff;
        }

        /* Tombol WhatsApp Mengambang */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            right: 30px;
            background: #25d366;
            color: white;
            border-radius: 50px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            text-decoration: none;
            animation: bounce 2s infinite;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            background: #128C7E;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 1.7rem;
            }

            header h2 {
                font-size: 1.05rem;
            }

            .logout-btn {
                top: 0.8rem;
                right: 1rem;
                font-size: 0.85rem;
                padding: 0.3rem 0.8rem;
            }

            .container {
                padding: 0 1rem;
            }

            .whatsapp-float {
                width: 55px;
                height: 55px;
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Header Admin -->
    <header>
        <div class="logo-container">
            <img src="../assets/logo.png" alt="Logo BMWI">
        </div>
        <h1>Dashboard Admin</h1>
        <h2>Bhakti Mandiri Wisata Indonesia</h2>
        <!-- 🔴 Link Logout di Header -->
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </header>

    

    <!-- Konten Utama -->
    <div class="container">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h2>
        <p>Selamat datang, <strong><?= htmlspecialchars($username) ?></strong>! Anda telah berhasil masuk ke panel administrasi.</p>

        <div class="card">
            <h3>📊 Statistik Singkat</h3>
            <p>Di sini Anda bisa melihat ringkasan aktivitas sistem.</p>
            <ul>
                <li>Manajemen posting artikel</li>
                <li>Kelola pengguna admin</li>
                <li>Pengaturan umum situs</li>
            </ul>
        </div>

        <div class="card">
            <h3>🚀 Mulai Sekarang</h3>
            <p>Anda dapat mulai mengembangkan CMS dengan menambahkan fitur:</p>
            <ul>
                <li><a href="posts.php">Kelola Posting</a></li>
                <li><a href="users.php">Kelola Pengguna</a></li>
                <li><a href="settings.php">Pengaturan Situs</a></li>
                
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?= date('Y') ?> Bhakti Mandiri Wisata Indonesia. All Rights Reserved.
    </footer>

    <!-- Tombol WhatsApp Mengambang -->
    <a href="https://wa.me/6281234567890" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>

</html>
