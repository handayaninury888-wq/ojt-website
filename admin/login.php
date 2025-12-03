<?php
session_start();

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin - BMWI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 320px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #1a73e8;
        }

        .login-box input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .login-box button {
            width: 100%;
            padding: 0.75rem;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-box button:hover {
            background: #0d4a7f;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Login Admin</h2>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
            <div class="error">Username atau password salah!</div>
        <?php endif; ?>

        <form action="../includes/auth-check.php" method="POST">
            <input
                type="text"
                name="username"
                placeholder="Username"
                required
                autocomplete="off"
                tabindex="1"
                autofocus>
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                autocomplete="off"
                tabindex="2">
            <button type="submit" tabindex="3">Login</button>
        </form>
    </div>

</body>

</html>
