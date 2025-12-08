<?php
session_start();
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// index.php - Halaman Utama Publik BMWI
require_once('includes/db_config.php');
$posts = $pdo->query("SELECT id, title, content, image, created_at FROM posts ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhakti Mandiri Wisata Indonesia | Lembaga Sertifikasi Usaha Pariwisata</title>
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

        .post-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2.2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f4ff;
        }

        .post-content {
            padding: 1.6rem;
        }

        .post-card h3 a {
            color: #0d4a7f;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-size: 1.45rem;
            transition: color 0.2s;
        }

        .post-card h3 a:hover {
            color: #1a73e8;
        }

        .post-meta {
            color: #5a6c85;
            font-size: 0.9rem;
            margin: 0.6rem 0 1rem;
        }

        .post-meta i {
            margin-right: 6px;
            color: #1a73e8;
        }

        .post-excerpt {
            color: #444;
            margin-bottom: 1.2rem;
            font-size: 1rem;
        }

        .read-more {
            display: inline-block;
            background: #1a73e8;
            color: white;
            text-decoration: none;
            padding: 0.55rem 1.3rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background 0.3s;
        }

        .read-more:hover {
            background: #0d4a7f;
        }

        .no-posts {
            text-align: center;
            padding: 3rem 1.5rem;
            background: white;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            font-size: 1.2rem;
            color: #555;
        }

        .admin-login {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e7ff;
        }

        .admin-login a {
            color: #1a73e8;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            padding: 0.5rem 1.2rem;
            border: 1px solid #1a73e8;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .admin-login a:hover {
            background: #1a73e8;
            color: white;
        }

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

            .post-content {
                padding: 1.2rem;
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

    <?php include_once('includes/header.php'); ?>

    <!-- Konten Utama -->
    <div class="container">
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <?php if (!empty($post['image'])): ?>
                        <img src="assets/uploads/<?php echo htmlspecialchars($post['image']); ?>"
                            alt="<?php echo htmlspecialchars($post['title']); ?>"
                            class="post-image">
                    <?php endif; ?>

                    <div class="post-content">
                        <h3>
                            <a href="post_detail.php?id=<?php echo (int)$post['id']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h3>
                        <div class="post-meta">
                            <i class="far fa-calendar"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?>
                        </div>
                        <div class="post-excerpt">
                            <?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 200))) . '...'; ?>
                        </div>
                        <a href="post_detail.php?id=<?php echo (int)$post['id']; ?>" class="read-more">
                            <i class="fas fa-eye"></i> Baca Selengkapnya
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-posts">
                <p>Belum ada informasi terbaru.</p>
                <p style="margin-top: 1rem; font-weight: 600; color: #009624;">
                    <i class="fas fa-lightbulb"></i> Segera dapatkan sertifikasi usaha pariwisata Anda!
                </p>
            </div>
        <?php endif; ?>

        <!-- Tampilkan tombol login hanya jika belum login -->
        <?php if (!$is_logged_in): ?>
            <div class="admin-login">
                <a href="admin/login.php">
                    <i class="fas fa-user-lock"></i> Login Admin
                </a>
            </div>
        <?php endif; ?>

        <!-- Tampilkan pagination hanya jika sudah login -->
        <?php if ($is_logged_in): ?>
            <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; align-items: center; position: relative; margin: 2rem 0;">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center" style="display: flex; list-style: none; padding: 0; margin: 0; gap: 5px;">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #666; background: #f9f9f9;">Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333; background: white;">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333; background: white;">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333; background: white;">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #333; background: white;">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div> <!-- penutup .container -->

    <?php include_once('includes/footer.php'); ?>

</body>

</html>
