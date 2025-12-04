<?php
require_once('includes/auth-check.php');
require_once('../includes/db_config.php');

$id = $_GET['id'] ?? 0;

if (!$id) {
    die("ID postingan tidak valid.");
}

$stmt = $pdo->prepare("SELECT id, title, content, image FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("Postingan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Postingan - BMWI</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <style>
        /* Copy style dari add_post.php */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }
        button {
            background: #007bff;
            color: white;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        button:hover {
            background: #0056b3;
        }
        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .current-image {
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #555;
        }
        .current-image img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Edit Postingan</h2>
        <div class="nav">
            <a href="index.php">Dashboard</a> |
            <a href="list_post.php">Kelola Postingan</a> |
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="container">
        <form method="POST" action="save_post.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

            <label for="title">Judul</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

            <label for="content">Isi Konten</label>
            <textarea name="content" id="content" rows="8" required><?php echo htmlspecialchars($post['content']); ?></textarea>

            <label for="image">Gambar (Opsional)</label>
            <input type="file" name="image" id="image" accept="image/*">

            <?php if ($post['image']): ?>
                <div class="current-image">
                    Gambar Saat Ini: 
                    <img src="../assets/uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Current Image">
                </div>
            <?php endif; ?>

            <button type="submit">Perbarui Postingan</button>
        </form>
        <a href="list_post.php" class="back-link">← Kembali ke Daftar Postingan</a>
    </div>
</body>
</html>
