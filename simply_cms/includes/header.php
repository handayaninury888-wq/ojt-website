<?php
// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil username jika admin sudah login
$username = '';
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $username = $_SESSION['admin_username'] ?? '';
}
?>

<!-- Header dengan Logo -->
<header>
    <div class="logo-container">
        <img src="assets/images/logo.png" alt="Logo BMWI">
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
        <!-- 🔴 DIGANTI: Logout -> Pengelolaan Situs -->
        <a href="admin/settings.php" style="margin-left: 1.5rem; color: #1a73e8; text-decoration: none; font-weight: 600;">Pengelolaan Situs</a>
    </div>
<?php endif; ?>