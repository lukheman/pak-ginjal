<?php
$files = [
    'resources/views/auth/login.blade.php',
    'resources/views/auth/pasien_register.blade.php',
    'resources/views/konsultasi/index.blade.php',
    'resources/views/konsultasi/hasil.blade.php',
    'resources/views/basis_pengetahuan/show.blade.php',
    'resources/views/basis_pengetahuan/index.blade.php',
    'resources/views/dashboard.blade.php',
    'resources/views/pasien/index.blade.php',
    'resources/views/penyakit/index.blade.php',
    'resources/views/layouts/app.blade.php',
    'resources/views/gejala/index.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $content = str_replace('indigo-', 'blue-', $content);
        $content = str_replace('emerald-', 'cyan-', $content);
        file_put_contents($file, $content);
        echo "Replaced in $file\n";
    }
}
