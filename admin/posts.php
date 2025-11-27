<?php
// admin/posts.php
require_once('includes/auth_check.php'); // Cek apakah user sudah login
require_once('../includes/db_config.php');

$message = '';
$posts = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();

// === Logic untuk Tambah/Edit Post ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $post_id = $_POST['id'] ?? null;
    $image_name = $_POST['current_image'] ?? null; // Untuk edit

    // --- LOGIKA UPLOAD GAMBAR ---
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../assets/uploads/';
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($_FILES['image']['type'], $allowed_types)) {
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                $message = 'Error: Gagal mengunggah gambar.';
            }
        } else {
            $message = 'Error: Hanya format JPG, PNG, atau GIF yang diizinkan.';
        }
    }
    // ----------------------------

    if (!$message) { // Jika tidak ada error upload
        if ($post_id) {
            // UPDATE Post
            $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $content, $image_name, $post_id]);
            $message = 'Postingan berhasil diperbarui!';
        } else {
            // CREATE Post
            $stmt = $pdo->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
            $stmt->execute([$title, $content, $image_name]);
            $message = 'Postingan baru berhasil ditambahkan!';
        }
        // Redirect untuk refresh daftar dan hapus data POST
        header('Location: posts.php?msg=' . urlencode($message));
        exit;
    }
}

// === Logic Hapus Post ===
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Ambil nama gambar untuk dihapus
    $stmt = $pdo->prepare("SELECT image FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post_to_delete = $stmt->fetch();

    if ($post_to_delete && $post_to_delete['image']) {
        unlink('../assets/uploads/' . $post_to_delete['image']);
    }

    // Hapus dari database
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: posts.php?msg=' . urlencode('Postingan berhasil dihapus.'));
    exit;
}

// === Tampilan Edit Form (Jika ada parameter 'edit_id') ===
$post_to_edit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([(int)$_GET['edit_id']]);
    $post_to_edit = $stmt->fetch();
}

// Tampilkan pesan status
if (isset($_GET['msg'])) {
    $message = htmlspecialchars($_GET['msg']);
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin - Manajemen Post</title></head>
<body>
    <h2>Manajemen Post</h2>
    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <h3><?php echo $post_to_edit ? 'Edit' : 'Tambah'; ?> Post</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $post_to_edit['id'] ?? ''; ?>">
        <input type="hidden" name="current_image" value="<?php echo $post_to_edit['image'] ?? ''; ?>">

        <label>Judul:</label><br>
        <input type="text" name="title" value="<?php echo $post_to_edit['title'] ?? ''; ?>" required><br><br>

        <label>Konten:</label><br>
        <textarea name="content" rows="10" cols="50" required><?php echo $post_to_edit['content'] ?? ''; ?></textarea><br><br>

        <label>Gambar:</label>
        <?php if (isset($post_to_edit['image'])): ?>
            <p>Gambar saat ini: <img src="../assets/uploads/<?php echo $post_to_edit['image']; ?>" width="100"></p>
        <?php endif; ?>
        <input type="file" name="image"><br>
        <small>Kosongkan jika tidak ingin mengubah gambar.</small><br><br>

        <button type="submit"><?php echo $post_to_edit ? 'Simpan Perubahan' : 'Terbitkan Post'; ?></button>
        <?php if ($post_to_edit): ?>
            <a href="posts.php">Batal Edit</a>
        <?php endif; ?>
    </form>

    <hr>

    <h3>Daftar Postingan</h3>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo $post['id']; ?></td>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td>
                    <?php if ($post['image']): ?>
                        ); ?> thumbnail]
                    <?php else: ?>
                        (Tidak ada gambar)
                    <?php endif; ?>
                </td>
                <td><?php echo $post['created_at']; ?></td>
                <td>
                    <a href="posts.php?edit_id=<?php echo $post['id']; ?>">Edit</a> |
                    <a href="posts.php?action=delete&id=<?php echo $post['id']; ?>" onclick="return confirm('Yakin ingin menghapus postingan ini?');">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>