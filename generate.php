<?php
$password = '797979'; // ganti sesuai keinginan Anda
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "<h3>Password: <code>$password</code></h3>";
echo "<p>Hash: <code>$hash</code></p>";
?>