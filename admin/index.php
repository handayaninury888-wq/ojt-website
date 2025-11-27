<?php
// admin/index.php
require_once('includes/auth_check.php');
require_once('../includes/db_config.php');

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total_posts FROM posts");
    $stats = $stmt->fetch();
    $total_posts = $stats['total_posts'] ?? 0;
} catch (\PDOException $e) {
    $total_posts = 'Error';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BMWI</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #0d4a7f, #0069d9);
            color: white;
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 1.2rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 1.8rem;
            margin-bottom: 2rem;
        }

        .card h2 {
            font-family: 'Poppins', sans-serif;
            margin-bottom: 1.2rem;
            color: #0d4a7f;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.2rem;
            margin-top: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1.2rem;
            background: #f8f9ff;
            border-radius: 10px;
            border: 1px solid #e0e6f0;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #007bff;
            margin: 0.5rem 0;
        }

        .quick-actions ul {
            list-style: none;
            padding-left: 0;
        }

        .quick-actions li {
            margin-bottom: 0.8rem;
        }

        .quick-actions a {
            display: inline-block;
            background: #007bff;
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .quick-actions a:hover {
            background: #0062cc;
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            color: #777;
            font-size: 0.85rem;
            border-top: 1px solid #eee;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

    <header>
        <h1>Dashboard Admin - BMWI</h1>
        <div class="nav-links">
            <a href="posts.php">Postingan</a>
            <a href="../index.php" target="_blank">Lihat Publik</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <h2>Statistik</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div>Total Postingan</div>
                    <div class="stat-number"><?php echo $total_posts; ?></div>
                    <a href="posts.php" style="font-size:0.9rem; color:#007bff; text-decoration: none;">Kelola</a>
                </div>
            </div>
        </div>

        <div class="card quick-actions">
            <h2>Aksi Cepat</h2>
            <ul>
                <li><a href="posts.php?edit_id=new">+ Buat Postingan Baru</a></li>
                <li><a href="posts.php">Lihat Semua Postingan</a></li>
            </ul>
        </div>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> BMWI - Admin Panel
    </footer>

</body>
</html>