<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';

$cek = [
    'auth' => ['guards', 'providers', 'passwords'],
    'broadcasting' => ['connections'],
    'cache' => ['stores'],
    'database' => ['connections'],
    'filesystems' => ['disks'],
    'logging' => ['channels'],
    'mail' => ['mailers'],
    'queue' => ['connections'],
];

foreach (glob(__DIR__.'/config/*.php') as $file) {
    $nama = basename($file, '.php');
    $data = require $file;

    if (!is_array($data)) {
        echo "ERROR: config/$nama.php tidak mengembalikan array\n";
        continue;
    }

    foreach ($cek[$nama] ?? [] as $bagian) {
        if (isset($data[$bagian]) && !is_array($data[$bagian])) {
            echo "ERROR: config/$nama.php -> $bagian bertipe ".gettype($data[$bagian])."\n";
        }
    }
}

echo "Pemeriksaan selesai.\n";
