<?php
require_once('includes/auth-check.php');
require_once('../includes/db_config.php');

// Cek apakah ada ID → update, jika tidak → create
$id = $_POST['id'] ?? null;

$title = trim($_POST['title'] ?? '');
$content = $_POST['content'] ?? '';
$image = $_FILES['image'] ?? null;

if (empty($title) || empty($content)) {
    die("Judul dan isi konten wajib diisi.");
}

// Proses upload gambar (jika ada)
$image_name = null;
if ($image && $image['error'] === UPLOAD_ERR_OK) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($image['type'], $allowed_types)) {
        die("Tipe file gambar tidak didukung. Gunakan JPG, PNG, atau GIF.");
    }

    $image_name = uniqid() . '_' . basename($image['name']);
    $upload_path = '../assets/uploads/' . $image_name;

    if (!move_uploaded_file($image['tmp_name'], $upload_path)) {
        die("Gagal mengunggah gambar.");
    }
}

try {
    if ($id) {
        // UPDATE
        $stmt = $pdo->prepare("
            UPDATE posts 
            SET title = ?, content = ?, image = COALESCE(?, image),
            WHERE id = ?
        ");
        $stmt->execute([$title, $content, $image_name, $id]);
        $message = "Postingan berhasil diperbarui!";
    } else {
        // INSERT
        $stmt = $pdo->prepare("
            INSERT INTO posts (title, content, image, created_at) 
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$title, $content, $image_name]);
        $message = "Postingan baru berhasil dibuat!";
    }

    // Redirect ke daftar postingan dengan pesan sukses
    header("Location: list_post.php?success=" . urlencode($message));
    exit();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
