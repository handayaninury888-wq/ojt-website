<?php
// post_detail.php
require_once('includes/db_config.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php'); // Jika ID tidak valid, kembali ke beranda
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "<h1>404 Postingan Tidak Ditemukan</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title><?php echo htmlspecialchars($post['title']); ?></title></head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <small>Dipublikasikan: <?php echo date('d M Y H:i', strtotime($post['created_at'])); ?></small>

    <?php if ($post['image']): ?>
        <p>); ?>]</p>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
    </div>

    <hr>
    <a href="index.php">Kembali ke Beranda</a>
</body>
</html>