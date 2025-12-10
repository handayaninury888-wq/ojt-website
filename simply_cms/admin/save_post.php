<?php
session_start();
include '../includes/admin_check.php';
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO posts (title, content, status, created_at) VALUES ('$title', '$content', '$status', '$created_at')";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_post.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>