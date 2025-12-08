<?php
session_start();

// Proteksi halaman admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../login.php');
    exit;
}

include 'config.php'; // Sesuaikan path jika config.php ada di root

// === PAGINATION ===
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;

// Hitung total post
$total_sql = "SELECT COUNT(*) as total FROM posts";
$total_result = mysqli_query($conn, $total_sql);
$total = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total / $limit);

// Ambil data post
$sql = "SELECT id, title, content, image, created_at 
        FROM posts 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";
$posts_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Postingan - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #f8fbff, #eef5ff);
            color: #2c3e50;
            line-height: 1.6;
        }
        header {
            background: linear-gradient(135deg, #7dff93, #1a73e8);
            color: white;
            text-align: center;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(13, 74, 127, 0.2);
        }
        header h1 { font-family: 'Poppins', sans-serif; font-size: 1.8rem; }
        .nav {
            background: #343a40;
            padding: 0.8rem;
            text-align: center;
        }
        .nav a {
            color: white;
            text-decoration: none;
            margin: 0 12px;
            padding: 6px 12px;
            border-radius: 4px;
        }
        .nav a:hover { background: #555; }
        .container {
            max-width: 900px;
            margin: 1.5rem auto;
            padding: 0 1.5rem;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .btn-primary {
            display: inline-block;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .btn-primary:hover { background: #0d4a7f; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #0d4a7f;
        }
        tr:last-child td { border-bottom: none; }
        .post-title {
            font-weight: 600;
            color: #0d4a7f;
            max-width: 300px;
            word-wrap: break-word;
        }
        .post-date {
            color: #5a6c85;
            font-size: 0.9rem;
        }
        .actions a {
            margin-right: 10px;
            color: #1a73e8;
            text-decoration: none;
            font-weight: 600;
        }
        .actions a:hover { text-decoration: underline; }
        .actions a.delete { color: #e74c3c; }
        .empty {
            text-align: center;
            padding: 2.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            color: #666;
        }
        .pagination {
            margin-top: 1.8rem;
            text-align: center;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 14px;
            margin: 0 4px;
            text-decoration: none;
            color: #1a73e8;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .pagination a:hover { background: #f1f9ff; }
        .pagination .active {
            background: #1a73e8;
            color: white;
            border-color: #1a73e8;
        }
        .pagination .disabled {
            color: #ccc;
            pointer-events: none;
        }
        footer {
            text-align: center;
            padding: 1.5rem;
            color: #666;
            background: #f8fbff;
            margin-top: 2rem;
            border-top: 1px solid #eef5ff;
        }
        @media (max-width: 600px) {
            .page-header { flex-direction: column; gap: 12px; }
            th, td { padding: 10px 8px; font-size: 0.9rem; }
            .post-title { max-width: 180px; }
        }
    </style>
</head>
<body>

    <header>
        <h1>Manajemen Postingan</h1>
    </header>

    <div class="nav">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="posts.php" style="background:#555">Postingan</a>
        <a href="users.php">Pengguna</a>
        <a href="settings.php">Pengaturan Situs</a>
        
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Daftar Postingan</h2>
            <a href="post-add.php" class="btn-primary"><i class="fas fa-plus"></i> Tambah Baru</a>
        </div>

        <?php if ($total > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($post = mysqli_fetch_assoc($posts_result)) {
                        $formatted_date = date('d M Y H:i', strtotime($post['created_at']));
                        echo "<tr>";
                        echo "<td>" . $post['id'] . "</td>";
                        echo "<td class='post-title'>" . htmlspecialchars($post['title']) . "</td>";
                        echo "<td class='post-date'>" . $formatted_date . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='post-edit.php?id=" . $post['id'] . "'>Edit</a>";
                        echo "<a href='post-delete.php?id=" . $post['id'] . "' class='delete' onclick='return confirm(\"Yakin hapus postingan ini?\")'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>">&laquo; Sebelumnya</a>
                <?php else: ?>
                    <span class="disabled">&laquo; Sebelumnya</span>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);

                if ($start > 1) {
                    echo '<a href="?page=1">1</a>';
                    if ($start > 2) echo '<span>...</span>';
                }

                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $page) {
                        echo '<span class="active">' . $i . '</span>';
                    } else {
                        echo '<a href="?page=' . $i . '">' . $i . '</a>';
                    }
                }

                if ($end < $total_pages) {
                    if ($end < $total_pages - 1) echo '<span>...</span>';
                    echo '<a href="?page=' . $total_pages . '">' . $total_pages . '</a>';
                }
                ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>">Selanjutnya &raquo;</a>
                <?php else: ?>
                    <span class="disabled">Selanjutnya &raquo;</span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; color: #ccc;"></i>
                <p>Belum ada postingan.</p>
                <a href="post-add.php" class="btn-primary" style="margin-top: 1rem;">Buat Postingan Pertama</a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Bhakti Mandiri Wisata Indonesia. All Rights Reserved.
    </footer>

</body>
</html>
