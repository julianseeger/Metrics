<?php
$path = '../../' . substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'bower_components'));
$type = 'text/css';
if (strpos($path, '.js') !== false) {
    $type = 'text/javascript';
}
if (strpos($path, '.woff') !== false) {
    $type = 'application/x-font-woff';
}
header('Content-Type: ' . $type);
echo file_get_contents($path);
