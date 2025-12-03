<?php
// Jika Anda ingin menampilkan nama user di header, tambahkan ini
$username = $_SESSION['admin_username'] ?? '';
?>

<!-- Header dengan Logo -->
<header>
    <div class="logo-container">
        <img src="../assets/images/logo.png" alt="Logo BMWI">
    </div>
    <h1>Bhakti Mandiri Wisata Indonesia</h1>
    <h2>Lembaga Sertifikasi Usaha Pariwisata</h2>
</header>

<!-- Banner Promosi -->
<div class="container">
    <div class="promo-banner">
        <i class="fas fa-certificate"></i> Sertifikasi Usaha Pariwisata Resmi • Proses Cepat & Terpercaya!
    </div>
</div>

<!-- Tambahkan menu admin jika login -->
<?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
    <div style="text-align: center; padding: 1rem; background: #f0f4ff; margin-top: 1rem;">
        <span style="font-weight: bold; color: #0d4a7f;">Halo, <?= htmlspecialchars($username) ?>!</span>
        <a href="/simply_cms/admin/logout.php" style="margin-left: 1.5rem; color: #dc3545; text-decoration: none; font-weight: 600;">Logout</a>
    </div>
<?php endif; ?>
