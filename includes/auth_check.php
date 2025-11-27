<?php
// admin/includes/auth_check.php
session_start();
// Pastikan user sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>