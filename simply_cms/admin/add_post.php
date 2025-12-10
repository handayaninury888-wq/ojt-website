<?php
session_start();
include '../includes/admin_check.php';
include '../config.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validasi wajib
    if (empty($title)) {
        $error = "Judul postingan wajib diisi.";
    } elseif (empty($content)) {
        $error = "Isi postingan wajib diisi.";
    } else {
        // Simpan ke database
        $sql = "INSERT INTO posts (title, content, status, created_at) 
                VALUES ('$title', '$content', '$status', NOW())";

        if (mysqli_query($conn, $sql)) {
            $success = true;
            // Reset form setelah sukses
            $title = $content = '';
        } else {
            $error = "Gagal menyimpan postingan: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Postingan Baru - Bhakti Mandiri Wisata Indonesia</title>

    
    <style>
        :root {
            --primary: #28a745;
            --secondary: #007bff;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --white: #fff;
            --border: #dee2e6;
            --danger: #dc3545;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h2 {
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--secondary);
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }

        button {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
        }

        button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>➕ Tambah Postingan Baru</h2>

        <?php if ($error): ?>
            <div class="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                ✅ Postingan berhasil disimpan!
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Judul Postingan *</label>
                <input type="text" name="title" id="title" required placeholder="Masukkan judul postingan" value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="content">Isi Postingan *</label>
                <textarea name="content" id="content" rows="10" required placeholder="Tulis isi postingan di sini..."><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select name="status" id="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="published" <?= isset($_POST['status']) && $_POST['status'] == 'published' ? 'selected' : '' ?>>Publik</option>
                    <option value="draft" <?= isset($_POST['status']) && $_POST['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                </select>
            </div>

            <button type="submit">💾 Simpan Postingan</button>
        </form>

        <br>
        <a href="dashboard.php" class="back-link">← Kembali ke Dashboard</a>
    </div>


</body>
</html>