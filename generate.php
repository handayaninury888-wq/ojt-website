<?php
// Daftar username dan password yang ingin di-hash
$users = [
    ['username' => 'admin', 'password' => 'kemesraan'],
    ['username' => 'dayat', 'password' => '44444'],
    ['username' => 'iniaja', 'password' => 'nuri']
];

echo "<h2>Hash Password untuk User:</h2>";
echo "<pre>";

foreach ($users as $user) {
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    echo "Username: {$user['username']}\n";
    echo "Password Asli: {$user['password']}\n";
    echo "Hash: $hash\n";
    echo str_repeat("-", 60) . "\n";
}

echo "</pre>";
