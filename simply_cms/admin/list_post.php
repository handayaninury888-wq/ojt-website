<?php
require_once('includes/auth_check.php');
require_once('../includes/db_config.php');

// Ambil semua postingan
$stmt = $pdo->query("SELECT id, title, image, created_at FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Postingan - BMWI</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 1.5rem;
        }
        header {
            background: #0d4a7f;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav a {
            color: white;
            text-decoration: none;
            margin-left: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #eef5ff;
            font-weight: 600;
        }
        .action-btn {
            display: inline-block;
            padding: 4px 8px;
            margin: 0 2px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .edit {
            background: #ffc107;
            color: #333;
        }
        .delete {
            background: #dc3545;
            color: white;
        }
        .add-btn {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
        }
        .add-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h2>Kelola Postingan</h2>
        <div class="nav">
            <a href="index.php">Dashboard</a> |
            <a href="add_post.php">+ Tambah Postingan</a> |
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td>
                        <?php if ($post['image']): ?>
                            <img src="../assets/uploads/<?php echo htmlspecialchars($post['image']); ?>" 
                                 alt="Thumbnail" style="height: 40px; object-fit: cover;">
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo date('d M Y', strtotime($post['created_at'])); ?></td>
                    <td>
                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="action-btn edit">Edit</a>
                        <a href="delete_post.php?id=<?php echo $post['id']; ?>" 
                           class="action-btn delete" 
                           onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>