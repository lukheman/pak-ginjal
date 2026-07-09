<?php

$files = [
    '.env',
    'resources/views/welcome.blade.php',
    'resources/views/layouts/pasien.blade.php',
    'resources/views/layouts/app.blade.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Replace RenalCare variants
        $content = str_replace('RenalCare', 'PakGinjal', $content);
        $content = str_replace('Renal<span class="text-blue-600">Care</span>', 'Pak<span class="text-blue-600">Ginjal</span>', $content);
        
        // Replace APP_NAME in .env
        if ($file === '.env') {
            $content = preg_replace('/APP_NAME=.*/', 'APP_NAME=PakGinjal', $content);
        }
        
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
