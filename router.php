<?php
if (php_sapi_name() == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false; // Servir el archivo directamente
    }
}
require_once __DIR__ . '/webhook.php';
