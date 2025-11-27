<?php
require_once('includes/db_config.php');

// Ganti sesuai keinginanmu
$username = 'admin';
$password = 'bmwi777'; // Password untuk login

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hash]);
    echo "<h2>✅ Akun admin berhasil dibuat!</h2>";
    echo "<p><strong>Username:</strong> $username</p>";
    echo "<p><strong>Password:</strong> $password</p>";
    echo "<p style='color:red;'><b>SEGERA HAPUS FILE INI SETELAH DIPAKAI!</b></p>";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<h2>⚠️ Username sudah ada!</h2>";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>