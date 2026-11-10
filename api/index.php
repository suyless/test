<?php

$storagePath = '/tmp/storage';
$subdirs = [
    $storagePath.'/framework/views',
    $storagePath.'/framework/cache',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/testing',
    $storagePath.'/logs',
    $storagePath.'/app',
    $storagePath.'/app/public',
];

foreach ($subdirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Forward Vercel requests to Laravel's public index.php
require __DIR__.'/../public/index.php';
