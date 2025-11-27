<?php
require_once('includes/auth_check.php');
require_once('../includes/db_config.php');

$id = $_GET['id'] ?? 0;

if (!$id) {
    die("ID postingan tidak valid.");
}

$stmt = $pdo->prepare("SELECT image FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("Postingan tidak ditemukan.");
}

// Hapus file gambar jika ada
if ($post['image']) {
    $image_path = '../assets/uploads/' . $post['image'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

// Hapus dari database
$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);

// Redirect dengan pesan sukses
header("Location: list_post.php?success=" . urlencode("Postingan berhasil dihapus."));
exit();