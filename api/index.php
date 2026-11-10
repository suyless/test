<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Endpoint tes diagnostik untuk memastikan runtime PHP Vercel aktif
if (isset($_SERVER['REQUEST_URI']) && str_starts_with($_SERVER['REQUEST_URI'], '/test-php')) {
    header('Content-Type: text/plain');
    echo "PHP Runtime is working on Vercel!\n";
    echo 'PHP Version: '.PHP_VERSION."\n";
    echo 'Server SAPI: '.php_sapi_name()."\n";
    exit;
}

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

try {
    require __DIR__.'/../public/index.php';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<h1>Laravel Runtime Exception</h1>';
    echo '<p><strong>Message:</strong> '.htmlspecialchars($e->getMessage()).'</p>';
    echo '<p><strong>File:</strong> '.htmlspecialchars($e->getFile()).' on line '.$e->getLine().'</p>';
    echo '<pre>'.htmlspecialchars($e->getTraceAsString()).'</pre>';
}
