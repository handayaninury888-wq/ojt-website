<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// 👇 Tambahkan ini untuk debugging (hapus setelah selesai!)
error_log("Login attempt: username='$username', password='$password'");

if (empty($username) || empty($password)) {
    header('Location: ../admin/login.php?error=invalid');
    exit;
}

// === KONEKSI DATABASE ===
try {
    // Sesuaikan jika Anda pakai password database di Laragon
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=simply_cms;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Untuk debugging sementara
    error_log("DB Error: " . $e->getMessage());
    header('Location: ../admin/login.php?error=invalid');
    exit;
}

// === CARI USER ===
$stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// === VERIFIKASI ===
if ($user && password_verify($password, $user['password'])) {
    // Login sukses
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];

    header('Location: ../admin/dashboard.php');
    exit;
} else {
    // Gagal
    header('Location: ../admin/login.php?error=invalid');
    exit;
}
